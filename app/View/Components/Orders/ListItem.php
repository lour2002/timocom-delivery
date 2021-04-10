<?php

namespace App\View\Components\Orders;

use App\Models\OrderResult;
use Illuminate\View\Component;

class ListItem extends Component
{

    public $id;
    public $offer_id;
    public $status;
    public $status_class;
    public $time;
    public $date;
    public $name;
    public $email;
    public $phone;
    public $from;
    public $to;
    public $price;
    public $distance;
    public $reason;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        //dd($order->created_at);
        $this->id = $order->id;
        $this->status = $order->status;
        $this->offer_id = $order->offer_id;

        switch($order->status){
            case OrderResult::STATUS_NONE:
            $this->status_class = '';
            break;
            case OrderResult::STATUS_SENT:
            $this->status_class = 'fa-2x text-green-500 fa-check-square';
            break;
            case OrderResult::STATUS_BORDER:
            case OrderResult::STATUS_DUPLICATE:
            case OrderResult::STATUS_EQUIPMENT:
            $this->status_class = 'fa-2x text-red-500 fa-minus-square';
            break;
            case OrderResult::STATUS_STOP:
            $this->status_class = 'fa-2x text-yellow-500 fa-pen-square';
            break;
            case OrderResult::STATUS_OVERPRICE:
            $this->status_class = 'fa-lg text-yellow-500 fa-money-check-alt';
            break;
        }

        $this->time = $order->time;
        $this->date = $order->date;
        $this->name = $order->name;
        $this->email = $order->email;
        $this->phone = $order->phone;
        $this->from = json_decode($order->from, true);
        $this->to = json_decode($order->to, true);
        $this->price = $order->price;
        $this->distance = $order->distance;
        $this->reason = $order->reason;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.orders.list-item');
    }
}
