<?php

namespace App\Http\Controllers\FAII;

use App\Http\Controllers\Controller;

class FAIIDashboardController extends Controller
{
    public function index()
    {
        return view('faii.dashboard');
    }
}