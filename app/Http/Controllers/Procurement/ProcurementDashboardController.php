<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;

class ProcurementDashboardController extends Controller
{
    public function index()
    {
        $requests = PurchaseRequest::with('user')
            ->whereIn('status', ['draft', 'pending', 'submitted_to_procurement'])
            ->latest()
            ->get();

        $forApprovalCount = PurchaseRequest::whereIn('status', [
            'draft',
            'pending',
            'submitted_to_procurement'
        ])->count();

        $approvedThisMonth = PurchaseRequest::where('status', 'approved')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();

        $returnedCount = PurchaseRequest::whereIn('status', ['returned', 'rejected'])
            ->count();

        $processedCount = PurchaseRequest::whereNotIn('status', ['draft'])
            ->count();

        return view('procurement.step1dashboard', compact(
            'requests',
            'forApprovalCount',
            'approvedThisMonth',
            'returnedCount',
            'processedCount'
        ));
    }

    public function show($id)
    {
        $purchaseRequest = PurchaseRequest::with(['user', 'items', 'attachments'])
            ->findOrFail($id);

        return view('procurement.review', compact('purchaseRequest'));
    }

    public function approve(Request $request, $id)
    {
        $purchaseRequest = PurchaseRequest::findOrFail($id);

        if ($purchaseRequest->status === 'pending') {
            $purchaseRequest->status = 'approved';
            $message = 'Proposal approved successfully.';
        } elseif ($purchaseRequest->status === 'submitted_to_procurement') {
            $purchaseRequest->status = 'bac_processing';
            $message = 'Purchase request approved and forwarded to BAC Processing.';
        } else {
            return redirect()
                ->route('procurement.dashboard')
                ->with('error', 'This request cannot be approved in its current status.');
        }

        $purchaseRequest->save();

        return redirect()
            ->route('procurement.dashboard')
            ->with('success', $message);
    }

    public function reject(Request $request, $id)
    {
        $purchaseRequest = PurchaseRequest::findOrFail($id);

        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        if ($purchaseRequest->status === 'pending') {
            $purchaseRequest->status = 'rejected';
            $message = 'Proposal rejected successfully.';
        } elseif ($purchaseRequest->status === 'submitted_to_procurement') {
            $purchaseRequest->status = 'rejected';
            $message = 'Purchase request rejected and returned to end user.';
        } else {
            return redirect()
                ->route('procurement.dashboard')
                ->with('error', 'This request cannot be rejected in its current status.');
        }

        $purchaseRequest->remarks = $request->remarks;
        $purchaseRequest->save();

        return redirect()
            ->route('procurement.dashboard')
            ->with('success', $message);
    }

    public function step1()
    {
        return redirect()->route('procurement.dashboard');
    }

    public function step2()
    {
        $purchaseRequests = PurchaseRequest::with('user')
            ->whereIn('status', [
                'submitted_to_procurement',
                'bac_processing',
                'canvassing',
                'abstract_preparation',
                'po_generation',
                'completed',
            ])
            ->latest()
            ->get();

        $forApprovalCount = PurchaseRequest::whereIn('status', [
            'draft',
            'pending',
            'submitted_to_procurement'
        ])->count();

        $incomingCount = PurchaseRequest::where('status', 'submitted_to_procurement')->count();
        $canvassingCount = PurchaseRequest::where('status', 'canvassing')->count();
        $abstractCount = PurchaseRequest::where('status', 'abstract_preparation')->count();
        $poGenerationCount = PurchaseRequest::where('status', 'po_generation')->count();
        $completedCount = PurchaseRequest::where('status', 'completed')->count();

        return view('procurement.step2dashboard', compact(
            'purchaseRequests',
            'forApprovalCount',
            'incomingCount',
            'canvassingCount',
            'abstractCount',
            'poGenerationCount',
            'completedCount'
        ));
    }

    public function step3()
    {
        return view('procurement.step3dashboard');
    }
}
