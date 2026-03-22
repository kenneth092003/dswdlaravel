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
    $purchaseRequest = PurchaseRequest::with(['items', 'attachments', 'histories'])
        ->where('user_id', auth()->id())
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

    $status = $request->input('submit_action') === 'pending' ? 'pending' : 'draft';

    $remarks = "Activity Title: {$validated['activity_title']}\n"
        . "Fund Source: {$validated['fund_source']}\n"
        . "Expected Venue: {$validated['expected_venue']}\n"
        . "Priority Level: {$validated['priority_level']}\n"
        . "Expected Output: " . ($validated['expected_output'] ?? 'N/A');

    $purchaseRequest = new PurchaseRequest();
    $purchaseRequest->user_id = Auth::id();
    $purchaseRequest->pr_number = $this->generatePrNumber();
    $purchaseRequest->office_department = $validated['division_office'];
    $purchaseRequest->purpose = $validated['purpose_justification'];
    $purchaseRequest->request_date = now()->toDateString();
    $purchaseRequest->needed_date = $validated['activity_date'];
    $purchaseRequest->status = $status;
    $purchaseRequest->total_amount = 0;
    $purchaseRequest->remarks = $remarks;
    $purchaseRequest->save();

    $this->setLifecycle(
        $purchaseRequest,
        'activity_proposal',
        'Activity Proposal',
        $status === 'pending'
            ? 'Proposal submitted and pending approval'
            : 'Proposal saved as draft',
        1,
        true
    );

    return redirect()
        ->route('enduser.requests.index', $purchaseRequest->id)
        ->with('success', $status === 'pending'
            ? 'Proposal submitted successfully.'
            : 'Proposal saved as draft.');
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

        $remarks = "Activity Title: {$validated['activity_title']}\n"
            . "Fund Source: {$validated['fund_source']}\n"
            . "Expected Venue: {$validated['expected_venue']}\n"
            . "Priority Level: {$validated['priority_level']}\n"
            . "Expected Output: " . ($validated['expected_output'] ?? 'N/A');

        $purchaseRequest->office_department = $validated['division_office'];
        $purchaseRequest->purpose = $validated['purpose_justification'];
        $purchaseRequest->needed_date = $validated['activity_date'];
        $purchaseRequest->remarks = $remarks;
        $purchaseRequest->save();

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

                $requestItem = new PurchaseRequestItem();
                $requestItem->purchase_request_id = $purchaseRequest->id;
                $requestItem->item_description = $item['item_description'];
                $requestItem->unit = $item['unit'];
                $requestItem->qty = $item['qty'];
                $requestItem->estimated_unit_cost = $item['estimated_unit_cost'];
                $requestItem->total_amount = $lineTotal;
                $requestItem->sort_order = $index + 1;
                $requestItem->save();
            }

            $purchaseRequest->total_amount = $grandTotal;
            $purchaseRequest->save();
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
    $purchaseRequest = PurchaseRequest::where('user_id', auth()->id())->findOrFail($id);

    if ($purchaseRequest->status !== 'approved') {
        abort(403, 'You can only update items after approval.');
    }

    // save items here...
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
        });

        return back()->with('success', 'Attachments saved successfully.');
    }

    public function updateAttachments(Request $request, $id)
{
    $purchaseRequest = $this->ownedRequest($id);

    if ($purchaseRequest->status !== 'approved') {
        abort(403, 'Attachments can only be uploaded when the request is approved.');
    }

    $request->validate([
        'activity_design' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        'endorsement_letter' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        'remarks' => 'nullable|string',
    ]);

    if ($request->hasFile('activity_design')) {
        $file = $request->file('activity_design');
        $path = $file->store('purchase_requests/attachments', 'public');

        $purchaseRequest->attachments()->create([
            'file_type' => 'activity_design',
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
        ]);
    }

    if ($request->hasFile('endorsement_letter')) {
        $file = $request->file('endorsement_letter');
        $path = $file->store('purchase_requests/attachments', 'public');

        $purchaseRequest->attachments()->create([
            'file_type' => 'endorsement_letter',
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
        ]);
    }

    $purchaseRequest->remarks = $request->remarks;
    $purchaseRequest->save();

    return back()->with('success', 'Attachments uploaded successfully.');
}


    public function saveDraft($id)
    {
        $purchaseRequest = $this->ownedRequest($id);
        $purchaseRequest->status = 'draft';
        $purchaseRequest->save();

        return back()->with('success', 'Draft saved.');
    }

    public function submitProposal($id)
{
    $purchaseRequest = $this->ownedRequest($id);
    $purchaseRequest->status = 'submitted_to_procurement';
    $purchaseRequest->save();

    $this->replaceLifecycle(
        $purchaseRequest,
        'submitted_to_procurement',
        'Submitted to Procurement',
        'Your purchase request has been submitted to Procurement.',
        1,
        true
    );

    $this->notifyUser(
        $purchaseRequest,
        'Proposal Submitted',
        'Your purchase request has been submitted to Procurement.'
    );

    return back()->with('success', 'Proposal submitted successfully.');
}
   public function submitToProcurement($id)
{
    $purchaseRequest = $this->ownedRequest($id);

    if ($purchaseRequest->status !== 'approved') {
        return back()->with('error', 'Only approved requests can be submitted to procurement.');
    }

    $purchaseRequest->status = 'submitted_to_procurement';
    $purchaseRequest->save();

    $this->replaceLifecycle(
        $purchaseRequest,
        'submitted_to_procurement',
        'Submitted to Procurement',
        'Approved proposal with complete items and documents was submitted to procurement.',
        3,
        true
    );

    $this->notifyUser(
        $purchaseRequest,
        'Submitted to Procurement',
        'Your approved proposal has been submitted to procurement successfully.'
    );

    return redirect()
        ->route('enduser.requests.show', $purchaseRequest->id)
        ->with('success', 'Request submitted to procurement successfully.');
}


    public function submitSignedPR($id)
{
    $purchaseRequest = $this->ownedRequest($id);
    $purchaseRequest->status = 'processing';
    $purchaseRequest->save();

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
        $purchaseRequest->status = 'submitted_to_rd';
        $purchaseRequest->save();

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

    private function generatePrNumber(): string
    {
        $year = now()->format('Y');
        $latestId = (PurchaseRequest::max('id') ?? 0) + 1;

        return 'PR-' . $year . '-' . str_pad((string) $latestId, 4, '0', STR_PAD_LEFT);
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

        $attachment = new PurchaseRequestAttachment();
        $attachment->purchase_request_id = $purchaseRequest->id;
        $attachment->file_type = $type;
        $attachment->file_name = $file->getClientOriginalName();
        $attachment->file_path = $path;
        $attachment->remarks = $request->input('remarks');
        $attachment->save();
    }

    private function setLifecycle(
        PurchaseRequest $purchaseRequest,
        string $statusKey,
        string $statusLabel,
        ?string $remarks,
        int $stepNo,
        bool $isCurrent
    ): void {
        $history = new PurchaseRequestHistory();
        $history->purchase_request_id = $purchaseRequest->id;
        $history->status_key = $statusKey;
        $history->status_label = $statusLabel;
        $history->remarks = $remarks;
        $history->acted_by = Auth::id();
        $history->acted_at = now();
        $history->step_no = $stepNo;
        $history->is_current = $isCurrent;
        $history->save();
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
            $existing->status_label = $statusLabel;
            $existing->remarks = $remarks;
            $existing->acted_by = Auth::id();
            $existing->acted_at = now();
            $existing->is_current = $isCurrent;
            $existing->save();
            return;
        }

        $this->setLifecycle($purchaseRequest, $statusKey, $statusLabel, $remarks, $stepNo, $isCurrent);
    }

    private function notifyUser(PurchaseRequest $purchaseRequest, string $title, string $message): void
    {
        $notification = new UserNotification();
        $notification->user_id = $purchaseRequest->user_id;
        $notification->purchase_request_id = $purchaseRequest->id;
        $notification->title = $title;
        $notification->message = $message;
        $notification->is_read = false;
        $notification->save();
    }
}
