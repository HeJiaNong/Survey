<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    //允许添加的字段
    protected $fillable = ['name','describe'];
}
