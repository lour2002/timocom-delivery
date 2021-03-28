<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanySettings as SettingsModel;

class CompanySettingsController extends Controller
{
    public function get(Request $request)
    {
//      TODO: Привязать настройки к Пользователю.
        $settings = SettingsModel::find(1) ?? [];

        return view('company', [
            'settings' => $settings
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
