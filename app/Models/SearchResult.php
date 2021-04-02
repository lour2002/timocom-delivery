<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchResult extends Model
{
    protected $fillable = [
        'id_task', 'offer_id', 'content_order_64'
    ];
}
