<?php

namespace App\Orchid\Layouts\Task;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\CheckBox;

use Orchid\Support\Facades\Layout;


class ExceptionTabEquipmentRow extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    public function __construct() {
        $this->title = 'LOADING EQUIPMENT EXCHANGE:';
    }

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            CheckBox::make('task.exchange_equipment')
                ->placeholder('Skip order, if yes, when exchanging pallets')
        ];
    }
}
