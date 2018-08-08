<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['word_id','grade_id','answer','name','email','number','sex','qq_number','ip_address','country','region','city','isp'];

    //属性类型转换    定义后，该字段任何操作都会被转换
//    protected $casts = [
//        'answer' => 'array',
//    ];

    public function word()
    {
        return $this->belongsTo('App\Models\Word');
    }

    public function grade()
    {
        return $this->belongsTo('App\Models\Grade');
    }

    //定义一个访问器   将json字符串转为数组    所有对此字段的访问将会得到一个json_decode后的值
    public function getAnswerAttribute($value){
        return json_decode($value,true);
    }

}
