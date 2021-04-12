<?php

namespace App\Http\Controllers;

use App\Mail\DynamicEmail;
use App\Models\EmailBlacklist;
use App\Models\Smtp;
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

            $toEmail = $user->email;
            $data = array(
                "subject" => 'Test smtp',
                "message" => '<p>Hello, {name}!&nbsp;<br> <br>We can <strong>pick up</strong> {date_collection} after 13.00 and <strong>deliver </strong>same day or next day for <strong>€{price}</strong>.</p><p>I offer sprinter (10 EP): LENGTH&nbsp;<strong style="color: rgb(230, 0, 0);">4.85m</strong>, WIDTH&nbsp;<strong style="color: rgb(230, 0, 0);">2.25m</strong>, HEIGHT&nbsp;<strong style="color: rgb(230, 0, 0);">2.45m</strong>, Ramp HEIGHT is&nbsp;<strong style="color: rgb(230, 0, 0);">1.00m</strong>. <br> <br><strong>LOADING FROM SIDE &amp; BACK / NO TAIL LIFT <br> <br>WE CAN CHANGE PALETTS !</strong> <br> <br>Thanks in advance and hope to hear from you soon!&nbsp;<br> <br>[This letter is not a final agreement]</p><p><br></p><p><br></p><p><br></p>',
                "template" => 'test-email-template',
                "from" => [
                    'name' => $companySettings->name,
                    'email' => "timocom@kiri.com",
                ],
            );

            // pass dynamic message to mail class
            Mail::to($companySettings->email)
                ->bcc($evenMoreUsers)
                ->send(new DynamicEmail($data));

            if (Mail::failures() != 0) {
                return back()->with("success", "E-mail sent successfully!");
            }

            return back()->with("failed", "E-mail not sent!");
        }

        return back()->with("failed", "User not found!");
    }
}
