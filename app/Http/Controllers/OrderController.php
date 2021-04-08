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
                        ->select('orders.*', 'order_result.price AS price', 'order_result.status','order_result.reason','order_result.created_at')
                        ->where('order_result.task_id', '=', $taskId)
                        ->get()
        ]);
    }

    public function clean(Request $request)
    {
        $date = new \DateTime();
        $dateEnd = $date->sub(new \DateInterval('P2D'));
        try {
            SearchResult::where('created_at', '<', $dateEnd)->delete();
            OrderResult::where('created_at', '<', $dateEnd)->delete();
            Order::where('created_at', '<', $dateEnd)->delete();
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::debug('ERROR DELETE OLD DATA: '.$e->getMessage());
            return response()->json(['success' => false]);
        }
    }
}
