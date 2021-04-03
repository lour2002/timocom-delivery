<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'offer_id', 'date_collection', 'name', 'email', 'phone', 'company_id', 'loading_places', 'unloading_places',
        'distance', 'from_country', 'from_zip', 'from_city', 'from_date1', 'from_date2', 'from_time1', 'from_time2', 'to'
    ];
}
