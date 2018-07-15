<?php

use Illuminate\Database\Seeder;
use App\Models\Word;

class WordTableSeeder extends Seeder
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
        $users = factory(Word::class)->times(3)->make();


        Word::insert($users->toArray());

        //赋值多对多关联
        foreach (Word::all() as $value){
            $value->grade()->attach(mt_rand(1,20));
        }

    }
}
