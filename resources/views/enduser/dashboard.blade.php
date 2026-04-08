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

    {{-- FULL WIDTH CONTENT --}}
    <div style="display:block;">

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

    </div>

@endsection
