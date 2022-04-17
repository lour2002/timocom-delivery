<?php

namespace App\Orchid\Screens\Task;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;


use App\Models\Task;

use App\Orchid\Layouts\Task\SearchTabNameRow;
use App\Orchid\Layouts\Task\SearchTabFromRow;
use App\Orchid\Layouts\Task\SearchTabToRow;
use App\Orchid\Layouts\Task\SearchTabFreightRow;
use App\Orchid\Layouts\Task\SearchTabDateRow;

use App\Orchid\Layouts\Task\ExceptionTabPriceRow;
use App\Orchid\Layouts\Task\ExceptionTabEquipmentRow;
use App\Orchid\Layouts\Task\ExceptionTabMinOrderRow;
use App\Orchid\Layouts\Task\ExceptionTabFoolProtectionRow;
use App\Orchid\Layouts\Task\ExceptionTabCrossBorderRow;
use App\Orchid\Layouts\Task\ExceptionTabStopWordRow;

use App\Orchid\Layouts\Task\EmailTemplateTab;

class TaskEditScreen extends Screen
{
    public $task;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Task $task): iterable
    {
        return [
            'task' => $task->presenter(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->task->exists ? 'Edit Task' : 'Create Task';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::tabs([
                'Search settings' => [
                    SearchTabNameRow::class,
                    SearchTabFromRow::class,
                    SearchTabToRow::class,
                    SearchTabFreightRow::class,
                    SearchTabDateRow::class,
                ],
                'Filters and exceptions' => [
                    ExceptionTabPriceRow::class,
                    ExceptionTabEquipmentRow::class,
                    ExceptionTabMinOrderRow::class,
                    ExceptionTabFoolProtectionRow::class,
                    ExceptionTabCrossBorderRow::class,
                    ExceptionTabStopWordRow::class,
                ],
                'Email Template' => Layout::block(EmailTemplateTab::class)
                                        ->title('EMAIL TEMPLATE:')
                                        ->description('List of variables to set in email template:<br>
                                                       <b>{name}</b> - company name<br>
                                                       <b>{full_name}</b> - contact person<br>
                                                       <b>{date_collection}</b> - the day collection cargo<br>
                                                       <b>{price}</b> - calculated price for offer<br>'),
            ]),
        ];
    }
}
