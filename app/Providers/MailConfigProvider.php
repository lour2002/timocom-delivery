<?php

namespace App\Providers;

use App\Models\Smtp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailConfigProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $user = null;
        if (isset(Auth::user()->id)) {
            $user = User::find(Auth::user()->id);
        } elseif (request()->get('user_key')) {
            $user = User::where('key', '=', request()->get('user_key'))->first();
        }

        if (null !== $user) {
            $configuration = Smtp::where("user_id", $user->id)->first();
            if (!is_null($configuration)) {
                $config = array(
                    'driver' => 'smtp',
                    'host' => $configuration->server,
                    'port' => $configuration->port,
                    'username' => $configuration->login,
                    'password' => $configuration->password,
                    'encryption' => $configuration->secure,
                    'from' => array('address' => $configuration->email, 'name' => $user->name),
                );
                Config::set('mail', $config);
            }
        }
    }
}
