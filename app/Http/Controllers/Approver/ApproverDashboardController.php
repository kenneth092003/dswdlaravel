<?php

namespace App\Http\Controllers\Approver;

use App\Http\Controllers\Controller;
use App\Models\PurchaseRequest;
use App\Models\UserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApproverDashboardController extends Controller
{
    public function index()
    {
        $pendingProposalsCount = PurchaseRequest::whereIn('status', ['pending', 'submitted_to_rd'])->count();
        $forReviewCount = PurchaseRequest::whereIn('status', ['pending', 'submitted_to_rd', 'submitted_to_procurement'])->count();
        $returnedCount = PurchaseRequest::whereIn('status', ['returned', 'rejected'])->count();

        $recentRequests = PurchaseRequest::with('user')
            ->whereIn('status', ['pending', 'submitted_to_rd', 'submitted_to_procurement', 'returned', 'rejected'])
            ->latest()
            ->limit(8)
            ->get();

        return view('approver.dashboard', compact(
            'pendingProposalsCount',
            'forReviewCount',
            'returnedCount',
            'recentRequests'
        ));
    }

    public function requests(): RedirectResponse
    {
        return redirect()
            ->route('approver.dashboard')
            ->with('success', 'Approver request workspace is not ready yet. Use the dashboard for now.');
    }

    public function show(Request $request, $id): RedirectResponse
    {
        return redirect()
            ->route('approver.dashboard')
            ->with('success', 'Request details view is not ready yet.');
    }

    public function approve($id): RedirectResponse
    {
        $purchaseRequest = PurchaseRequest::whereIn('status', ['pending', 'submitted_to_rd'])
            ->findOrFail($id);

        $purchaseRequest->status = 'approved';
        $purchaseRequest->save();

        $this->notifyRequester(
            $purchaseRequest->user_id,
            $purchaseRequest->id,
            'Activity Proposal Approved',
            'Your activity proposal has been approved by the RD.'
        );

        return back()->with('success', 'Proposal approved successfully.');
    }

    public function reject(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $purchaseRequest = PurchaseRequest::whereIn('status', ['pending', 'submitted_to_rd'])
            ->findOrFail($id);

        $purchaseRequest->status = 'rejected';
        $purchaseRequest->remarks = $validated['remarks'] ?? 'Proposal returned for revision.';
        $purchaseRequest->save();

        $this->notifyRequester(
            $purchaseRequest->user_id,
            $purchaseRequest->id,
            'Activity Proposal Rejected',
            $purchaseRequest->remarks ?: 'Your activity proposal was rejected and needs revision.'
        );

        return back()->with('success', 'Proposal rejected successfully.');
    }

    private function notifyRequester(int $userId, int $purchaseRequestId, string $title, string $message): void
    {
        UserNotification::create([
            'user_id' => $userId,
            'purchase_request_id' => $purchaseRequestId,
            'title' => $title,
            'message' => $message,
            'is_read' => false,
        ]);
    }
}
