<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Color;


class AddRelationUserLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    public function __construct()
    {
        $this->title ='Added user relation to current';
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
                Input::make('relation.email')
                    ->title('Email address')
                    ->mask(['alias' => 'email'])
                    ->placeholder('Email address'),

                Input::make('relation.password')
                    ->type('password')
                    ->title('Password')
                    ->placeholder('********'),

                Button::make(__('ADD USER'))
                    ->type(Color::SUCCESS())
                    ->icon('plus')
                    ->method('addRelationUser'),
            ])->alignEnd(),
        ];
    }


}