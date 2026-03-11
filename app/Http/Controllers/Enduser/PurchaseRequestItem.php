<?php

namespace App\Http\Controllers\EndUser;

use App\Http\Controllers\Controller;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PurchaseRequestController extends Controller
{
    public function index()
    {
        $requests = PurchaseRequest::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('enduser.requests.index', compact('requests'));
    }

    public function create()
    {
        return view('enduser.requests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'office_department' => 'required|string|max:255',
            'purpose' => 'required|string',
            'request_date' => 'required|date',
            'needed_date' => 'required|date|after_or_equal:request_date',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit' => 'required|string|max:50',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        $purchaseRequest = PurchaseRequest::create([
            'pr_number' => 'PR-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
            'user_id' => Auth::id(),
            'office_department' => $validated['office_department'],
            'purpose' => $validated['purpose'],
            'request_date' => $validated['request_date'],
            'needed_date' => $validated['needed_date'],
            'status' => 'draft',
            'remarks' => null,
            'total_amount' => 0,
        ]);

        $grandTotal = 0;

        foreach ($validated['items'] as $item) {
            $totalCost = $item['quantity'] * $item['unit_cost'];
            $grandTotal += $totalCost;

            PurchaseRequestItem::create([
                'purchase_request_id' => $purchaseRequest->id,
                'item_name' => $item['item_name'],
                'description' => $item['description'] ?? null,
                'quantity' => $item['quantity'],
                'unit' => $item['unit'],
                'unit_cost' => $item['unit_cost'],
                'total_cost' => $totalCost,
            ]);
        }

        $purchaseRequest->update([
            'total_amount' => $grandTotal,
        ]);

        return redirect()
            ->route('enduser.requests.show', $purchaseRequest->id)
            ->with('success', 'Purchase request created successfully.');
    }

    public function show($id)
    {
        $purchaseRequest = PurchaseRequest::with(['items', 'approvals.approver'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('enduser.requests.show', compact('purchaseRequest'));
    }

    public function edit($id)
    {
        $purchaseRequest = PurchaseRequest::with('items')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if ($purchaseRequest->status !== 'draft') {
            return redirect()->route('enduser.requests.index')
                ->with('error', 'Only draft requests can be edited.');
        }

        return view('enduser.requests.edit', compact('purchaseRequest'));
    }

    public function update(Request $request, $id)
    {
        $purchaseRequest = PurchaseRequest::where('user_id', Auth::id())->findOrFail($id);

        if ($purchaseRequest->status !== 'draft') {
            return redirect()->route('enduser.requests.index')
                ->with('error', 'Only draft requests can be updated.');
        }

        $validated = $request->validate([
            'office_department' => 'required|string|max:255',
            'purpose' => 'required|string',
            'request_date' => 'required|date',
            'needed_date' => 'required|date|after_or_equal:request_date',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit' => 'required|string|max:50',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        $purchaseRequest->update([
            'office_department' => $validated['office_department'],
            'purpose' => $validated['purpose'],
            'request_date' => $validated['request_date'],
            'needed_date' => $validated['needed_date'],
        ]);

        $purchaseRequest->items()->delete();

        $grandTotal = 0;

        foreach ($validated['items'] as $item) {
            $totalCost = $item['quantity'] * $item['unit_cost'];
            $grandTotal += $totalCost;

            PurchaseRequestItem::create([
                'purchase_request_id' => $purchaseRequest->id,
                'item_name' => $item['item_name'],
                'description' => $item['description'] ?? null,
                'quantity' => $item['quantity'],
                'unit' => $item['unit'],
                'unit_cost' => $item['unit_cost'],
                'total_cost' => $totalCost,
            ]);
        }

        $purchaseRequest->update([
            'total_amount' => $grandTotal,
        ]);

        return redirect()
            ->route('enduser.requests.show', $purchaseRequest->id)
            ->with('success', 'Purchase request updated successfully.');
    }

    public function submit($id)
    {
        $purchaseRequest = PurchaseRequest::where('user_id', Auth::id())->findOrFail($id);

        if ($purchaseRequest->status !== 'draft') {
            return back()->with('error', 'Only draft requests can be submitted.');
        }

        $purchaseRequest->update([
            'status' => 'submitted',
        ]);

        return redirect()
            ->route('enduser.requests.show', $purchaseRequest->id)
            ->with('success', 'Purchase request submitted successfully.');
    }

    public function cancel($id)
    {
        $purchaseRequest = PurchaseRequest::where('user_id', Auth::id())->findOrFail($id);

        if (!in_array($purchaseRequest->status, ['draft', 'submitted'])) {
            return back()->with('error', 'This request can no longer be cancelled.');
        }

        $purchaseRequest->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('enduser.requests.index')
            ->with('success', 'Purchase request cancelled successfully.');
    }
}