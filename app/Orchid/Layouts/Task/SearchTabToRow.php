<?php

namespace App\Orchid\Layouts\Task;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Group;

use Orchid\Support\Facades\Layout;

use App\Models\Task;


class SearchTabToRow extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    public function __construct() {
        $this->title = 'TO';
    }

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        $options = $this->query->get('task')->countriesSelectOptions();

        return [
            Group::make([
                Select::make('task.as_country_to.0')
                        ->title('Country')
                        ->options($options),
                Input::make('task.post1.0')
                        ->title('post 1')
                        ->placeholder('zip code'),
                Input::make('task.post2.0')
                        ->title('post 2')
                        ->placeholder('zip code'),
                Input::make('task.post3.0')
                        ->title('post 3')
                        ->placeholder('zip code'),
            ]),
            Group::make([
                Select::make('task.as_country_to.1')
                        ->options($options),
                Input::make('task.post1.1')
                        ->placeholder('zip code'),
                Input::make('task.post2.1')
                        ->placeholder('zip code'),
                Input::make('task.post3.1')
                        ->placeholder('zip code'),
            ]),
            Group::make([
                Select::make('task.as_country_to.2')
                        ->options($options),
                Input::make('task.post1.2')
                        ->placeholder('zip code'),
                Input::make('task.post2.2')
                        ->placeholder('zip code'),
                Input::make('task.post3.2')
                        ->placeholder('zip code'),
            ]),
            Group::make([
                Select::make('task.as_country_to.3')
                        ->options($options),
                Input::make('task.post1.3')
                        ->placeholder('zip code'),
                Input::make('task.post2.3')
                        ->placeholder('zip code'),
                Input::make('task.post3.3')
                        ->placeholder('zip code'),
            ]),
            Group::make([
                Select::make('task.as_country_to.4')
                        ->options($options),
                Input::make('task.post1.4')
                        ->placeholder('zip code'),
                Input::make('task.post2.4')
                        ->placeholder('zip code'),
                Input::make('task.post3.4')
                        ->placeholder('zip code'),
            ]),
        ];
    }
}
