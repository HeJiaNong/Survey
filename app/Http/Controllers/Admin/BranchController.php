<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    protected $model_name = 'Branch';



    /*
     * 公共列表展示页
     */
    public function index()
    {
        $dataset = Branch::orderBy('order','asc')->paginate(10);  //分页

        return view("admin.branch.branch_list", compact('dataset'));
    }


    /*
     * 添加页面
     */
    public function addPage(){
        return view('admin.branch.branch_add');
    }

    /*
     * 添加逻辑
     */
    public function addStore(Request $request,Branch $branch){

        $this->validate($request,[
            'name' => 'required|unique:branches'
        ]);

        $branch->create(\request(['name']));

        return ['msg' => '添加成功'];
    }

    /*
     * 编辑页面
     */
    public function editPage(Branch $branch){
        return view('admin.branch.branch_edit',compact('branch'));
    }

    /*
     * 编辑逻辑
     */
    public function editStore(Branch $branch,Request $request){
        $this->validate($request,[
            'name' => [
                'required',
                Rule::unique('branches')->ignore($branch->id), //进行字段唯一性验证时忽略指定 ID
            ],
        ]);

        $field = array_intersect($branch->getFillable(), array_keys(\request()->toArray()));   //得到可修改的字段

        foreach ($field as $k => $v) {
            $branch->$v = \request()->$v;    //循环赋值
        }

        $branch->save();    //保存至数据库

        return ['msg' => '编辑成功'];            //返回结果
    }



    /**
     * 删除部门
     * @param Branch $branch    部门模型
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response   返回json
     * @throws \Exception   响应错误
     */
    public function del(Branch $branch)
    {
        //不允许删除默认分组
        if (1 == $branch->id){
            return response(['msg' => '你是真的皮'],400);
        }

        //将此部门下的所有老师移至默认分组
        foreach ($branch->teacher as $teacher){
            $teacher->branch_id = 1;
            $teacher->save();
        }

        //执行删除部门
        $branch->delete();
        //返回json数据
        return ['msg' => '删除部门成功'];
    }

    /*
 * 搜索
 */
    public function searchStore(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $username = $request->username;

        $start = empty($start) ? date('Y-m-d H:i:s', 0) : $start . ' 00:00:00';     //如果开始时间为空，则为初始时间

        $end = empty($end) ? date('Y-m-d H:i:s', time()) : $end . ' ' . explode(' ', date('Y-m-d H:i:s', time()))[1];   //如果结束时间为空，则为当前时间

        if (empty($username)) {
            $dataset = Branch::whereBetween('created_at', [$start, $end])->paginate(10);    //如果用户名为空，则不添加用户名条件
        } else {
            $dataset = Branch::where('name', 'like', '%' . $username . '%')->whereBetween('created_at', [$start, $end])->paginate(10);  //如果都有值，则添加所有条件
        }

        $start = explode(' ', $start)[0];
        $end = explode(' ', $end)[0];

        return view("admin.branch.branch_list",compact('dataset', 'start', 'end', 'username'));
    }

}
