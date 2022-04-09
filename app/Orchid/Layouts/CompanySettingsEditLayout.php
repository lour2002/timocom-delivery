<?php

declare(strict_types=1);

namespace App\Orchid\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class CompanySettingsEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Group::make([
                Input::make('company_settings.timocom_id')
                    ->mask('999999')
                    ->title('TIMOCOM ID')
                    ->placeholder('Enter Timocom ID'),

            ]),
            Group::make([
                Input::make('company_settings.name')
                    ->title('Compasny name')
                    ->placeholder('Enter company name'),

                Input::make('company_settings.contact_person')
                    ->title('Contact person')
                    ->placeholder('Enter first and last name of person'),
            ]),
            Group::make([
                Input::make('company_settings.phone')
                    ->mask([
                        'regex' => "^\+[0-9]*$"
                    ])
                    ->title('Phone number')
                    ->placeholder('Enter phone number'),

                Input::make('company_settings.email')
                    ->title('Email address')
                    ->mask(['alias' => 'email'])
                    ->placeholder('Email address'),
            ]),
        ];
    }
}