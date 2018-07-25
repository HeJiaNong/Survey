<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Word::class, function (Faker $faker) {
    /*
     * define 方法接收两个参数，第一个参数为指定的 Eloquent 模型类，
     * 第二个参数为一个闭包函数，该闭包函数接收一个 Faker PHP 函数库的实例，
     * 让我们可以在函数内部使用 Faker 方法来生成假数据并为模型的指定字段赋值。
     */
    $date_time = $faker->date . ' ' . $faker->time;


    $name = array_random(['学生','老师','家长','社会']).array_random(['综合','卫生','授课','服务','食物']).array_random(['满意度','工作']).'调查';

    return [
        'name' => $name,
        'describe' => $faker->text,
        'category_id' => mt_rand(1,4),
        'content' => '{
 "pages": [
  {
   "name": "page1",
   "elements": [
    {
     "type": "rating",
     "name": "冬哥有多优秀？",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题17",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题16",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题15",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题14",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题13",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题12",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题11",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题10",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题9",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题8",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题7",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题6",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题5",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题4",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题3",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题2",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题1",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题19",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    },
    {
     "type": "rating",
     "name": "问题18",
     "title": "冬哥有多优秀？",
     "isRequired": true,
     "rateValues": [
      "秀",
      "天秀",
      "蒂花之秀",
      "造化钟神秀",
      "社会主义接班人就属你最优秀"
     ]
    }
   ]
  }
 ]
}',
        'status' => false,
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
