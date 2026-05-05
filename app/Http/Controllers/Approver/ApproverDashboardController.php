<?php

namespace App\Http\Controllers\Approver;

use App\Http\Controllers\Controller;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestAttachment;
use App\Models\UserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function requests()
    {
        $requests = PurchaseRequest::with('user')
            ->whereIn('status', ['pending', 'submitted_to_rd', 'submitted_to_procurement', 'returned', 'rejected', 'approved'])
            ->latest()
            ->paginate(15);

        return view('approver.requests.index', compact('requests'));
    }

    public function show($id)
    {
        $purchaseRequest = PurchaseRequest::with(['user', 'attachments', 'items', 'histories'])
            ->findOrFail($id);

        return view('approver.requests.show', compact('purchaseRequest'));
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

    // ✅ NEW: Approver uploads signed docx back to End User
    public function uploadSigned(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'signed_document' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'remarks'         => 'nullable|string|max:1000',
        ]);

        $purchaseRequest = PurchaseRequest::findOrFail($id);

        $file = $request->file('signed_document');
        $path = $file->store('purchase_requests/signed', 'public');

        // Delete old signed document if exists
        $existing = $purchaseRequest->attachments()
            ->where('file_type', 'signed_document')
            ->first();

        if ($existing) {
            if (Storage::disk('public')->exists($existing->file_path)) {
                Storage::disk('public')->delete($existing->file_path);
            }
            $existing->delete();
        }

        // Save new signed document
        PurchaseRequestAttachment::create([
            'purchase_request_id' => $purchaseRequest->id,
            'file_type'           => 'signed_document',
            'file_name'           => $file->getClientOriginalName(),
            'file_path'           => $path,
            'remarks'             => $request->remarks ?? 'Signed by Approver',
        ]);

        // Notify End User
        $this->notifyRequester(
            $purchaseRequest->user_id,
            $purchaseRequest->id,
            'Signed Document Available',
            'The Approver has uploaded the signed document for your proposal: ' . $purchaseRequest->activity_title . '.'
        );

        return back()->with('success', 'Signed document uploaded successfully. End User has been notified.');
    }

    private function notifyRequester(int $userId, int $purchaseRequestId, string $title, string $message): void
    {
        UserNotification::create([
            'user_id'             => $userId,
            'purchase_request_id' => $purchaseRequestId,
            'title'               => $title,
            'message'             => $message,
            'is_read'             => false,
        ]);
    }
}