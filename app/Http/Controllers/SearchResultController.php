<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanySettings as SettingsModel;

class SearchResultController extends Controller
{
    public function store(Request $request)
    {
        dd($request->all());
    }
}
