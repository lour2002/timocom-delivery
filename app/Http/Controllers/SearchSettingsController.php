<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class SearchSettingsController extends Controller
{
    public function get(Request $request, $id = null)
    {
        $task = Task::find(intval($id, 10)) ?? [];

        return view('task-edit', [
            'task' => $task
        ]);
    }

    public function store(Request $request)
    {

        $toSelectOptArray = [];

        foreach($request->all() as $k => $v) {
            preg_match("/post[1-3]:\d|as_country_to:\d/", $k, $matches);

            if (count($matches)) {
                $keys = explode(':', $k);
                $toSelectOptArray[$keys[1]][$keys[0]] = $v;
            } else {
                $input[$k] = $v;
            }

        }

        // TODO:  может лучше  user_key
        $input['user_id'] = auth()->user()->id;
        $input['toSelectOptArray'] = json_encode(array_values($toSelectOptArray));

        if (!array_key_exists('id', $input)) {
            $task = Task::create($input);
        } else {
            $task = Task::find($input['id']);
            foreach($input as $k => $v) {
                if (in_array($k, ['id', '_token'])) {
                    continue;
                }
                $task->$k = $v;
            }
            $task->save();
        }

        return redirect()->route('task', ['id' => $task->id]);
    }
}
