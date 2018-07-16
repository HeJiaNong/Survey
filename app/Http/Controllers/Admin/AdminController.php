<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth', [
//            'except' => [],    //指定动作 不使用 Auth 中间件进行过滤
//        ]);
//    }


    /*
     * 后台首页
     */
    public function index(){
        return view('admin.index');
    }

    /*
     * 桌面页
     */
    public function desktop(){
        dump('hello');
        return view('admin.desktop.welcome');
    }


}
