<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderResult;
use App\Models\SearchResult;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function get(Request $request, $taskId)
    {
        $user_id = auth()->user()->id;
        $has_working_tasks = Task::where('user_id', '=', $user_id)
                             ->where('status_job', '!=', Task::STATUS_STOP)
                             ->get()
                             ->count();

        return view('orders', [
            'id' => $taskId,
            'disabled' => !!$has_working_tasks,
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
        $user_id = auth()->user()->id;
        try {
            DB::table('search_result')
                ->leftJoin('tasks', 'search_result.id_task', '=', 'tasks.id')
                ->where('tasks.user_id', '=', $user_id)
                ->delete();

            DB::table('order_result')
                ->leftJoin('tasks', 'order_result.task_id', '=', 'tasks.id')
                ->where('tasks.user_id', '=', $user_id)
                ->delete();

            DB::table('orders')
                ->leftJoin('tasks', 'orders.task_id', '=', 'tasks.id')
                ->where('tasks.user_id', '=', $user_id)
                ->delete();

            return back();
        } catch (\Throwable $e) {
            Log::debug('ERROR DELETE OLD DATA: '.$e->getMessage());
            return back();
        }
    }
}
