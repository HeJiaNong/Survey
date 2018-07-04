<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['name','count','teacher_id','status'];

    protected $table = 'grades';


    public function word(){
        return $this->belongsToMany('App\Models\Word');
    }

    /*
     * 一个班级关联多个老师
     */
    public function teacher()
    {
        return $this->belongsToMany('App\Models\Teacher');
    }
}
