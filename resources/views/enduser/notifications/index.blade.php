@extends('layouts.enduser-internal', ['title' => 'End User - Notifications'])

@section('content')
    <div class="panel">
        <div class="panel-header">
            <span>Notifications</span>
            <a href="{{ route('enduser.requests.create') }}" class="btn-primary">+ New Proposal</a>
        </div>

        <div class="panel-body" style="padding:0;">
            @forelse($notifications as $notification)
                <div class="notice-row">
                    <strong>{{ $notification->title }}</strong>
                    <span style="margin-left:12px;color:#6b7280;">{{ $notification->message }}</span>
                </div>
            @empty
                <div class="notice-row"><strong>Proposal Approved</strong></div>
                <div class="notice-row"></div>
                <div class="notice-row"></div>
                <div class="notice-row"></div>
                <div class="notice-row"></div>
                <div class="notice-row"></div>
            @endforelse
        </div>
    </div>
@endsection