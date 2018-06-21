<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [],    //指定动作 不使用 Auth 中间件进行过滤
        ]);
    }


    /*
     * 后台首页
     */
    public function index(){
        return view('admin.index');
    }


}
