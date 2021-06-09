<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderResult;
use App\Models\SearchResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function get(Request $request, $taskId)
    {
        return view('orders', [
            'id' => $taskId,
            'orders' => DB::table('order_result')
                           ->join('orders', 'order_result.order_id', '=', 'orders.id')
                           ->select('orders.*', 'order_result.price AS price', 'order_result.status','order_result.reason',
                                    'order_result.distance AS full_distance',
                                    DB::raw('DATE_FORMAT(order_result.created_at, "%H:%i:%s") as time'),
                                    DB::raw('DATE_FORMAT(order_result.created_at, "%d.%m.%Y") as date'))
                           ->where('order_result.task_id', '=', $taskId)
                           ->latest()
                           ->get()
        ]);
    }

    public function clean(Request $request)
    {
        $date = new \DateTime();
        $dateEnd = $date->sub(new \DateInterval('P1D'));
        try {
            SearchResult::where('created_at', '<', $dateEnd)->delete();
            OrderResult::where('created_at', '<', $dateEnd)->delete();
            Order::where('created_at', '<', $dateEnd)->delete();
            return back();
        } catch (\Throwable $e) {
            Log::debug('ERROR DELETE OLD DATA: '.$e->getMessage());
            return back();
        }
    }
}
