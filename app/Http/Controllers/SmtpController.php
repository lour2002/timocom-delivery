<?php

namespace App\Http\Controllers;

use App\Mail\DynamicEmail;
use App\Models\EmailBlacklist;
use App\Models\Smtp;
use App\Models\Task;
use App\Models\Order;
use App\Models\User;
use App\Models\CompanySettings;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use lib\OSMap\OSMapOpenRoute;
use lib\OSMap\OSMapPoint;

class SmtpController extends Controller
{
    public function get(Request $request)
    {
        return view('smtp', [
            'smtp' => Smtp::where('user_id', '=', auth()->user()->id)->first()
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if (!array_key_exists('id', $input)) {
            $input['user_id'] = auth()->user()->id;
            $smtp = Smtp::create($input);
        } else {
            $smtp = Smtp::find($input['id']);
            foreach ($input as $k => $v) {
                if (in_array($k, ['id', '_token'])) {
                    continue;
                }
                $smtp->$k = $v;
            }
            $smtp->save();
        }

        return redirect()->route('smtp');
    }

    public function testEmail()
    {
        if (auth()->user()) {
            $user = User::find(auth()->user()->id);
        } elseif (request()->get('user_key')) {
            $user = User::where('key', '=', request()->get('user_key'))->first();
        }

        if ($user) {
            $companySettings = CompanySettings::where('user_id', '=', $user->id)->first();
            $task = Task::find(5);
            $order = Order::find(2);

            $message = $task->email_template;

            $message = str_replace(
                ['{name}', '{date_collection}', '{price}'],
                [$order->name, $order->date_collection, 190],
                $message
            );

            $data = array(
                "subject" => 'Test smtp',
                "template" => 'email-template',
                "from" => [
                    'name' => $companySettings->name,
                    'email' => "timocom@kiri.com",
                ],
                "message" => $message,
                 "order" => $order,
                 "company" => $companySettings
            );

            // pass dynamic message to mail class
            Mail::to($companySettings->email)
                ->send(new DynamicEmail($data));

            if (Mail::failures() != 0) {
                //return back()->with("success", "E-mail sent successfully!");
            }

            //return back()->with("failed", "E-mail not sent!");
        }

        //return back()->with("failed", "User not found!");
    }
}
