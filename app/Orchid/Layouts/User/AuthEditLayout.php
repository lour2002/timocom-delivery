<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Rows;

class AuthEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.auth_email')
                ->type('email')
                ->max(255)
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),

            Input::make('user.auth_password')
                ->type('text')
                ->required()
                ->title(__('Password'))
                ->placeholder(__('Password')),
        ];
    }
}
