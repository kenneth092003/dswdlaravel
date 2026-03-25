{{-- resources/views/enduser/notifications/index.blade.php --}}
@extends('layouts.enduser-internal', ['title' => 'End User - Notifications'])

@section('content')
    <div class="panel">
        <div class="panel-header">
            <span>Notifications</span>
            <a href="{{ route('enduser.requests.create') }}" class="btn-primary">+ New Proposal</a>
        </div>

        <div class="panel-body" style="padding:0;">
            @forelse($notifications as $notification)
                <div class="notice-row" style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;padding:14px 16px;">
                    <div>
                        <div style="font-size:13px;font-weight:700;color:#1f2937;">
                            {{ $notification->title }}
                        </div>
                        <div style="margin-top:4px;font-size:12px;color:#6b7280;line-height:1.5;">
                            {{ $notification->message }}
                        </div>
                    </div>

                    @if(!empty($notification->created_at))
                        <div style="white-space:nowrap;font-size:11px;color:#94a3b8;">
                            {{ \Carbon\Carbon::parse($notification->created_at)->format('M d, Y h:i A') }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-card" style="min-height:220px;">No notifications available.</div>
            @endforelse
        </div>
    </div>
@endsection