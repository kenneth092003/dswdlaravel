<?php

namespace App\Http\Controllers\EndUser;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseRequest;

class EnduserDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $draftCount = PurchaseRequest::where('user_id', $userId)
            ->where('status', 'draft')
            ->count();

        $pendingCount = PurchaseRequest::where('user_id', $userId)
            ->whereIn('status', ['pending', 'submitted_to_rd'])
            ->count();

        $approvedProcessingCount = PurchaseRequest::where('user_id', $userId)
            ->whereIn('status', ['approved', 'processing', 'bac_processing', 'signed_pr', 'validated_payment'])
            ->count();

        $returnedRejectedCount = PurchaseRequest::where('user_id', $userId)
            ->whereIn('status', ['returned', 'rejected'])
            ->count();

        $requests = PurchaseRequest::where('user_id', $userId)
            ->latest()
            ->get();

        return view('enduser.dashboard', compact(
            'draftCount',
            'pendingCount',
            'approvedProcessingCount',
            'returnedRejectedCount',
            'requests'
        ));
    }
}
