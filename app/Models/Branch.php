<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name','status'];

    protected $table = 'branches';


    public function teacher()
    {
        return $this->hasMany('App\Models\Teacher');
    }

}
