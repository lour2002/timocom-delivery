<?php

namespace App\Http\Controllers;

use http\Env;
use Illuminate\Http\Request;
use App\Models\CompanySettings as SettingsModel;

class PythonController extends Controller
{
    public function checkAuth(Request $request)
    {
        if ($request->get('user_key') === env('AUTH_KET')) {
            return response()->json([
                'status' => '1',
                'msg' => '  ... Авторизация пройдена',
                'token_app' => env('AUTH_KET'),
                'coockies' => 'W3siZG9tYWluIjoiLm15LnRpbW9jb20uY29tIiwiZXhwaXJhdGlvbkRhdGUiOjM3NjM5NjQ1MTcuNTczNzE1LCJob3N0T25seSI6ZmFsc2UsImh0dHBPbmx5IjpmYWxzZSwibmFtZSI6InRydXN0X2xvZ2luX2FnZW50IiwicGF0aCI6Ii8iLCJzYW1lU2l0ZSI6InVuc3BlY2lmaWVkIiwic2VjdXJlIjp0cnVlLCJzZXNzaW9uIjpmYWxzZSwic3RvcmVJZCI6IjAiLCJ2YWx1ZSI6Ik5PVElGSUVSIn0seyJkb21haW4iOiJteS50aW1vY29tLmNvbSIsImhvc3RPbmx5Ijp0cnVlLCJodHRwT25seSI6dHJ1ZSwibmFtZSI6IkJJR2lwU2VydmVydGMtdHJ1c3QtcHJvIiwicGF0aCI6Ii8iLCJzYW1lU2l0ZSI6ImxheCIsInNlY3VyZSI6dHJ1ZSwic2Vzc2lvbiI6dHJ1ZSwic3RvcmVJZCI6IjAiLCJ2YWx1ZSI6IiFjM20gQjh0ZjRVdjBxRkpEQ2lRdllNdXh0N29RNXVwWTdUb0UzYmswTFdKWVNzTCBua2VhSFRQYzFJdG5NN1Y1ZjR1SHRTeU9sU1ZwIn0seyJkb21haW4iOiJteS50aW1vY29tLmNvbSIsImhvc3RPbmx5Ijp0cnVlLCJodHRwT25seSI6dHJ1ZSwibmFtZSI6IkJJR2lwU2VydmVybXlfdGltb2NvbV9jb21fdGNnYXRlX3RvbWNhdCIsInBhdGgiOiIvIiwic2FtZVNpdGUiOiJsYXgiLCJzZWN1cmUiOnRydWUsInNlc3Npb24iOnRydWUsInN0b3JlSWQiOiIwIiwidmFsdWUiOiIhTU5HeldUd3ZiL0x5ZnlCRENpUXZZTXV4dDdvUTVwNklSd3BsU0swMGlHR2NURlIvSjZueWVndk5yVGhzYVJTNmtEZVIzc25FMHQxRkpnPT0ifSx7ImRvbWFpbiI6Im15LnRpbW9jb20uY29tIiwiaG9zdE9ubHkiOnRydWUsImh0dHBPbmx5Ijp0cnVlLCJuYW1lIjoiQklHaXBTZXJ2ZXJwcm9fc3RhdGljX3NoYXJlZCIsInBhdGgiOiIvIiwic2FtZVNpdGUiOiJsYXgiLCJzZWN1cmUiOnRydWUsInNlc3Npb24iOnRydWUsInN0b3JlSWQiOiIwIiwidmFsdWUiOiIhNlI0L3NJaWdUNGhydCBSRENpUXZZTXV4dDdvUTVqR24yUmVpMDBzSEtvYkVqblk4R1JTTlVHZU14bnE5T210eHZ5SklndFZ2NTdxSmt3PT0ifSx7ImRvbWFpbiI6Im15LnRpbW9jb20uY29tIiwiaG9zdE9ubHkiOnRydWUsImh0dHBPbmx5Ijp0cnVlLCJuYW1lIjoiQklHaXBTZXJ2ZXJteV90aW1vY29tX2NvbV9hcHBoZWFkZXIiLCJwYXRoIjoiLyIsInNhbWVTaXRlIjoibGF4Iiwic2VjdXJlIjp0cnVlLCJzZXNzaW9uIjp0cnVlLCJzdG9yZUlkIjoiMCIsInZhbHVlIjoiITdoVm5ualhORy95Rmk3MURDaVF2WU11eHQ3b1E1dXJEIGVyTUs4dFY5NXBRTE02ZzdOaWtxaXJ1VzM0WTlBQUNJNW5CZjZsWDJUcTZtcXc9In0seyJkb21haW4iOiJteS50aW1vY29tLmNvbSIsImhvc3RPbmx5Ijp0cnVlLCJodHRwT25seSI6dHJ1ZSwibmFtZSI6IkJJR2lwU2VydmVycmVhbHRpbWUudGltb2NvbS5jb21fcmVzdCIsInBhdGgiOiIvIiwic2FtZVNpdGUiOiJsYXgiLCJzZWN1cmUiOnRydWUsInNlc3Npb24iOnRydWUsInN0b3JlSWQiOiIwIiwidmFsdWUiOiIhck5sZVRBSWdkIEU4TENsRENpUXZZTXV4dDdvUTV2bXdCZEYgdk44MmRRYmhXN3dlMi8gV3pXMHNST05ETmhNUDl5RXNiOGJXQXhYRFc5az0ifSx7ImRvbWFpbiI6Im15LnRpbW9jb20uY29tIiwiaG9zdE9ubHkiOnRydWUsImh0dHBPbmx5Ijp0cnVlLCJuYW1lIjoiQklHaXBTZXJ2ZXJteS5wcm8ub25saW5lLnRpbW9jb20ubmV0X25vdGlmaWNhdGlvbiIsInBhdGgiOiIvIiwic2FtZVNpdGUiOiJsYXgiLCJzZWN1cmUiOnRydWUsInNlc3Npb24iOnRydWUsInN0b3JlSWQiOiIwIiwidmFsdWUiOiIhUmxNU3psUFlWWiB6dHV4RENpUXZZTXV4dDdvUTVpQnNjcUdDZXRrMjNBckZhaEUvSWQ5S3NTRmdOdGFWT1hpQkNPeFA1RmxEeG1HQ2twMD0ifSx7ImRvbWFpbiI6Im15LnRpbW9jb20uY29tIiwiaG9zdE9ubHkiOnRydWUsImh0dHBPbmx5Ijp0cnVlLCJuYW1lIjoiQklHaXBTZXJ2ZXJteS50aW1vY29tLmNvbV93c190Y2ViaWQtbmV3IiwicGF0aCI6Ii8iLCJzYW1lU2l0ZSI6ImxheCIsInNlY3VyZSI6dHJ1ZSwic2Vzc2lvbiI6dHJ1ZSwic3RvcmVJZCI6IjAiLCJ2YWx1ZSI6IiE4WC9jVndyemViWkJ6OWhEQ2lRdllNdXh0N29RNXJzMzkxVkRaT0RVYVk5Q1RubndCcTdKWE5JM2Y3dkJISVZQIFRjbkxERWh0b2N4QVE9PSJ9LHsiZG9tYWluIjoibXkudGltb2NvbS5jb20iLCJob3N0T25seSI6dHJ1ZSwiaHR0cE9ubHkiOnRydWUsIm5hbWUiOiJCSUdpcFNlcnZlcm15X3RpbW9jb21fY29tX3Rjb19uZyIsInBhdGgiOiIvIiwic2FtZVNpdGUiOiJsYXgiLCJzZWN1cmUiOnRydWUsInNlc3Npb24iOnRydWUsInN0b3JlSWQiOiIwIiwidmFsdWUiOiIheFJiQXgwNnplb0JETVRsRENpUXZZTXV4dDdvUTVrMHdsU2U2T2o5clJxNHRQblpzWnh0WWlZNURGNTNUOUlYdWF2d2Zhc1JhWDFsOFR3PT0ifSx7ImRvbWFpbiI6Ii5teS50aW1vY29tLmNvbSIsImhvc3RPbmx5IjpmYWxzZSwiaHR0cE9ubHkiOnRydWUsIm5hbWUiOiJ0Z3QiLCJwYXRoIjoiLyIsInNhbWVTaXRlIjoibGF4Iiwic2VjdXJlIjp0cnVlLCJzZXNzaW9uIjp0cnVlLCJzdG9yZUlkIjoiMCIsInZhbHVlIjoiLlFVVlRMMGREVFM5T2IxQmhaR1JwYm1jLjYwcXppQ0x4YUlEMXpJTlUuMGlmcDdsM1RIbDlubDFXMnNMVjVfaWxkYkxCMzdnZFRtUzlBUWE2T0xZdFUyYkF5RVVTRWYtdGlrdmxkMTFrLTdNNW9HU3BaaWM0RlFPWXZWSlFxTWs2ZHIxM21pSlZiMWhIaGlrZFVfbVRhRVVIcldWd1RRTF8zSWF2ciJ9LHsiZG9tYWluIjoiLm15LnRpbW9jb20uY29tIiwiZXhwaXJhdGlvbkRhdGUiOjE2NDgwMTY4NzAuNTczNzY0LCJob3N0T25seSI6ZmFsc2UsImh0dHBPbmx5IjpmYWxzZSwibmFtZSI6InRydXN0X2ZwIiwicGF0aCI6Ii8iLCJzYW1lU2l0ZSI6InVuc3BlY2lmaWVkIiwic2VjdXJlIjp0cnVlLCJzZXNzaW9uIjpmYWxzZSwic3RvcmVJZCI6IjAiLCJ2YWx1ZSI6Ii5RVVZUTDBkRFRTOU9iMUJoWkdScGJtYy5mOXpZbjZpZkxQb0hieGJSLklXT0VLZlZFWXdPX1Z1ekNsVEJMVFVNdEdQa0laclp0dkstd3NuOXhJNUJEIn1d',
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
            "status_job" => "1",
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
        dd($request->all());
    }
}
