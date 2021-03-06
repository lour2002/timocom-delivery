<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class SearchSettingsController extends Controller
{
    const EMPTY_COUNTRY = "-- is empty --";

    public function all(Request $request)
    {
        $tasks = Task::where('user_id', '=', auth()->user()->id)->get();

        return view('dashboard', [
            'list' => $tasks
        ]);
    }

    public function start(Request $request)
    {
        $task = Task::where([
            ['user_id', '=', auth()->user()->id],
            ['id', '=', $request->post('id')],
        ])->first();

        if (null !== $task) {
            $task->status_job = '3';
            $task->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function test(Request $request)
    {
        $task = Task::where([
            ['user_id', '=', auth()->user()->id],
            ['id', '=', $request->post('id')],
        ])->first();

        if (null !== $task) {
            $task->status_job = '2';
            $task->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function stop(Request $request)
    {
        $task = Task::where([
            ['user_id', '=', auth()->user()->id],
            ['id', '=', $request->post('id')],
        ])->first();

        if (null !== $task) {
            $task->status_job = '1';
            $task->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function get(Request $request, $id = null)
    {
        $task = Task::find((int) $id) ?? [];

        return view('task-edit', [
            'task' => $task
        ]);
    }

    public function store(Request $request)
    {

        $toSelectOptArray = [];
        $crossBorder = [];
        $input = [];
        foreach($request->all() as $k => $v) {
            if (null === $v) {
                $v='';
            }

            preg_match("/post[1-3]:\d|as_country_to:\d|border_[\w]+:\d/", $k, $matches);

            if (count($matches)) {
                $keys = explode(':', $k);
                switch ($keys[0]) {
                    case "post1":
                    case "post2":
                    case "post3":
                    case "as_country_to":
                        $toSelectOptArray[$keys[1]][$keys[0]] = $v;
                    break;
                    case "border_country":
                    case "border_val":
                        $crossBorder[$keys[1]][$keys[0]] = $v;
                    break;
                }

            } else {
                $input[$k] = $v;
            }

        }

        if (!empty($toSelectOptArray) {
            $toSelectOptArray=array_filter($toSelectOptArray, function ($val) {
                return $val['as_country_to'] !== self::EMPTY_COUNTRY;
            });
        }

        if (!empty($crossBorder) {
            $crossBorder=array_filter($crossBorder, function ($val) {
                return $val['border_country'] !== self::EMPTY_COUNTRY;
            });
        }

        $user = User::find(auth()->user()->id);
        $input['car_country'] = $input['as_country'];
        $input['car_zip'] = $input['as_zip'];
        $input['car_price_empty'] = $input['car_price'];
        $input['car_price_extra_points'] = 1 + $input['car_price_extra_points']/100;
        $input['user_id'] = $user->id;
        $input['user_key'] = $user->key;
        $input['toSelectOptArray'] = json_encode(array_values($toSelectOptArray));
        $input['cross_border'] = json_encode(array_values($crossBorder));

        if (!array_key_exists('id', $input)) {
            $max = Task::where('user_id', '=', $user->id)->max('num');
            if (5 < $max + 1) {
                return response()->json(['success' => false, 'error' => 'Only five active jobs allow']);
            }
            $input['num'] = $max + 1;
            $task = Task::create($input);
        } else {
            $task = Task::find($input['id']);
            foreach($input as $k => $v) {
                if (in_array($k, ['id', '_token'])) {
                    continue;
                }
                $task->$k = $v;
            }
            $task->version_task++;
            $task->save();
        }

        return redirect()->route('dashboard');
    }
}
