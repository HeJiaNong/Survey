<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //允许写入的字段
    protected $fillable = [];
    //不可写入的字段
    protected $guarded = [];
    //要隐藏的字段
    protected $hidden = [];

}
