<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{


    protected $fillable = ['name','category_id','status'];

    /*
     * 模型关联
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function word() {
        return $this->belongsToMany('App\Models\Word');
    }
}
