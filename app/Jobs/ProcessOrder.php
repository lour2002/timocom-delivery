<?php

namespace App\Jobs;

use App\Mail\DynamicEmail;
use App\Models\BlackList;
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
use DiDom\Query;
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
    public function handle(): void
    {
        $result = [];

        $content = base64_decode($this->searchResult->content_order_64);
        $doc = new Document($content);



        //$result['date_collection'] = \DateTime::createFromFormat('Y-m-d H:i:s', $entry[0]->text());

        $entry = $doc->find('//*[@data-testid="EV_contactperson-email"]', Query::TYPE_XPATH);
        $result['email'] = $entry[0]->text();

        if (empty($result['email'])) {
            SearchResult::destroy($this->searchResult->id);
            exit;
        }

        $entry = $doc->find('//*[@data-testid="ContactView/name"]', Query::TYPE_XPATH);
        $result['name'] = $entry[0]->text();

        $entry = $doc->find('//*[@data-testid="HeaderTitle/companyLink"]', Query::TYPE_XPATH);
        if (sizeof($entry)) {
            $result['company'] = $entry[0]->text();
        }
        else {
            $entry = $doc->find('//*[@data-testid="HeaderTitle/companyName"]', Query::TYPE_XPATH);
            $result['company'] = $entry[0]->text();
        }

        $entry = $doc->find('//*[@data-testid="EV_contactperson-phone"]', Query::TYPE_XPATH);
        $result['phone'] = $entry[0]->text();

        $entry = $doc->find('//*[contains(@class,"HeaderTitle_timocomID")]', Query::TYPE_XPATH);
        $result['company_id'] = str_replace("TC ID: ", "", $entry[0]->text());

        $entry = $doc->find('//*[@data-testid="FreightDescriptionView/freightLength"]', Query::TYPE_XPATH);
        $result['freight_length'] = str_replace(" m", "", $entry[0]->text());

        $entry = $doc->find('//*[@data-testid="FreightDescriptionView/freightWeight"]', Query::TYPE_XPATH);
        $result['freight_weight'] = str_replace(" t", "", $entry[0]->text());

        $entry = $doc->find('//*[@data-testid="FreightPriceView/paymentDue"]', Query::TYPE_XPATH);
        $result['payment_due'] = $entry[0]->text();

        $description = '';
        $entry = $doc->find('//*[@data-testid="FreightDescriptionView/typeOfGoods"]', Query::TYPE_XPATH);
        $description .= ('' !== $entry[0]->text()) ? ', ' . $entry[0]->text() : '';
        $entry = $doc->find('//*[@data-testid="FreightDescriptionView/additionalInformation"]', Query::TYPE_XPATH);
        $description .= ('' !== $entry[0]->text()) ? ', ' . $entry[0]->text() : '';
        $result['freight_description'] = $description;

        $entry = $doc->find('//*[@data-testid="FreightPriceView/price"]', Query::TYPE_XPATH);
        $price = str_replace(array("Price: ", "EUR"), "", $entry[0]->text());

        $result['price'] = trim($price) !== '-' ? $price : null;

        $entry = $doc->find('//*[@data-testid="FreightDescriptionView/loadingEquipment"]', Query::TYPE_XPATH);
        $res = $entry[0]->text();
        if ('No loading equipment exchange' === $res) {
            $result['equipment_exchange'] = 0;
        } else {
            $result['equipment_exchange'] = 1;
        }

        $entry = $doc->find('//*[@data-testid="VehicleRequirementsView/vehicleType"]', Query::TYPE_XPATH);
        $result['vehicle_type'] = $entry[0]->text();

        $description = '';
        $entry = $doc->find('//*[@data-testid="VehicleRequirementsView/vehicleType"]', Query::TYPE_XPATH);
        $description .= $entry[0]->text();
        $entry = $doc->find('//*[@data-testid="VehicleRequirementsView/vehicleBody"]', Query::TYPE_XPATH);
        $description .= (''!== $entry[0]->text()) ? ', '.$entry[0]->text() : '';
        $entry = $doc->find('//*[@data-testid="VehicleRequirementsView/vehicleCharacteristicsCertificate"]', Query::TYPE_XPATH);
        $description .= ('' !== $entry[0]->text()) ? ', ' . $entry[0]->text() : '';
        $result['vehicle_description'] = $description;

        // $entry = $doc->xpath('//*[@data-testid="app:cnt:searchDetail:remarks"]');
        $result['remarks'] = '';

        $entry = $doc->find('//*[contains(@class,"LoadingPlaceView_iconGreen")]', Query::TYPE_XPATH);
        $result['loading_places'] = sizeof($entry);

        $entry = $doc->find('//*[contains(@class,"LoadingPlaceView_arrowIconBlue")]', Query::TYPE_XPATH);
        $result['unloading_places'] = sizeof($entry);

        $entry = $doc->find('//*[@id="distance"]', Query::TYPE_XPATH);
        $result['distance'] = str_replace(" km", "", $entry[0]->text());

        if (empty($result['distance']) || trim($result['distance']) === '-') {
            SearchResult::destroy($this->searchResult->id);
            exit;
        }

        $entry = $doc->find('//*[contains(@class,"LoadingPlaceView_loadingPlacesRow")]', Query::TYPE_XPATH);
        $from = $to = [];

        foreach ($entry as $row) {
            $addressEl = $row->child(1)->child(0);
            $city = explode(' ', $addressEl->child(1)->text(), 3);
            $timeEl = $row->child(1)->child(1);
            $date = $timeEl->child(0);
            $time = $timeEl->child(2)->child(0);

            $date1 = trim($date->child(1)->text());
            $date2 = '-';
            if ($date->child(3)) {
                $date2 = $date->child(3)->text();
            }

            $time1 = trim($time->child(1)->text());
            $time2 = '-';
            if ($time->child(3)) {
                $time2 = $time->child(3)->text();
            }

            if ($row->child(0)->has('[class*=LoadingPlaceView_iconGreen]')) {
                $from[] = [
                    'from_country' => $addressEl->child(0)->text(),
                    'from_zip' => $city[1] ?? null,
                    'from_city' => $city[2] ?? null,
                    'from_date1' => $date1,
                    'from_date2' => $date2,
                    'from_time1' => $time1,
                    'from_time2' => $time2,
                ];
            } elseif ($row->child(0)->has('[class*=LoadingPlaceView_arrowIconBlue]')) {
                $to[] = [
                    'to_country' => $addressEl->child(0)->text(),
                    'to_zip' => $city[1] ?? null,
                    'to_city' => $city[2] ?? null,
                    'to_date1' => $date1,
                    'to_date2' => $date2,
                    'to_time1' => $time1,
                    'to_time2' => $time2,
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

        //check loading equipment
        if ($result) {
            if ($task->exchange_equipment && $order->equipment_exchange) {
                $result = false;
                $status = OrderResult::STATUS_EQUIPMENT;
                $reason[$status] = 'Need exchange equipment';
            }
        }

        //check cross boarding  (unused by Victor)
        if ($result) {
            foreach($task->presenter()->getCrossBorder() as $k => $v) {
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
        $empaty_car_distance = 0;

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
                $country = $from['from_country'];
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

                    $num = time();

                    $ORS_token = ($num % 2 == 0) ? env('ORS_TOKEN_1') : env('ORS_TOKEN_2');

                    $oOR = new OSMapOpenRoute($ORS_token);

                    $oOR->setLanguage('EN');
                    $oOR->setVehicleType(OSMapOpenRoute::VT_CAR);    // we're driving heavy goods ;-)
                    $oOR->setFormat(OSMapOpenRoute::FMT_JSON);

                    $aRoute = [];
                    $aRoute[] = $task->car_position_coordinates;
                    $aRoute[] = $coordTo[0]['lat'] . ', ' . $coordTo[0]['lon'];

                    if ($oOR->calcRoute($aRoute)) {
                        $empaty_car_distance = round($oOR->getDistance() / 1000);
                    } else {
                        Log::debug('Error : ' . $oOR->getError());
                    }
                }
                Log::debug('Empty car distance : ' . $empaty_car_distance);
            }

            $k = 1;
            if ($order->loading_places + $order->unloading_places > 2) {
                $k = $task->car_price_extra_points;
            }

            $car_price = $task->car_price;
            $car_price_empty = $task->car_price_empty;
            $distance = $order->distance + $empaty_car_distance;

            $special_prices = $task->presenter()->getSpecialPrice();

            uasort($special_prices, function($a, $b) {
                return ($a['distance'] < $b['distance']) ? -1 : 1;
            });

            foreach ($special_prices as $value) {
                if($value['distance'] <= $distance)
                    $car_price = $value['price'];
            }

            $price = $k * $car_price * $distance;

            Log::debug('Full car distance : ' . $order->distance);

            Log::debug('Calc price : ' . $price);

            if (!$empaty_car_distance) {
                $result = false;
                $status = OrderResult::STATUS_STOP;
                $reason[$status] = 'Empty car distance = 0';
            }

            $price = round($price, -1);
        }

        // Check overprice
        if ($result) {
            if (!empty($order->price) && $order->price < $price) {
                $percent = round($price * 100 / intval($order->price), 2);
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
            $blackEmail = BlackList::where([
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
        $res->distance = $order->distance + $empaty_car_distance;
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
