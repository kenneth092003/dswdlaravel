<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Super Admin')) {
            return view('dashboard.superadmin');
        }

        return view('dashboard.default');
    }
}