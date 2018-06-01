<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $status; //批量删除时接受的状态码

    /*
     * 用户列表页
     */
    public function index(){
        $users = User::where('status','!=',-1)->orderBy('created_at','desc')->paginate(20);
        return view('admin.users.member-list',compact('users'));
    }

    /*
     * 用户添加
     */
    public function add_page(){
        return view('admin.users.member-add');
    }

    /*
     * 用户添加逻辑
     */
    public function add_store(Request $request){

        $this->validate($request,[
            'email' => 'required|email|unique:users',   //唯一
            'number' => 'required|numeric',             //必须是数组
            'name' => 'required|string|max:20',         //最大20位
            'password' => 'confirmed',                  //密码相同
        ]);

        $params = \request(['email','number','name','password']);
        $params['password'] = bcrypt($params['password']);  //对密码进行加密
        User::create($params);

        //返回 json 结果
        return response()->json(
            ['code' => 1]
        );
    }

    /*
     * 修改用户状态
     */
    public function status_store(User $user,$status){
        //Laravel 会自动解析定义在路由或控制器行为中与类型提示的变量名匹配的路由段名称的 Eloquent 模型
        //如果在数据库中找不到对应的模型实例，将会自动生成 404 异常。
        //所以，如果数据库没有这条记录，将会直接返回error，触发前端错误提醒
        //只需要执行删除程序即可
        //修改用户的状态为-1，代表删除,1代表正常，0代表停用
        switch ($status){
            case (1):
                $user->status = 1;
                break;
            case (0):
                $user->status = 0;
                break;
            case (-1):
                $user->status = -1;
                break;
            default:
                return false;
                break;
        }
        //保存状态
        $user->save();
        //返回数据，那边ajax接受，成功
        return 1;
    }

    /*
     * 批量修改用户信息
     */
    public function status_store_bulk($data,$status){
        //接受状态吗，并且赋值给类属性
        $this->status = $status;
        //拼接成数组
        $data = array_unique(explode(',',$data));
        //删除数组中的空元素值
        foreach ($data as $k => $v){
            if (empty($v)){
                unset($data[$k]);
            }
        }
        //去除数组中有0的元素,并且获取数组的长度
        $data_count = collect($data)->diff([0])->count();

        $res = User::whereIn('id',$data)->get();
        $res_count = User::whereIn('id',$data)->get()->count();

        if ($res_count !== $data_count){
            //操作失败
            return false;
        }

        //修改这些数据的状态
        $res->transform(function ($item,$key){
            $item->status = $this->status;
            $item->save();
        });
        //返回修改成功的状态码
        return 1;
    }

}
