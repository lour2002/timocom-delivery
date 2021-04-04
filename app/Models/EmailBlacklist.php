<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailBlacklist extends Model
{
    protected $fillable = [
        'user_id', 'email', 'ttl'
    ];

    protected $table = 'email_blacklist';

}
