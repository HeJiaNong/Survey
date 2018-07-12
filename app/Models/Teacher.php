<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    //允许写入的字段
    protected $fillable = ['name','sex','email','number','addr','status','branch_id'];
    //不可写入的字段
    protected $guarded = ['id'];
    //要隐藏的字段
    protected $hidden = [];


    /*
     * 一个老师关联一个部门
     */
    public function branch()
    {
        return $this->belongsTo('App\Models\Branch')->withDefault();
    }

    /*
     * 一个老师关联多个班级
     */
    public function grade()
    {
        return $this->belongsToMany('App\Models\Grade');
    }

}
