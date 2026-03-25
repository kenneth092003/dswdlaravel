<?php

namespace App\Listeners;

use App\Models\Attendance;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class RecordAttendance
{
    // ✅ Auto record login time
    public function handleLogin(Login $event): void
    {
        Attendance::create([
            'user_id'  => $event->user->id,
            'login_at' => now(),
        ]);
    }

    // ✅ Auto record logout time
    public function handleLogout(Logout $event): void
    {
        Attendance::where('user_id', $event->user->id)
            ->whereNull('logout_at')
            ->latest('login_at')
            ->first()
            ?->update(['logout_at' => now()]);
    }
}