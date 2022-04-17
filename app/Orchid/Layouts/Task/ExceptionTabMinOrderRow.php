<?php

namespace App\Orchid\Layouts\Task;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Input;

use Orchid\Support\Facades\Layout;


class ExceptionTabMinOrderRow extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    public function __construct() {
        $this->title = 'MINIMUM ORDER VALUE (EURO):';
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
                    ->value('Cost below which the order will not be processed. The offer will not be sent to the customer.'),
            Input::make('task.minimal_price_order')
                    ->type('number')
                    ->title('Min price')
                    ->help('Enter The minimum value in euros')
                    ->placeholder('0 €'),
        ];
    }
}
