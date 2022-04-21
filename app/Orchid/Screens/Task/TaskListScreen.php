<?php

namespace App\Orchid\Screens\Task;

use Illuminate\Http\Request;

use Orchid\Screen\Screen;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;

use App\Models\Task;
use App\Orchid\Layouts\Task\ViewItemRow;

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
            'tasks' => Task::where('user_id', '=', $request->user()->id)
                        ->orderBy('id')
                        ->get()
                        ->map
                        ->presenter(),
        ];;
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'CONTROL PANEL: '.date('d-m-Y');
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
                ->canSee($this->tasks->count() < 5),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        $rows = $this->tasks->map(function($task) {
            return new ViewItemRow($task);
        });

        return $rows->all();
    }

    public function action(Request $request)
    {
        $task = Task::where([
            ['user_id', '=', $request->user()->id],
            ['id', '=', $request->get('id')],
        ])->first();

        if (null !== $task) {
            $task->status_job = $request->get('action');
            $task->save();
        }

        $msg = $task->presenter()->getActionMessage($request->get('action'));

        Toast::info($msg);
    }
}
