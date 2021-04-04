<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'offer_id', 'date_collection', 'name', 'email', 'phone', 'company_id', 'freight_length', 'freight_weight',
        'freight_description', 'price', 'equipment_exchange', 'vehicle_type', 'vehicle_description', 'remarks',
        'loading_places', 'unloading_places', 'distance', 'from', 'to'
    ];

    public function task(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Task::class);
    }
}
