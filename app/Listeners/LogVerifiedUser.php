<?php

namespace App\Listeners;

use App\Traits\CaptureIpTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use jeremykenedy\LaravelRoles\Models\Role;

class LogVerifiedUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $ipAddress = new CaptureIpTrait();
        $user = $event->user;
        $user->signup_confirmation_ip_address = $ipAddress->getClientIp();
        $user->save();

        $userRole = Role::query()->where('slug', '=', 'user')->first();
        $user->roles()->detach();
        $user->roles()->attach($userRole);
    }
}
