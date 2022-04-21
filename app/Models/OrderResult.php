<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class OrderResult extends Model
{
    use AsSource, Filterable, Attachable;

    public const STATUS_NONE = 'NONE';
    public const STATUS_SENT = 'SENT';
    public const STATUS_BORDER = 'BORDER';
    public const STATUS_DUPLICATE = 'DUPLICATE';
    public const STATUS_STOP = 'STOP';
    public const STATUS_LOW_PRICE = 'LOW_PRICE';
    public const STATUS_EQUIPMENT = 'EQUIPMENT';
    public const STATUS_OVERPRICE = 'OVERPRICE';
    public const STATUS_BLACKLIST = 'BLACKLIST';

    public const STATUSES = [
        self::STATUS_NONE,
        self::STATUS_SENT,
        self::STATUS_BORDER,
        self::STATUS_DUPLICATE,
        self::STATUS_STOP,
        self::STATUS_LOW_PRICE,
        self::STATUS_EQUIPMENT,
        self::STATUS_OVERPRICE,
        self::STATUS_BLACKLIST,
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders_result';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_id',
        'order_id',
        'price',
        'distance',
        'status',
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
