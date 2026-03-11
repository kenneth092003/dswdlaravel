<?php

namespace App\Http\Controllers\EndUser;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = UserNotification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('enduser.notifications.index', compact('notifications'));
    }
}