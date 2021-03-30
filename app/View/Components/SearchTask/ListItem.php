<?php

namespace App\View\Components\SearchTask;

use Illuminate\View\Component;

define('ALL_DATES', 'app:cnt:searchForm:dateSelectOpt1');
define('INDIVIDUAL', 'app:cnt:searchForm:dateSelectOpt2');
define('PERIOD', 'app:cnt:searchForm:dateSelectOpt3');

class ListItem extends Component
{
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
    public $task_date_type;
    public $task_dates;

    private static $FROM_TYPES = [
      "app:cnt:searchForm:fromSelectOpt3" => "Area search"
    ];
    private static $TO_TYPES = [
      "app:cnt:searchForm:toSelectOpt2" => "Country selection"
    ];
    private static $DATE_TYPES = [
      ALL_DATES => "All dates",
      INDIVIDUAL => "Individual days",
      PERIOD => "Period"
    ];
    /**
     * Create a new component instance.
     * @param  array  $task
     * @return void
     */
    public function __construct($task)
    {
        $this->task_id = $task['id'] ?? 1143;
        $this->task_status = $task['status'] ?? "stopped";
        $this->task_name = $task['name'] ?? "SER";
        $this->task_driver_cost = $task['driverCost'] ?? 0.69;

        //  FROM
        $this->task_from_type = $this->FROM_TYPES[$task['fromSelectOpt'] ?? ""] ?? "Area search";
        $this->task_from_country = $task['as_country'] ?? "DE Germany";
        $this->task_from_zip = $task['as_zip'] ?? "88214";
        $this->task_from_radius = $task['as_radius'] ?? "140";

        //  TO
        $this->task_to_type = $this->TO_TYPES[$task['toSelectOpt'] ?? ""] ?? "Area search";
        $toSelectArray = $task['toSelectOptArray'] ?? [[
                                                           "as_country_to" => "CH Switzerland",
                                                           "post1" => "",
                                                           "post2" => "",
                                                           "post3" => ""
                                                       ],
                                                       [
                                                           "as_country_to" => "CZ Czech Republic",
                                                           "post1" => "",
                                                           "post2" => "",
                                                           "post3" => ""
                                                       ],
                                                       [
                                                           "as_country_to" => "LU Luxembourg",
                                                           "post1" => "",
                                                           "post2" => "",
                                                           "post3" => ""
                                                       ],
                                                       [
                                                           "as_country_to" => "LI Liechtenstein",
                                                           "post1" => "",
                                                           "post2" => "",
                                                           "post3" => ""
                                                       ],
                                                       [
                                                           "as_country_to" => "IT Italy",
                                                           "post1" => "",
                                                           "post2" => "",
                                                           "post3" => ""
                                                       ]];


        $task_to_countries = array_reduce($toSelectArray, function ($accumulator, $item) {
            array_push($accumulator, $item['as_country_to']);
            return $accumulator;
        },[]);

        $this->task_to_countries = implode(", ", $task_to_countries);
        // DATES
        $this->task_date_type = $this->DATE_TYPES[$task['dateSelectOpt'] ?? ""] ?? "All dates";

        switch ($task['dateSelectOpt'] ?? "") {
            case PERIOD:
                $this->task_dates = $task['period_stop'] . " - " . $task['period_stop'];
                break;
            case INDIVIDUAL:
                $this->task_dates = $task['individual_days'];
                break;
            default:
                $this->task_dates = '';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.search-task.list-item');
    }
}
