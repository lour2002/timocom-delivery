<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Smtp extends Model
{
    protected $fillable = [
        'user_id', 'email', 'server', 'secure', 'port', 'login', 'password'
    ];

    protected $table = 'smtp';

}
