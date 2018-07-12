<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Teacher;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    protected $model_name = 'Branch';



    /*
     * 公共列表展示页
     */
    public function index()
    {

        $dataset = Branch::with('teacher')->select('id','name')->orderBy('order','asc')->get();  //分页

//        dump($dataset);

        return view("admin.branch.cate", compact('dataset'));
    }

    public function add(Request $request){

        $this->validate($request,[
            'name' => 'required|unique:branches'
        ]);

        $prams = [];

        $prams['name'] = $request->name;

        Branch::create($prams);

        return ['msg' => '添加成功'];
    }

    /**
     * 删除部门
     * @param Branch $branch    部门模型
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response   返回json
     * @throws \Exception   响应错误
     */
    public function del(Branch $branch)
    {
        if (1 == $branch->id){
            return response(['msg' => '你是真的皮'],400);
        }

        //循环修改部门为默认部门 1
        foreach ($branch->teacher as $teacher){
            $teacher->branch_id = 1;
            $teacher->save();
        }

        //执行删除部门
        $branch->delete();
        //返回json数据
        return ['msg' => '删除部门成功'];
    }

}
