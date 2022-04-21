<?php

namespace App\Orchid\Screens\Task;

use Illuminate\Http\Request;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;

use App\Models\Task;
use App\Models\OrderResult;
use App\Jobs\CleanTaskOrders;
use App\Orchid\Layouts\Order\OrderListLayout;

class TaskOrdersListScreen extends Screen
{
    public $orders;
    public $task_id;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Task $task): iterable
    {

        $pagination = OrderResult::where('task_id', '=', $task->id)->paginate();
        return [
            'orders' => $pagination,
            'task_id' => $task->id
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Orders List';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Clear Orders')
                    ->type(Color::WARNING())
                    ->confirm(__('You want delete all precessed orders for this task'))
                    ->icon('trash')
                    ->canSee($this->orders->total() !== 0)
                    ->method('reset_orders',['id' => $this->task_id]),
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
            OrderListLayout::class,
        ];
    }

    /**
     * @param task    $task
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */

    public function reset_orders(Task $task, Request $request)
    {
        CleanTaskOrders::dispatch($task);

        Toast::message('It working!');

        return redirect()->route('platform.task');
    }
}
