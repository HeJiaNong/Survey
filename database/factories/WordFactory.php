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
        'content' => '{
 "pages": [
  {
   "name": "页面1",
   "elements": [
    {
     "type": "emotionsratings",
     "name": "近期学校餐饮条件,食堂卫生情况,以及用餐费用.",
     "title": "近期学校餐饮条件,食堂卫生情况,以及用餐费用.",
     "valueName": "近期学校餐饮条件,食堂卫生情况,以及用餐费用",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "校园超市是否出售三无产品、过期产品。",
     "title": "校园超市是否出售三无产品、过期产品。",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "学生浴室水温是否合适，水量是否充足。",
     "title": "学生浴室水温是否合适，水量是否充足。",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "对学生的学习和生活所需的各类维修状况是否及时。",
     "title": "对学生的学习和生活所需的各类维修状况是否及时。",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "库房物资领用是否顺畅，服务态度是否好。",
     "title": "库房物资领用是否顺畅，服务态度是否好。",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "教师上课、上机时，对作业是否每次都认真批改和讲评？",
     "title": "教师上课、上机时，对作业是否每次都认真批改和讲评？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "学校教师能够为人师表、按时上课？",
     "title": "学校教师能够为人师表、按时上课？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "教师备课充分、课堂内容充实、具有条理性？",
     "title": "教师备课充分、课堂内容充实、具有条理性？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "学校组织的测验和考试的内容能反映课程的重要部分？",
     "title": "学校组织的测验和考试的内容能反映课程的重要部分？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "课外教师经常主动找学生谈心，了解并指导学生学习？",
     "title": "课外教师经常主动找学生谈心，了解并指导学生学习？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "课内外教师都愿意解答和帮助学生，上机均有老师辅导？",
     "title": "课内外教师都愿意解答和帮助学生，上机均有老师辅导？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "任课老师在上课前是否对班级学生点名？",
     "title": "任课老师在上课前是否对班级学生点名？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "学校的职业素质课对我帮助很大，对班级学生素质提升有益？",
     "title": "学校的职业素质课对我帮助很大，对班级学生素质提升有益？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "任课老师在上课时是否对违纪学生进行管理或提醒？",
     "title": "任课老师在上课时是否对违纪学生进行管理或提醒？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "教师语言清晰流畅、言能达意、讲课生动、形象？",
     "title": "教师语言清晰流畅、言能达意、讲课生动、形象？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "班主任工作负责，经常主动找学生谈心，及时协调处理学生反映的各类问题并将处理结果反馈给学生？",
     "title": "班主任工作负责，经常主动找学生谈心，及时协调处理学生反映的各类问题并将处理结果反馈给学生？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "学校考试纪律严明，考风正派？",
     "title": "学校考试纪律严明，考风正派？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "学校组织了职业素质课程教育，个人受益很多？",
     "title": "学校组织了职业素质课程教育，个人受益很多？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "学生宿舍内卫生干净整洁？",
     "title": "学生宿舍内卫生干净整洁？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "emotionsratings",
     "name": "宿舍管理员服务态度好，宿舍管理有序，未发生偷盗、打架、男女生串房、留宿外来人员等现象？",
     "title": "宿舍管理员服务态度好，宿舍管理有序，未发生偷盗、打架、男女生串房、留宿外来人员等现象？",
     "isRequired": true,
     "choices": [
      {
       "value": 1,
       "text": "不满意"
      },
      {
       "value": 2,
       "text": "普通"
      },
      {
       "value": 3,
       "text": "满意"
      },
      {
       "value": 4,
       "text": "很满意"
      },
      {
       "value": 5,
       "text": "非常满意"
      }
     ]
    },
    {
     "type": "comment",
     "name": "如有其他意见，请认真反馈",
     "title": "如有其他意见，请认真反馈"
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
