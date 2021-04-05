<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CompanySettings as SettingsModel;

class CompanySettingsController extends Controller
{
    public function get(Request $request)
    {
        $settings = SettingsModel::where('user_id', '=', auth()->user()->id)->first();

        return view('company', [
            'settings' => $settings ?? []
        ]);
    }

    public function set(Request $request)
    {
        $input = $request->all();

        if (!isset($input['id']) || 0 === $input['id'])
        {
            $settings = new SettingsModel();
        } else {
            $settings = SettingsModel::find($input['id']);
        }

        $settings->user_id = auth()->user()->id;
        $settings->timocom_id = $input['timocomId'];
        $settings->name = $input['companyName'];
        $settings->contact_person = $input['contactPerson'];
        $settings->phone = $input['phone'];
        $settings->email = $input['email'];
        $settings->save();

        return view('company', [
            'settings' => $settings
        ]);
    }
}
