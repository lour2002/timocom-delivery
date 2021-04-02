<?php

namespace App\Jobs;

use App\Models\Order;
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

        Order::create($result);
    }
}
