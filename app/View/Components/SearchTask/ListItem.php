<?php

namespace App\View\Components\SearchTask;

use Illuminate\View\Component;
use App\View\Components\SearchTask\View;


class ListItem extends View
{
    public $task_title_status;
    public $task_dates_view;
    public $task_to_countries;

    /**
     * Create a new component instance.
     * @param  array  $task
     * @return void
     */
    public function __construct($task)
    {
        parent::__construct($task);
        $this->task_title_status = 'Stopped';
        // FROM
        $this->task_from_type = $this->FROM_TYPES[$this->task_from_type];
        // TO
        $this->task_to_type = $this->TO_TYPES[$this->task_to_type];

        $task_to_countries = array_reduce($this->task_to_array, function ($accumulator, $item) {
            if ($item['as_country_to'] !== EMPTY_COUNTRY) {
                $countries = explode(' ', $item['as_country_to']);
                array_push($accumulator, array_shift($countries));
            }
            return $accumulator;
        },[]);

        $this->task_to_countries = implode(", ", $task_to_countries);

        // FREIGHT

        // DATES
        $this->task_date_type = $this->DATE_TYPES[$this->task_date_type];

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
