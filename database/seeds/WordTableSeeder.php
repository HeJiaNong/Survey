<?php

use Illuminate\Database\Seeder;
use App\Models\Word;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $i = 1;
        foreach ($users as $user){
            //通过id生成二维码
            QrCode::format('png')->size(200)->generate(route('home_wordShow',$i),public_path('static/qrcodes/'.$i.'.png'));
            $user->qrcode = URL::asset('/static/qrcodes/').'/'.$i.'.png';
            $i++;
        }
        Word::insert($users->toArray());



        //赋值多对多关联
        foreach (Word::all() as $value){
            $value->grade()->attach(mt_rand(1,20));
            $value->rule()->attach([1,2,3,4,5]);
        }

    }
}
