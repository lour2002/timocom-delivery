<?php

namespace App\Orchid\Screens\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\User;
use App\Orchid\Layouts\User\AddRelationUserLayout;
use App\Orchid\Layouts\User\RelationUserLayout;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Access\UserSwitch;

class UserProfileRelationsScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Request $request): iterable
    {
        return [
            'users' => $request->user()->relation_users,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Relation Users';
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
            Layout::columns([AddRelationUserLayout::class]),
            Layout::columns([RelationUserLayout::class]),
        ];
    }

    public function addRelationUser(Request $request)
    {
        $data = $request->get('relation');
        $result = true;

        $checkUser = User::where('email', '=', $data['email'])->first();

        if(!$checkUser) $result = false;

        if($result) {
            $result = Hash::check($data['password'], $checkUser->password);
        }

        if ($result) {
            $request->user()->relation_users()->attach($checkUser);

            Toast::success(__('Relation created.'));
        } else {
            Toast::warning(__('Can\'t create releation user.'));
        }
    }

    public function removeRelation(Request $request)
    {
        try {
            $user = User::findOrFail($request->get('id'));

            $request->user()->relation_users()->detach($user);
        } catch(\Exception $exception) {
            Toast::danger(__('Can\'t remove releation user. Try later'));
        }
    }

    public function loginAs(Request $request)
    {
        $user = User::findOrFail($request->get('id'));

        UserSwitch::loginAs($user);

        Toast::info(__('You are now impersonating this user'));

        return redirect()->route('platform.task');
    }
}
