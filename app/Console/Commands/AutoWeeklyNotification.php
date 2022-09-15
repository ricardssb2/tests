<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Notifications\WeeklyAdminNotification;

class AutoWeeklyNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:weeklyadminnotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        //user where role is admin
        $users = User::where('role', 'admin')->get();

        if ($users->count() > 0) {
            foreach ($users as $user) {
                $notification = new WeeklyAdminNotification($user);

                Notification::send($user, $notification);
            }
        }

        return 0;
    }
}
