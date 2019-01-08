<?php

use Illuminate\Database\Seeder;

class QRCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //由于使用了 Iseed 逆向填充数据，qrcode图片数据遗漏，故增加此seeder来填充图片数据
        $words = \App\Models\Word::all();
        $i = 1;
        foreach ($words as $word){
            //通过id生成二维码
            QrCode::format('png')->size(200)->generate(route('home_wordShow',$i),public_path('static/qrcodes/'.$i.'.png'));
            $word->qrcode = URL::asset('/static/qrcodes/').'/'.$i.'.png';
            $i++;
        }

    }
}
