<?php

namespace App\Http\Controllers\EndUser;

use App\Http\Controllers\Controller;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestAttachment;
use App\Models\PurchaseRequestHistory;
use App\Models\PurchaseRequestItem;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PurchaseRequestController extends Controller
{
    public function index()
    {
        $requests = PurchaseRequest::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('enduser.requests.index', compact('requests'));
    }

    public function create()
    {
        return view('enduser.requests.create');
    }

    public function show($id)
    {
        $purchaseRequest = PurchaseRequest::where('user_id', Auth::id())
            ->with(['items', 'attachments', 'histories'])
            ->findOrFail($id);

        return view('enduser.requests.show', compact('purchaseRequest'));
    }

    public function edit($id)
    {
        $purchaseRequest = PurchaseRequest::where('user_id', Auth::id())
            ->with(['items', 'attachments', 'histories'])
            ->findOrFail($id);

        return view('enduser.requests.edit', compact('purchaseRequest'));
    }

    public function storeBasicInfo(Request $request)
    {
        $validated = $request->validate([
            'activity_title' => 'required|string|max:255',
            'division_office' => 'required|string|max:255',
            'fund_source' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'expected_venue' => 'required|string|max:255',
            'priority_level' => 'required|string|max:255',
            'purpose_justification' => 'required|string',
            'expected_output' => 'nullable|string',
        ]);

        $purchaseRequest = PurchaseRequest::create([
            'user_id' => Auth::id(),
            'doc_number' => $this->generateDocNumber(),
            'activity_title' => $validated['activity_title'],
            'division_office' => $validated['division_office'],
            'fund_source' => $validated['fund_source'],
            'activity_date' => $validated['activity_date'],
            'expected_venue' => $validated['expected_venue'],
            'priority_level' => $validated['priority_level'],
            'purpose_justification' => $validated['purpose_justification'],
            'expected_output' => $validated['expected_output'] ?? null,
            'estimated_total' => 0,
            'status' => 'draft',
            'current_step' => 1,
            'date_filed' => now()->toDateString(),
        ]);

        $this->setLifecycle(
            $purchaseRequest,
            'activity_proposal',
            'Activity Proposal',
            'Wait for your proposal to be approved',
            1,
            true
        );

        return redirect()->route('enduser.requests.edit', $purchaseRequest->id)
            ->with('success', 'Basic information saved.');
    }

    public function updateBasicInfo(Request $request, $id)
    {
        $purchaseRequest = $this->ownedRequest($id);

        $validated = $request->validate([
            'activity_title' => 'required|string|max:255',
            'division_office' => 'required|string|max:255',
            'fund_source' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'expected_venue' => 'required|string|max:255',
            'priority_level' => 'required|string|max:255',
            'purpose_justification' => 'required|string',
            'expected_output' => 'nullable|string',
        ]);

        $purchaseRequest->update($validated);

        return back()->with('success', 'Basic information updated.');
    }

    public function storeItems(Request $request, $id)
    {
        $purchaseRequest = $this->ownedRequest($id);

        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.item_description' => 'required|string|max:255',
            'items.*.unit' => 'required|string|max:50',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.estimated_unit_cost' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $purchaseRequest) {
            $purchaseRequest->items()->delete();

            $grandTotal = 0;

            foreach ($validated['items'] as $index => $item) {
                $lineTotal = (float) $item['qty'] * (float) $item['estimated_unit_cost'];
                $grandTotal += $lineTotal;

                PurchaseRequestItem::create([
                    'purchase_request_id' => $purchaseRequest->id,
                    'item_description' => $item['item_description'],
                    'unit' => $item['unit'],
                    'qty' => $item['qty'],
                    'estimated_unit_cost' => $item['estimated_unit_cost'],
                    'total_amount' => $lineTotal,
                    'sort_order' => $index + 1,
                ]);
            }

            $purchaseRequest->update([
                'estimated_total' => $grandTotal,
                'current_step' => max($purchaseRequest->current_step, 2),
            ]);
        });

        $this->replaceLifecycle(
            $purchaseRequest,
            'purchase_requested',
            'Purchase Requested',
            'Canvassing, price matrix, abstract, PO',
            3,
            true
        );

        return back()->with('success', 'Items saved successfully.');
    }

    public function updateItems(Request $request, $id)
    {
        return $this->storeItems($request, $id);
    }

    public function storeAttachments(Request $request, $id)
    {
        $purchaseRequest = $this->ownedRequest($id);

        $request->validate([
            'activity_design' => 'nullable|file|mimes:pdf,doc,docx',
            'budget_estimate' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx',
            'endorsement_letter' => 'nullable|file|mimes:pdf,doc,docx',
            'remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $purchaseRequest) {
            $this->storeAttachmentFile($request, $purchaseRequest, 'activity_design');
            $this->storeAttachmentFile($request, $purchaseRequest, 'budget_estimate');
            $this->storeAttachmentFile($request, $purchaseRequest, 'endorsement_letter');

            $purchaseRequest->update([
                'current_step' => max($purchaseRequest->current_step, 3),
            ]);
        });

        return back()->with('success', 'Attachments saved successfully.');
    }

    public function updateAttachments(Request $request, $id)
    {
        return $this->storeAttachments($request, $id);
    }

    public function saveDraft($id)
    {
        $purchaseRequest = $this->ownedRequest($id);

        $purchaseRequest->update([
            'status' => 'draft',
        ]);

        return back()->with('success', 'Draft saved.');
    }

    public function submitProposal($id)
    {
        $purchaseRequest = $this->ownedRequest($id);

        $purchaseRequest->update([
            'status' => 'pending',
            'current_step' => 1,
        ]);

        $this->replaceLifecycle(
            $purchaseRequest,
            'activity_proposal',
            'Activity Proposal',
            'Wait for your proposal to be approved',
            1,
            true
        );

        $this->notifyUser(
            $purchaseRequest,
            'Proposal Submitted',
            'Your activity proposal has been submitted for approval.'
        );

        return back()->with('success', 'Proposal submitted successfully.');
    }

    public function submitSignedPR($id)
    {
        $purchaseRequest = $this->ownedRequest($id);

        $purchaseRequest->update([
            'status' => 'processing',
            'current_step' => 2,
        ]);

        $this->replaceLifecycle(
            $purchaseRequest,
            'signed_pr',
            'Signed Purchase Request',
            'PR signed and forwarded to FA II',
            4,
            true
        );

        $this->notifyUser(
            $purchaseRequest,
            'Signed PR Submitted',
            'Your signed purchase request was submitted successfully.'
        );

        return back()->with('success', 'Signed PR submitted successfully.');
    }

    public function submitForRDApproval($id)
    {
        $purchaseRequest = $this->ownedRequest($id);

        $purchaseRequest->update([
            'status' => 'submitted_to_rd',
            'current_step' => 3,
        ]);

        $this->replaceLifecycle(
            $purchaseRequest,
            'submitted_to_rd',
            'Submitted to RD. Waiting for approval',
            'Accounting validates, cash releases payment',
            5,
            true
        );

        $this->notifyUser(
            $purchaseRequest,
            'Submitted for RD Approval',
            'Your proposal has been submitted to the Regional Director for approval.'
        );

        return redirect()->route('enduser.requests.index')
            ->with('success', 'Proposal submitted for RD approval.');
    }

    public function lifecycle($id)
    {
        $purchaseRequest = $this->ownedRequest($id)->load('histories');

        return response()->json([
            'purchase_request' => $purchaseRequest,
            'histories' => $purchaseRequest->histories()->orderBy('step_no')->get(),
        ]);
    }

    private function ownedRequest($id): PurchaseRequest
    {
        return PurchaseRequest::where('user_id', Auth::id())->findOrFail($id);
    }

    private function generateDocNumber(): string
    {
        $year = now()->format('Y');
        $latestId = (PurchaseRequest::max('id') ?? 0) + 1;

        return 'AP-' . $year . '-' . str_pad((string) $latestId, 4, '0', STR_PAD_LEFT);
    }

    private function storeAttachmentFile(Request $request, PurchaseRequest $purchaseRequest, string $type): void
    {
        if (! $request->hasFile($type)) {
            return;
        }

        $existing = $purchaseRequest->attachments()->where('file_type', $type)->first();

        if ($existing && Storage::disk('public')->exists($existing->file_path)) {
            Storage::disk('public')->delete($existing->file_path);
        }

        if ($existing) {
            $existing->delete();
        }

        $file = $request->file($type);
        $path = $file->store('purchase-request-attachments', 'public');

        PurchaseRequestAttachment::create([
            'purchase_request_id' => $purchaseRequest->id,
            'file_type' => $type,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'remarks' => $request->input('remarks'),
        ]);
    }

    private function setLifecycle(
        PurchaseRequest $purchaseRequest,
        string $statusKey,
        string $statusLabel,
        ?string $remarks,
        int $stepNo,
        bool $isCurrent
    ): void {
        PurchaseRequestHistory::create([
            'purchase_request_id' => $purchaseRequest->id,
            'status_key' => $statusKey,
            'status_label' => $statusLabel,
            'remarks' => $remarks,
            'acted_by' => Auth::id(),
            'acted_at' => now(),
            'step_no' => $stepNo,
            'is_current' => $isCurrent,
        ]);
    }

    private function replaceLifecycle(
        PurchaseRequest $purchaseRequest,
        string $statusKey,
        string $statusLabel,
        ?string $remarks,
        int $stepNo,
        bool $isCurrent
    ): void {
        $purchaseRequest->histories()->update(['is_current' => false]);

        $existing = $purchaseRequest->histories()
            ->where('status_key', $statusKey)
            ->where('step_no', $stepNo)
            ->first();

        if ($existing) {
            $existing->update([
                'status_label' => $statusLabel,
                'remarks' => $remarks,
                'acted_by' => Auth::id(),
                'acted_at' => now(),
                'is_current' => $isCurrent,
            ]);
            return;
        }

        $this->setLifecycle($purchaseRequest, $statusKey, $statusLabel, $remarks, $stepNo, $isCurrent);
    }

    private function notifyUser(PurchaseRequest $purchaseRequest, string $title, string $message): void
    {
        UserNotification::create([
            'user_id' => $purchaseRequest->user_id,
            'purchase_request_id' => $purchaseRequest->id,
            'title' => $title,
            'message' => $message,
            'is_read' => false,
        ]);
    }
}