{{-- resources/views/enduser/profile/edit.blade.php --}}
@extends('layouts.enduser-internal', ['title' => 'End User - Edit Profile'])

@section('content')

    {{-- Breadcrumb --}}
    <div style="font-size:12px;color:#6c7785;margin-bottom:12px;display:flex;align-items:center;gap:6px;">
        <span>Home</span>
        <span style="opacity:.4;">/</span>
        <span>Account</span>
        <span style="opacity:.4;">/</span>
        <span style="color:#0d4fb3;font-weight:700;">Edit Profile</span>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div style="margin-bottom:12px;background:#e8f7e6;border:1px solid #9ed598;padding:10px 13px;border-radius:7px;font-size:13px;color:#276124;display:flex;align-items:center;gap:8px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#276124" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="margin-bottom:12px;background:#fff2f2;border:1px solid #f1b0b0;padding:10px 13px;border-radius:7px;font-size:13px;color:#b53b3b;">
            @foreach($errors->all() as $error)
                <div style="display:flex;align-items:center;gap:6px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#b53b3b" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    {{ $error }}
                </div>
            @endforeach
        </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 2fr;gap:14px;align-items:start;">

        {{-- LEFT: Account Summary --}}
        <div class="panel">
            <div class="panel-header">
                <span style="display:flex;align-items:center;gap:8px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" style="opacity:.85;">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Account Summary
                </span>
            </div>

            <div class="panel-body" style="display:flex;flex-direction:column;align-items:center;gap:10px;padding:22px 16px;">
                <div style="width:72px;height:72px;border-radius:50%;background:#1f3f7d;color:#fff;display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;border:3px solid #d9e7ff;">
                    {{ strtoupper(substr(auth()->user()->firstname ?? 'U', 0, 1) . substr(auth()->user()->lastname ?? '', 0, 1)) }}
                </div>

                <div style="font-size:15px;font-weight:700;color:#263238;text-align:center;">
                    {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                </div>

                <div style="font-size:11px;color:#6c7785;text-align:center;">
                    {{ auth()->user()->email }}
                </div>

                <span style="display:inline-block;background:#d9e7ff;color:#1f3f7d;font-size:11px;font-weight:700;padding:3px 14px;border-radius:999px;margin-top:2px;">
                    End User
                </span>

                <table style="width:100%;border-top:1px solid #eef2f6;margin-top:10px;">
                    <tr>
                        <td style="padding:7px 0;font-size:12px;color:#6c7785;border-bottom:1px solid #f0f2f5;width:45%;">Employee ID</td>
                        <td style="padding:7px 0;font-size:12px;font-weight:700;color:#263238;border-bottom:1px solid #f0f2f5;">
                            {{ auth()->user()->employee_id ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:7px 0;font-size:12px;color:#6c7785;">Status</td>
                        <td style="padding:7px 0;font-size:12px;font-weight:700;color:#2a7a2f;">Active</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- RIGHT: Edit Form --}}
        <div class="panel">
            <div class="panel-header">
                <span style="display:flex;align-items:center;gap:8px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" style="opacity:.85;">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Edit Profile
                </span>
            </div>

            <form method="POST" action="{{ route('enduser.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="panel-body">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#0d4fb3;border-bottom:2px solid #d9e7ff;padding-bottom:5px;margin-bottom:14px;">
                        Account Information
                    </div>

                    <div class="grid-2" style="margin-bottom:16px;">
                        <div class="field">
                            <label>First Name</label>
                            <input type="text" name="firstname" value="{{ old('firstname', auth()->user()->firstname) }}" placeholder="Enter first name">
                        </div>

                        <div class="field">
                            <label>Last Name</label>
                            <input type="text" name="lastname" value="{{ old('lastname', auth()->user()->lastname) }}" placeholder="Enter last name">
                        </div>

                        <div class="field">
                            <label>Employee ID</label>
                            <input type="text" name="employee_id" value="{{ old('employee_id', auth()->user()->employee_id) }}" placeholder="Enter employee ID">
                        </div>

                        <div class="field">
                            <label>Email Address</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" placeholder="Enter email address">
                        </div>
                    </div>
                </div>

                <div style="border-top:1px solid #e8edf3;background:#f8f9fb;padding:11px 16px;display:flex;justify-content:flex-end;align-items:center;gap:9px;">
                    <a href="{{ route('enduser.dashboard') }}" class="btn-outline">Cancel</a>

                    <button type="submit" style="background:#1f3f7d;color:#fff;border:1px solid #183268;border-radius:7px;padding:7px 16px;font-size:12px;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Update Profile
                    </button>
                </div>
            </form>
        </div>

    </div>

@endsection