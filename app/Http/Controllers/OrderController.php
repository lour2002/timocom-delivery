<?php

namespace App\Http\Controllers;

use App\Mail\DynamicEmail;
use App\Models\EmailBlacklist;
use App\Models\Order;
use App\Models\Smtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function get(Request $request)
    {
        return view('orders', [
            'orders' => Order::where('task_id', '=', $request->get('id'))->get()
        ]);
    }
}
