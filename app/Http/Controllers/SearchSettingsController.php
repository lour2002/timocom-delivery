<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class SearchSettingsController extends Controller
{
    public function get(Request $request, $id = null)
    {
        $task = $id ? (Task::find(intval($id, 10)) ?? []) : [];

        return view('task-edit', [
            'task' => $task
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        $task = Task::create($input);


        return response()->json([
            'success' => true,
        ]);
    }
}
