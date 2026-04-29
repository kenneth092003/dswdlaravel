<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit User
        </h2>
    </x-slot>

    @php
        $fullName = $user->full_name ?: trim(($user->firstname ?? '') . ' ' . ($user->lastname ?? ''));
        $roleName = $user->getRoleNames()->first() ?: $user->role ?: 'Not assigned';
        $divisionOffice = $user->division ?? $user->office_department ?? 'Not provided';
        $isApproved = (bool) $user->is_approved;
        $statusLabel = $isApproved ? 'Active' : 'Suspended';
    @endphp

    <style>
        .user-shell {
            max-width: 1100px;
            margin: 0 auto;
        }
        .user-panel {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        }
        .user-hero {
            background: linear-gradient(180deg, #254f8e 0%, #21457c 100%);
            color: #fff;
            padding: 16px 22px 14px;
            border-bottom: 3px solid #2f7cf6;
        }
        .hero-title {
            font-size: 1.35rem;
            font-weight: 800;
            line-height: 1.1;
        }
        .hero-sub {
            margin-top: 2px;
            font-size: 0.92rem;
            color: rgba(255,255,255,0.88);
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            padding: 14px 20px 6px;
        }
        .summary-card {
            background: #f3f4f6;
            border-radius: 18px;
            padding: 12px 16px 13px;
            min-height: 60px;
        }
        .summary-label {
            font-size: 0.82rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: #6b7280;
            line-height: 1.1;
        }
        .summary-value {
            margin-top: 4px;
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
        }
        .pill-active {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 2px 9px;
            border-radius: 999px;
            background: #d9f7d3;
            color: #166534;
            font-size: 0.88rem;
            font-weight: 700;
        }
        .section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px 12px;
            font-weight: 800;
            color: #111827;
            font-size: 1.05rem;
        }
        .section-rule {
            border-top: 1px solid #e5e7eb;
        }
        .field-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px 14px;
            padding: 12px 20px 20px;
        }
        .field label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.95rem;
            font-weight: 700;
            color: #111827;
        }
        .field input,
        .field select {
            width: 100%;
            border: 1px solid #cfd4dc;
            border-radius: 4px;
            background: #fff;
            padding: 9px 11px;
            font-size: 0.95rem;
            color: #6b7280;
        }
        .field input[readonly] {
            background: #f9fafb;
        }
        .status-strip {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 12px;
            padding: 10px 20px 14px;
        }
        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #86efac;
            border-radius: 6px;
            background: #dcfce7;
            color: #14532d;
            padding: 14px 16px;
            font-weight: 700;
        }
        .status-chip.inactive {
            border-color: #fca5a5;
            background: #fee2e2;
            color: #991b1b;
        }
        .status-note {
            text-align: center;
            font-size: 0.98rem;
            color: #111827;
        }
        .footer-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 18px 20px 20px;
            border-top: 1px solid #e5e7eb;
        }
        .btn {
            border: 1px solid transparent;
            border-radius: 6px;
            font-size: 0.98rem;
            font-weight: 800;
            padding: 11px 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-blue { background: #0f52ba; color: #fff; }
        .btn-blue:hover { background: #0b479f; }
        .btn-gray { background: #fff; color: #8b8b8b; border-color: #d1d5db; }
        .btn-gray:hover { background: #f9fafb; }
        .btn-red { background: #ef4444; color: #fff; border-color: #dc2626; }
        .btn-red:hover { background: #dc2626; }
        .btn-soft-green {
            background: #d9f7d3;
            color: #14532d;
            border-color: #86efac;
        }
        .btn-soft-green:hover { background: #c7f0bf; }
        .btn-outline {
            background: #fff;
            color: #111827;
            border-color: #d1d5db;
        }
        .alert-success {
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #166534;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 0.92rem;
            font-weight: 700;
            margin-bottom: 14px;
        }
        @media (max-width: 768px) {
            .summary-grid,
            .field-grid,
            .status-strip {
                grid-template-columns: 1fr;
            }
            .footer-actions {
                flex-direction: column;
            }
            .footer-actions .btn {
                width: 100%;
            }
        }
    </style>

    <div class="py-8">
        <div class="user-shell px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            <div class="user-panel">
                <div class="user-hero">
                    <div class="hero-title">Edit: {{ $fullName }}</div>
                    <div class="hero-sub">{{ $user->email }}</div>
                </div>

                <div class="summary-grid">
                    <div class="summary-card">
                        <div class="summary-label">Current Status</div>
                        <div class="summary-value">
                            <span class="pill-active">• {{ $statusLabel }}</span>
                        </div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-label">Current Role</div>
                        <div class="summary-value">{{ $roleName }}</div>
                    </div>
                </div>

                <div class="section-title">👤 Account Information</div>
                <div class="section-rule"></div>

                <div class="field-grid">
                    <div class="field">
                        <label for="full_name">Full Name *</label>
                        <input id="full_name" type="text" value="{{ $fullName }}" readonly>
                    </div>
                    <div class="field">
                        <label for="email">Email Address *</label>
                        <input id="email" type="email" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="field">
                        <label for="division_office">Division / Office *</label>
                        <input id="division_office" type="text" value="{{ $divisionOffice }}" readonly>
                    </div>
                    <div class="field">
                        <label for="role">Assigned Role *</label>
                        <form id="role-update-form" method="POST" action="{{ route('admin.users.role.update', $user) }}">
                            @csrf
                            @method('PATCH')
                            <select id="role" name="role">
                                @foreach ($availableRoles as $role)
                                    <option value="{{ $role }}" @selected($roleName === $role)>
                                        {{ $role }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                <div class="section-title section-rule">🛡 Account Status</div>
                <div class="status-strip">
                    <div class="status-chip {{ $isApproved ? '' : 'inactive' }}">
                        {{ $isApproved ? '✓ Account Active' : '✕ Account Suspended' }}
                    </div>
                    <div class="status-note">{{ $isApproved ? 'Account Active' : 'Account Suspended' }}</div>
                    <div></div>
                </div>

                <div class="footer-actions">
                    @if($isApproved)
                        <form method="POST" action="{{ route('admin.users.status.toggle', $user) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-red">Suspend Account</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.users.status.toggle', $user) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-soft-green">Activate Account</button>
                        </form>
                    @endif
                    <a href="{{ route('admin.users.index') }}" class="btn btn-gray">Cancel</a>
                    <button type="submit" form="role-update-form" class="btn btn-blue">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
