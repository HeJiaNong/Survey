<?php

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeTableSeeder extends Seeder
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
        $users = factory(Grade::class)->times(20)->make();
        Grade::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        //指定一条数据
        $user = Grade::find(1);
        $user->name = '15三年软件2';
        $user->count = 30;
        $user->status = true;
        $user->teacher_id = 1;
        //保存数据
        $user->save();
    }
}
