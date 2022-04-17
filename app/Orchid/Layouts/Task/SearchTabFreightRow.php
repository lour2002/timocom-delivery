<?php

namespace App\Orchid\Layouts\Task;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Label;

use Orchid\Support\Facades\Layout;


class SearchTabFreightRow extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    public function __construct() {
        $this->title = 'SELECTION OF FREIGHT';
    }

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Group::make([
                Label::make('static')
                        ->title('Length:'),
                Input::make('task.length_min')
                        ->title('min.')
                        ->type('number')
                        ->set('step', '0.01')
                        ->placeholder('0'),
                Input::make('task.length_max')
                        ->title('max.')
                        ->type('number')
                        ->set('step', '0.01')
                        ->placeholder('0'),
            ]),
            Group::make([
                Label::make('static')
                        ->title('Weight:'),
                Input::make('task.weight_min')
                        ->title('min.')
                        ->type('number')
                        ->set('step', '0.01')
                        ->placeholder('0'),
                Input::make('task.weight_max')
                        ->title('max.')
                        ->type('number')
                        ->set('step', '0.01')
                        ->placeholder('0'),
            ]),
        ];
    }
}
