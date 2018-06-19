<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //fillable 与 guarded 只限制了 create 方法，而不会限制 save。 只在创建数据时限制，不限制修改数据
    //允许写入/修改的字段
    protected $fillable = [
        'name','number','sex','email', 'password','number','addr', 'status','activated',
    ];

    //不可写入的字段
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
