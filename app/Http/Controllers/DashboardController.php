<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasRole('Super Admin')) {
            return redirect()->route('admin.users.index');
        }

        if ($user->hasRole('FAII')) {
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

        if ($user->hasRole('Enduser')) {
            return redirect()->route('enduser.dashboard');
        }

        // Fallback — no role assigned
        return view('dashboard');
    }
}