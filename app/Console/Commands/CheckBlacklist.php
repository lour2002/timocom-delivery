<?php

namespace App\Console\Commands;

use App\Models\Blacklist;
use App\Models\User;
use Illuminate\Console\Command;

class CheckBlacklist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_blacklist:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check emails blacklist';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $date = new \DateTime();
        /** @var User[] $users */
        $users = User::select('id')->get();
        foreach($users as $user) {
            $list = Blacklist::where('user_id', '=', $user->id)->get();
            foreach($list as $item) {
                if (new \DateTime($item->ttl) < $date) {
                    $item->delete();
                }
            }
        }
    }
}
