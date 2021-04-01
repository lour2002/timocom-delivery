<?php

namespace App\View\Components\SearchTask;

use Illuminate\View\Component;

define('ALL_DATES', 'app:cnt:searchForm:dateSelectOpt1');
define('INDIVIDUAL', 'app:cnt:searchForm:dateSelectOpt2');
define('PERIOD', 'app:cnt:searchForm:dateSelectOpt3');

abstract class View extends Component
{
    public $task;
    public $task_id;
    public $task_status;
    public $task_name;
    public $task_driver_cost;

    public $task_from_type;
    public $task_from_country;
    public $task_from_zip;
    public $task_from_radius;

    public $task_to_type;
    public $task_to_countries;

    public $task_freight_type;
    public $task_length_min;
    public $task_length_max;
    public $task_weight_min;
    public $task_weight_max;

    public $task_date_type;
    public $task_individual_days;
    public $task_period_start;
    public $task_period_stop;


    private static $FROM_TYPES = [
      "app:cnt:searchForm:fromSelectOpt3" => "Area search"
    ];
    private static $TO_TYPES = [
      "app:cnt:searchForm:toSelectOpt2" => "Country selection"
    ];
    private static $FREIGHT_TYPES = [
      "app:cnt:searchForm:freightSelectOpt2" => "Limit the search"
    ];
    private static $DATE_TYPES = [
      ALL_DATES => "All dates",
      INDIVIDUAL => "Individual days",
      PERIOD => "Period"
    ];


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($task)
    {
        $this->task = $task;

        if (count($task)) {
            $this->task_id = $task['id'];
            $this->task_name = $task['name'];
        }

//         $this->task_id = $task['id'];
//         $this->task_status = $task['status'] ?? '';
//         $this->task_name = $task['name'];
//         $this->task_driver_cost = $task['driverCost'];
//
//         // FROM
//         $this->task_from_type = $this->FROM_TYPES[$task['fromSelectOpt']];
//         $this->task_from_country = $task['as_country'];
//         $this->task_from_zip = $task['as_zip'];
//         $this->task_from_radius = $task['as_radius'];
//
//         //  TO
//         $this->task_to_type = $this->TO_TYPES[$task['toSelectOpt'] ?? ""] ?? "Area search";

        // FREIGHT

        // DATES

    }
}
