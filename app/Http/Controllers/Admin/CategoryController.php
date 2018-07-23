<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    protected $model_name = 'Category';

    public function index(){
        $dataset = Category::paginate(10);  //分页

        return view("admin.category.category_list", compact('dataset'));
    }


    public function addPage(){
        return view('admin.category.category_add');
    }

    public function addStore(Request $request,Category $category){


        $this->validate($request,[
            'name' => 'required|unique:category',
            'describe' =>'nullable'
        ]);


        $category->create(\request(['name','describe']));

        return ['msg' => '添加成功'];
    }

    public function editPage(Category $category){
        return view('admin.category.category_edit',compact('category'));
    }

    public function editStore(Category $category,Request $request){
        $this->validate($request,[
            'name' => [
                'required',
                Rule::unique('category')->ignore($category->id), //进行字段唯一性验证时忽略指定 ID
            ],
            'describe' =>'nullable'
        ]);

        $field = array_intersect($category->getFillable(), array_keys(\request()->toArray()));   //得到可修改的字段

        foreach ($field as $k => $v) {
            $category->$v = \request()->$v;    //循环赋值
        }

        $category->save();    //保存至数据库

        return ['msg' => '编辑成功'];            //返回结果
    }
}
