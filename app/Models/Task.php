<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Task extends Model
{
    protected $fillable = [
        'name', 'status_job', 'version_task', 'fromSelectOpt', 'as_country', 'as_zip',
        'as_radius', 'toSelectOpt', 'toSelectOptArray', 'freightSelectOpt', 'length_min', 'length_max',
        'weight_min', 'weight_max', 'dateSelectOpt', 'individual_days', 'period_start', 'period_stop',
        'car_country', 'car_zip', 'car_city', 'car_price_empty', 'car_price', 'car_price_extra_points',
        'exchange_equipment', 'minimal_price_order', 'percent_stop_value', 'cross_border', 'tags', 'email_template'
    ];
}
