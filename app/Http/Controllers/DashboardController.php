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

        if ($user->hasRole('Superadmin')) {
            return redirect()->route('admin.users.index');
        }

        if ($user->hasRole('Enduser')) {
            return redirect()->route('enduser.dashboard');
        }

        abort(403, 'Unauthorized.');
    }
}