<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['word_id','grade_id','answer','name','email','number','sex','qq_number','ip_address','country','region','city','isp'];

    public function word()
    {
        return $this->belongsTo('App\Models\Word');
    }

    public function grade()
    {
        return $this->belongsTo('App\Models\Grade');
    }
}
