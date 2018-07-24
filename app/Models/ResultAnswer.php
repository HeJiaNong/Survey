<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultAnswer extends Model
{
    protected $fillable = ['word_id','answer'];

    public function word()
    {
        return $this->belongsTo('App\Models\Word');
    }
}
