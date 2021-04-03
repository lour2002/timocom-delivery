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
        if (!$input['id']) {
            Task::create($input);
        } else {
            $task = Task::find($input['id']);
            foreach($input as $k => $v) {
                if ($k === 'id') {
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
