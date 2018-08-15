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
        $teachers = factory(Teacher::class)->times(50)->make();

        Teacher::insert($teachers->toArray());

        //赋值多对多关联   班级
        foreach (Teacher::all() as $teacher){
            $teacher->grade()->attach(mt_rand(1,20));
        }

        //指定一条数据
        $teacher = Teacher::find(1);
        $teacher->name = '冬哥';
        $teacher->sex = '男';
        $teacher->status = true;
        $teacher->branch_id = 1;
        //保存数据
        $teacher->save();
    }
}
