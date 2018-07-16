<?php
/**
 * Created by PhpStorm.
 * User: JiaNong
 * Date: 2018/6/21
 * Time: 15:10
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Teacher;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $model;           //当前模型的实例对象

    protected $model_name;      //当前模型名称

    protected $model_class;     //App\Models\xxx

    protected $interaction;     //当前模型所关联的模型名

    protected $relations;       //模型关联

    /*
     * 构造方法
     */
    public function __construct()
    {
        if(isset($this->model_name)) $this->model_class  = 'App\\Models\\' . $this->model_name;     //设置模型引用
        if(isset($this->interaction)) $this->interaction = 'App\\Models\\' . $this->interaction;    //设置模型关联
        if(isset($this->model_class)) $this->model       = new $this->model_class();                //设置模型实例

    }

    /*
     * 钩子方法，主要用于子类继承之后修改参数
     */
    protected function __search(&$where)
    {

    }

    /*
     * 通过id获取所属表的一条记录
     */
    protected function getCollection($id)
    {
        return $this->model_class::find($id);
    }

    /*
     * 公共列表展示页
     */
    public function index()
    {

        $dataset = $this->model_class::paginate(10);  //分页

        return view("admin." . $this->model_name . "." . $this->model_name . "_list", compact('dataset'));
    }



    /*
     * 删除记录
     */
    public function del($id)
    {
        $collection = $this->getCollection($id);

        $collection->delete();

        return 1;
    }

    /*
     * 添加/编辑
     */
    public function save($id = '')
    {
        //如果有id 编辑页面
        if (!empty($id)){
            if (request()->isMethod('PUT')) {
                //todo 数据验证

                $collection = $this->getCollection($id);    //通过id获取collection对象

                $field = array_intersect($this->model->getFillable(), array_keys(\request()->toArray()));   //得到可修改的字段

                foreach ($field as $k => $v) {
                    $collection->$v = \request()->$v;    //循环赋值
                }

                $collection->save();    //保存至数据库

                return 1;   //返回结果

            } else {

                $dataset = $this->getCollection($id);

                $rows = [];

                if ($this->relations !== null){
                    //todo 这个模型关联的表名被写死
                    $rows = $this->model_class::first()->branch->select('id','name')->where('status',1)->get();
                }

                return view("admin." . $this->model_name . "." . $this->model_name . "_save", compact('dataset','rows'));
            }
        }else{
            if (\request()->isMethod('POST')) {
                //todo 验证数据

                $field = array_intersect($this->model->getFillable(), array_keys(\request()->toArray()));   //得到最终将要加入数据库的字段

                foreach ($field as $v) {
                    $this->model->$v = \request()->$v;        //循环赋值给数组

                    //如果是新增用户，则需要加密密码
                    if ($this->model_name == 'User'){
                        if ($v == 'password'){
                            $this->model->$v = bcrypt(\request()->$v);
                        }
                    }
                }

                $this->model->save();     //将数组入库

                $this->model->teacher()->attach(\request('teacher_id'));

                return 1;                               //返回成功信息

            } else {
                $rows = [];

                if ($this->relations !== null){
                    //todo 这个模型关联的表名被写死
                    if ($this->model_name == 'Teacher'){
                        $rows = $this->model_class::first()->branch->select('id','name')->where('status',1)->get();
                    }elseif ($this->model_name == 'Grade'){
                        $rows = $this->model_class::first()->teacher[0]->select('id','name')->get();
                    }
                }

                return view("admin." . $this->model_name . "." . $this->model_name . "_save",compact('rows'));   //返回视图
            }
        }
    }

    /*
     * 修改状态   1启用  0停用
     */
    public function status($id)
    {
        //Laravel 会自动解析定义在路由或控制器行为中与类型提示的变量名匹配的路由段名称的 Eloquent 模型
        //如果在数据库中找不到对应的模型实例，将会自动生成 404 异常。
        //所以，如果数据库没有这条记录，将会直接返回error，触发前端错误提醒
        //只需要执行删除程序即可
        //修改用户的状态    1启用/0停用

        $collection = $this->getCollection($id);

        if ($collection->status === 1) {
            $collection->status = 0;
        } else {
            $collection->status = 1;
        }

        //保存状态
        $collection->save();

        return ['msg' => '操作成功!'];
    }

    /*
     * 批量修改状态
     */
    public function allStatus($ids)
    {
        $ids = array_unique(explode(',', $ids));    //拼接成数组

        foreach ($ids as $k => $v) {
            if (empty($v) || $v == 0) {
                unset($ids[$k]);    //删除数组中的空元素值
            }
        }

        $ids_count = count($ids);   //去除数组中有0的元素,并且获取数组的长度

        $res = $this->model_class::whereIn('id', $ids)->get();

        $res_count = $this->model_class::whereIn('id', $ids)->get()->count();
        //如果2个总数相等，说明数据库中记录条数=传递过来的id总数
        if ($res_count !== $ids_count) {
            return false;   //操作失败
        }

        $res->transform(function ($item, $key) {
            $item->status = 0;  //修改这些数据的状态
            $item->save();
        });

        return 1;   //返回修改成功的状态码
    }

    /*
     * 搜索
     */
    public function searchStore(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $username = $request->username;

        $start = empty($start) ? date('Y-m-d H:i:s', 0) : $start . ' 00:00:00';     //如果开始时间为空，则为初始时间

        $end = empty($end) ? date('Y-m-d H:i:s', time()) : $end . ' ' . explode(' ', date('Y-m-d H:i:s', time()))[1];   //如果结束时间为空，则为当前时间

        if (empty($username)) {
            $dataset = $this->model_class::whereBetween('created_at', [$start, $end])->paginate(10);    //如果用户名为空，则不添加用户名条件
        } else {
            $dataset = $this->model_class::where('name', 'like', '%' . $username . '%')->whereBetween('created_at', [$start, $end])->paginate(10);  //如果都有值，则添加所有条件
        }

        $start = explode(' ', $start)[0];
        $end = explode(' ', $end)[0];

        return view("admin.".$this->model_name.".".$this->model_name."_list",compact('dataset', 'start', 'end', 'username'));
    }

}