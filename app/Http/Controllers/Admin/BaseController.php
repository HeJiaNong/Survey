<?php
/**
 * Created by PhpStorm.
 * User: JiaNong
 * Date: 2018/6/21
 * Time: 15:10
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherStore;
use App\Http\Requests\UserStore;
use App\Models\Teacher;
use Illuminate\Http\Request;

use App\Models\User;

class BaseController extends Controller
{
    protected $model;   //模型实例

    protected $model_name;  //模型名称

    protected $model_class; //模型引用

    protected $getCollection;        //模型绑定

    /*
     * 构造方法
     */
    public function __construct()
    {

        //设置模型引用
        $this->model_class = 'App\\Models\\' . $this->model_name;
        $this->model = new $this->model_class();
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
        $where = "(1,'=',1)";
        $this->__search($where);

        $dataset = $this->model_class::paginate(10);  //分页


        return view("admin." . $this->model_name . "." . $this->model_name . "_list", compact('dataset'));
    }


    /*
     * 编辑
     */
    public function edit($id = '')
    {
//        dump($id);
//        dump(\request()->method());

        if (request()->isMethod('PUT')) { //判断请求方式是否为put 返回bool
            //通过id获取collection对象
            $collection = $this->getCollection($id);

            $data = \request()->toArray();
            //移除 _token和_method字段
            unset($data['_token']);
            unset($data['_method']);
            //循环赋值
            foreach ($data as $k => $v) {
                $collection->$k = $v;
            }

            //保存至数据库
            $collection->save();
            //返回结果
            return 1;
        } else {
            $this->getCollection = $this->getCollection($id);

            $dataset = $this->getCollection;

            return view("admin." . $this->model_name . "." . $this->model_name . "_edit", compact('dataset'));
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

        return 1;
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
     * 添加
     */
    public function add()
    {

        //判断请求方式
        if (\request()->isMethod('Post')) {
            //todo 验证数据

            $field = array_intersect($this->model->getFillable(), array_keys(\request()->toArray()));   //得到最终将要加入数据库的字段

            $prams = [];    //要存入数据库的数据参数

            foreach ($field as $k => $v) {
                $prams[$v] = \request()->$v;    //循环赋值给数组
            }

            $this->model_class::create($prams);     //将数组入库

            return 1;   //返回成功信息

        } else {
            return view("admin." . $this->model_name . "." . $this->model_name . "_add");   //返回视图
        }
    }

    /*
     * 批量修改状态
     */
    public function allStatus($ids)
    {

        //拼接成数组
        $ids = array_unique(explode(',', $ids));
        //删除数组中的空元素值
        foreach ($ids as $k => $v) {
            if (empty($v) || $v == 0) {
                unset($ids[$k]);
            }
        }
        //去除数组中有0的元素,并且获取数组的长度
        $ids_count = count($ids);

        $res = $this->model_class::whereIn('id', $ids)->get();
        $res_count = $this->model_class::whereIn('id', $ids)->get()->count();
        //如果2个总数相等，说明数据库中记录条数=传递过来的id总数
        if ($res_count !== $ids_count) {
            //操作失败
            return false;
        }

        //修改这些数据的状态
        $res->transform(function ($item, $key) {
            $item->status = 0;
            $item->save();
        });
        //返回修改成功的状态码
        return 1;
    }

    /*
     * 搜索逻辑
     */
    public function searchStore(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $username = $request->username;

        //如果开始时间为空，则为初始时间
        $start = empty($start) ? date('Y-m-d H:i:s', 0) : $start . ' 00:00:00';
        //如果结束时间为空，则为当前时间
        $end = empty($end) ? date('Y-m-d H:i:s', time()) : $end . ' ' . explode(' ', date('Y-m-d H:i:s', time()))[1];

        if (empty($username)) {
            //如果用户名为空，则不添加用户名条件
            $dataset = $this->model_class::whereBetween('created_at', [$start, $end])->paginate(10);
        } else {
            //如果都有值，则添加所有条件
            $dataset = $this->model_class::where('name', 'like', '%' . $username . '%')->whereBetween('created_at', [$start, $end])->paginate(10);
        }

        $start = explode(' ', $start)[0];
        $end = explode(' ', $end)[0];

        return view("admin.".$this->model_name.".".$this->model_name."_list",compact('dataset', 'start', 'end', 'username'));
    }

}