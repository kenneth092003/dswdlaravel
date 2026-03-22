@extends('layouts.enduser-internal', ['title' => 'End User - My Proposals'])

@section('content')
    <div class="panel">
        <div class="panel-header">
            <span>My Activity Proposals</span>
            <a href="{{ route('enduser.requests.create') }}" class="btn-primary">+ New Proposal</a>
        </div>

        <div class="panel-body">
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
                                <td class="doc-no">{{ $request->pr_number ?? '-' }}</td>

                                <td>
                                    <div>{{ $request->purpose ?? '-' }}</div>
                                    <div class="muted">
                                        ₱{{ number_format((float) ($request->total_amount ?? 0), 2) }}
                                    </div>
                                </td>

                                <td class="muted">
                                    {{ $request->request_date ? \Carbon\Carbon::parse($request->request_date)->format('M d, Y') : '-' }}
                                </td>

                                <td class="muted">
                                    {{ $request->office_department ?? '-' }}
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
@endsection
