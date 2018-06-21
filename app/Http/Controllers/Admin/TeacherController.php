<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;
use App\Models\Teacher;

class TeacherController extends Controller
{
    /*
     * 老师列表页
     */
    public function teacher_list_page(){
        $teachers = Teacher::paginate(20);
        return view('admin.teacher.teacher-list',compact('teachers'));
    }
}
