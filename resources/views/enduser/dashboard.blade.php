{{-- resources/views/enduser/dashboard.blade.php --}}
@extends('layouts.enduser-internal', ['title' => 'End User - Dashboard'])

@section('content')

    {{-- Breadcrumb --}}
    <div style="font-size:12px;color:#6c7785;margin-bottom:12px;display:flex;align-items:center;gap:6px;">
        <span>Home</span>
        <span style="opacity:.4;">/</span>
        <span style="color:#0d4fb3;font-weight:700;">Dashboard</span>
    </div>

    {{-- Page Title --}}
    <div style="margin-bottom:14px;">
        <div style="font-size:17px;font-weight:700;color:#263238;">
            Welcome back, {{ auth()->user()->firstname }}
        </div>
        <div style="font-size:12px;color:#6c7785;margin-top:2px;">
            Here's an overview of your activity proposals and documents.
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="stats" style="margin-bottom:14px;">
        <div class="stat-card">
            <div class="stat-title">Draft Proposals</div>
            <div class="stat-value" style="color:#1f3f7d;">{{ $draftCount ?? $totalProposals ?? 0 }}</div>
            <div class="stat-sub">Not yet submitted</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Pending Approval</div>
            <div class="stat-value" style="color:#8a5b00;">{{ $pendingCount ?? $pendingProposals ?? 0 }}</div>
            <div class="stat-sub">Awaiting RD decision</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Approved / In Process</div>
            <div class="stat-value" style="color:#2a7a2f;">{{ $approvedProcessingCount ?? $approvedProposals ?? 0 }}</div>
            <div class="stat-sub">BAC or Payment stage</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Returned / Rejected</div>
            <div class="stat-value" style="color:#b53b3b;">{{ $returnedRejectedCount ?? $returnedProposals ?? 0 }}</div>
            <div class="stat-sub">Needs correction</div>
        </div>
    </div>

    {{-- Main content grid --}}
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:14px;align-items:start;">

        {{-- LEFT: My Activity Proposals --}}
        <div class="panel">
            <div class="panel-header" style="justify-content:space-between;">
                <span>My Activity Proposals</span>
                <a href="{{ route('enduser.requests.create') }}" class="btn-primary">+ New Proposal</a>
            </div>

            <div class="panel-body">
                <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:12px;flex-wrap:wrap;">
                    <div style="font-size:12px;color:#64748b;">
                        Quick overview of your procurement request activity.
                    </div>
                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                        <span class="badge badge-draft">Draft</span>
                        <span class="badge badge-pending">Pending</span>
                        <span class="badge badge-approved">Approved</span>
                        <span class="badge badge-returned">Returned</span>
                    </div>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:130px;">Doc No.</th>
                                <th>Activity / Title</th>
                                <th style="width:130px;">Date Filed</th>
                                <th style="width:180px;">Division / Office</th>
                                <th style="width:140px;">Priority Level</th>
                                <th style="width:130px;">Status</th>
                                <th style="width:100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $request)
                                @php
                                    $badgeClass = 'badge-draft';

                                    if ($request->status === 'pending' || $request->status === 'submitted_to_rd' || $request->status === 'submitted_to_procurement') {
                                        $badgeClass = 'badge-pending';
                                    } elseif (in_array($request->status, ['approved', 'final_approved'])) {
                                        $badgeClass = 'badge-approved';
                                    } elseif (in_array($request->status, ['returned', 'rejected'])) {
                                        $badgeClass = 'badge-returned';
                                    } elseif (in_array($request->status, ['processing', 'bac_processing', 'signed_pr', 'validated_payment'])) {
                                        $badgeClass = 'badge-processing';
                                    }
                                @endphp

                                <tr>
                                    <td class="doc-no">{{ $request->pr_number ?? $request->document_no ?? '-' }}</td>

                                    <td>
                                        <div style="font-weight:700;color:#1f2937;">
                                            {{ $request->purpose ?? $request->title ?? $request->activity_title ?? '-' }}
                                        </div>
                                        <div class="muted">
                                            ₱{{ number_format((float) ($request->total_amount ?? $request->estimated_total ?? 0), 2) }}
                                        </div>
                                    </td>

                                    <td class="muted">
                                        {{
                                            !empty($request->request_date)
                                                ? \Carbon\Carbon::parse($request->request_date)->format('M d, Y')
                                                : (!empty($request->date_filed)
                                                    ? \Carbon\Carbon::parse($request->date_filed)->format('M d, Y')
                                                    : (!empty($request->created_at)
                                                        ? \Carbon\Carbon::parse($request->created_at)->format('M d, Y')
                                                        : '-'))
                                        }}
                                    </td>

                                    <td class="muted">
                                        {{ $request->office_department ?? $request->division_office ?? '-' }}
                                    </td>

                                    <td class="muted">
                                        {{ $request->priority_level ?? 'Normal' }}
                                    </td>

                                    <td>
                                        <span class="badge {{ $badgeClass }}">
                                            {{ ucwords(str_replace('_', ' ', $request->status)) }}
                                        </span>
                                    </td>

                                    <td>
                                        <a href="{{ route('enduser.requests.show', $request->id) }}" class="view-btn">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-card">No purchase requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- RIGHT: Quick Actions + Status Guide --}}
        <div style="display:flex;flex-direction:column;gap:14px;">

            {{-- Quick Actions --}}
            <div class="panel">
                <div class="panel-header">
                    <span style="display:flex;align-items:center;gap:8px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" style="opacity:.85;">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                        </svg>
                        Quick Actions
                    </span>
                </div>
                <div class="panel-body" style="display:flex;flex-direction:column;gap:8px;">
                    <a href="{{ route('enduser.requests.create') }}" style="display:flex;align-items:center;gap:9px;padding:10px 12px;background:#f5f8ff;border:1px solid #d9e7ff;border-radius:7px;text-decoration:none;color:#1f3f7d;font-size:13px;font-weight:700;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1f3f7d" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        New Activity Proposal
                    </a>

                    <a href="{{ route('enduser.requests.index') }}" style="display:flex;align-items:center;gap:9px;padding:10px 12px;background:#f5f8ff;border:1px solid #d9e7ff;border-radius:7px;text-decoration:none;color:#1f3f7d;font-size:13px;font-weight:700;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1f3f7d" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        My Proposals
                    </a>

                    <a href="{{ route('enduser.notifications.index') }}" style="display:flex;align-items:center;gap:9px;padding:10px 12px;background:#f5f8ff;border:1px solid #d9e7ff;border-radius:7px;text-decoration:none;color:#1f3f7d;font-size:13px;font-weight:700;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1f3f7d" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                        Notifications
                    </a>

                    <a href="{{ route('enduser.profile.edit') }}" style="display:flex;align-items:center;gap:9px;padding:10px 12px;background:#f5f8ff;border:1px solid #d9e7ff;border-radius:7px;text-decoration:none;color:#1f3f7d;font-size:13px;font-weight:700;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#1f3f7d" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        My Profile
                    </a>
                </div>
            </div>

            {{-- Status Guide --}}
            <div class="panel">
                <div class="panel-header">
                    <span style="display:flex;align-items:center;gap:8px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" style="opacity:.85;">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        Status Guide
                    </span>
                </div>
                <div class="panel-body" style="display:flex;flex-direction:column;gap:8px;">
                    @foreach([
                        ['draft', 'Draft', 'Saved but not yet submitted.'],
                        ['pending', 'Pending', 'Submitted, awaiting review.'],
                        ['approved', 'Approved', 'Approved and in processing.'],
                        ['returned', 'Returned', 'Sent back for revisions.'],
                    ] as [$key, $label, $desc])
                        <div style="display:flex;align-items:flex-start;gap:9px;">
                            <span class="badge badge-{{ $key }}" style="margin-top:1px;flex-shrink:0;">{{ $label }}</span>
                            <span style="font-size:12px;color:#6c7785;line-height:1.5;">{{ $desc }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

@endsection