<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    //允许添加的字段
    protected $fillable = ['name','title'];

    public function word()
    {
        return $this->belongsToMany('App\Models\Word');
    }
}
