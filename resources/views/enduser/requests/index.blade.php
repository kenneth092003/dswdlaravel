{{-- resources/views/enduser/requests/index.blade.php --}}
@extends('layouts.enduser-internal', ['title' => 'End User - My Proposals'])

@section('content')

    {{-- Breadcrumb --}}
    <div style="font-size:12px;color:#6c7785;margin-bottom:12px;display:flex;align-items:center;gap:6px;">
        <span>Home</span>
        <span style="opacity:.4;">/</span>
        <span>Activity Proposals</span>
        <span style="opacity:.4;">/</span>
        <span style="color:#0d4fb3;font-weight:700;">My Proposals</span>
    </div>

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:8px;">
        <div>
            <div style="font-size:17px;font-weight:700;color:#263238;">My Proposals</div>
            <div style="font-size:12px;color:#6c7785;margin-top:2px;">
                Manage and track all your activity proposals.
            </div>
        </div>

        <a href="{{ route('enduser.requests.create') }}"
           style="background:#1f3f7d;color:#fff;border:1px solid #183268;border-radius:7px;padding:8px 16px;font-size:12px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            New Proposal
        </a>
    </div>

    {{-- Success Alert --}}
    @if(session('success'))
        <div style="margin-bottom:12px;background:#e8f7e6;border:1px solid #9ed598;padding:10px 13px;border-radius:7px;font-size:13px;color:#276124;display:flex;align-items:center;gap:8px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#276124" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="stats" style="margin-bottom:14px;">
        <div class="stat-card">
            <div class="stat-title">Total</div>
            <div class="stat-value" style="color:#1f3f7d;">
                {{ method_exists($requests, 'total') ? $requests->total() : $requests->count() }}
            </div>
            <div class="stat-sub">All proposals</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Pending</div>
            <div class="stat-value" style="color:#8a5b00;">
                {{ $requests->whereIn('status', ['pending', 'submitted_to_rd', 'submitted_to_procurement'])->count() }}
            </div>
            <div class="stat-sub">Awaiting review</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Approved</div>
            <div class="stat-value" style="color:#2a7a2f;">
                {{ $requests->whereIn('status', ['approved', 'final_approved'])->count() }}
            </div>
            <div class="stat-sub">Approved</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Returned</div>
            <div class="stat-value" style="color:#b53b3b;">
                {{ $requests->whereIn('status', ['returned', 'rejected'])->count() }}
            </div>
            <div class="stat-sub">Needs revision</div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="panel" style="margin-bottom:14px;">
        <div class="panel-body" style="padding:12px 14px;">
            <form method="GET" action="{{ route('enduser.requests.index') }}" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <div class="field" style="margin:0;flex:1;min-width:180px;">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search by title or document no..."
                           style="width:100%;">
                </div>

                <div class="field" style="margin:0;">
                    <select name="status" style="border:1px solid #cfd6df;border-radius:5px;padding:9px 10px;font-size:13px;color:#263238;background:#fff;min-width:150px;">
                        <option value="">All Statuses</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <button type="submit"
                        style="background:#1f3f7d;color:#fff;border:none;border-radius:7px;padding:9px 16px;font-size:12px;font-weight:700;cursor:pointer;">
                    Filter
                </button>

                @if(request('search') || request('status'))
                    <a href="{{ route('enduser.requests.index') }}"
                       style="font-size:12px;color:#6c7785;text-decoration:none;padding:9px 8px;">
                        Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Main Table --}}
    <div class="panel">
        <div class="panel-header">
            <span>My Activity Proposals</span>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <span class="badge badge-draft">Draft</span>
                <span class="badge badge-pending">Pending</span>
                <span class="badge badge-approved">Approved</span>
                <span class="badge badge-returned">Returned</span>
            </div>
        </div>

        <div class="panel-body">
            <div style="font-size:12px;color:#64748b;margin-bottom:12px;">
                Track all submitted, approved, and returned requests here.
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
                            <th style="width:120px;">Action</th>
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

                            <tr style="transition:background .15s ease;"
                                onmouseover="this.style.background='#fafbfd'"
                                onmouseout="this.style.background=''">
                                <td class="doc-no">
                                    {{ $request->pr_number ?? $request->document_no ?? '-' }}
                                </td>

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
                                        $request->request_date
                                            ? \Carbon\Carbon::parse($request->request_date)->format('M d, Y')
                                            : (
                                                $request->date_filed
                                                    ? \Carbon\Carbon::parse($request->date_filed)->format('M d, Y')
                                                    : '-'
                                            )
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
                                    <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                                        <a href="{{ route('enduser.requests.show', $request->id) }}" class="view-btn">View</a>

                                        @if(in_array($request->status, ['draft', 'returned', 'rejected']))
                                            <a href="{{ route('enduser.requests.edit', $request->id) }}"
                                               class="view-btn"
                                               style="color:#8a5b00;border-color:#e1b841;">
                                                Edit Proposal
                                            </a>
                                        @endif

                                        @if($request->status === 'approved')
                                            <a href="{{ route('enduser.requests.draft.pr', $request->id) }}"
                                               class="view-btn"
                                               style="color:#1f3f7d;border-color:#6c8bb3;">
                                                Draft PR
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div style="padding:36px;text-align:center;color:#7d8793;">
                                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#cfd6df" stroke-width="1.5" style="display:block;margin:0 auto 12px;">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <polyline points="14 2 14 8 20 8"/>
                                        </svg>
                                        No purchase requests found.
                                        <div style="margin-top:10px;">
                                            <a href="{{ route('enduser.requests.create') }}"
                                               style="background:#1f3f7d;color:#fff;border-radius:7px;padding:7px 16px;font-size:12px;font-weight:700;text-decoration:none;display:inline-block;">
                                                + Submit your first proposal
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if(method_exists($requests, 'hasPages') && $requests->hasPages())
            <div style="padding:12px 14px;border-top:1px solid #eceff3;display:flex;justify-content:flex-end;">
                {{ $requests->withQueryString()->links() }}
            </div>
        @endif
    </div>

@endsection
