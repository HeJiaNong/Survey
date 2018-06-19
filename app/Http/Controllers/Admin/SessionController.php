<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
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

        $credentials = $this->validate($request,[
            'email' => 'email',
            'password' => 'required',
        ]);


//        dd($credentials);

        //has 判断是否有值，返回 true or false
        if(Auth::attempt($credentials,$request->has('remember'))){
            //做一个对未激活用户的判断
            if (Auth::user()->activated){
                // 登录成功后的相关操作
                session()->flash('success','欢迎回来!');
                //intended 方法，该方法可将页面重定向到上一次请求尝试访问的页面上，并接收一个默认跳转地址参数，当上一次请求记录为空时，跳转到默认地址上。
                return redirect()->intended(route('users.show',Auth::user()));
            }else{
                Auth::logout();
                session()->flash('warning','你的账号尚未激活，请检查邮箱中的注册邮件进行激活');
                return redirect()->route('admin_login_up');
            }

        } else {
            // 登录失败后的相关操作
            session()->flash('danger','很抱歉，你的邮箱和密码不匹配');
            return redirect()->back();
        }


    }
}
