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
        'category_id' => mt_rand(1,3),
        'topics_html' => '暂无',
        'content' => '{
 "pages": [
  {
   "name": "页面2",
   "elements": [
    {
     "type": "emotionsratings",
     "name": "问题1",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题2",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题3",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题4",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题5",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题6",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题7",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题8",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题9",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题10",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题11",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题12",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题13",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题14",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题15",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题16",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题17",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题18",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题19",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
     ]
    },
    {
     "type": "emotionsratings",
     "name": "问题20",
     "isRequired": true,
     "choices": [
      1,
      2,
      3,
      4,
      5
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
