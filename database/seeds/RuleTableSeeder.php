<?php

use Illuminate\Database\Seeder;
use App\Models\Rule;

class RuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rule = new Rule();
        $rule->name = '用户名';
        $rule->validate = "'required'";
        $rule->save();

        $rule = new Rule();
        $rule->name = '邮箱';
        $rule->validate = "'required|email'";
        $rule->save();

        $rule = new Rule();
        $rule->name = '电话号码';
        $rule->validate = "'required|integer'";
        $rule->save();

        $rule = new Rule();
        $rule->name = '性别';
        $rule->validate = "'required'";
        $rule->save();

        $rule = new Rule();
        $rule->name = 'qq号码';
        $rule->validate = "'required|integer'";
        $rule->save();



    }
}
