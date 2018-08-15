<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
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
        $data = factory(Category::class)->times(3)->make();

        Category::insert($data->toArray());

        //指定一条数据
        $teacher = Category::find(1);
        $teacher->name = '新华分数统计';
        $teacher->describe = '此分组下的问卷专门用于学校问卷分数统计调查';
        //保存数据
        $teacher->save();

    }
}
