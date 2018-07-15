<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicTableSeeder extends Seeder
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
        $users = factory(Topic::class)->times(3)->make();
        Topic::insert($users->toArray());

    }
}
