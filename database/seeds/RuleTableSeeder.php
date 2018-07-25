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
        $rule->validate = "'required'";
        $rule->topic_json = <<<EOF
        {
                    "name": "用户名",
                    "elements": [
                        {
                            "type": "text",
                            "name": "name",
                            "title": {
                                "zh-cn": "用户名"
                            },
                            "isRequired": true,
                            "placeHolder": {
                                "zh-cn": "your name"
                            }
                        }
                    ]
                }
EOF;

        $rule->save();

        $rule = new Rule();
        $rule->name = 'email';
        $rule->title = '邮箱';
        $rule->validate = "'required|email'";
        $rule->topic_json = <<<EOF
        {
                    "name": "邮箱",
                    "elements": [
                        {
                            "type": "text",
                            "name": "email",
                            "title": {
                                "zh-cn": "邮箱"
                            },
                            "isRequired": true,
                            "inputType": "email",
                            "placeHolder": {
                                "zh-cn": "your@email.com"
                            }
                        }
                    ]
                }
EOF;
        $rule->save();

        $rule = new Rule();
        $rule->name = 'number';
        $rule->title = '电话号码';
        $rule->validate = "'required|integer'";
        $rule->topic_json = <<<EOF
        {
                    "name": "电话号码",
                    "elements": [
                        {
                            "type": "text",
                            "name": "number",
                            "title": {
                                "zh-cn": "电话号码"
                            },
                            "isRequired": true,
                            "inputType": "number",
                            "placeHolder": {
                                "zh-cn": "your number"
                            }
                        }
                    ],
                    "maxTimeToFinish": 15
                }
EOF;
        $rule->save();

        $rule = new Rule();
        $rule->name = 'sex';
        $rule->title = '性别';
        $rule->validate = "'required'";
        $rule->topic_json = <<<EOF
        {
                    "name": "性别",
                    "elements": [
                        {
                            "type": "radiogroup",
                            "name": "sex",
                            "title": {
                                "zh-cn": "性别"
                            },
                            "isRequired": true,
                            "choices": [
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
        $rule->validate = "'required|integer'";
        $rule->topic_json = <<<EOF
        {
                    "name": "QQ号码",
                    "elements": [
                        {
                            "type": "text",
                            "name": "qq_number",
                            "title": {
                                "zh-cn": "QQ号码"
                            },
                            "isRequired": true,
                            "inputType": "number",
                            "placeHolder": {
                                "zh-cn": "马化腾给的"
                            }
                        }
                    ]
                }
EOF;
        $rule->save();



    }
}
