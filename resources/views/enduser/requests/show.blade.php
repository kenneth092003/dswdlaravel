@extends('layouts.enduser-internal', ['title' => 'End User - Proposal Summary'])

@section('content')
    <div class="panel">
        <div class="panel-header">
            <span>Summary of Purchase Request</span>
            <a href="{{ route('enduser.requests.edit', $purchaseRequest->id) }}" class="btn-primary">Edit Request</a>
        </div>

        <div class="panel-body">
            <div class="grid-3">
                <div class="field">
                    <label>Doc Number</label>
                    <input type="text" value="{{ $purchaseRequest->doc_number }}" readonly>
                </div>
                <div class="field">
                    <label>Status</label>
                    <input type="text" value="{{ str_replace('_', ' ', $purchaseRequest->status) }}" readonly>
                </div>
                <div class="field">
                    <label>Date Filed</label>
                    <input type="text" value="{{ optional($purchaseRequest->date_filed)->format('M d, Y') }}" readonly>
                </div>
            </div>

            <div class="section-title">Basic Information</div>

            <div class="grid-3">
                <div class="field">
                    <label>Activity Title</label>
                    <input type="text" value="{{ $purchaseRequest->activity_title }}" readonly>
                </div>
                <div class="field">
                    <label>Division / Office</label>
                    <input type="text" value="{{ $purchaseRequest->division_office }}" readonly>
                </div>
                <div class="field">
                    <label>Fund Source</label>
                    <input type="text" value="{{ $purchaseRequest->fund_source }}" readonly>
                </div>
            </div>

            <div class="grid-3" style="margin-top:10px;">
                <div class="field">
                    <label>Activity Date</label>
                    <input type="text" value="{{ optional($purchaseRequest->activity_date)->format('M d, Y') }}" readonly>
                </div>
                <div class="field">
                    <label>Expected Venue</label>
                    <input type="text" value="{{ $purchaseRequest->expected_venue }}" readonly>
                </div>
                <div class="field">
                    <label>Priority Level</label>
                    <input type="text" value="{{ $purchaseRequest->priority_level }}" readonly>
                </div>
            </div>

            <div class="field" style="margin-top:10px;">
                <label>Purpose / Justification</label>
                <textarea readonly>{{ $purchaseRequest->purpose_justification }}</textarea>
            </div>

            <div class="field" style="margin-top:10px;">
                <label>Expected Output / Deliverables</label>
                <textarea readonly>{{ $purchaseRequest->expected_output }}</textarea>
            </div>

            <div class="section-title">Requested Items</div>

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
                                <td>{{ $item->item_description }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>₱{{ number_format((float) $item->estimated_unit_cost, 2) }}</td>
                                <td>₱{{ number_format((float) $item->total_amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-card">No items added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top:10px;display:flex;justify-content:flex-end;">
                <div style="font-size:24px;font-weight:700;color:#274a85;">₱ {{ number_format((float) $purchaseRequest->estimated_total, 2) }}</div>
            </div>

            <div class="section-title">Attachments</div>

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