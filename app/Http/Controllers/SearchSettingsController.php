<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class SearchSettingsController extends Controller
{
    public function get(Request $request)
    {
        $id = $request->get('id', 0);
        $task = Task::find($id) ?? [];

        return view('task-edit', [
            'task' => $task
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        if (!$input['task_id']) {
            Task::create($input);
        } else {
            $task = Task::find($input['task_id']);
            foreach($input as $k => $v) {
                if ($k === 'task_id') {
                    continue;
                }
                $task->$k = $v;
            }
            $task->save();
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
