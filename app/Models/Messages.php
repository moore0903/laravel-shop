<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'name', 'phone', 'city','area','content','ip'
    ];
}
