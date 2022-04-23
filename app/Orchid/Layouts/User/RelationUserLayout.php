<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class RelationUserLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'users';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('name', __('Name')),

            TD::make('email', __('Email')),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (User $user) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Button::make(__('Impersonate user'))
                                ->icon('login')
                                ->confirm('You can revert to your original state by logging out.')
                                ->method('loginAs', [
                                    'id' => $user->id,
                                ]),
                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Relation with account will be delete.'))
                                ->method('removeRelation', [
                                    'id' => $user->id,
                                ]),
                        ]);
                }),
        ];
    }
}
