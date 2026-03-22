<div class="section-title">Purchase Request Items</div>

<form method="POST" action="{{ route('enduser.requests.update.items', $purchaseRequest->id) }}">
    @csrf
    @method('PUT')

    <div class="hint-box">
        List all items, supplies, or services needed for this activity.
    </div>

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
                    <th style="width:140px;">Est. Unit Cost (₱)</th>
                    <th style="width:140px;">Total Amount (₱)</th>
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

    <div style="margin-top:10px;display:flex;justify-content:space-between;align-items:center;">
        <div class="muted">Total Estimated Amount</div>
        <div style="font-size:28px;font-weight:700;color:#274a85;">
            ₱ {{ number_format((float) ($purchaseRequest->estimated_total ?? $purchaseRequest->total_amount ?? 0), 2) }}
        </div>
    </div>

    @if($purchaseRequest->status === 'approved')
        <div style="margin-top:12px;display:flex;gap:8px;justify-content:flex-end;">
            <button type="submit" class="btn-red">Save Items</button>
        </div>
    @endif
</form>

<div class="section-title">Required Attachments</div>

@if($purchaseRequest->status === 'approved')
    <form method="POST" action="{{ route('enduser.requests.update.attachments', $purchaseRequest->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="hint-box">
            Upload the required supporting documents before sending to procurement.
        </div>

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

        <div class="field" style="margin-top:10px;">
            <label>Remarks / Special Instructions</label>
            <textarea name="remarks">{{ old('remarks', $purchaseRequest->remarks ?? '') }}</textarea>
        </div>

        @if($purchaseRequest->attachments->count())
            <div class="section-title">Uploaded Files</div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>File Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseRequest->attachments as $attachment)
                            <tr>
                                <td>{{ str_replace('_', ' ', $attachment->file_type) }}</td>
                                <td>{{ $attachment->file_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div style="margin-top:12px;display:flex;gap:8px;justify-content:flex-end;">
            <button type="submit" class="btn-purple">Upload Attachments</button>
        </div>
    </form>

    <form method="POST" action="{{ route('enduser.requests.submit.procurement', $purchaseRequest->id) }}" style="margin-top:8px; display:flex; justify-content:flex-end;">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn-green">Submit to Procurement</button>
    </form>
@else
    <div class="hint-box">
        Items and attachments can only be completed after the proposal is approved.
    </div>

    <div class="table-wrap">
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
@endif
