<?php

namespace App\Orchid\Layouts\Task;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Group;

use Orchid\Support\Facades\Layout;


class ExceptionTabPriceRow extends Rows
{
    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Group::make([
                Input::make('task.car_price_empty')
                        ->type('number')
                        ->set('step','0.01')
                        ->title('Cost per kilometer of an empty car (of 1 km / €)')
                        ->placeholder('0.00')
                        ->disabled(),
                Input::make('task.car_price')
                        ->type('number')
                        ->set('step','0.01')
                        ->title('Cost per kilometer of loaded car (of 1 km / €)')
                        ->placeholder('0.00'),
                Input::make('task.car_price_extra_points')
                        ->type('number')
                        ->set('step','1')
                        ->set('min','1')
                        ->set('max','999')
                        ->title('Extra stop extra charge (%)')
                        ->placeholder('0 %'),
            ]),
        ];
    }
}
