<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Task extends Model
{
    use AsSource, Filterable, Attachable;

    public const STATUS_START = '3';
    public const STATUS_TEST = '2';
    public const STATUS_STOP = '1';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'user_id','user_key', 'name', 'status_job', 'num', 'version_task', 'fromSelectOpt', 'as_country', 'as_zip',
        'as_radius', 'toSelectOpt', 'toSelectOptArray', 'freightSelectOpt', 'length_min', 'length_max',
        'weight_min', 'weight_max', 'dateSelectOpt', 'individual_days', 'car_position_coordinates','car_price_empty',
        'car_price', 'car_price_extra_points', 'car_price_special_price', 'exchange_equipment', 'minimal_price_order',
        'percent_stop_value', 'cross_border', 'tags', 'email_template'
    ];
}
