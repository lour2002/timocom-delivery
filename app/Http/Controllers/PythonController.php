<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessOrder;
use App\Models\Cookies;
use App\Models\SearchResult;
use App\Models\Task;
use App\Models\User;
use http\Env;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Log;

class PythonController extends Controller
{

    const TASK_KEYS = ['id','status_job', "version_task", "fromSelectOpt", "as_country", "as_country",
                       "as_zip","as_radius","toSelectOpt","toSelectOptArray","freightSelectOpt","length_min",
                       "length_max","weight_min","weight_max","dateSelectOpt","individual_days"];

    public function checkAuth(Request $request)
    {
        $user = User::where('key', '=', $request->get('user_key'))->first();
        if ($user) {

            $cookies = Cookies::where('user_key', '=', $request->get('user_key'))->first();

            return response()->json([
                'status' => '1',
                'msg' => '  ... Авторизация пройдена',
                'token_app' => $user->key,
                'cookies' => null !== $cookies ? $cookies->cookie : '',
            ]);
        }

        return response()->json([
            'status' => '0',
            'msg' => ' ... ERROR | Ошибка авторизации, не верный ключ!',
            'token_app' => '0',
            'cookies' => ''
        ]);
    }

    public function getTask(Request $request)
    {

        $task = Task::select('id', 'status_job', "version_task", "fromSelectOpt", "as_country", "car_city",
            "as_zip", "as_radius", "toSelectOpt", "toSelectOptArray", "freightSelectOpt", "length_min",
            "length_max", "weight_min", "weight_max", "dateSelectOpt", "individual_days")
            ->where([
                ['user_key', "=", $request->get('user_key')],
                ['status_job', '>', 1],
                ['num', '=', $request->get('num')],
            ])->first();

        // Log::debug($request->get('user_key'));

        if (null !== $task) {
            $task['id_task'] = $task['id'];
            unset($task['id']);
            $task["status_all_task"] = '1';
            $task["as_city"] = $task['car_city'];
            $task["toSelectOptArray"] = json_decode($task["toSelectOptArray"]);

            return response()->json($task);
        }

        return response()->json([
            'status_all_task'=> "1",
            "status_job" => "0",
            "id_task" => "0",
            "version_task" => "0"
            ]);
    }

    public function order(Request $request)
    {
        $input = $request->all();
        $task = Task::find($input['id_task']);
        if ($task['status_job'] == Task::STATUS_START ||
            $task['status_job'] == Task::STATUS_TEST &&
            $input['offer_id'])
        {
            $result = SearchResult::create($input);
            ProcessOrder::dispatch($result);
        }

        return response()->json(['success' => true]);
    }

    public function chrome(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'check_key' => 'required',
            'cookies' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        $cookie = Cookies::where('user_key', '=', $request->post('check_key'))->first();
        $cookie_data = $request->post('cookies');

        $cookie_data = json_decode($cookie_data, true);

        $cookie_data = array_filter($cookie_data, function ($val) {
            return in_array($val["sameSite"], ['lax', 'Lax', 'strict', 'Strict', 'none', 'None']);
        });

        $cookie_data = array_map(function ($val) {
            $val['domain'] = ltrim($val['domain'], '.');
            $val['sameSite'] = ucfirst($val['sameSite']);
            return $val;
        },$cookie_data);

        $cookie_data=json_encode(array_values($cookie_data));

        $md5 = md5($cookie_data);

        if (null === $cookie) {
            $c = new Cookies();
            $c->user_key = $request->post('check_key');
            $c->cookie = base64_encode($cookie_data);
            $c->hash = $md5;
            $c->save();
        } else {
            if ($cookie->hash !== $md5) {
                $cookie->cookie = base64_encode($cookie_data);
                $cookie->hash = $md5;
                $cookie->save();
            }
        }
        return response()->json(['success' => true]);
    }
}
