<?php

namespace App\Orchid\Layouts\Task;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Select;

use Orchid\Support\Facades\Layout;


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
        $options = $this->query->get('task')->countriesSelectOptions();

        return [
            Group::make([
                Select::make('task.border_country.0')
                        ->title('Country')
                        ->options($options),
                Input::make('task.border_val.0')
                        ->title('Weight')
                        ->type('number')
                        ->set('step', '0.01')
                        ->placeholder('0'),
            ]),
            Group::make([
                Select::make('task.border_country.1')
                        ->options($options),
                Input::make('task.border_val.1')
                        ->type('number')
                        ->set('step', '0.01')
                        ->placeholder('0'),
            ]),
            Group::make([
                Select::make('task.border_country.2')
                        ->options($options),
                Input::make('task.border_val.2')
                        ->type('number')
                        ->set('step', '0.01')
                        ->placeholder('0'),
            ]),
            Group::make([
                Select::make('task.border_country.3')
                        ->options($options),
                Input::make('task.border_val.3')
                        ->type('number')
                        ->set('step', '0.01')
                        ->placeholder('0'),
            ]),
            Group::make([
                Select::make('task.border_country.4')
                        ->options($options),
                Input::make('task.border_val.4')
                        ->type('number')
                        ->set('step', '0.01')
                        ->placeholder('0'),
            ]),
        ];
    }
}
