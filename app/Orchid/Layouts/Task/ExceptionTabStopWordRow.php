<?php

namespace App\Orchid\Layouts\Task;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Label;


use Orchid\Support\Facades\Layout;


class ExceptionTabStopWordRow extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    public function __construct() {
        $this->title = 'EXCEPTIONS / STOP WORD:';
    }

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Label::make('static')
                        ->value('The words for the filter, under which the order is skipped. The letter will not be sent. You can import multiple values separated by commas. Values will be added to the current list.'),
            TextArea::make('task.tags')
                        ->title('Example textarea')
                        ->rows(6),
        ];
    }
}
