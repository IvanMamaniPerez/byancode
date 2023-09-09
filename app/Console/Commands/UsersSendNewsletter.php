<?php

namespace App\Console\Commands;

use App\Mail\NotificationShipped;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UsersSendNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:send-newsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $nofitication = Notification::first();
        for ($i = 0; $i < 5; $i++) {
            $usersNotNotified = User::doesntHave("notifications")->take(100)->get();
            foreach ($usersNotNotified as $key => $user) {
                Mail::to($user->email)
                    ->send(new NotificationShipped($nofitication))
                    ->onQueue();
            }
            sleep(.5);
        }
    }
}
