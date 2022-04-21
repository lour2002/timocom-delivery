<?php

namespace App\Orchid\Layouts\Order;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

use App\Models\OrderResult;

class OrderListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'orders';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('status','Status'),
            TD::make('created_at', 'Time')
                ->render(function (OrderResult $order) {
                    return $order->created_at->toDateTimeString().'<br>'.
                           "ID: ".$order->id;
                }),
            TD::make('Contacts')
                ->render(function (OrderResult $order) {
                    return $order->order->email.'<br>'.
                           $order->order->phone.'<br>'.
                           $order->order->name;
                }),
            TD::make('Remark')
                ->render(function (OrderResult $order) {
                    return "Price: ".$order->price."<br>".
                           "Distance: ".$order->distance."<br>".
                           "Reason: ".$order->reason."<br>";
                }),
        ];
    }
}
