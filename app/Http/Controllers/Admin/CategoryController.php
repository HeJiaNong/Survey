<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    protected $model_name = 'Category';

    /*
     * 列表页
     */
    public function index(){
        $dataset = Category::paginate(10);  //分页

        return view("admin.category.category_list", compact('dataset'));
    }

    /*
     * 添加页
     */
    public function addPage(){
        return view('admin.category.category_add');
    }

    /*
     * 添加逻辑
     */
    public function addStore(Request $request,Category $category){

        $request->validate([
            'name' => 'required|unique:category',
            'describe' =>'nullable',
            'formula_mode' => [
                'required',
                'integer',
                Rule::in([1,2]),    //暂时只允许为1和2 2种统计方式
            ],
        ]);

        $category->create(\request(['name','describe','formula_mode']));

        return ['msg' => '添加成功'];
    }

    /*
     * 编辑页
     */
    public function editPage(Category $category){
        return view('admin.category.category_edit',compact('category'));
    }

    /*
     * 编辑逻辑
     */
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

    /*
     * 删除逻辑
     */
    public function del(Category $category){
        //动态添加问卷模型关联
        $category->load('word');

        //动态添加答卷模型管理
        $category->word->load('result');

        //删除问卷下的答卷
        foreach ($category->word as $value){
            foreach ($value->result as $v){
                $v->delete();
            }

        }

        //删除所有问卷
        $category->word()->delete();

        //删除当前分组
        $category->delete();

        //返回json
        return ['msg' => '已删除'];
    }
}
