<?php

namespace App\View\Components\Orders;

use Illuminate\View\Component;

class ListItem extends Component
{

    public $status;
    public $time;
    public $name;
    public $email;
    public $phone;
    public $from;
    public $to;
    public $price;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        //dd($order->created_at);
        $this->status = $order->status;
        $this->time = $order->created_at;
        $this->name = $order->name;
        $this->email = $order->email;
        $this->phone = $order->phone;
        $this->from = json_decode($order->from, true);
        $this->to = json_decode($order->to, true);
        $this->price = $order->price;

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
