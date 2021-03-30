<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class SearchSettingsController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = auth()->user()->id;
        Task::create($input);

        return response()->json([
            'success' => true,
        ]);
    }
}
