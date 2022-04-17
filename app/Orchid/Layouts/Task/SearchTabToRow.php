<?php

namespace App\Orchid\Layouts\Task;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Group;

use Orchid\Support\Facades\Layout;

use App\Models\Task;

use App\Orchid\Presenters\TaskPresenter;

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
        $options = TaskPresenter::countriesSelectOptions();

        return [
            Group::make([
                Select::make('task.to.0.as_country_to')
                        ->title('Country')
                        ->options($options),
                Input::make('task.to.0.post1')
                        ->title('post 1')
                        ->placeholder('zip code'),
                Input::make('task.to.0.post2')
                        ->title('post 2')
                        ->placeholder('zip code'),
                Input::make('task.to.0.post3')
                        ->title('post 3')
                        ->placeholder('zip code'),
            ]),
            Group::make([
                Select::make('task.to.1.as_country_to')
                        ->options($options),
                Input::make('task.to.1.post1')
                        ->placeholder('zip code'),
                Input::make('task.to.1.post2')
                        ->placeholder('zip code'),
                Input::make('task.to.1.post3')
                        ->placeholder('zip code'),
            ]),
            Group::make([
                Select::make('task.to.2.as_country_to')
                        ->options($options),
                Input::make('task.to.2.post1')
                        ->placeholder('zip code'),
                Input::make('task.to.2.post2')
                        ->placeholder('zip code'),
                Input::make('task.to.2.post3')
                        ->placeholder('zip code'),
            ]),
            Group::make([
                Select::make('task.to.3.as_country_to')
                        ->options($options),
                Input::make('task.to.3.post1')
                        ->placeholder('zip code'),
                Input::make('task.to.3.post2')
                        ->placeholder('zip code'),
                Input::make('task.to.3.post3')
                        ->placeholder('zip code'),
            ]),
            Group::make([
                Select::make('task.to.4.as_country_to')
                        ->options($options),
                Input::make('task.to.4.post1')
                        ->placeholder('zip code'),
                Input::make('task.to.4.post2')
                        ->placeholder('zip code'),
                Input::make('task.to.4.post3')
                        ->placeholder('zip code'),
            ]),
        ];
    }
}
