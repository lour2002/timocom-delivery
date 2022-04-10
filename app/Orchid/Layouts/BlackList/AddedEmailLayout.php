<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\BlackList;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Color;


class AddedEmailLayout extends Rows
{

    public function __construct()
    {
        $this->title('Added email to black list');
    }

    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Group::make([
                Input::make('blacklist.email')
                    ->title('Email address')
                    ->help('Email added to black list')
                    ->mask(['alias' => 'email'])
                    ->placeholder('Email address'),

                Select::make('blacklist.ttl')
                    ->title(__('Period'))
                    ->help(__('Time to remove from list'))
                    ->value(0)
                    ->options([
                        '86400' => __('24 hour'),
                        '112800' => __('48 hour'),
                        '259200' => __('72 hour'),
                        '604800' =>  __('week'),
                        '2592000' => __('month'),
                        '31536000' => __('year'),
                    ]),

                Button::make(__('ADD EMAIL'))
                    ->type(Color::SUCCESS())
                    ->icon('plus')
                    ->method('addEmail'),
            ])->alignCenter(),
        ];
    }


}