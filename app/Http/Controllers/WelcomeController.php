<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //首页欢迎页
    public function index(){
        return view('admin.welcome.index',['data' => $_SERVER]);
    }

}
