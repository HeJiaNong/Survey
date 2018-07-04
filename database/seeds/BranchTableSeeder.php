<?php

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //生成数据
        //times 要生成记录的数量
        //make 生成数据
        $users = factory(Branch::class)->times(3)->make();
        Branch::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        //指定一条数据
        $user = Branch::find(1);
        $user->name = '软件部';
        $user->status = 1;
        //保存数据
        $user->save();
    }
}
