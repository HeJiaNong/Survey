<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultUserinfo extends Model
{
    protected $fillable = ['word_id','name','email','number','sex','qq_number','ip_address','country','region','city','isp'];

    public function word()
    {
        return $this->belongsTo('App\Models\Word');
    }

}
