<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /*
     * 批量删除时接受的状态码
     */
    private $status;


    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [],    //指定动作 不使用 Auth 中间件进行过滤
        ]);
    }

    /*
     * 用户列表页
     */
    public function index()
    {
        $users = User::where('status', '!=', -1)->orderBy('created_at', 'desc')->paginate(20);  //按时间倒序
        return view('admin.users.member-list', compact('users'));
    }


    /*
     * 用户添加页面
     */
    public function add_page()
    {
        return view('admin.users.member-add');
    }


    /*
     * 用户添加逻辑
     */
    public function add_store(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email|unique:users',   //唯一
            'number' => 'required|numeric',             //必须是数组
            'name' => 'required|string|max:20',         //最大20位
            'password' => 'confirmed',                  //密码相同
        ]);

        $params = \request(['email', 'number', 'name', 'password']);
        $params['password'] = bcrypt($params['password']);  //对密码进行加密
//        dd($params);
        User::create($params);

        //返回 json 结果
        return 1;
    }


    /*
     * 修改用户状态
     */
    public function status_store(User $user, $status)
    {
        //Laravel 会自动解析定义在路由或控制器行为中与类型提示的变量名匹配的路由段名称的 Eloquent 模型
        //如果在数据库中找不到对应的模型实例，将会自动生成 404 异常。
        //所以，如果数据库没有这条记录，将会直接返回error，触发前端错误提醒
        //只需要执行删除程序即可
        //修改用户的状态为-1，代表删除,1代表正常，0代表停用
        switch ($status) {
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
     * 只能修改数据库中存在的记录
     */
    public function status_store_bulk($data, $status)
    {
        //接受状态吗，并且赋值给类属性
        $this->status = $status;
        //拼接成数组
        $data = array_unique(explode(',', $data));
        //删除数组中的空元素值
        foreach ($data as $k => $v) {
            if (empty($v) || $v == 0) {
                unset($data[$k]);
            }
        }
        //去除数组中有0的元素,并且获取数组的长度
        $data_count = count($data);

        $res = User::whereIn('id', $data)->get();
        $res_count = User::whereIn('id', $data)->get()->count();
        //如果2个总数相等，说明数据库中记录条数=传递过来的id总数
        if ($res_count !== $data_count) {
            //操作失败
            return false;
        }

        //修改这些数据的状态
        $res->transform(function ($item, $key) {
            $item->status = $this->status;
            $item->save();
        });
        //返回修改成功的状态码
        return 1;
    }


    /*
     * 用户信息编辑页面
     */
    public function edit_page(User $user)
    {
        return view('admin.users.member-edit', compact('user'));
    }


    /*
     * 用户信息编辑逻辑
     */
    public function edit_store(User $user)
    {
        $user->email = \request()->email;
        $user->name = \request()->name;
        $user->sex = \request()->sex;
        $user->number = \request()->number;
        $user->addr = \request()->addr;
        $user->save();

        return 1;

    }


    /*
     * 修改用户密码页面
     */
    public function edit_passwd_page(User $user)
    {
        return view('admin.users.member-password', compact('user'));
    }


    /*
     * 修改用户密码逻辑
     */
    public function edit_passwd_store(User $user)
    {
        $this->validate(\request(), [
            'oldpass' => 'required',
            'password' => 'required|confirmed'
        ]);

        //如果用户输入的旧密码和数据库密码不对应，则返回错误
        if (\request()->oldpass != decrypt($user->password)) {
            return false;
        }

        $user->password = bcrypt(\request()->password);
        $user->save();
        return 1;

    }



    /*
     * 用户搜索逻辑
     */
    public function user_search_store(Request $request)
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
            $users = User::where('status', '<>', -1)->whereBetween('created_at', [$start, $end])->orderBy('created_at', 'desc')->paginate(20);
        } else {
            //如果都有值，则添加所有条件
            $users = User::where('status', '<>', -1)->where('name', 'like', '%' . $username . '%')->whereBetween('created_at', [$start, $end])->orderBy('created_at', 'desc')->paginate(20);
        }

        $start = explode(' ', $start)[0];
        $end = explode(' ', $end)[0];

        return view('admin.users.member-list',compact('users', 'start', 'end', 'username'));
    }


    /*
     * 用户回收站页面
     */
    public function user_del_page()
    {
        $users = User::where('status', '=', '-1')->orderBy('created_at', 'desc')->paginate(20);  //按时间倒序
        return view('admin.users.member-del', compact('users'));
    }


    /*
     * 用户永久删除逻辑
     */
    public function user_del_delete_store(User $user)
    {
        //删除
        $user->delete();
        return 1;
    }


    /*
    * 回收站搜索逻辑
    */
    public function user_del_search_store(Request $request)
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
            $users = User::where('status', '=', -1)->whereBetween('created_at', [$start, $end])->orderBy('created_at', 'desc')->paginate(20);
        } else {
            //如果都有值，则添加所有条件
            $users = User::where('status', '=', -1)->where('name', 'like', '%' . $username . '%')->whereBetween('created_at', [$start, $end])->orderBy('created_at', 'desc')->paginate(20);
        }

        $start = explode(' ', $start)[0];
        $end = explode(' ', $end)[0];

        return view('admin.users.member-del',compact('users', 'start', 'end', 'username'));
    }

}
