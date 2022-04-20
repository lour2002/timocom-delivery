<?php

namespace App\Orchid\Layouts\Task;

use Orchid\Screen\Field;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Wrapper;

use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

use App\Orchid\Layouts\Task\ViewItem;
use App\Models\Task;

class ViewItemRow extends Wrapper
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    public $task;

    public function __construct($task)
    {
        $this->task = $task;
        parent::__construct('components.orchid.task.view-item', [
            'info' => Layout::view('components.orchid.task.item-info', ['task' => $this->task]),
            'status_controls' => Layout::rows([
                Group::make([
                    Button::make('Start')
                        ->type(Color::SUCCESS())
                        ->icon('control-play')
                        ->disabled($this->task->cantStart())
                        ->method('action',[
                            'id' => $task->id,
                            'action' => Task::STATUS_START
                        ]),
                    Button::make('Test')
                        ->type(Color::INFO())
                        ->icon('circle_thin')
                        ->disabled($this->task->cantTest())
                        ->method('action',[
                            'id' => $task->id,
                            'action' => Task::STATUS_TEST
                        ]),
                    Button::make('Stop')
                        ->type(Color::DANGER())
                        ->icon('minus')
                        ->disabled($this->task->cantStop())
                        ->method('action',[
                            'id' => $task->id,
                            'action' => Task::STATUS_STOP
                        ]),
                ])->alignCenter(),
                Link::make('show processed tasks')
            ]),
        ]);
    }
}
