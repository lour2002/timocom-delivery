<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cookies extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cookies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_key',
        'cookie',
        'hash'
    ];

}
