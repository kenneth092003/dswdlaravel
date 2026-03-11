@extends('layouts.enduser-internal', ['title' => 'End User - My Proposals'])

@section('content')
    <div class="panel">
        <div class="panel-header">
            <span>My Activity Proposals</span>
            <a href="{{ route('enduser.requests.create') }}" class="btn-primary">+ New Proposal</a>
        </div>

        <div class="panel-body">
            <div class="tabs">
                <span>All</span>
                <span>Draft</span>
                <span>Pending</span>
                <span>Approved</span>
                <span>Returned</span>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:120px;">Doc No.</th>
                            <th>Activity / Title</th>
                            <th style="width:110px;">Date Filed</th>
                            <th style="width:140px;">Status</th>
                            <th style="width:100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                            @php
                                $badgeClass = 'badge-draft';
                                if ($request->status === 'pending' || $request->status === 'submitted_to_rd') $badgeClass = 'badge-pending';
                                elseif (in_array($request->status, ['approved'])) $badgeClass = 'badge-approved';
                                elseif (in_array($request->status, ['returned', 'rejected'])) $badgeClass = 'badge-returned';
                                elseif (in_array($request->status, ['processing', 'bac_processing', 'signed_pr', 'validated_payment'])) $badgeClass = 'badge-processing';
                            @endphp
                            <tr>
                                <td class="doc-no">{{ $request->doc_number }}</td>
                                <td>
                                    <div>{{ $request->activity_title }}</div>
                                    <div class="muted">₱{{ number_format((float) $request->estimated_total, 2) }} · {{ $request->division_office }}</div>
                                </td>
                                <td class="muted">{{ optional($request->date_filed)->format('M d') }}</td>
                                <td><span class="badge {{ $badgeClass }}">{{ str_replace('_', ' ', $request->status) }}</span></td>
                                <td><a href="{{ route('enduser.requests.show', $request->id) }}" class="view-btn">View</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-card">No purchase requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection