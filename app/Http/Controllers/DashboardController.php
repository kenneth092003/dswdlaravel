<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\User;
=======
use Illuminate\Http\Request;
>>>>>>> 81f4c2acf5b187b13d419a9a9344d0587ebf828c
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
<<<<<<< HEAD
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->hasRole('Superadmin')) {
            return redirect()->route('admin.users.index');
        }

        if ($user->hasRole('Enduser')) {
            return redirect()->route('enduser.dashboard');
        }

        abort(403, 'Unauthorized.');
=======
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Block unapproved users
        if (! $user->is_approved) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Your account is pending approval by an administrator.']);
        }

        // ✅ Super Admin → loads superadmin dashboard view
        if ($user->hasRole('Super Admin')) {
            return view('dashboard.superadmin');
        }

        // ✅ FA II
        if ($user->hasRole('FA II')) {
            return redirect()->route('faii.dashboard');
        }

        // ✅ Budget
        if ($user->hasRole('Budget')) {
            return redirect()->route('budget.dashboard');
        }

        // ✅ Cash
        if ($user->hasRole('Cash')) {
            return redirect()->route('cash.dashboard');
        }

        // ✅ Procurement
        if ($user->hasRole('Procurement')) {
            return redirect()->route('procurement.dashboard');
        }

        // ✅ End User
        if ($user->hasRole('End User')) {
            return redirect()->route('enduser.dashboard');
        }

        // Fallback
        return view('dashboard');
>>>>>>> 81f4c2acf5b187b13d419a9a9344d0587ebf828c
    }
}