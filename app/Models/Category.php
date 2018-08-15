<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable = ['name','describe','formula_mode'];

    /*
     * 模型关联
     */
    public function topic()
    {
        return $this->hasMany('App\Models\Topic');
    }

    public function word(){
        return $this->hasMany('App\Models\Word');
    }

}
