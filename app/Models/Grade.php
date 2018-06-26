<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['name','count','teacher_id','status'];

    /*
     * 一个班级关联一个老师
     */
    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }
}
