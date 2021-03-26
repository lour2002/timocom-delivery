<?php

namespace App\Http\Controllers;

use http\Env;
use Illuminate\Http\Request;
use App\Models\CompanySettings as SettingsModel;

class PythonController extends Controller
{
    public function checkAuth(Request $request)
    {
        if ($request->get('user_key') === env('AUTH_KEY')) {
            return response()->json([
                'status' => '1',
                'msg' => '  ... Авторизация пройдена',
                'token_app' => env('AUTH_KET'),
                'coockies' => 'W3siZG9tYWluIjoiLm15LnRpbW9jb20uY29tIiwiZXhwaXJhdGlvbkRhdGUiOjM3NjQxNDY0ODguNDA4OTA2LCJob3N0T25seSI6ZmFsc2UsImh0dHBPbmx5IjpmYWxzZSwibmFtZSI6InRydXN0X2xvZ2luX2FnZW50IiwicGF0aCI6Ii8iLCJzZWN1cmUiOnRydWUsInNlc3Npb24iOmZhbHNlLCJzdG9yZUlkIjoiMCIsInZhbHVlIjoiTk9USUZJRVIifSx7ImRvbWFpbiI6Im15LnRpbW9jb20uY29tIiwiaG9zdE9ubHkiOnRydWUsImh0dHBPbmx5Ijp0cnVlLCJuYW1lIjoiQklHaXBTZXJ2ZXJ0Yy10cnVzdC1wcm8iLCJwYXRoIjoiLyIsInNlY3VyZSI6dHJ1ZSwic2Vzc2lvbiI6dHJ1ZSwic3RvcmVJZCI6IjAiLCJ2YWx1ZSI6IiFFOFBWNEZoMGtoMzV4RHFyM2dhRXZ2aDYybS9ZajJOMzRzTWIgbiBEcFVsZ0MwYnlSRlVwaWZ5R2tkaTBreUFGRFFxd2JsZnM5VVNoIn0seyJkb21haW4iOiJteS50aW1vY29tLmNvbSIsImhvc3RPbmx5Ijp0cnVlLCJodHRwT25seSI6dHJ1ZSwibmFtZSI6IkJJR2lwU2VydmVybXlfdGltb2NvbV9jb21fdGNnYXRlX3RvbWNhdCIsInBhdGgiOiIvIiwic2VjdXJlIjp0cnVlLCJzZXNzaW9uIjp0cnVlLCJzdG9yZUlkIjoiMCIsInZhbHVlIjoiIXVZRzhsOWEgc3JTaElJaXIzZ2FFdnZoNjJtL1lqMlFMREg5d3hDa05yWSBFbmZhY2MgRXlWUFpVVHVZd01SZEo4a1lCQXJ4dU5mV201Zz09In0seyJkb21haW4iOiJteS50aW1vY29tLmNvbSIsImhvc3RPbmx5Ijp0cnVlLCJodHRwT25seSI6dHJ1ZSwibmFtZSI6IkJJR2lwU2VydmVybXlfdGltb2NvbV9jb21fYXBwaGVhZGVyIiwicGF0aCI6Ii8iLCJzZWN1cmUiOnRydWUsInNlc3Npb24iOnRydWUsInN0b3JlSWQiOiIwIiwidmFsdWUiOiIhSm5DQWhndG5zbCBrQTBpcjNnYUV2dmg2Mm0vWWp3U09nc1RORWJqQ3c2YlNBWTlJWnlRS3BNZkdNMlA2RHdpMy9IOW5zbGFsN2RkOXN2WT0ifSx7ImRvbWFpbiI6Im15LnRpbW9jb20uY29tIiwiaG9zdE9ubHkiOnRydWUsImh0dHBPbmx5Ijp0cnVlLCJuYW1lIjoiQklHaXBTZXJ2ZXJteV90aW1vY29tX2NvbV90Y29fbmciLCJwYXRoIjoiLyIsInNlY3VyZSI6dHJ1ZSwic2Vzc2lvbiI6dHJ1ZSwic3RvcmVJZCI6IjAiLCJ2YWx1ZSI6IiFCZWhJdXcwQ1IwRUVIN1NyM2dhRXZ2aDYybS9ZajJsYkRoQkdRY2ZMNGNTaEZJQU9pMkM2bnA5WHRYNkI0TW53TlpDb3FjVUI4QWZwUkJzPSJ9LHsiZG9tYWluIjoibXkudGltb2NvbS5jb20iLCJob3N0T25seSI6dHJ1ZSwiaHR0cE9ubHkiOnRydWUsIm5hbWUiOiJCSUdpcFNlcnZlcm15LnRpbW9jb20uY29tX3dzX3RjZWJpZC1uZXciLCJwYXRoIjoiLyIsInNlY3VyZSI6dHJ1ZSwic2Vzc2lvbiI6dHJ1ZSwic3RvcmVJZCI6IjAiLCJ2YWx1ZSI6IiFWcE5rajNyN2U0Qk9vR0tyM2dhRXZ2aDYybS9ZajlYdFZoZlE5SFBVUjFVR2Z4OWFWeGJvVy9FUGtSbnBqS0JkNWwxM0xmeHRkOGNyVTk0PSJ9LHsiZG9tYWluIjoibXkudGltb2NvbS5jb20iLCJob3N0T25seSI6dHJ1ZSwiaHR0cE9ubHkiOnRydWUsIm5hbWUiOiJCSUdpcFNlcnZlcnJlYWx0aW1lLnRpbW9jb20uY29tX3Jlc3QiLCJwYXRoIjoiLyIsInNlY3VyZSI6dHJ1ZSwic2Vzc2lvbiI6dHJ1ZSwic3RvcmVJZCI6IjAiLCJ2YWx1ZSI6IiE2TWlJdzJoLzhkb0EvSjJyM2dhRXZ2aDYybS9ZajlVbDJ3T2huc2RVTjJENTZzIHM1Y0tpUENvNiAweHlmV2VQRTdJeUtlRndFM0FqdzNrPSJ9LHsiZG9tYWluIjoibXkudGltb2NvbS5jb20iLCJob3N0T25seSI6dHJ1ZSwiaHR0cE9ubHkiOnRydWUsIm5hbWUiOiJCSUdpcFNlcnZlcm15LnByby5vbmxpbmUudGltb2NvbS5uZXRfbm90aWZpY2F0aW9uIiwicGF0aCI6Ii8iLCJzZWN1cmUiOnRydWUsInNlc3Npb24iOnRydWUsInN0b3JlSWQiOiIwIiwidmFsdWUiOiIhS290bDRVa3Z4UTNGbHJLcjNnYUV2dmg2Mm0vWWogd2ppayBsZXogbk9FME5UYlBDb2lSeG44bzYyb0MgZlJrSFdNZDBKWG1ZV2NuSzBzYz0ifSx7ImRvbWFpbiI6Im15LnRpbW9jb20uY29tIiwiaG9zdE9ubHkiOnRydWUsImh0dHBPbmx5Ijp0cnVlLCJuYW1lIjoiQklHaXBTZXJ2ZXJteV90aW1vY29tX2NvbV9wcm9maWxlX3RvbWNhdCIsInBhdGgiOiIvIiwic2VjdXJlIjp0cnVlLCJzZXNzaW9uIjp0cnVlLCJzdG9yZUlkIjoiMCIsInZhbHVlIjoiIVUwWk9rTzBEbUlzb01QU3IzZ2FFdnZoNjJtL1lqeU9zWDRnUDBJMEtabG9DNU1GdzBiMWdJTmZBa2ovcXBoay9aZzQ2dnVYTzkwNFpBQT09In0seyJkb21haW4iOiIubXkudGltb2NvbS5jb20iLCJob3N0T25seSI6ZmFsc2UsImh0dHBPbmx5Ijp0cnVlLCJuYW1lIjoidGd0IiwicGF0aCI6Ii8iLCJzZWN1cmUiOnRydWUsInNlc3Npb24iOnRydWUsInN0b3JlSWQiOiIwIiwidmFsdWUiOiIuUVVWVEwwZERUUzlPYjFCaFpHUnBibWMuSFFvVGNOTl9wYkVscDN5ZC5ENkhNcEc3cF91SThRZFZIbkZvZF8yYU4xUjR2OC0wQ2hSeVpsOGFwbXFoWklHYmxVOTdteWU0ekk0T2xGRHI3OWl2cTRBcXdPcUVVdEdsUFlGSFI4aGFsSUNrSWFLTW9DWGdOeEpwNldDdWpvUWdOb2dkaF9GM3hzZVl3In0seyJkb21haW4iOiJteS50aW1vY29tLmNvbSIsImV4cGlyYXRpb25EYXRlIjoxNjQ4MTk4ODQxLjQwODkwNiwiaG9zdE9ubHkiOmZhbHNlLCJodHRwT25seSI6ZmFsc2UsIm5hbWUiOiJ0cnVzdF9mcCIsInBhdGgiOiIvIiwic2VjdXJlIjp0cnVlLCJzZXNzaW9uIjpmYWxzZSwic3RvcmVJZCI6IjAiLCJ2YWx1ZSI6Ii5RVVZUTDBkRFRTOU9iMUJoWkdScGJtYy5rX1VWMDRiOWhvS1hjNGlhLmpMMzR0azU5WS1hUDhrMUd0MUxXcU5KZFl0anFuakpnSm5tZjljcENPMk8yIn1d',
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
}
