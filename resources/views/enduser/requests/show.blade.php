{{-- resources/views/enduser/requests/show.blade.php --}}
@extends('layouts.enduser-internal', ['title' => 'End User - Proposal Summary'])

@section('content')

{{-- Breadcrumb --}}
<div style="font-size:12px;color:#6c7785;margin-bottom:12px;display:flex;align-items:center;gap:6px;">
    <span>Home</span>
    <span style="opacity:.4;">/</span>
    <a href="{{ route('enduser.requests.index') }}" style="color:#6c7785;text-decoration:none;">My Proposals</a>
    <span style="opacity:.4;">/</span>
    <span style="color:#0d4fb3;font-weight:700;">
        {{ $purchaseRequest->doc_number ?? $purchaseRequest->pr_number ?? 'View Proposal' }}
    </span>
</div>

{{-- Header --}}
<div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:14px;flex-wrap:wrap;gap:10px;">
    <div>
        <div style="font-size:17px;font-weight:700;color:#263238;">
            {{ $purchaseRequest->activity_title ?? $purchaseRequest->purpose ?? 'Activity Proposal' }}
        </div>
        <div style="font-size:12px;color:#6c7785;margin-top:4px;">
            Submitted {{ optional($purchaseRequest->created_at)->format('M d, Y h:i A') }}
        </div>
    </div>

    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <span class="badge badge-{{ strtolower($purchaseRequest->status ?? 'draft') }}">
            {{ ucwords(str_replace('_',' ', $purchaseRequest->status ?? 'draft')) }}
        </span>
        <a href="{{ route('enduser.requests.index') }}" class="btn-outline">Back</a>

        @if(in_array($purchaseRequest->status, ['draft','returned']))
            <a href="{{ route('enduser.requests.edit', $purchaseRequest->id) }}" class="btn-primary">Edit</a>
        @endif

        @if($purchaseRequest->status === 'approved')
            <a href="{{ route('enduser.requests.draft.pr', $purchaseRequest->id) }}" class="btn-primary-dark">Draft PR</a>
        @endif
    </div>
</div>

@php
    $originalDocs = $purchaseRequest->attachments->where('file_type', 'supporting_document');
    $signedDoc    = $purchaseRequest->attachments->where('file_type', 'signed_document')->first();
@endphp

{{-- ✅ Signed Document Alert --}}
@if($signedDoc)
    <div style="margin-bottom:14px;padding:14px 18px;background:#eef6ff;border:1.5px solid #b6d4fe;border-radius:12px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
        <div style="display:flex;align-items:center;gap:12px;">
            <span style="display:inline-flex;align-items:center;justify-content:center;width:38px;height:38px;border-radius:10px;background:#1d4ed8;color:#fff;font-size:16px;">✓</span>
            <div>
                <div style="font-size:13px;font-weight:700;color:#1e3a5f;">Signed Document Available</div>
                <div style="font-size:11px;color:#4b7bb5;margin-top:2px;">
                    {{ $signedDoc->file_name }} — Uploaded {{ optional($signedDoc->created_at)->format('M d, Y h:i A') }}
                </div>
            </div>
        </div>
        <a href="{{ asset('storage/' . $signedDoc->file_path) }}"
           target="_blank"
           download="{{ $signedDoc->file_name }}"
           style="display:inline-block;padding:8px 18px;background:#1d4ed8;color:#fff;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;">
            &#8595; Download Signed Doc
        </a>
    </div>
@endif

{{-- Layout --}}
<div style="display:grid;grid-template-columns:2fr 1fr;gap:14px;">

    {{-- LEFT --}}
    <div style="display:flex;flex-direction:column;gap:14px;">

        {{-- BASIC INFO --}}
        <div class="panel">
            <div class="panel-header">Basic Information</div>
            <div class="panel-body">
                <div class="grid-3">
                    <div class="field">
                        <label>Doc Number</label>
                        <input type="text" value="{{ $purchaseRequest->doc_number ?? $purchaseRequest->pr_number ?? '-' }}" readonly>
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <input type="text" value="{{ ucwords(str_replace('_',' ', $purchaseRequest->status ?? 'draft')) }}" readonly>
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

                <div class="grid-3" style="margin-top:10px;">
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
                        <label>Venue</label>
                        <input type="text" value="{{ $purchaseRequest->expected_venue ?? '-' }}" readonly>
                    </div>
                    <div class="field">
                        <label>Priority Level</label>
                        <input type="text" value="{{ $purchaseRequest->priority_level ?? '-' }}" readonly>
                    </div>
                </div>

                <div class="field" style="margin-top:10px;">
                    <label>Purpose</label>
                    <textarea readonly>{{ $purchaseRequest->purpose_justification ?? $purchaseRequest->purpose ?? '-' }}</textarea>
                </div>
            </div>
        </div>

        {{-- ITEMS --}}
        <div class="panel">
            <div class="panel-header">Requested Items</div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Cost</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchaseRequest->items as $item)
                            <tr>
                                <td>{{ $item->item_description ?? '-' }}</td>
                                <td>{{ $item->unit ?? '-' }}</td>
                                <td>{{ $item->qty ?? 0 }}</td>
                                <td>₱{{ number_format($item->estimated_unit_cost ?? 0, 2) }}</td>
                                <td>₱{{ number_format(($item->qty ?? 0)*($item->estimated_unit_cost ?? 0), 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-card">No items</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ATTACHMENTS --}}
        <div class="panel">
            <div class="panel-header">My Uploaded Documents</div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($originalDocs as $file)
                            @php
                                $ext = strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION));
                                $label = match($ext) {
                                    'pdf'           => 'PDF',
                                    'doc', 'docx'   => 'DOC',
                                    'xls', 'xlsx'   => 'XLS',
                                    'jpg','jpeg','png' => 'IMG',
                                    default         => strtoupper($ext),
                                };
                                $color = match($ext) {
                                    'pdf'           => '#e53935',
                                    'doc', 'docx'   => '#1565c0',
                                    'xls', 'xlsx'   => '#2e7d32',
                                    default         => '#607d8b',
                                };
                            @endphp
                            <tr>
                                <td>
                                    <span style="display:inline-block;padding:2px 8px;border-radius:6px;font-size:10px;font-weight:800;background:{{ $color }}20;color:{{ $color }};">
                                        {{ $label }}
                                    </span>
                                    <span style="margin-left:6px;font-size:12px;color:#6c7785;">
                                        {{ ucwords(str_replace('_', ' ', $file->file_type ?? 'document')) }}
                                    </span>
                                </td>
                                <td style="font-size:13px;color:#263238;">{{ $file->file_name }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $file->file_path) }}"
                                       target="_blank"
                                       download="{{ $file->file_name }}"
                                       style="display:inline-block;padding:4px 12px;background:#0d4fb3;color:#fff;border-radius:7px;font-size:11px;font-weight:700;text-decoration:none;">
                                        &#8595; Download
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty-card">No files uploaded</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ✅ SIGNED DOCUMENT FROM APPROVER --}}
        <div class="panel">
            <div class="panel-header">Signed Document from Approver</div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>File</th>
                            <th>Remarks</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($signedDoc)
                            <tr>
                                <td style="font-size:13px;font-weight:600;color:#263238;">{{ $signedDoc->file_name }}</td>
                                <td style="font-size:12px;color:#6c7785;">{{ $signedDoc->remarks ?? 'Signed by Approver' }}</td>
                                <td style="font-size:12px;color:#6c7785;">{{ optional($signedDoc->created_at)->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $signedDoc->file_path) }}"
                                       target="_blank"
                                       download="{{ $signedDoc->file_name }}"
                                       style="display:inline-block;padding:4px 12px;background:#1d4ed8;color:#fff;border-radius:7px;font-size:11px;font-weight:700;text-decoration:none;">
                                        &#8595; Download
                                    </a>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="4" class="empty-card">No signed document yet. Waiting for Approver.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- RIGHT --}}
    <div style="display:flex;flex-direction:column;gap:14px;">

        {{-- META --}}
        <div class="panel">
            <div class="panel-header">Request Info</div>
            <div class="panel-body">
                <div>Submitted: {{ optional($purchaseRequest->created_at)->format('M d, Y') }}</div>
                <div>Updated: {{ optional($purchaseRequest->updated_at)->format('M d, Y') }}</div>
                <div style="margin-top:6px;">My Docs: {{ $originalDocs->count() }} file(s)</div>
                <div style="margin-top:4px;">
                    Signed Doc:
                    <span style="font-weight:700;color:{{ $signedDoc ? '#1d4ed8' : '#9ca3af' }};">
                        {{ $signedDoc ? 'Available ✓' : 'Pending' }}
                    </span>
                </div>
                @if($purchaseRequest->status === 'approved')
                    <div style="margin-top:10px;padding:10px 12px;border-radius:10px;background:#eef6ff;color:#1f3f7d;font-size:12px;font-weight:700;">
                        Proposal approved. You can now draft the Purchase Request.
                    </div>
                @endif
            </div>
        </div>

        {{-- LIFECYCLE --}}
        <div class="lifecycle-box">
            <div class="lifecycle-head">Lifecycle</div>
            @forelse($purchaseRequest->histories as $h)
                <div class="lifecycle-item">
                    <div class="life-num {{ $h->is_current ? 'active' : 'done' }}">
                        {{ $h->step_no }}
                    </div>
                    <div>
                        <div class="life-title">{{ $h->status_label }}</div>
                        <div class="life-text">{{ $h->remarks }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-card">No lifecycle yet</div>
            @endforelse
        </div>

    </div>

</div>

@endsection