@extends('layouts.enduser-internal', ['title' => 'End User - Proposal Summary'])

@section('content')
    <div class="panel">
        <div class="panel-header">
            <span>Summary of Purchase Request</span>
             @if($purchaseRequest->status === 'approved')
    <a href="{{ route('enduser.requests.edit', $purchaseRequest->id) }}" class="btn-primary">Edit Request</a>
@endif
        </div>

        <div class="panel-body">
            <div class="grid-3">
                <div class="field">
                    <label>Doc Number</label>
                    <input type="text" value="{{ $purchaseRequest->doc_number ?? $purchaseRequest->pr_number ?? '-' }}" readonly>
                </div>
                <div class="field">
                    <label>Status</label>
                    <input type="text" value="{{ ucwords(str_replace('_', ' ', $purchaseRequest->status ?? 'draft')) }}" readonly>
                </div>
                <div class="field">
                    <label>Date Filed</label>
                    <input type="text"
                        value="{{ !empty($purchaseRequest->date_filed ?? $purchaseRequest->request_date)
                            ? \Carbon\Carbon::parse($purchaseRequest->date_filed ?? $purchaseRequest->request_date)->format('M d, Y')
                            : '-' }}"
                        readonly>
                </div>
            </div>

            <div class="section-title">Basic Information</div>

            <div class="grid-3">
                <div class="field">
                    <label>Activity Title</label>
                    <input type="text" value="{{ $purchaseRequest->activity_title ?? $purchaseRequest->purpose ?? '-' }}" readonly>
                </div>
                <div class="field">
                    <label>Division / Office</label>
                    <input type="text" value="{{ $purchaseRequest->division_office ?? $purchaseRequest->office_department ?? '-' }}" readonly>
                </div>
                <div class="field">
                    <label>Fund Source</label>
                    <input type="text" value="{{ $purchaseRequest->fund_source ?? '-' }}" readonly>
                </div>
            </div>

            <div class="grid-3" style="margin-top:10px;">
                <div class="field">
                    <label>Activity Date</label>
                    <input type="text"
                        value="{{ !empty($purchaseRequest->activity_date)
                            ? \Carbon\Carbon::parse($purchaseRequest->activity_date)->format('M d, Y')
                            : '-' }}"
                        readonly>
                </div>
                <div class="field">
                    <label>Expected Venue</label>
                    <input type="text" value="{{ $purchaseRequest->expected_venue ?? '-' }}" readonly>
                </div>
                <div class="field">
                    <label>Priority Level</label>
                    <input type="text" value="{{ $purchaseRequest->priority_level ?? '-' }}" readonly>
                </div>
            </div>

            <div class="field" style="margin-top:10px;">
                <label>Purpose / Justification</label>
                <textarea readonly>{{ $purchaseRequest->purpose_justification ?? $purchaseRequest->purpose ?? '-' }}</textarea>
            </div>

            <div class="field" style="margin-top:10px;">
                <label>Expected Output / Deliverables</label>
                <textarea readonly>{{ $purchaseRequest->expected_output ?? '-' }}</textarea>
            </div>

            <div class="section-title">Requested Items</div>

@if($purchaseRequest->status === 'approved')
    <form method="POST" action="{{ route('enduser.requests.update.items', $purchaseRequest->id) }}">
        @csrf
        @method('PUT')

        @php
            $items = old('items', $purchaseRequest->items->count()
                ? $purchaseRequest->items->map(function ($i) {
                    return [
                        'item_description' => $i->item_description,
                        'unit' => $i->unit,
                        'qty' => $i->qty,
                        'estimated_unit_cost' => $i->estimated_unit_cost,
                    ];
                })->toArray()
                : [
                    ['item_description' => '', 'unit' => '', 'qty' => 1, 'estimated_unit_cost' => 0],
                    ['item_description' => '', 'unit' => '', 'qty' => 1, 'estimated_unit_cost' => 0],
                    ['item_description' => '', 'unit' => '', 'qty' => 1, 'estimated_unit_cost' => 0],
                ]
            );
        @endphp

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Item Description</th>
                        <th style="width:90px;">Unit</th>
                        <th style="width:80px;">Qty</th>
                        <th style="width:140px;">Est. Unit Cost</th>
                        <th style="width:140px;">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $index => $item)
                        @php
                            $qty = (float) ($item['qty'] ?? 0);
                            $cost = (float) ($item['estimated_unit_cost'] ?? 0);
                            $lineTotal = $qty * $cost;
                        @endphp
                        <tr>
                            <td>
                                <input type="text" name="items[{{ $index }}][item_description]" value="{{ $item['item_description'] ?? '' }}">
                            </td>
                            <td>
                                <input type="text" name="items[{{ $index }}][unit]" value="{{ $item['unit'] ?? '' }}">
                            </td>
                            <td>
                                <input type="number" min="1" name="items[{{ $index }}][qty]" value="{{ $item['qty'] ?? 1 }}">
                            </td>
                            <td>
                                <input type="number" step="0.01" min="0" name="items[{{ $index }}][estimated_unit_cost]" value="{{ $item['estimated_unit_cost'] ?? 0 }}">
                            </td>
                            <td>
                                <input type="text" value="{{ number_format($lineTotal, 2) }}" readonly>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top:12px;display:flex;justify-content:flex-end;">
            <button type="submit" class="btn-primary">Save Requested Items</button>
        </div>
    </form>
@else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th style="width:90px;">Unit</th>
                    <th style="width:80px;">Qty</th>
                    <th style="width:140px;">Est. Unit Cost</th>
                    <th style="width:140px;">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchaseRequest->items as $item)
                    <tr>
                        <td>{{ $item->item_description ?? '-' }}</td>
                        <td>{{ $item->unit ?? '-' }}</td>
                        <td>{{ $item->qty ?? 0 }}</td>
                        <td>₱{{ number_format((float) ($item->estimated_unit_cost ?? 0), 2) }}</td>
                        <td>₱{{ number_format((float) ($item->total_amount ?? (($item->qty ?? 0) * ($item->estimated_unit_cost ?? 0))), 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-card">No items added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endif

<div class="section-title">Attachments</div>

@if($purchaseRequest->status === 'approved')
    <form method="POST" action="{{ route('enduser.requests.update.attachments', $purchaseRequest->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid-2">
    <div class="field">
        <label>Activity Design / Program of Work</label>
        <input type="file" name="activity_design">
    </div>
    <div class="field">
        <label>Endorsement Letter / Authority to Procure</label>
        <input type="file" name="endorsement_letter">
    </div>
</div>
            <div class="field">
                <label>Remarks / Special Instructions</label>
                <textarea name="remarks">{{ old('remarks', $purchaseRequest->remarks ?? '') }}</textarea>
            </div>
        </div>

        <div style="margin-top:12px;display:flex;justify-content:flex-end;">
            <button type="submit" class="btn-primary">Upload Attachments</button>
        </div>
    </form>
@endif

<div class="table-wrap" style="margin-top:12px;">
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>File Name</th>
            </tr>
        </thead>
        <tbody>
            @forelse($purchaseRequest->attachments as $attachment)
                <tr>
                    <td>{{ str_replace('_', ' ', $attachment->file_type) }}</td>
                    <td>{{ $attachment->file_name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="empty-card">No attachments uploaded yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($purchaseRequest->status === 'approved')
    <form method="POST" action="{{ route('enduser.requests.submit.procurement', $purchaseRequest->id) }}"
          style="margin-top:12px; display:flex; justify-content:flex-end;">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn-green">Submit to Procurement</button>
    </form>
@endif

@if($purchaseRequest->status === 'approved')
    <div style="margin-top:12px;padding:12px 14px;border-radius:10px;background:#ecfdf5;color:#065f46;font-size:13px;">
        This request has been approved. You may now complete the requested items, upload supporting documents, and submit it to procurement.
    </div>
@else
    <div style="margin-top:12px;padding:12px 14px;border-radius:10px;background:#f8fafc;color:#475569;font-size:13px;">
        Requested items and attachment upload will be enabled only after procurement approval.
    </div>
@endif


            <div class="section-title">Document Lifecycle - Current Position</div>

            <div class="lifecycle-box">
                <div class="lifecycle-head">📌 DOCUMENT LIFECYCLE - CURRENT POSITION</div>
                @forelse($purchaseRequest->histories->sortBy('step_no') as $history)
                    <div class="lifecycle-item">
                        <div class="life-num {{ $history->is_current ? 'active' : 'done' }}">
                            {{ $history->step_no }}
                        </div>
                        <div>
                            <div class="life-title">
                                {{ $history->status_label }}
                                @if($history->is_current)
                                    <span style="color:#8a5b00;">- YOU ARE HERE</span>
                                @endif
                            </div>
                            <div class="life-text">{{ $history->remarks }}</div>
                        </div>
                    </div>
                @empty
                    <div class="empty-card">No lifecycle records yet.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
