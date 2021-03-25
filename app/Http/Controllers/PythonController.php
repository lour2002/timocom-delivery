<?php

namespace App\Http\Controllers;

use App\Models\Coockies;
use http\Env;
use Illuminate\Http\Request;
use App\Models\CompanySettings as SettingsModel;

class PythonController extends Controller
{
    public function checkAuth(Request $request)
    {
        if ($request->get('user_key') === env('AUTH_KEY')) {

            $coockies = Coockies::where('auth_key', '=', $request->get('user_key'))->first();

            return response()->json([
                'status' => '1',
                'msg' => '  ... Авторизация пройдена',
                'token_app' => env('AUTH_KEY'),
                'coockies' => null !== $coockies ? $coockies->coockie : '',
            ]);
        }

        return response()->json([
            'status' => '0',
            'msg' => ' ... ERROR | Ошибка авторизации, не верный ключ!',
            'token_app' => '0',
            'coockies' => ''
        ]);
    }

    public function getTask(Request $request)
    {
        return response()->json([
            "id_task" => "1143",
            "status_all_task" => "1",
            "status_job" => "2",
            "version_task" => "1406",
            "fromSelectOpt" => "app:cnt:searchForm:fromSelectOpt3",
            "as_country" => "DE Germany",
            "as_zip" => "88214",
            "as_radius" => "140",
            "toSelectOpt" => "app:cnt:searchForm:toSelectOpt2",
            "toSelectOptArray" => [
                [
                    "as_country_to" => "CH Switzerland",
                    "post1" => "",
                    "post2" => "",
                    "post3" => ""
                ],
                [
                    "as_country_to" => "CZ Czech Republic",
                    "post1" => "",
                    "post2" => "",
                    "post3" => ""
                ],
                [
                    "as_country_to" => "LU Luxembourg",
                    "post1" => "",
                    "post2" => "",
                    "post3" => ""
                ],
                [
                    "as_country_to" => "LI Liechtenstein",
                    "post1" => "",
                    "post2" => "",
                    "post3" => ""
                ],
                [
                    "as_country_to" => "IT Italy",
                    "post1" => "",
                    "post2" => "",
                    "post3" => ""
                ]
            ],
            "freightSelectOpt" => "app:cnt:searchForm:freightSelectOpt2",
            "length_min" => "0.00",
            "length_max" => "6.00",
            "weight_min" => "0.00",
            "weight_max" => "1.00",
            "dateSelectOpt" => "app:cnt:searchForm:dateSelectOpt2",
            "individual_days" => "25.03.2021",
            "period_start" => "22.02.2021",
            "period_stop" => "23.02.2021"
        ]);
    }

    public function order(Request $request)
    {
        Log::chanel('timocom')->debug("===============================================");
        Log::chanel('timocom')->debug($request->all());
        Log::chanel('timocom')->debug("===============================================");
    }

    public function chrome(Request $request)
    {
        $coockie = Coockies::where('auth_key', '=', $request->post('check_key'))->first();
        $coock = $request->post('coockies');
        $md5 = md5($coock);
        if (null === $coockie) {
            $c = new Coockies();
            $c->auth_key = $request->post('check_key');
            $c->coockie = base64_encode($coock);
            $c->hash = $md5;
            $c->save();
        } else {
            if ($coockie->hash !== $md5) {
                $coockie->coockie = base64_encode($coock);
                $coockie->hash = $md5;
                $coockie->save();
            }
        }
        return response()->json(['success' => true]);
    }
}
