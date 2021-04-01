<?php

namespace App\View\Components\SearchTask;

use Illuminate\View\Component;
use App\View\Components\SearchTask\View;


class ListItem extends View
{
    public $task_dates_view;

    /**
     * Create a new component instance.
     * @param  array  $task
     * @return void
     */
    public function __construct($task)
    {
        parent::__construct($task);
        // FROM

        // TO
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

        // FREIGHT

        // DATES
        $this->task_date_type = $this->DATE_TYPES[$task['dateSelectOpt'] ?? ""] ?? "All dates";

        switch ($task['dateSelectOpt'] ?? "") {
            case PERIOD:
                $this->task_dates_view = $task['period_stop'] . " - " . $task['period_stop'];
                break;
            case INDIVIDUAL:
                $this->task_dates_view = $task['individual_days'];
                break;
            default:
                $this->task_dates_view = '';
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
