<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderResult;
use App\Models\SearchResult;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DiDom\Document;

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
        $i=1;
        $to = [];
        foreach ($entry as $row) {
            if (1===$i) {
                $result['from_country'] = $row->child(1)->text();
                $result['from_zip'] = $row->child(2)->text();
                $result['from_city'] = $row->child(3)->text();
                $result['from_date1'] = new \DateTime($row->child(4)->text());
                $result['from_date2'] = new \DateTime($row->child(6)->text());
                $result['from_time1'] = $row->child(7)->text();
                $result['from_time2'] = $row->child(9)->text();
            } else {
                $to[$i-1]['to_country'] = $row->child(1)->text();
                $to[$i-1]['to_zip'] = $row->child(2)->text();
                $to[$i-1]['to_city'] = $row->child(3)->text();
                $to[$i-1]['to_date1'] = $row->child(4)->text()!=='' ? new \DateTime($row->child(4)->text()) : '';
                $to[$i-1]['to_date2'] = $row->child(6)->text()!=='' ? new \DateTime($row->child(6)->text()) : '';
                $to[$i-1]['to_time1'] = $row->child(7)->text();
                $to[$i-1]['to_time2'] = $row->child(9)->text();
            }
            $i++;
        }
        $result['to'] = json_encode($to);
        $result['offer_id'] = $this->searchResult->offer_id;

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
            foreach(explode(',', $task->tags) as $tag) {
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
            foreach(json_decode($order->to, true) as $k => $to) {
                if ($to['to_country'] !== $order->from_country) {
                    $result = false;
                    $status = OrderResult::STATUS_BORDER;
                    $reason[$status] = 'Crossing the border: ' . $order->from_country . ' -> ' . $to['to_country'];
                    break;
                }
            }
        }

        //check duplicate TODO: check duplicates
//        if ($result) {
//            foreach (json_decode($order->to, true) as $k => $to) {
//                if ($to['to_country'] !== $order->from_country) {
//                    $result = false;
//                    $status = OrderResult::STATUS_BORDER;
//                    $reason[$status] = 'Crossing the border: ' . $order->from_country . ' -> ' . $to['to_country'];
//                    break;
//                }
//            }
//        }

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
            $car_location = 0; //TODO: calc distance to car position via openStreetMap
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
            //TODO: send letter
        }
    }
}
