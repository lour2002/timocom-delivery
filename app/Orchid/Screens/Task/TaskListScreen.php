<?php

namespace App\Orchid\Screens\Task;

use Illuminate\Http\Request;

use Orchid\Screen\Screen;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Color;

use App\Models\Task;

class TaskListScreen extends Screen
{
    public $tasks;
    /**
     * Query data.
     * @param Request $request
     *
     * @return array
     */
    public function query(Request $request): iterable
    {
        return [
            'tasks' => Task::where('user_id', '=', $request->user()->id)->get()->map->presenter(),
        ];;
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Dashboard';
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->type(Color::SUCCESS())
                ->icon('plus')
                ->href(route('platform.task.create'))
                ->canSee($this->tasks->count() <= 5),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [

        ];
    }
}
