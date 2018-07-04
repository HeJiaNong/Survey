<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    //允许添加的字段
    protected $fillable = ['name','describe'];


    public function grade(){
        return $this->belongsToMany('App\Models\Grade');
    }

    public function topic(){
        return $this->belongsToMany('App\Models\Topic');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category')->withDefault();
    }


}
