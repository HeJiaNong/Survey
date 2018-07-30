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
        $rule->name = 'name';
        $rule->title = '用户名';
        $rule->topic_json = <<<EOF
        {
   name: "name",
   elements: [
    {
     type: "text",
     name: "name",
     title: "姓名",
     isRequired: true
    }
   ]
  }
EOF;

        $rule->save();

        $rule = new Rule();
        $rule->name = 'email';
        $rule->title = '邮箱';
        $rule->topic_json = <<<EOF
        {
   name: "email",
   elements: [
    {
     type: "text",
     name: "email",
     title: "邮箱",
     isRequired: true,
     validators: [
      {
       type: "email"
      }
     ],
     inputType: "email"
    }
   ]
  }
EOF;
        $rule->save();

        $rule = new Rule();
        $rule->name = 'number';
        $rule->title = '电话号码';
        $rule->topic_json = <<<EOF
        {
   name: "number",
   elements: [
    {
     type: "text",
     name: "number",
     title: "电话号码",
     isRequired: true,
     validators: [
      {
       type: "numeric"
      }
     ],
     inputType: "tel",
     size: "",
     maxLength: 11,
     placeHolder: "请输入11位电话号码"
    }
   ]
  }
EOF;
        $rule->save();

        $rule = new Rule();
        $rule->name = 'sex';
        $rule->title = '性别';
        $rule->topic_json = <<<EOF
        {
   name: "sex",
   elements: [
    {
     type: "radiogroup",
     name: "sex",
     title: "性别",
     isRequired: true,
     choices: [
      "男",
      "女"
     ]
    }
   ]
  }
EOF;
        $rule->save();

        $rule = new Rule();
        $rule->name = 'qq_number';
        $rule->title = 'QQ号码';
        $rule->topic_json = <<<EOF
        {
   name: "qq_number",
   elements: [
    {
     type: "text",
     name: "qq_number",
     title: "QQ号码",
     isRequired: true,
     inputType: "number",
     maxLength: 10
    }
   ]
  }
EOF;
        $rule->save();



    }
}
