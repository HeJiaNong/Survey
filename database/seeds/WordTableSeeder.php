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
        Word::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        //指定一条数据
//        $user = Word::find(1);
//        $user->name = '何佳农';
//        $user->sex = '男';
//        $user->email = 'jianonghe@gmail.com';
//        $user->password = bcrypt('hejiang335200');
//        $user->number = 18780260029;
//        $user->addr = '成都';
//        $user->status = 1;
        //保存数据
//        $user->save();
    }
}
