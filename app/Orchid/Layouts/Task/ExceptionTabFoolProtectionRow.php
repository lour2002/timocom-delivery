<?php

namespace App\Orchid\Layouts\Task;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Input;

use Orchid\Support\Facades\Layout;


class ExceptionTabFoolProtectionRow extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    public function __construct() {
        $this->title = 'PROTECTION FROM "ARE YOU A FOOL?":';
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
                    ->value('Do not send an offer if the price offered is YOUR_PERCENT% higher than the price set by the customer. Specify the percentage and activate the function.'),
            Input::make('task.percent_stop_value')
                    ->type('number')
                    ->help('Enter The value in percent')
                    ->placeholder('0 %'),
        ];
    }
}
