<?php

namespace App\Orchid\Layouts\Task;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\DateTimer;

use Orchid\Support\Facades\Layout;


class SearchTabDateRow extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    public function __construct() {
        $this->title = 'DATE';
    }

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            DateTimer::make('task.individual_days')
                    ->title('Individual Date')
                    ->format('d.m.Y')
                    ->horizontal(),
        ];
    }
}
