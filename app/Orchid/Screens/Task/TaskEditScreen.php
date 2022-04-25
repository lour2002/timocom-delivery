<?php

namespace App\Orchid\Screens\Task;

use Illuminate\Http\Request;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

use Orchid\Support\Color;

use App\Models\Task;
use App\Jobs\CleanTaskOrders;
use App\Orchid\Presenters\TaskPresenter;

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
    public $taskPresenter;
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Task $task): iterable
    {
        $task->car_price_extra_points = $task->presenter()->getCarPriceExtraPoints();
        $task->to = $task->presenter()->getDesctinations();
        $task->cross_border = $task->presenter()->getCrossBorder();

        return [
            'task' => $task,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->task->exists ? 'Edit: '.$this->task->name : 'Create Task';
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
                    ->canSee($this->task->exists)
                    ->method('reset_orders',['id' => $this->task->id]),
            Button::make('Save')
                    ->type(Color::PRIMARY())
                    ->icon('check')
                    ->method('save'),
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

    /**
     * @param task    $task
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */

    public function save(Task $task, Request $request)
    {
        $data = $request->get('task');

        $error = false;
        $toSelectOptArray = [];
        $crossBorder = [];

        $data['user_id'] = $request->user()->id;
        $data['user_key'] = $request->user()->key;

        $toSelectOptArray = array_filter($data['to'], function ($val) {
            return $val['as_country_to'] !== TaskPresenter::EMPTY_COUNTRY;
        });

        $toSelectOptArray = array_map(function ($val) {
            $val['post1'] = $val['post1'] ?? '';
            $val['post2'] = $val['post2'] ?? '';
            $val['post3'] = $val['post3'] ?? '';

            return $val;
        }, $toSelectOptArray);

        $data['toSelectOptArray'] = json_encode(array_values($toSelectOptArray));

        $data['car_price_empty'] = $data['car_price'];
        $data['car_price_extra_points'] = 1 + $data['car_price_extra_points']/100;

        $crossBorder = array_filter($data['cross_border'], function ($val) {
            return $val['border_country'] !== TaskPresenter::EMPTY_COUNTRY;
        });
        $data['cross_border'] = json_encode(array_values($crossBorder));

        $address = '';
        $country = substr($data['as_country'], 3);
        $address .= $country;
        if (!empty($data['as_zip'])) {
            $address .= !empty($address) ? ','.$data['as_zip'] : $data['as_zip'];
        }
        if (!empty($task->car_city)) {
            $address .= !empty($address) ? ',' . $data['car_city'] : $data['car_city'];
        }
        $client = new \GuzzleHttp\Client();
        $car_position = $client->request(
            'GET',
            'https://nominatim.openstreetmap.org/?format=json&addressdetails=1&q='.$address.'&format=json&limit=1'
        );
        $car_position = json_decode($car_position->getBody()->getContents(), true);

        if (!empty($car_position)) {
            $data['car_position_coordinates'] = $car_position[0]['lat'] . ', ' . $car_position[0]['lon'];
        }


        if(!$task->exists) {
            $max = Task::where('user_id', '=', $request->user()->id)->max('num');

            if (5 < $max + 1) {
                Toast::warning('Only five jobs allow');
                $error = true;
            }

            $data['num'] = $max + 1;
        } else {
            $data['version_task'] = $task->version_task + 1;
        }



        if (!$error) {
            $task
                ->fill($data)
                ->save();

            Toast::success('Task was saved!');
        }

        return redirect()->route('platform.task');
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
