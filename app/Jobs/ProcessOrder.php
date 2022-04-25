<?php

namespace App\Jobs;

use App\Mail\DynamicEmail;
use App\Models\Blacklist;
use App\Models\CompanySettings;
use App\Models\Order;
use App\Models\OrderResult;
use App\Models\SearchResult;
use App\Models\Smtp;
use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DiDom\Document;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use lib\OSMap\OSMapOpenRoute;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $searchResult;

    /**
     * Create a new job instance.
     *
     * @param SearchResult $result
     */
    public function __construct(SearchResult $result)
    {
        $this->searchResult = $result;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = [];

        $content = base64_decode($this->searchResult->content_order_64);
        $doc = new Document($content);



        //$result['date_collection'] = \DateTime::createFromFormat('Y-m-d H:i:s', $entry[0]->text());

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:contactPersonEmail"]');
        $result['email'] = $entry[0]->text();

        if (empty($result['email'])) {
            exit;
        }

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:contactPersonName"]');
        $result['name'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:company"]');
        $result['company'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:contactPhone"]');
        $result['phone'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:timocomID"]');
        $result['company_id'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:freightLength"]');
        $result['freight_length'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:freightWeight"]');
        $result['freight_weight'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:paymentDueWithinDays"]');
        $result['payment_due'] = $entry[0]->text();

        $description = '';
        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:typeOfGoods"]');
        $description .= ('' !== $entry[0]->text()) ? ', ' . $entry[0]->text() : '';
        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:additionalInfo"]');
        $description .= ('' !== $entry[0]->text()) ? ', ' . $entry[0]->text() : '';
        $result['freight_description'] = $description;

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:price"]');
        $result['price'] = !empty($entry[0]->text()) ? $entry[0]->text() : null;

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:loadingEquipmentExchange"]');
        $res = $entry[0]->text();
        if ('Yes' === $res) {
            $result['equipment_exchange'] = 1;
        } else {
            $result['equipment_exchange'] = 0;
        }

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:vehicleTypesList"]');
        $result['vehicle_type'] = $entry[0]->text();

        $description = '';
        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:vehicleTypesList"]');
        $description .= $entry[0]->text();
        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:vehicleBodies"]');
        $description .= (''!== $entry[0]->text()) ? ', '.$entry[0]->text() : '';
        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:vehicleProperties"]');
        $description .= ('' !== $entry[0]->text()) ? ', ' . $entry[0]->text() : '';
        $result['vehicle_description'] = $description;

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:remarks"]');
        $result['remarks'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:loadingPlacesAmount"]');
        $result['loading_places'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:unloadingPlacesAmount"]');
        $result['unloading_places'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:estimatedDistance"]');
        $result['distance'] = $entry[0]->text();
        if (empty($result['distance'])) {
            exit;
        }

        $entry = $doc->find('.tco-loadingplace');
        $from = $to = [];
        foreach ($entry as $row) {
            if ($row->child(0)->has('.tc-load')) {
                $from[] = [
                    'from_country' => $row->child(1)->text(),
                    'from_zip' => $row->child(2)->text(),
                    'from_city' => $row->child(3)->text(),
                    'from_date1' => $row->child(4)->text(),
                    'from_date2' => $row->child(6)->text(),
                    'from_time1' => $row->child(7)->text(),
                    'from_time2' => $row->child(9)->text(),
                ];
            } elseif ($row->child(0)->has('.tc-unload')) {
                $to[] = [
                    'to_country' => $row->child(1)->text(),
                    'to_zip' => $row->child(2)->text(),
                    'to_city' => $row->child(3)->text(),
                    'to_date1' => $row->child(4)->text(),
                    'to_date2' => $row->child(6)->text(),
                    'to_time1' => $row->child(7)->text(),
                    'to_time2' => $row->child(9)->text(),
                ];
            }
        }
        $result['from'] = json_encode($from);
        $result['to'] = json_encode($to);
        $result['offer_id'] = $this->searchResult->offer_id;
        $result['task_id'] = $this->searchResult->id_task;

        $task = Task::find($this->searchResult->id_task);
        $result['date_collection'] = new \DateTime($task->individual_days);

        $order = Order::create($result);

        $this->checkOrder($order);
    }

    private function checkOrder(Order $order)
    {
        $task = Task::find($order->task_id);
        $user = User::find($task->user_id);

        $status = OrderResult::STATUS_SENT;
        $reason = [
            OrderResult::STATUS_STOP => '',
            OrderResult::STATUS_BORDER => '',
            OrderResult::STATUS_DUPLICATE => '',
            OrderResult::STATUS_LOW_PRICE => '',
            OrderResult::STATUS_SENT => 'Proposal sent',
        ];
        $result = true;

        //check stop word
        if (!empty($task->tags)) {
            foreach(explode(';', $task->tags) as $tag) {
                if (preg_match('/\b'.$tag.'\b/i', $order->freight_description)) {
                    $result = false;
                    $status = OrderResult::STATUS_STOP;
                    $reason[$status] = 'Stop word: ' . $tag;
                    break;
                }
                if (preg_match('/\b' . $tag . '\b/i', $order->vehicle_description)) {
                    $result = false;
                    $status = OrderResult::STATUS_STOP;
                    $reason[$status] = 'Stop word: ' . $tag;
                    break;
                }
                if (preg_match('/\b' . $tag . '\b/i', $order->remarks)) {
                    $result = false;
                    $status = OrderResult::STATUS_STOP;
                    $reason[$status] = 'Stop word: ' . $tag;
                    break;
                }
            }
        }

        //check cross boarding  (unused by Victor)
        if ($result) {
            foreach(json_decode($task->cross_border, true) as $k => $v) {
                foreach (json_decode($order->to, true) as $key => $to) {
                    if ($to['to_country'] === $v['border_country'] && (float) $order->freight_weight > (float) $v['border_val']) {
                        $result = false;
                        $status = OrderResult::STATUS_BORDER;
                        $reason[$status] = 'Crossing the border: ' . $v['border_country'] . ' -> ' . $order->freight_weight .'>'. $v['border_val'];
                        break;
                    }
                }
            }
        }

        //check loading equipment
        if ($result) {
            if ($task->exchange_equipment && $order->equipment_exchange) {
                $result = false;
                $status = OrderResult::STATUS_EQUIPMENT;
                $reason[$status] = 'Need exchange equipment';
            }
        }

        //check duplicate
        if ($result) {
            $fromCurrent = '';

            foreach (json_decode($order->from, true) as $key => $val) {
                $fromCurrent .= $val['from_country'].$val['from_zip'].$val['from_city'];
            }

            $toCurrent = '';
            foreach (json_decode($order->to, true) as $key => $val) {
                $toCurrent .= $val['to_country'] . $val['to_zip'] . $val['to_city'];
            }

            $orders = DB::table('orders')
                        ->join('orders_result', 'orders_result.order_id', '=', 'orders.id')
                        ->select('orders.*')
                        ->where([
                            ['orders.id', '!=', $order->id],
                            ['orders.name', '=', $order->name],
                            ['orders.email', '=', $order->email],
                            ['orders.company_id', '=', $order->company_id],
                            ['orders_result.status', '=', OrderResult::STATUS_SENT]
                        ])->get();

            $d1 = $order->created_at;
            foreach($orders as $item) {
                $from = '';
                foreach (json_decode($item->from, true) as $key => $val) {
                    $from .= $val['from_country'] . $val['from_zip'] . $val['from_city'];
                }

                $to = '';
                foreach (json_decode($item->to, true) as $key => $val) {
                    $to .= $val['to_country'] . $val['to_zip'] . $val['to_city'];
                }

                $d11 = clone($d1);
                $d2 = new \DateTime($item->created_at);
                $interval = $d11->diff($d2);
                $h = ($interval->days * 24) + $interval->h;
                if ($fromCurrent.$toCurrent === $from.$to && 18 > $h) {
                    $result = false;
                    $status = OrderResult::STATUS_DUPLICATE;
                    $reason[$status] = 'Duplicate: id '.$item->id;
                }
            }
        }
        //calculate price
        $price = 0;
        $car_location = 0;

        if ($result) {
            Log::debug("=============================".$task->id.'|'.$order->id."=============================");
            if (!empty($task->as_country) && (!empty($task->as_zip) || !empty($task->car_city))) {
                $address = '';
                $country = substr($task->as_country, 3);
                $address .= $country;

                if (!empty($task->as_zip)) {
                    $address .= !empty($address) ? ','.$task->as_zip : $task->as_zip;
                }
                if (!empty($task->car_city)) {
                    $address .= !empty($address) ? ',' . $task->car_city : $task->car_city;
                }

                Log::debug("Car position : ".$address);
                Log::debug($task->car_position_coordinates);

                $address = '';
                $from = json_decode($order->from, true)[0];
                $country = explode(' - ', $from['from_country'])[1];
                $address .= $country;
                if (!empty($from['from_zip'])) {
                    $address .= !empty($address) ? ',' . $from['from_zip'] : $from['from_zip'];
                }
                if (!empty($from['from_city'])) {
                    $address .= !empty($address) ? ',' . $from['from_city'] : $from['from_city'];
                }

                $client = new \GuzzleHttp\Client();
                $coordTo = $client->request(
                    'GET',
                    'https://nominatim.openstreetmap.org/?format=json&addressdetails=1&q=' . $address . '&format=json&limit=1'
                );
                $coordTo = json_decode($coordTo->getBody()->getContents(), true);
                Log::debug("Loading position : ".$address);
                Log::debug($coordTo);

                if (!empty($task->car_position_coordinates) && !empty($coordTo)) {

                    require_once __DIR__ . '/../../lib/OSMap/OSMapPoint.php';
                    require_once __DIR__ . '/../../lib/OSMap/OSMapOpenRoute.php';
                    require_once __DIR__ . '/../../lib/OSMap/OSMapOpenRouteStep.php';

                    $oOR = new OSMapOpenRoute(env('ORS_TOKEN'));

                    $oOR->setLanguage('EN');
                    $oOR->setVehicleType(OSMapOpenRoute::VT_CAR);    // we're driving heavy goods ;-)
                    $oOR->setFormat(OSMapOpenRoute::FMT_JSON);

                    $aRoute = [];
                    $aRoute[] = $coordFrom[0]['lat'] . ', ' . $coordFrom[0]['lon'];
                    $aRoute[] = $coordTo[0]['lat'] . ', ' . $coordTo[0]['lon'];

                    if ($oOR->calcRoute($aRoute)) {
                        $car_location = round($oOR->getDistance() / 1000);
                    } else {
                        Log::debug('Error : ' . $oOR->getError());
                    }
                    Log::debug('Responce : ' . print_r($oOR->getResponse(), true));
                }
                Log::debug('Empty car distance : ' . $car_location);
            }

            $k = 1;
            if ($order->loading_places + $order->unloading_places > 2) {
                $k = $task->car_price_extra_points;
            }
            $price = ($task->car_price * $order->distance + $task->car_price_empty * $car_location) * $k;
            Log::debug('Full car distance : ' . $order->distance);

            Log::debug('Calc price : ' . $price);

            if (!$car_location) {
                $result = false;
                $status = OrderResult::STATUS_STOP;
                $reason[$status] = 'Empty car distance = 0';
            }

            $price = round($price, -1);
        }

        // Check overprice
        if ($result) {
            if (!empty($order->price) && $order->price < $price) {
                $percent = round($price * 100 / $order->price, 2);
                if ($task->percent_stop_value && $percent > $task->percent_stop_value) {
                    $result = false;
                    $status = OrderResult::STATUS_OVERPRICE;
                    $reason[$status] = 'Overprice more than '. $task->percent_stop_value.'%'.': '. $price.'>'.$order->price;
                }
            }
        }
        // Set minimal price
        if ($task->minimal_price_order > $price) {
            $price = $task->minimal_price_order;
        }

        // Set order price
        if (!empty($order->price) && $order->price > $price) {
            $price = $order->price;
        }

        //check blacklist email
        if ($result) {
            $blackEmail = Blacklist::where([
                ['user_id', '=', $user->id],
                ['email', '=', $order->email],
            ])->first();
            if (null !== $blackEmail) {
                $result = false;
                $status = OrderResult::STATUS_BLACKLIST;
                $reason[$status] = 'Email ' . $order->email . ' in black list';
            }
        }

        // Save order result
        $res = new OrderResult();
        $res->task_id = $task->id;
        $res->order_id = $order->id;
        $res->price = $price;
        $res->distance = $car_location + $order->distance;
        $res->status = $status;
        $res->reason = $reason[$status];
        $res->save();


        // Send email
        if ($result) {
            $companySettings = CompanySettings::where('user_id', '=', $user->id)->first();
            $message = $task->email_template;

            $message = str_replace(
                ['{name}', '{date_collection}', '{price}'],
                [$order->name, $order->date_collection->format('Y-m-d'), $price],
                $message
            );

            $toEmail = '';
            if ($task->status_job == Task::STATUS_START) {
                $toEmail = $order->email;
            } elseif ($task->status_job == Task::STATUS_TEST) {
                $toEmail = $companySettings->email;
            }

            $subject = '[' . $task->name . ']' . 'TIMOCOM-OFFER: (' . $task->individual_days . ')';
            $orderFrom = json_decode($order->from);
            if (count($orderFrom)) {
                $subject .= ' '.current($orderFrom)->from_country;
                $subject .= ' '.current($orderFrom)->from_zip;
                $subject .= ' '.current($orderFrom)->from_city;
            }
            $orderTo = json_decode($order->to);
            if (count($orderTo)) {
                $subject .= '--->';
                end($orderTo);
                $subject .= ' '.current($orderTo)->to_country;
                $subject .= ' '.current($orderTo)->to_zip;
                $subject .= ' '.current($orderTo)->to_city;
            }

            if (!empty($toEmail)) {
                $data = array(
                    "subject" => $subject,
                    "template" => 'email-template',
                    "from" => [
                        'name' => $companySettings->name,
                        'email' => $companySettings->email,
                    ],
                    "message" => $message,
                    "order" => $order,
                    "company" => $companySettings
                );

                Mail::to($toEmail)->send(new DynamicEmail($data));
            }
        }

        SearchResult::destroy($this->searchResult->id);
    }
}
