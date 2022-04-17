<?php

namespace App\Orchid\Layouts\Task;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Select;

use Orchid\Support\Facades\Layout;

use App\Orchid\Presenters\TaskPresenter;

class ExceptionTabCrossBorderRow extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    public function __construct() {
        $this->title = 'CROSSING THE BORDER:';
    }

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        $options = TaskPresenter::countriesSelectOptions();

        return [
            Group::make([
                Select::make('task.cross_border.0.border_country')
                        ->title('Country')
                        ->options($options),
                Input::make('task.cross_border.0.border_val')
                        ->title('Weight')
                        ->type('number')
                        ->set('step', '0.01')
                        ->placeholder('0'),
            ]),
            Group::make([
                Select::make('task.cross_border.1.border_country')
                        ->options($options),
                Input::make('task.cross_border.1.border_val')
                        ->type('number')
                        ->set('step', '0.01')
                        ->placeholder('0'),
            ]),
            Group::make([
                Select::make('task.cross_border.2.border_country')
                        ->options($options),
                Input::make('task.cross_border.2.border_val')
                        ->type('number')
                        ->set('step', '0.01')
                        ->placeholder('0'),
            ]),
            Group::make([
                Select::make('task.cross_border.3.border_country')
                        ->options($options),
                Input::make('task.cross_border.3.border_val')
                        ->type('number')
                        ->set('step', '0.01')
                        ->placeholder('0'),
            ]),
            Group::make([
                Select::make('task.cross_border.4.border_country')
                        ->options($options),
                Input::make('task.cross_border.4.border_val')
                        ->type('number')
                        ->set('step', '0.01')
                        ->placeholder('0'),
            ]),
        ];
    }
}
