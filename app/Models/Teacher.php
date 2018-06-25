<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //允许写入的字段
    protected $fillable = ['name','sex','email','number','addr','status','branches_id'];
    //不可写入的字段
    protected $guarded = ['id'];
    //要隐藏的字段
    protected $hidden = [];

}
