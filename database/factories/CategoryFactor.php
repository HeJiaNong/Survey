<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Category::class, function (Faker $faker) {
    /*
     * define 方法接收两个参数，第一个参数为指定的 Eloquent 模型类，
     * 第二个参数为一个闭包函数，该闭包函数接收一个 Faker PHP 函数库的实例，
     * 让我们可以在函数内部使用 Faker 方法来生成假数据并为模型的指定字段赋值。
     */
    $date_time = $faker->date . ' ' . $faker->time;

    $name = $faker->unique()->randomElement(['问卷调查','在线考试','在线投票','报名表单','在线测评','业余生活调查']);

    return [
        'name' => $name,
        'describe' => '巴拉巴拉...',
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
