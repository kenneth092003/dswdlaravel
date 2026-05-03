<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Block unapproved users
        if (! $user->is_approved) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Your account is pending approval by an administrator.']);
        }

        // ✅ Fixed role names to match DB exactly
        if ($user->hasRole('Super Admin')) {
            $pendingApprovalCount = User::where('is_approved', false)->count();
            $signupNotificationCount = UserNotification::where('user_id', $user->id)
                ->where('is_read', false)
                ->where('title', 'New User Registration')
                ->count();
            $complaintNotificationCount = UserNotification::where('user_id', $user->id)
                ->where('is_read', false)
                ->whereNotNull('system_issue_id')
                ->count();

            return view('dashboard.superadmin', compact(
                'pendingApprovalCount',
                'signupNotificationCount',
                'complaintNotificationCount'
            ));
        }

        if ($user->hasRole('End User')) {
            return redirect()->route('enduser.dashboard');
        }

        if ($user->hasRole('FA II')) {
            return redirect()->route('faii.dashboard');
        }

        if ($user->hasRole('Budget')) {
            return redirect()->route('budget.dashboard');
        }

        if ($user->hasRole('Cash')) {
            return redirect()->route('cash.dashboard');
        }

        if ($user->hasRole('Procurement')) {
            return redirect()->route('procurement.dashboard');
        }

        if ($user->hasRole('Approver')) {
            return redirect()->route('approver.dashboard');
        }

        abort(403, 'Unauthorized.');
    }
}
