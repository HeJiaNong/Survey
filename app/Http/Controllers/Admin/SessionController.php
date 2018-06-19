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

        if (Auth::attempt($credentials)){
            dd(2);
        }else{
            dd(3);
        }


    }
}
