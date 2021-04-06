<?php

namespace App\Http\Controllers;

use App\Mail\DynamicEmail;
use App\Models\EmailBlacklist;
use App\Models\Order;
use App\Models\OrderResult;
use App\Models\Smtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function get(Request $request, $taskId)
    {
        return view('orders', [
            'id' => $taskId,
            'orders' => DB::table('order_result')
                        ->join('orders', 'order_result.order_id', '=', 'orders.id')
                        ->select('orders.*', 'order_result.price AS price', 'order_result.status','order_result.reason','order_result.created_at')
                        ->where('order_result.task_id', '=', $taskId)
                        ->get()
        ]);
    }
}
