<?php

namespace App\Http\Controllers\EndUser;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $total = PurchaseRequest::where('user_id', $user->id)->count();

        $pending = PurchaseRequest::where('user_id', $user->id)
            ->where('status', 'submitted')
            ->count();

        $approved = PurchaseRequest::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();

        $draft = PurchaseRequest::where('user_id', $user->id)
            ->where('status', 'draft')
            ->count();

        $requests = PurchaseRequest::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('enduser.dashboard', compact(
            'total',
            'pending',
            'approved',
            'draft',
            'requests'
        ));
    }
}