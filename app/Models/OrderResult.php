<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderResult extends Model
{
    public const STATUS_NONE = 'NONE';
    public const STATUS_SENT = 'SENT';
    public const STATUS_BORDER = 'BORDER';
    public const STATUS_DUPLICATE = 'DUPLICATE';
    public const STATUS_STOP = 'STOP';
    public const STATUS_LOW_PRICE = 'LOW_PRICE';
    public const STATUS_EQUIPMENT = 'EQUIPMENT';
    public const STATUS_OVERPRICE = 'OVERPRICE';
    public const STATUS_BLACKLIST = 'BLACKLIST';

    protected $fillable = [
        'task_id', 'order_id', 'price', 'distance', 'status'
    ];

    protected $table = 'order_result';

    public function order(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Order::class);
    }
}
