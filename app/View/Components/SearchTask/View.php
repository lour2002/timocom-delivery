<?php

namespace App\View\Components\SearchTask;

use Illuminate\View\Component;

define('EMPTY_COUNTRY', "-- is empty --");

define('ALL_DATES', 'app:cnt:searchForm:dateSelectOpt1');
define('INDIVIDUAL', 'app:cnt:searchForm:dateSelectOpt2');
define('PERIOD', 'app:cnt:searchForm:dateSelectOpt3');

define('FROM_AREA', "app:cnt:searchForm:fromSelectOpt3");

define('TO_COUNTRY', "app:cnt:searchForm:toSelectOpt2");

define('FREIGHT_LIMIT', "app:cnt:searchForm:freightSelectOpt2");

abstract class View extends Component
{
    public $task;
    public $task_id;
    public $task_status = 'Stopped';
    public $task_name;
    public $task_driver_cost;

    public $task_from_type;
    public $task_from_country;
    public $task_from_zip;
    public $task_from_radius;

    public $task_to_type;
    public $task_to_array;

    public $task_freight_type;
    public $task_length_min = "0.00";
    public $task_length_max = "6.00";
    public $task_weight_min = "0.00";
    public $task_weight_max = "1.6";

    public $task_date_type;
    public $task_individual_days = "29.03.2021";
    public $task_period_start = "22.02.2021";
    public $task_period_stop = "23.02.2021";

    public $task_car_country;
    public $task_car_zip;
    public $task_car_city;

    public $task_cross_border;
    public $task_tags;
    public $task_email_template;




    public $FROM_TYPES = [
      FROM_AREA => "Area search"
    ];
    public $TO_TYPES = [
      TO_COUNTRY => "Country selection"
    ];
    public $FREIGHT_TYPES = [
      FREIGHT_LIMIT => "Limit the search"
    ];
    public $DATE_TYPES = [
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

        $this->task_id = $task['id'] ?? 0;
        $this->task_status = $task['status'] ?? '';
        $this->task_name = $task['name'] ?? '';
        $this->task_driver_cost = $task['driverCost'] ?? 0;

        // FROM
        $this->task_from_type = $task['fromSelectOpt'] ?? FROM_AREA;
        $this->task_from_country = $task['as_country'] ?? EMPTY_COUNTRY;
        $this->task_from_zip = $task['as_zip'] ?? '';
        $this->task_from_radius = $task['as_radius'] ?? '';

        //  TO
        $this->task_to_array = json_decode($task['toSelectOptArray'] ?? "[]", true);
        $this->task_to_type = $task['toSelectOpt'] ?? TO_COUNTRY;

        // FREIGHT
        $this->task_freight_type = $task['freightSelectOpt'] ?? FREIGHT_LIMIT;
        $this->task_length_min = $task['length_min'] ?? '';
        $this->task_length_max = $task['length_max'] ?? '';
        $this->task_weight_min = $task['weight_min'] ?? '';
        $this->task_weight_max = $task['weight_max'] ?? '';

        // DATES
        $this->task_date_type = $task['dateSelectOpt'] ?? ALL_DATES;
        $this->task_individual_days = $task['individual_days'] ?? date("d.m.Y");
        $this->task_period_start = $task['period_start'] ?? date("d.m.Y");
        $this->task_period_stop = $task['period_stop'] ?? date("d.m.Y");

        // CAR
        $this->task_car_country = $task['car_country'] ?? EMPTY_COUNTRY;
        $this->task_car_zip = $task['car_zip'] ?? '';
        $this->task_car_city = $task['car_city'] ?? '';

        $this->task_cross_border = json_decode($task['cross_border'] ?? "[]", true);
        $this->task_tags = $task['tags'] ?? '';
        $this->task_email_template = $task['email_template'] ?? '';



    }
}
