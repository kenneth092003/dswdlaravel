<?php

namespace App\Http\Controllers;

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
            return view('dashboard.superadmin');
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

        abort(403, 'Unauthorized.');
    }
}