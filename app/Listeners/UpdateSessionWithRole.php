<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UpdateSessionWithRole
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;

        // Update current session with user role
        DB::table('sessions')
            ->where('id', Session::getId())
            ->update([
                'user_role' => $user->role,
                'user_id' => $user->id,
            ]);
    }
}
