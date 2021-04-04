<?php

namespace App\Jobs;

use App\Mail\DynamicEmail;
use App\Models\Order;
use App\Models\OrderResult;
use App\Models\SearchResult;
use App\Models\Smtp;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DiDom\Document;
use Illuminate\Support\Facades\Config;
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

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:navBar:creationDate"]');
        $result['date_collection'] = new \DateTime($entry[0]->text());
        //$result['date_collection'] = \DateTime::createFromFormat('Y-m-d H:i:s', $entry[0]->text());

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:contactPersonName"]');
        $result['name'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:contactPersonEmail"]');
        $result['email'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:contactPhone"]');
        $result['phone'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:timocomID"]');
        $result['company_id'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:freightLength"]');
        $result['freight_length'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:freightWeight"]');
        $result['freight_weight'] = $entry[0]->text();

        $descr = '';
        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:typeOfGoods"]');
        $descr .= ('' !== $entry[0]->text()) ? ', ' . $entry[0]->text() : '';
        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:additionalInfo"]');
        $descr .= ('' !== $entry[0]->text()) ? ', ' . $entry[0]->text() : '';
        $result['freight_description'] = $descr;

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:price"]');
        $result['price'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:loadingEquipmentExchange"]');
        $res = $entry[0]->text();
        if ('Yes' === $res) {
            $result['equipment_exchange'] = 1;
        } else {
            $result['equipment_exchange'] = 0;
        }

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:vehicleTypesList"]');
        $result['vehicle_type'] = $entry[0]->text();

        $descr = '';
        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:vehicleTypesList"]');
        $descr .= $entry[0]->text();
        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:vehicleBodies"]');
        $descr .= (''!== $entry[0]->text()) ? ', '.$entry[0]->text() : '';
        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:vehicleProperties"]');
        $descr .= ('' !== $entry[0]->text()) ? ', ' . $entry[0]->text() : '';
        $result['vehicle_description'] = $descr;

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:remarks"]');
        $result['remarks'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:loadingPlacesAmount"]');
        $result['loading_places'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:unloadingPlacesAmount"]');
        $result['unloading_places'] = $entry[0]->text();

        $entry = $doc->xpath('//*[@id="app:cnt:searchDetail:estimatedDistance"]');
        $result['distance'] = $entry[0]->text();

        $entry = $doc->find('.tco-loadingplace');
        $from = $to = [];
        foreach ($entry as $row) {
            if ($row->child(1)->has('.tc-load')) {
                $from[] = [
                    'from_country' => $row->child(1)->text(),
                    'from_zip' => $row->child(2)->text(),
                    'from_city' => $row->child(3)->text(),
                    'from_date1' => new \DateTime($row->child(4)->text()),
                    'from_date2' => new \DateTime($row->child(6)->text()),
                    'from_time1' => $row->child(7)->text(),
                    'from_time2' => $row->child(9)->text(),
                ];

            } elseif ($row->child(1)->has('.tc-unload')) {
                $to[] = [
                    'to_country' => $row->child(1)->text(),
                    'to_zip' => $row->child(2)->text(),
                    'to_city' => $row->child(3)->text(),
                    'to_date1' => new \DateTime($row->child(4)->text()),
                    'to_date2' => new \DateTime($row->child(6)->text()),
                    'to_time1' => $row->child(7)->text(),
                    'to_time2' => $row->child(9)->text(),
                ];
            }
        }
        $result['from'] = json_encode($from);
        $result['to'] = json_encode($to);
        $result['offer_id'] = $this->searchResult->offer_id;
        $result['task_id'] = $this->searchResult->task_id;

        $order = Order::create($result);

        $this->checkOrder($order);
    }

    private function checkOrder(Order $order)
    {
        $task = $order->task;

        $status = OrderResult::STATUS_SENT;
        $reason = [
            OrderResult::STATUS_STOP => '',
            OrderResult::STATUS_BORDER => '',
            OrderResult::STATUS_DUPLICATE => '',
            OrderResult::STATUS_LOW_PRICE => '',
            OrderResult::STATUS_SENT => 'Proposal sent',
        ];
        $result = true;
        if (!empty($task->tags)) {
            foreach(explode(';', $task->tags) as $tag) {
                if (preg_match('/\b'.$tag.'\b/', $order->freight_description)) {
                    $result = false;
                    $status = OrderResult::STATUS_STOP;
                    $reason[$status] = 'Stop word: ' . $tag;
                    break;
                }
                if (preg_match('/\b' . $tag . '\b/', $order->vehicle_description)) {
                    $result = false;
                    $status = OrderResult::STATUS_STOP;
                    $reason[$status] = 'Stop word: ' . $tag;
                    break;
                }
                if (preg_match('/\b' . $tag . '\b/', $order->remarks)) {
                    $result = false;
                    $status = OrderResult::STATUS_STOP;
                    $reason[$status] = 'Stop word: ' . $tag;
                    break;
                }
            }
        }

        //check cross boarding
        if ($result) {
            foreach(json_decode($task->cross_border, true) as $k => $v) {
                foreach (json_decode($order->to, true) as $key => $to) {
                    if ($to['to_country'] === $v['border_country'] && $order->freight_weight > $v['border_val']) {
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

            $orders = Order::where([
                ['id', '!=', $order->id],
                ['name', '=', $order->name],
                ['email', '=', $order->email],
                ['company_id', '=', $order->company_id],
            ])->all();
            $d1 = $order->date_collection;
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
                $d2 = $item->date_collection;
                $interval = $d11->diff($d2);
                $h = ($interval->days * 24) + $interval->h;
                if ($fromCurrent.$toCurrent === $from.$to && 18 > $h) {
                    $result = false;
                    $status = OrderResult::STATUS_DUPLICATE;
                    $reason[$status] = 'Duplicate: id '.$item->id;
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

        //calculate price
        $price = 0;
        if ($result) {
            $car_location = 0;
            if (!empty($task->car_country) && (!empty($task->car_zip) || !empty($task->car_city))) {
                $address = '';
                if (!empty($task->car_zip)) {
                    $address .= $task->car_zip;
                }
                $country = explode(' - ', $task->car_country)[1];
                $address .= !empty($address) ? ','.$country : $country;
                if (!empty($task->car_city)) {
                    $address .= !empty($address) ? ',' . $task->car_city : $task->car_city;
                }
                $client = new \GuzzleHttp\Client();
                $coordFrom = $client->request(
                    'GET',
                    'https://nominatim.openstreetmap.org/?format=json&addressdetails=1&q='.$address.'format=json&limit=1'
                );
                $coordFrom = json_decode($coordFrom->getBody()->getContents(), true);


                $address = '';
                $from = json_encode($order->from)[0];
                if (!empty($from->from_zip)) {
                    $address .= $from->from_zip;
                }
                $country = explode(' - ', $from->from_country)[1];
                $address .= !empty($address) ? ',' . $country : $country;
                if (!empty($from->from_city)) {
                    $address .= !empty($address) ? ',' . $from->from_city : $from->from_city;
                }
                $client = new \GuzzleHttp\Client();
                $coordTo = $client->request(
                    'GET',
                    'https://nominatim.openstreetmap.org/?format=json&addressdetails=1&q=' . $address . 'format=json&limit=1'
                );


                require_once __DIR__ . '/../../lib/OSMap/OSMapPoint.php';
                require_once __DIR__ . '/../../lib/OSMap/OSMapOpenRoute.php';
                require_once __DIR__ . '/../../lib/OSMap/OSMapOpenRouteStep.php';

                $oOR = new OSMapOpenRoute('5b3ce3597851110001cf6248f156d08190e241fa80a09ac3f96d1132');

                $oOR->setLanguage('EN');
                $oOR->setVehicleType(OSMapOpenRoute::VT_HGV);    // we're driving heavy goods ;-)
                $oOR->setFormat(OSMapOpenRoute::FMT_JSON);
                $oOR->enableInstructions();
                $oOR->setInstructionFormat(OSMapOpenRoute::IF_HTML);

                $aRoute = [];
                $aRoute[] = $coordFrom[0]['lat'].', '. $coordFrom[0]['lon'];
                $aRoute[] = $coordTo[0]['lat'].', '. $coordTo[0]['lon'];

                if ($oOR->calcRoute($aRoute)) {
                    $car_location = round($oOR->getDistance() / 1000);
                }
            }

            $k = 1;
            if ($order->loading_places + $order->unloading_places > 2) {
                $k = $task->car_price_extra_points;
            }
            $price = ($task->car_price * $order->distance + $task->car_price_empty * $car_location) * $k;
        }
        $price = round($price);

        if ($result) {
            if ($order->price < $price) {
                $percent = ($price / $order->price) * 100;
                if ($task->percent_stop_value && $percent > $task->percent_stop_value) {
                    $result = false;
                    $status = OrderResult::STATUS_OVERPRICE;
                    $reason[$status] = 'Overprice more than '. $task->percent_stop_value.'%'.': '. $order->price.'->'.$price;
                }
            }
        }

        if ($task->minimal_price_order > $price) {
            $price = $task->minimal_price_order;
        }

        $res = new OrderResult();
        $res->task_id = $task->id;
        $res->order_id = $order->id;
        $res->price = $price;
        $res->status = $status;
        $res->reason = $reason[$status];
        $res->save();

        if ($result) {
            $user = User::find($task->user_id);
            $configuration = Smtp::where("user_id", $task->user_id)->first();
            if (!is_null($configuration)) {
                $config = array(
                    'driver' => 'smtp',
                    'host' => $configuration->server,
                    'port' => $configuration->port,
                    'username' => $configuration->login,
                    'password' => $configuration->password,
                    'encryption' => $configuration->secure,
                    'from' => array('address' => $configuration->email, 'name' => $user->name),
                );
                Config::set('mail', $config);

                $message = 'Hello dear {name}< br/><br />
                    If your TIMOCOM OFFER on {date_collection} is still available, we could handle it for you
                    FOR JUST {price} EUR!
                    <br />
                    SOLO TRIP, DIRECT DELIVERY, EXPRESS SERVICE ID GUARANTEED!
                ';
                //date_delivery???????????
                $message = str_replace(
                    ['{name}', '{date_collection}', '{price}', '{date_delivery}'],
                    [$order->name, $order->date_collection, $price],
                    $message
                );

                //$toEmail = $user->email;
                $toEmail = 'triongroup@gmail.com';
                $data = array(
                    "subject" => 'Proposal',
                    "message" => $message,
                    "template" => 'email-template'
                );

                Mail::to($toEmail)->send(new DynamicEmail($data));
            }
        }
    }
}
