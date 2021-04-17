<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use Illuminate\Http\Request;

class BlacklistController extends Controller
{
    public function get(Request $request)
    {
        return view('blacklist', [
            'list' => Blacklist::where('user_id', '=', auth()->user()->id)->get()
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        if (!array_key_exists('id', $input)) {
            $input['user_id'] = auth()->user()->id;
            $date = new \DateTime();
            $input['ttl'] = $date->setTimestamp($input['ttl'])->format('Y-m-d');
            $blacklist = Blacklist::create($input);
        } else {
            $blacklist = Blacklist::find($input['id']);
            foreach ($input as $k => $v) {
                if ('id' === $k) {
                    continue;
                }
                $blacklist->$k = $v;
            }
            $blacklist->save();
        }

        return redirect()->route('blacklist');
    }

    public function delete(Request $request)
    {
        Blacklist::find($request->post('id'))->delete();
        return redirect()->route('blacklist');
    }
}
