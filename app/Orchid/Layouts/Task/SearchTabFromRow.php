<?php

namespace App\Orchid\Layouts\Task;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Label;

use Orchid\Support\Facades\Layout;

use App\Models\Task;

use App\Orchid\Presenters\TaskPresenter;

class SearchTabFromRow extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    public function __construct() {
        $this->title = 'CURRENT POSITION OF THE TRUCK / FROM';
    }

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        $options = TaskPresenter::countriesSelectOptions();

        $task = $this->query->get('task');

        $result = [
            Group::make([
                Select::make('task.as_country')
                        ->title('Country')
                        ->options($options),
                Input::make('task.as_zip')
                        ->title('ZIP code')
                        ->placeholder('zip code'),
                Input::make('task.as_radius')
                        ->title('Radius')
                        ->type('number')
                        ->placeholder('0'),
                Input::make('task.car_city')
                        ->title('City')
                        ->placeholder('City'),
            ]),
        ];

        if (!$task['car_position_coordinates']) {
            $result = array_merge($result, [
                Label::make('static')
                    ->value('Truck position not defined')
                    ->set('class', 'text-danger'),
            ]);
        }

        return $result;
    }
}
