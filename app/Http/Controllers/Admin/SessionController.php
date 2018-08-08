<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    /*
     * 登陆页面
     */
    public function login_page(){
        return view('admin.login.login');
    }

    /*
     * 登陆逻辑
     */
    public function login_store(Request $request){

        //数据验证
        $this->validate($request,[
            'email' => 'email',
            'password' => 'required|min:6',
        ]);

//        dd(2);

        //只允许状态为1的用户登陆 has 判断是否有值，返回 true or false
        if(Auth::attempt(array_merge(\request(['email','password']),['status' => 1]),$request->has('remember'))){
            // 登录成功后的相关操作
            return ['url' => route('admin'),'msg' => '欢迎回来!'];
        } else {
            // 登录失败后的相关操作
            return response()->json(['msg' => '很抱歉，你的邮箱和密码不匹配'],422);
        }


    }

    /*
     * 退出登录
     */
    public function logout(){
        Auth::logout();
        session()->flash('msg','已退出登陆!');
        return redirect()->route('admin_login_up');
    }
}
