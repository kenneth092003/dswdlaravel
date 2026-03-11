@extends('layouts.enduser-internal', ['title' => 'End User - Edit Proposal'])

@section('content')
    <div class="wizard-overlay">
        <div class="wizard">
            <div class="wizard-header">
                <div>
                    <div class="wizard-title">New Activity Proposal</div>
                    <div class="wizard-sub">Complete all steps before submitting for RD approval</div>
                </div>
                <div class="close-x">×</div>
            </div>

            <div class="steps">
                <div class="step {{ $purchaseRequest->current_step >= 1 ? 'active' : '' }}">
                    <div class="step-circle">1</div>
                    <span>Basic Info</span>
                </div>
                <div class="step {{ $purchaseRequest->current_step >= 2 ? 'active' : '' }}">
                    <div class="step-circle">2</div>
                    <span>Purchase Request</span>
                </div>
                <div class="step {{ $purchaseRequest->current_step >= 3 ? 'active' : '' }}">
                    <div class="step-circle">3</div>
                    <span>Attachments</span>
                </div>
            </div>

            <div class="wizard-body">
                <div class="section-title">Basic Information</div>

                <form method="POST" action="{{ route('enduser.requests.update.basic', $purchaseRequest->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid-3">
                        <div class="field">
                            <label>Activity / Proposal Title *</label>
                            <input type="text" name="activity_title" value="{{ old('activity_title', $purchaseRequest->activity_title) }}">
                        </div>
                        <div class="field">
                            <label>Division / Office *</label>
                            <input type="text" name="division_office" value="{{ old('division_office', $purchaseRequest->division_office) }}">
                        </div>
                        <div class="field">
                            <label>Fund Source *</label>
                            <input type="text" name="fund_source" value="{{ old('fund_source', $purchaseRequest->fund_source) }}">
                        </div>
                    </div>

                    <div class="grid-3" style="margin-top:10px;">
                        <div class="field">
                            <label>Activity Date *</label>
                            <input type="date" name="activity_date" value="{{ old('activity_date', optional($purchaseRequest->activity_date)->format('Y-m-d')) }}">
                        </div>
                        <div class="field">
                            <label>Expected Venue *</label>
                            <input type="text" name="expected_venue" value="{{ old('expected_venue', $purchaseRequest->expected_venue) }}">
                        </div>
                        <div class="field">
                            <label>Priority Level *</label>
                            <input type="text" name="priority_level" value="{{ old('priority_level', $purchaseRequest->priority_level) }}">
                        </div>
                    </div>

                    <div class="field" style="margin-top:10px;">
                        <label>Purpose / Justification *</label>
                        <textarea name="purpose_justification">{{ old('purpose_justification', $purchaseRequest->purpose_justification) }}</textarea>
                    </div>

                    <div class="field" style="margin-top:10px;">
                        <label>Expected Output / Deliverables</label>
                        <textarea name="expected_output">{{ old('expected_output', $purchaseRequest->expected_output) }}</textarea>
                    </div>

                    <div style="margin-top:12px; display:flex; gap:8px; justify-content:flex-end;">
                        <button type="submit" class="btn-outline">Update Basic Info</button>
                    </div>
                </form>

                <div class="section-title">Purchase Request Items</div>

                <form method="POST" action="{{ route('enduser.requests.update.items', $purchaseRequest->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="hint-box">
                        List all items, supplies, or services needed for this activity. These will be used to generate the Purchase Request (PR) after approval.
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
                        <div style="font-size:28px;font-weight:700;color:#274a85;">₱ {{ number_format((float) $purchaseRequest->estimated_total, 2) }}</div>
                    </div>

                    <div style="margin-top:12px;display:flex;gap:8px;justify-content:flex-end;">
                        <button type="submit" class="btn-red">Draft PR</button>
                    </div>
                </form>

                <form method="POST" action="{{ route('enduser.requests.submit.signedpr', $purchaseRequest->id) }}" style="margin-top:8px; display:flex; justify-content:flex-end;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-green">Submit Signed PR</button>
                </form>

                <div class="section-title">Required Attachments</div>

                <form method="POST" action="{{ route('enduser.requests.update.attachments', $purchaseRequest->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="hint-box">
                        Attach all required supporting documents. Incomplete attachments may result in the proposal being returned.
                    </div>

                    <div class="grid-2">
                        <div class="field">
                            <label>Activity Design / Program of Work</label>
                            <input type="file" name="activity_design">
                        </div>
                        <div class="field">
                            <label>Budget Estimate / Cost Breakdown</label>
                            <input type="file" name="budget_estimate">
                        </div>
                    </div>

                    <div class="grid-2" style="margin-top:10px;">
                        <div class="field">
                            <label>Endorsement Letter / Authority to Procure</label>
                            <input type="file" name="endorsement_letter">
                        </div>
                        <div class="field">
                            <label>Remarks / Special Instructions</label>
                            <textarea name="remarks">{{ old('remarks') }}</textarea>
                        </div>
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
                        <button type="submit" class="btn-purple">Save Draft</button>
                    </div>
                </form>

                <form method="POST" action="{{ route('enduser.requests.submit.rd', $purchaseRequest->id) }}" style="margin-top:8px; display:flex; justify-content:flex-end;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-green">Submit For RD Approval</button>
                </form>

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

            <div class="wizard-footer">
                <div class="footer-note">Request No. {{ $purchaseRequest->doc_number }}</div>
                <div class="actions">
                    <a href="{{ route('enduser.dashboard') }}" class="btn-outline">← Back to Dashboard</a>
                    <a href="{{ route('enduser.requests.show', $purchaseRequest->id) }}" class="btn-outline">View Summary</a>
                </div>
            </div>
        </div>
    </div>
@endsection