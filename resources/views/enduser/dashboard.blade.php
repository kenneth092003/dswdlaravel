{{-- resources/views/enduser/dashboard.blade.php --}}
@extends('layouts.enduser-internal', ['title' => 'End User - Dashboard'])

@section('content')

    @php
        $activeRequests = $requests ?? collect();

        $withProcurementCount = $activeRequests->whereIn('status', [
            'submitted_to_procurement',
            'processing',
            'bac_processing',
            'approved',
            'final_approved',
            'signed_pr',
            'validated_payment',
        ])->count();

        $withFaiiCount = $activeRequests->whereIn('status', [
            'faii',
            'with_faii',
            'faii_processing',
        ])->count();

        $withFindingsCount = $activeRequests->whereIn('status', [
            'returned',
            'rejected',
            'with_findings',
        ])->count();

        $resolveStage = function ($request) {
            $status = strtolower((string) ($request->status ?? ''));

            return match ($status) {
                'draft' => 'Draft Proposal Created',
                'pending', 'submitted_to_rd' => 'Facilitate Signature of Proposal',
                'submitted_to_procurement', 'processing', 'bac_processing' => 'Receive Proposal Notification',
                'approved', 'final_approved' => 'Sign Activity Proposal',
                'signed_pr' => 'Submit Final Docs for Payment',
                'validated_payment' => 'Prepare OBR for DC Signature',
                'returned', 'rejected', 'with_findings' => 'Review / Revise Draft Proposal',
                default => 'Facilitate Signature of Proposal',
            };
        };

        $resolveLane = function ($request) {
            $status = strtolower((string) ($request->status ?? ''));

            return match ($status) {
                'submitted_to_procurement', 'processing', 'bac_processing' => 'APPROVER',
                'faii', 'with_faii', 'faii_processing' => 'FAII',
                'returned', 'rejected', 'with_findings' => 'APPROVER',
                default => 'ENDUSER',
            };
        };

        $resolveLaneClass = function ($lane) {
            return match ($lane) {
                'APPROVER' => 'background:#efe3ff;color:#7b3fb2;',
                'FAII' => 'background:#ffe9a8;color:#8a5b00;',
                default => 'background:#ccefc5;color:#2a7a2f;',
            };
        };

        $resolveMiniBadge = function ($request) {
            $status = strtolower((string) ($request->status ?? ''));

            return match ($status) {
                'submitted_to_procurement', 'processing', 'bac_processing' => ['RECEIVE', '#e8e0ff', '#7a54c7'],
                'approved', 'final_approved' => ['SIGN', '#dbe9ff', '#2d5ca8'],
                'returned', 'rejected', 'with_findings' => ['REVISE', '#ffd3d3', '#b53b3b'],
                default => ['PREPARE', '#fff0b8', '#8a5b00'],
            };
        };
    @endphp

    <div style="margin-bottom:10px;font-size:12px;color:#8c97a5;">
        Management Dashboard
    </div>

    <div class="stats" style="margin-bottom:12px;">
        <div class="stat-card" style="padding:10px 12px 8px;">
            <div class="stat-value" style="font-size:16px;color:#111827;font-weight:700;">{{ $activeRequests->count() }}</div>
            <div class="stat-sub" style="text-transform:uppercase;font-size:10px;color:#7b8794;">Active Requests</div>
        </div>

        <div class="stat-card" style="padding:10px 12px 8px;">
            <div class="stat-value" style="font-size:16px;color:#111827;font-weight:700;">{{ $withProcurementCount }}</div>
            <div class="stat-sub" style="text-transform:uppercase;font-size:10px;color:#7b8794;">With Procurement</div>
        </div>

        <div class="stat-card" style="padding:10px 12px 8px;">
            <div class="stat-value" style="font-size:16px;color:#111827;font-weight:700;">{{ $withFaiiCount }}</div>
            <div class="stat-sub" style="text-transform:uppercase;font-size:10px;color:#7b8794;">With FA II</div>
        </div>

        <div class="stat-card" style="padding:10px 12px 8px;">
            <div class="stat-value" style="font-size:16px;color:#111827;font-weight:700;">{{ $withFindingsCount }}</div>
            <div class="stat-sub" style="text-transform:uppercase;font-size:10px;color:#7b8794;">With Findings</div>
        </div>
    </div>

    <div class="panel" style="border-radius:14px;">
        <div class="panel-header" style="background:#ffffff;color:#111827;border-bottom:1px solid #dbe3ef;padding:12px 14px;">
            <span style="font-weight:700;">Active Procurement Pipeline</span>

            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <div style="position:relative;">
                    <input
                        type="text"
                        placeholder="Search ID or title..."
                        style="height:32px;width:170px;border:1px solid #d5dbe5;border-radius:8px;padding:0 12px 0 30px;font-size:12px;outline:none;background:#fafbfd;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#9aa3ad" stroke-width="2"
                        style="position:absolute;left:10px;top:50%;transform:translateY(-50%);">
                        <circle cx="11" cy="11" r="7"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>

                <a href="{{ route('enduser.requests.create') }}"
                    style="display:inline-flex;align-items:center;justify-content:center;height:32px;padding:0 16px;background:#2459d3;color:#fff;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;">
                    + New Activity Proposal
                </a>
            </div>
        </div>

        <div class="panel-body" style="padding:0;">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:150px;">Document ID</th>
                            <th>Activity / Description</th>
                            <th style="width:290px;">Current Stage</th>
                            <th style="width:120px;">Lane</th>
                            <th style="width:120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeRequests as $request)
                            @php
                                $stage = $resolveStage($request);
                                $lane = $resolveLane($request);
                                [$miniLabel, $miniBg, $miniColor] = $resolveMiniBadge($request);
                            @endphp

                            <tr>
                                <td>
                                    <div style="display:inline-block;background:#dbe9ff;color:#2459d3;font-size:10px;font-weight:700;border-radius:6px;padding:3px 8px;margin-bottom:4px;">
                                        {{ $request->pr_number ?? $request->doc_number ?? $request->document_no ?? ('DSWD-' . str_pad($request->id, 4, '0', STR_PAD_LEFT)) }}
                                    </div>
                                    <div class="muted" style="font-size:10px;">
                                        {{
                                            !empty($request->request_date)
                                                ? \Carbon\Carbon::parse($request->request_date)->format('n/j/Y')
                                                : (!empty($request->date_filed)
                                                    ? \Carbon\Carbon::parse($request->date_filed)->format('n/j/Y')
                                                    : (!empty($request->created_at)
                                                        ? \Carbon\Carbon::parse($request->created_at)->format('n/j/Y')
                                                        : '-'))
                                        }}
                                    </div>
                                </td>

                                <td>
                                    <div style="font-weight:700;color:#111827;font-size:12px;">
                                        {{ $request->purpose ?? $request->title ?? $request->activity_title ?? '-' }}
                                    </div>
                                    <div class="muted" style="font-size:11px;">
                                        ₱{{ number_format((float) ($request->total_amount ?? $request->estimated_total ?? 0), 2) }}
                                        @if(($request->priority_level ?? null) || ($request->division_office ?? $request->office_department ?? null))
                                            · {{ $request->priority_level ?? 'Normal' }}
                                            @if($request->division_office ?? $request->office_department ?? null)
                                                · {{ $request->division_office ?? $request->office_department }}
                                            @endif
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <div style="display:flex;align-items:flex-start;gap:8px;">
                                        <span style="width:6px;height:6px;border-radius:50%;background:#11a0bf;margin-top:5px;flex-shrink:0;"></span>
                                        <div>
                                            <div style="font-size:11px;font-weight:700;color:#1f2937;">{{ $stage }}</div>
                                            <div style="margin-top:4px;">
                                                <span style="display:inline-block;background:{{ $miniBg }};color:{{ $miniColor }};font-size:9px;font-weight:700;border-radius:4px;padding:2px 7px;">
                                                    {{ $miniLabel }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span style="display:inline-block;border-radius:999px;padding:3px 10px;font-size:10px;font-weight:700;{{ $resolveLaneClass($lane) }}">
                                        {{ $lane }}
                                    </span>
                                </td>

                                <td>
                                    <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                                        <a href="{{ route('enduser.requests.show', $request->id) }}"
                                            style="display:inline-flex;align-items:center;justify-content:center;min-width:38px;height:22px;background:#2459d3;color:#fff;border-radius:6px;font-size:9px;font-weight:700;text-decoration:none;">
                                            ACT
                                        </a>

                                        <a href="{{ route('enduser.requests.show', $request->id) }}"
                                            style="display:inline-flex;align-items:center;justify-content:center;min-width:48px;height:22px;border:1px solid #d5dbe5;color:#7b8794;border-radius:6px;font-size:9px;font-weight:700;text-decoration:none;background:#fff;">
                                            HISTORY
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-card">No active procurement requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
