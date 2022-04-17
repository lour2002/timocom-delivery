<?php

namespace App\Orchid\Layouts\Task;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;

use Orchid\Support\Facades\Layout;


class SearchTabNameRow extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('task.name')
                    ->title('Task name')
                    ->help('Enter task or driver name')
                    ->placeholder('Name')
                    ->required(),
        ];
    }
}
