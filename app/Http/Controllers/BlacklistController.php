<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use App\Models\EmailBlacklist;
use App\Models\User;
use Illuminate\Http\Request;

class BlacklistController extends Controller
{
    public function get(Request $request)
    {
        return view('email-blacklist', [
            'list' => Blacklist::where('user_id', '=', auth()->user()->id)->orderBy('ttl', 'asc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        try {
            $input['user_id'] = auth()->user()->id;

            $count = Blacklist::where([
                                    ["email","=", $input['email']],
                                    ['user_id', '=', $input['user_id']]
                                ])->count();



            if ($count) {
                throw new \Exception();
            }

            $date = new \DateTime();

            $input['ttl'] = $date->add(new \DateInterval('PT'.$input['ttl'].'S'))->format('Y-m-d');
            $email = Blacklist::create($input);

        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true, 'item' => $email]);
    }

    public function delete(Request $request)
    {
        try {
            Blacklist::find($request->post('id'))->delete();
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true]);
    }
}
