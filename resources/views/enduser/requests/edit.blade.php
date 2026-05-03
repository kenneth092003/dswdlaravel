<div class="section-title">Purchase Request Items</div>

<form method="POST" action="{{ route('enduser.requests.update.items', $purchaseRequest->id) }}">
    @csrf
    @method('PUT')

    <div class="hint-box" style="background:#eef4ff;border:1px solid #d7e3ff;color:#35507a;">
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

    <div class="table-wrap" style="border:1px solid #d9e2ee;border-radius:12px;overflow:hidden;background:#fff;">
        <table>
            <thead>
                <tr style="background:#eef3fb;">
                    <th>Item Description</th>
                    <th style="width:90px;">Unit</th>
                    <th style="width:80px;">Qty</th>
                    <th style="width:150px;">Est. Unit Cost (₱)</th>
                    <th style="width:150px;">Total Amount (₱)</th>
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
                            <input type="text"
                                   name="items[{{ $index }}][item_description]"
                                   class="item-description"
                                   value="{{ $item['item_description'] ?? '' }}"
                                   style="background:#fbfdff;">
                        </td>
                        <td>
                            <input type="text"
                                   name="items[{{ $index }}][unit]"
                                   class="item-unit"
                                   value="{{ $item['unit'] ?? '' }}"
                                   style="background:#fbfdff;">
                        </td>
                        <td>
                            <input type="number"
                                   min="1"
                                   step="1"
                                   name="items[{{ $index }}][qty]"
                                   class="item-qty"
                                   value="{{ $item['qty'] ?? 1 }}"
                                   style="background:#fbfdff;">
                        </td>
                        <td>
                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   name="items[{{ $index }}][estimated_unit_cost]"
                                   class="item-cost"
                                   value="{{ $item['estimated_unit_cost'] ?? 0 }}"
                                   style="background:#fbfdff;">
                        </td>
                        <td>
                            <input type="text"
                                   class="row-total"
                                   value="{{ number_format($lineTotal, 2) }}"
                                   readonly
                                   style="background:#f8fafc;color:#274a85;font-weight:700;">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:14px;padding:14px 16px;border:1px solid #d9e2ee;border-radius:12px;background:#f8fbff;display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;">
        <div>
            <div class="muted" style="font-size:12px;">Total Estimated Amount</div>
            <div id="grand-total" style="font-size:28px;font-weight:700;color:#274a85;line-height:1.1;">
                ₱ {{ number_format((float) ($purchaseRequest->estimated_total ?? $purchaseRequest->total_amount ?? 0), 2) }}
            </div>
        </div>

        @if($purchaseRequest->status === 'approved')
            <button type="submit" class="btn-red">Save Items</button>
        @endif
    </div>
</form>

<div class="section-title">Required Attachments</div>

@if($purchaseRequest->status === 'approved')
    <form method="POST" action="{{ route('enduser.requests.update.attachments', $purchaseRequest->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="hint-box" style="background:#eef4ff;border:1px solid #d7e3ff;color:#35507a;">
            Upload the required supporting documents before sending to procurement.
        </div>

        <div class="grid-2">
            <div class="field">
                <label>Activity Design / Program of Work</label>
                <input type="file" name="activity_design" style="background:#fff;">
            </div>

            <div class="field">
                <label>Endorsement Letter / Authority to Procure</label>
                <input type="file" name="endorsement_letter" style="background:#fff;">
            </div>
        </div>

        <div class="field" style="margin-top:10px;">
            <label>Remarks / Special Instructions</label>
            <textarea name="remarks" style="background:#fbfdff;">{{ old('remarks', $purchaseRequest->remarks ?? '') }}</textarea>
        </div>

        @if($purchaseRequest->attachments->count())
            <div class="section-title">Uploaded Files</div>
            <div class="table-wrap" style="border:1px solid #d9e2ee;border-radius:12px;overflow:hidden;background:#fff;">
                <table>
                    <thead>
                        <tr style="background:#eef3fb;">
                            <th>Type</th>
                            <th>File Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseRequest->attachments as $attachment)
                            <tr>
                                <td>
                                    <span class="badge badge-processing">
                                        {{ str_replace('_', ' ', $attachment->file_type) }}
                                    </span>
                                </td>
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

    <form method="POST"
          action="{{ route('enduser.requests.submit.procurement', $purchaseRequest->id) }}"
          style="margin-top:10px;display:flex;justify-content:flex-end;">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn-green">Submit to Procurement</button>
    </form>
@else
    <div class="hint-box" style="background:#f8fafc;border:1px solid #e2e8f0;color:#475569;">
        Items and attachments can only be completed after the proposal is approved.
    </div>

    <div class="table-wrap" style="border:1px solid #d9e2ee;border-radius:12px;overflow:hidden;background:#fff;">
        <table>
            <thead>
                <tr style="background:#eef3fb;">
                    <th>Type</th>
                    <th>File Name</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchaseRequest->attachments as $attachment)
                    <tr>
                        <td>
                            <span class="badge badge-processing">
                                {{ str_replace('_', ' ', $attachment->file_type) }}
                            </span>
                        </td>
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

<script>
    (function () {
        const formatCurrency = (value) => {
            const amount = Number.isFinite(value) ? value : 0;
            return amount.toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        };

        const recalculateTotals = () => {
            const rows = document.querySelectorAll('.table-wrap tbody tr');
            let grandTotal = 0;

            rows.forEach((row) => {
                const qtyInput = row.querySelector('.item-qty');
                const costInput = row.querySelector('.item-cost');
                const totalInput = row.querySelector('.row-total');

                if (!qtyInput || !costInput || !totalInput) {
                    return;
                }

                const qty = parseFloat(qtyInput.value) || 0;
                const cost = parseFloat(costInput.value) || 0;
                const lineTotal = qty * cost;

                grandTotal += lineTotal;
                totalInput.value = formatCurrency(lineTotal);
            });

            const grandTotalNode = document.getElementById('grand-total');
            if (grandTotalNode) {
                grandTotalNode.textContent = `₱ ${formatCurrency(grandTotal)}`;
            }
        };

        document.addEventListener('input', (event) => {
            if (event.target.matches('.item-qty, .item-cost')) {
                recalculateTotals();
            }
        });

        document.addEventListener('DOMContentLoaded', recalculateTotals);
        recalculateTotals();
    })();
</script>
