<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThirdUser extends Model
{
    protected $table = 'users_third';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'standard_id', 'platform','nick_name','name','avatar','extdata'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
