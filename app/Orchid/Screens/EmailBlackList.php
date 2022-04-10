<?php

namespace App\Orchid\Screens;

use App\Models\BlackList;
use Illuminate\Http\Request;

use App\Orchid\Layouts\BlackList\AddedEmailLayout;
use App\Orchid\Layouts\BlackList\EmailListLayout;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;


class EmailBlackList extends Screen
{
    public $emails;
    /**
     * Query data.
     * @param Request $request
     *
     * @return array
     */
    public function query(Request $request): iterable
    {
        return [
            'emails' => $request->user()->black_list_emails,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Black List Emails';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::columns([AddedEmailLayout::class]),
            Layout::columns([EmailListLayout::class])
        ];
    }

    /**
     * @param Request $request
     */

    public function addEmail(BlackList $blacklist, Request $request): void
    {
        $data = $request->get('blacklist');

        try {
            $data['user_id'] =  $request->user()->id;

            $count = BlackList::where([
                                    ["email","=", $data['email']],
                                    ['user_id', '=', $data['user_id']]
                                ])->count();



            if ($count) {
                throw new \Exception();
            }

            $date = new \DateTime();

            $data['ttl'] = $date->add(new \DateInterval('PT'.$data['ttl'].'S'))->format('Y-m-d');

            $email = $blacklist
                        ->fill($data)
                        ->save();

        } catch (\Exception $e) {
            Toast::warning(__('Email alredy exist.'));
        }

        Toast::success(__('Email added to black list.'));
    }

    /**
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        BlackList::findOrFail($request->get('id'))->delete();

        Toast::info(__('Email was removed'));
    }
}
