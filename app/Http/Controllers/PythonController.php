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
                'coockies' => 'W3siZG9tYWluIjoiLm15LnRpbW9jb20uY29tIiwiZXhwaXJhdGlvbkRhdGUiOjM3NjQxNDY0ODguNDA4OTA2LCJob3N0T25seSI6ZmFsc2UsImh0dHBPbmx5IjpmYWxzZSwibmFtZSI6InRydXN0X2xvZ2luX2FnZW50IiwicGF0aCI6Ii8iLCJzYW1lU2l0ZSI6InVuc3BlY2lmaWVkIiwic2VjdXJlIjp0cnVlLCJzZXNzaW9uIjpmYWxzZSwic3RvcmVJZCI6IjAiLCJ2YWx1ZSI6Ik5PVElGSUVSIn0seyJkb21haW4iOiJteS50aW1vY29tLmNvbSIsImhvc3RPbmx5Ijp0cnVlLCJodHRwT25seSI6dHJ1ZSwibmFtZSI6IkJJR2lwU2VydmVydGMtdHJ1c3QtcHJvIiwicGF0aCI6Ii8iLCJzYW1lU2l0ZSI6ImxheCIsInNlY3VyZSI6dHJ1ZSwic2Vzc2lvbiI6dHJ1ZSwic3RvcmVJZCI6IjAiLCJ2YWx1ZSI6IiFFOFBWNEZoMGtoMzV4RHFyM2dhRXZ2aDYybS9ZajJOMzRzTWIgbiBEcFVsZ0MwYnlSRlVwaWZ5R2tkaTBreUFGRFFxd2JsZnM5VVNoIn0seyJkb21haW4iOiJteS50aW1vY29tLmNvbSIsImhvc3RPbmx5Ijp0cnVlLCJodHRwT25seSI6dHJ1ZSwibmFtZSI6IkJJR2lwU2VydmVybXlfdGltb2NvbV9jb21fdGNnYXRlX3RvbWNhdCIsInBhdGgiOiIvIiwic2FtZVNpdGUiOiJsYXgiLCJzZWN1cmUiOnRydWUsInNlc3Npb24iOnRydWUsInN0b3JlSWQiOiIwIiwidmFsdWUiOiIhdVlHOGw5YSBzclNoSUlpcjNnYUV2dmg2Mm0vWWoyUUxESDl3eENrTnJZIEVuZmFjYyBFeVZQWlVUdVl3TVJkSjhrWUJBcnh1TmZXbTVnPT0ifSx7ImRvbWFpbiI6Im15LnRpbW9jb20uY29tIiwiaG9zdE9ubHkiOnRydWUsImh0dHBPbmx5Ijp0cnVlLCJuYW1lIjoiQklHaXBTZXJ2ZXJteV90aW1vY29tX2NvbV9hcHBoZWFkZXIiLCJwYXRoIjoiLyIsInNhbWVTaXRlIjoibGF4Iiwic2VjdXJlIjp0cnVlLCJzZXNzaW9uIjp0cnVlLCJzdG9yZUlkIjoiMCIsInZhbHVlIjoiIUpuQ0FoZ3Ruc2wga0EwaXIzZ2FFdnZoNjJtL1lqd1NPZ3NUTkViakN3NmJTQVk5SVp5UUtwTWZHTTJQNkR3aTMvSDluc2xhbDdkZDlzdlk9In0seyJkb21haW4iOiJteS50aW1vY29tLmNvbSIsImhvc3RPbmx5Ijp0cnVlLCJodHRwT25seSI6dHJ1ZSwibmFtZSI6IkJJR2lwU2VydmVybXlfdGltb2NvbV9jb21fdGNvX25nIiwicGF0aCI6Ii8iLCJzYW1lU2l0ZSI6ImxheCIsInNlY3VyZSI6dHJ1ZSwic2Vzc2lvbiI6dHJ1ZSwic3RvcmVJZCI6IjAiLCJ2YWx1ZSI6IiFCZWhJdXcwQ1IwRUVIN1NyM2dhRXZ2aDYybS9ZajJsYkRoQkdRY2ZMNGNTaEZJQU9pMkM2bnA5WHRYNkI0TW53TlpDb3FjVUI4QWZwUkJzPSJ9LHsiZG9tYWluIjoibXkudGltb2NvbS5jb20iLCJob3N0T25seSI6dHJ1ZSwiaHR0cE9ubHkiOnRydWUsIm5hbWUiOiJCSUdpcFNlcnZlcm15LnRpbW9jb20uY29tX3dzX3RjZWJpZC1uZXciLCJwYXRoIjoiLyIsInNhbWVTaXRlIjoibGF4Iiwic2VjdXJlIjp0cnVlLCJzZXNzaW9uIjp0cnVlLCJzdG9yZUlkIjoiMCIsInZhbHVlIjoiIVZwTmtqM3I3ZTRCT29HS3IzZ2FFdnZoNjJtL1lqOVh0VmhmUTlIUFVSMVVHZng5YVZ4Ym9XL0VQa1JucGpLQmQ1bDEzTGZ4dGQ4Y3JVOTQ9In0seyJkb21haW4iOiJteS50aW1vY29tLmNvbSIsImhvc3RPbmx5Ijp0cnVlLCJodHRwT25seSI6dHJ1ZSwibmFtZSI6IkJJR2lwU2VydmVycmVhbHRpbWUudGltb2NvbS5jb21fcmVzdCIsInBhdGgiOiIvIiwic2FtZVNpdGUiOiJsYXgiLCJzZWN1cmUiOnRydWUsInNlc3Npb24iOnRydWUsInN0b3JlSWQiOiIwIiwidmFsdWUiOiIhNk1pSXcyaC84ZG9BL0oycjNnYUV2dmg2Mm0vWWo5VWwyd09obnNkVU4yRDU2cyBzNWNLaVBDbzYgMHh5ZldlUEU3SXlLZUZ3RTNBanczaz0ifSx7ImRvbWFpbiI6Im15LnRpbW9jb20uY29tIiwiaG9zdE9ubHkiOnRydWUsImh0dHBPbmx5Ijp0cnVlLCJuYW1lIjoiQklHaXBTZXJ2ZXJteS5wcm8ub25saW5lLnRpbW9jb20ubmV0X25vdGlmaWNhdGlvbiIsInBhdGgiOiIvIiwic2FtZVNpdGUiOiJsYXgiLCJzZWN1cmUiOnRydWUsInNlc3Npb24iOnRydWUsInN0b3JlSWQiOiIwIiwidmFsdWUiOiIhS290bDRVa3Z4UTNGbHJLcjNnYUV2dmg2Mm0vWWogd2ppayBsZXogbk9FME5UYlBDb2lSeG44bzYyb0MgZlJrSFdNZDBKWG1ZV2NuSzBzYz0ifSx7ImRvbWFpbiI6Im15LnRpbW9jb20uY29tIiwiaG9zdE9ubHkiOnRydWUsImh0dHBPbmx5Ijp0cnVlLCJuYW1lIjoiQklHaXBTZXJ2ZXJteV90aW1vY29tX2NvbV9wcm9maWxlX3RvbWNhdCIsInBhdGgiOiIvIiwic2FtZVNpdGUiOiJsYXgiLCJzZWN1cmUiOnRydWUsInNlc3Npb24iOnRydWUsInN0b3JlSWQiOiIwIiwidmFsdWUiOiIhVTBaT2tPMERtSXNvTVBTcjNnYUV2dmg2Mm0vWWp5T3NYNGdQMEkwS1psb0M1TUZ3MGIxZ0lOZkFrai9xcGhrL1pnNDZ2dVhPOTA0WkFBPT0ifSx7ImRvbWFpbiI6Ii5teS50aW1vY29tLmNvbSIsImhvc3RPbmx5IjpmYWxzZSwiaHR0cE9ubHkiOnRydWUsIm5hbWUiOiJ0Z3QiLCJwYXRoIjoiLyIsInNhbWVTaXRlIjoibGF4Iiwic2VjdXJlIjp0cnVlLCJzZXNzaW9uIjp0cnVlLCJzdG9yZUlkIjoiMCIsInZhbHVlIjoiLlFVVlRMMGREVFM5T2IxQmhaR1JwYm1jLkhRb1RjTk5fcGJFbHAzeWQuRDZITXBHN3BfdUk4UWRWSG5Gb2RfMmFOMVI0djgtMENoUnlabDhhcG1xaFpJR2JsVTk3bXllNHpJNE9sRkRyNzlpdnE0QXF3T3FFVXRHbFBZRkhSOGhhbElDa0lhS01vQ1hnTnhKcDZXQ3Vqb1FnTm9nZGhfRjN4c2VZdyJ9LHsiZG9tYWluIjoibXkudGltb2NvbS5jb20iLCJleHBpcmF0aW9uRGF0ZSI6MTY0ODE5ODg0MS40MDg5MDYsImhvc3RPbmx5IjpmYWxzZSwiaHR0cE9ubHkiOmZhbHNlLCJuYW1lIjoidHJ1c3RfZnAiLCJwYXRoIjoiLyIsInNhbWVTaXRlIjoidW5zcGVjaWZpZWQiLCJzZWN1cmUiOnRydWUsInNlc3Npb24iOmZhbHNlLCJzdG9yZUlkIjoiMCIsInZhbHVlIjoiLlFVVlRMMGREVFM5T2IxQmhaR1JwYm1jLmtfVVYwNGI5aG9LWGM0aWEuakwzNHRrNTlZLWFQOGsxR3QxTFdxTkpkWXRqcW5qSmdKbm1mOWNwQ08yTzIifV0=',
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
