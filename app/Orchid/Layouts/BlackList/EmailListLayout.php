<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\BlackList;

use App\Models\BlackList as Email;

use Orchid\Platform\Models\Role;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

use Orchid\Support\Color;

class EmailListLayout extends Table
{
    public function __construct()
    {
        $this->title('Email list');
    }
    /**
     * @var string
     */
    public $target = 'emails';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make(__('Delete'))
                ->cantHide()
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Email $email) {
                    return Button::make(__('Delete'))
                    ->icon('trash')
                    ->type(Color::DANGER())
                    ->confirm(__('Once the email is delete.'))
                    ->method('remove', [
                        'id' => $email->id,
                    ]);
                }),

            TD::make('email', __('Email'))
                ->cantHide(),

            TD::make('ttl', __('Date Deleted'))
                ->sort()
                ->cantHide(),
        ];
    }
}
