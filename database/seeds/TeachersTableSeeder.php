<?php

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeachersTableSeeder extends Seeder
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
        $users = factory(Teacher::class)->times(50)->make();
        Teacher::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        //指定一条数据
        $user = Teacher::find(1);
        $user->name = '冬哥';
        $user->sex = '男';
        //保存数据
        $user->save();
    }
}
