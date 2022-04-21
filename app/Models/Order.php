<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_id',
        'offer_id',
        'date_collection',
        'name',
        'company',
        'email',
        'phone',
        'company_id',
        'freight_length',
        'freight_weight',
        'freight_description',
        'payment_due',
        'price',
        'equipment_exchange',
        'vehicle_type',
        'vehicle_description',
        'remarks',
        'loading_places',
        'unloading_places',
        'distance',
        'from',
        'to',
    ];

    public function task(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Task::class, 'id', 'task_id');
    }
}
