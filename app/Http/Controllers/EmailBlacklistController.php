<?php

namespace App\Http\Controllers;

use App\Models\EmailBlacklist;
use Illuminate\Http\Request;

class EmailBlacklistController extends Controller
{
    public function get(Request $request)
    {
        $emails = EmailBlacklist::where('user_id', '=', auth()->user()->id)->get();

        return view('email-blacklist', [
            'emails' => $emails
        ]);
    }

    public function store(Request $request)
    {
        $email = EmailBlacklist::where([
            ['user_id', '=', auth()->user()->id],
            ['email', '=', $request->post('email')],
        ])->first();

        if (null === $email) {
            $date = new \DateTime();
            $date->add(new \DateInterval('P'. $request->post('days').'D'));

            $email = new EmailBlacklist();
            $email->user_id = auth()->user()->id;
            $email->email = $request->post('email');
            $email->ttl = $date;
            $email->save();
        }

        return redirect()->route('email-blacklist');
    }
}
