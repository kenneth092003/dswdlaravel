<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Users
        </h2>
    </x-slot>

    <style>
        .tab-nav a.active {
            background: #1e3a5f;
            color: #fff;
            border-bottom: 3px solid #2563eb;
        }
        .tab-nav a {
            border-bottom: 3px solid transparent;
            text-decoration: none;
        }

        .role-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
        }
        .badge-approved { background:#d1fae5; color:#065f46; }
        .badge-enduser { background:#dbeafe; color:#1e40af; }
        .badge-procurement { background:#ede9fe; color:#5b21b6; }
        .badge-faii { background:#fef9c3; color:#92400e; }
        .badge-superadmin { background:#fee2e2; color:#991b1b; }

        .status-approved { background:#d1fae5; color:#065f46; padding:3px 10px; border-radius:999px; font-size:0.72rem; font-weight:700; }
        .status-pending { background:#fef3c7; color:#92400e; padding:3px 10px; border-radius:999px; font-size:0.72rem; font-weight:700; }

        .btn-approve {
            background:#1d4ed8; color:#fff; font-size:0.72rem; font-weight:600;
            padding:4px 12px; border-radius:5px; border:none; cursor:pointer;
        }
        .btn-approve:hover { background:#1e40af; }

        .btn-delete {
            background:#dc2626; color:#fff; font-size:0.72rem; font-weight:600;
            padding:4px 12px; border-radius:5px; border:none; cursor:pointer;
        }
        .btn-delete:hover { background:#b91c1c; }

        .avatar {
            width: 32px; height: 32px; border-radius:50%;
            background:#2563eb; color:#fff;
            display:inline-flex; align-items:center; justify-content:center;
            font-size:0.72rem; font-weight:700; flex-shrink:0;
        }

        thead th { font-size:0.78rem; font-weight:700; color:#1d4ed8; }

        .search-input {
            border:1px solid #d1d5db; border-radius:7px; padding:7px 14px;
            font-size:0.85rem; outline:none; width:220px;
        }
        .search-input:focus { border-color:#3b82f6; box-shadow:0 0 0 2px #bfdbfe; }

        .filter-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: #ede9fe; color: #5b21b6;
            font-size: 0.72rem; font-weight: 700;
            padding: 3px 10px; border-radius: 999px;
        }
        .filter-badge a { color: #7c3aed; text-decoration: none; font-size: 0.85rem; font-weight: 900; }
        .filter-badge a:hover { color: #dc2626; }

        .role-form select {
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 2px 30px 2px 10px;
            appearance: none;
            cursor: pointer;
            outline: none;
            min-width: 130px;
        }
        .role-form select:focus {
            box-shadow: 0 0 0 2px #bfdbfe;
        }
        .role-form .role-select-wrap {
            position: relative;
            display: inline-block;
        }
        .role-form .role-select-wrap::after {
            content: '▾';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.65rem;
            pointer-events: none;
            color: inherit;
        }

        .user-modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0.45);
            z-index: 60;
            padding: 20px;
        }
        .user-modal.open {
            display: flex;
        }
        .user-modal-card {
            width: min(100%, 720px);
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.32);
        }
        .user-modal-hero {
            background: linear-gradient(180deg, #2b4b86 0%, #24427b 100%);
            color: #fff;
            padding: 16px 20px 12px;
        }
        .user-modal-title {
            font-size: 1.15rem;
            font-weight: 800;
            line-height: 1.1;
        }
        .user-modal-subtitle {
            margin-top: 2px;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        .modal-summary-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            padding: 12px 18px 6px;
        }
        .modal-summary-card {
            background: #f1f2f4;
            border-radius: 18px;
            padding: 12px 14px;
            min-height: 64px;
        }
        .modal-summary-label {
            font-size: 0.78rem;
            color: #6b7280;
            font-weight: 800;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }
        .modal-summary-value {
            margin-top: 4px;
            font-size: 0.98rem;
            font-weight: 800;
            color: #111827;
        }
        .modal-section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px 12px;
            font-size: 1.02rem;
            font-weight: 800;
            color: #111827;
            border-top: 1px solid #e5e7eb;
        }
        .modal-fields {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            padding: 12px 18px 18px;
        }
        .modal-field label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.92rem;
            font-weight: 700;
            color: #111827;
        }
        .modal-field input {
            width: 100%;
            border: 1px solid #cfd4dc;
            border-radius: 4px;
            padding: 9px 11px;
            background: #fff;
            color: #6b7280;
            font-size: 0.92rem;
        }
        .modal-status-strip {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 12px;
            align-items: center;
            padding: 10px 18px 18px;
            border-top: 1px solid #e5e7eb;
        }
        .modal-status-chip {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #84cc16;
            background: #dcfce7;
            color: #14532d;
            border-radius: 6px;
            padding: 13px 14px;
            font-weight: 700;
        }
        .modal-status-chip.inactive {
            border-color: #f87171;
            background: #fee2e2;
            color: #991b1b;
        }
        .modal-status-note {
            text-align: center;
            font-size: 0.9rem;
            color: #111827;
        }
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 18px 18px;
            border-top: 1px solid #e5e7eb;
        }
        .modal-close-btn {
            border: 1px solid #d1d5db;
            background: #fff;
            color: #6b7280;
            border-radius: 6px;
            padding: 10px 16px;
            font-size: 0.95rem;
            font-weight: 800;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .modal-summary-grid,
            .modal-fields,
            .modal-status-strip {
                grid-template-columns: 1fr;
            }
            .modal-footer {
                flex-direction: column;
            }
            .modal-footer .btn,
            .modal-footer .modal-close-btn {
                width: 100%;
            }
        }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="tab-nav flex gap-1 bg-white border border-gray-200 rounded-lg p-1 shadow-sm w-full overflow-x-auto">
                <a href="{{ route('dashboard') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Overview</div>
                    <div class="text-xs font-normal text-gray-400">System snapshot</div>
                </a>
                <a href="{{ route('admin.users.index') }}" class="active flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold transition">
                    <div class="font-bold">Account Management</div>
                    <div class="text-xs font-normal opacity-80">Users &amp; accounts</div>
                </a>
                <a href="{{ route('admin.attendance.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Attendance</div>
                    <div class="text-xs font-normal text-gray-400">Login &amp; logout logs</div>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Report Issue</div>
                    <div class="text-xs font-normal text-gray-400">Submit system issues</div>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Audit Logs</div>
                    <div class="text-xs font-normal text-gray-400">Activity trail</div>
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden border border-gray-200">
                <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ request('role') ? request('role') . ' Users' : 'All Users' }}
                        </span>
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ $users->total() }}
                        </span>

                        @if(request('role'))
                            <span class="filter-badge">
                                Filtered: {{ request('role') }}
                                <a href="{{ route('admin.users.index') }}" title="Clear filter">×</a>
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="text" placeholder="Search users..." class="search-input" />
                        <a href="{{ route('admin.users.index', request('role') ? ['role' => request('role')] : []) }}"
                           class="text-xs text-blue-600 hover:underline font-semibold">Refresh</a>
                    </div>
                </div>

                @if (session('status'))
                    <div class="mx-6 mt-4 p-3 rounded bg-green-50 text-green-800 text-sm font-semibold border border-green-200">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left border-b border-gray-100 bg-blue-50">
                                <th class="px-5 py-3">Employee ID</th>
                                <th class="px-5 py-3">Name</th>
                                <th class="px-5 py-3">Email</th>
                                <th class="px-5 py-3">Role</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $u)
                                @php
                                    $roleName = strtolower(str_replace([' ','_'], '-', $u->getRoleNames()->first() ?? ''));
                                    $badgeMap = ['super-admin'=>'badge-superadmin','end-user'=>'badge-enduser','procurement'=>'badge-procurement','fa-ii'=>'badge-faii'];
                                    $badgeClass = $badgeMap[$roleName] ?? 'badge-enduser';
                                    $initials = strtoupper(substr($u->firstname,0,1).substr($u->lastname,0,1));
                                    $avatarColors = ['bg-blue-600','bg-purple-600','bg-green-600','bg-rose-500','bg-amber-500'];
                                    $color = $avatarColors[$u->id % count($avatarColors)];
                                    $fullName = trim($u->firstname . ' ' . $u->lastname);
                                    $divisionOffice = $u->division ?? $u->office_department ?? 'Not provided';
                                    $roleDisplay = $u->getRoleNames()->first() ?? $u->role ?? 'Not assigned';
                                @endphp
                                <tr
                                    class="border-b border-gray-50 hover:bg-gray-50 transition cursor-pointer"
                                    data-user-modal="1"
                                    data-user-name="{{ e($fullName) }}"
                                    data-user-email="{{ e($u->email) }}"
                                    data-user-role="{{ e($roleDisplay) }}"
                                    data-user-division="{{ e($divisionOffice) }}"
                                    data-user-status="{{ $u->is_approved ? 'Active' : 'Suspended' }}"
                                >
                                    <td class="px-5 py-3 text-gray-500 font-mono text-xs">{{ $u->employee_id }}</td>
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="avatar {{ $color }}">{{ $initials }}</div>
                                            <div class="font-semibold text-gray-800">{{ $u->firstname }} {{ $u->lastname }}</div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 text-gray-500">{{ $u->email }}</td>
                                    <td class="px-5 py-3">
                                        <form method="POST" action="{{ route('admin.users.role.update', $u) }}" class="role-form inline">
                                            @csrf
                                            @method('PATCH')
                                            <span class="role-select-wrap role-badge {{ $badgeClass }}">
                                                <select name="role" onchange="this.form.submit()" class="bg-transparent text-inherit">
                                                    @foreach ($availableRoles as $role)
                                                        <option value="{{ $role }}" @selected($u->role === $role || $u->getRoleNames()->first() === $role)>
                                                            {{ $role }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </span>
                                        </form>
                                    </td>
                                    <td class="px-5 py-3">
                                        @if ($u->is_approved)
                                            <span class="status-approved">Approved</span>
                                        @else
                                            <span class="status-pending">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-2">
                                            @if (! $u->is_approved)
                                                <form method="POST" action="{{ route('admin.users.approve', $u) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="btn-approve">Approve</button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if($users->isEmpty())
                                <tr>
                                    <td colspan="6" class="px-5 py-10 text-center text-gray-400 text-sm">
                                        No users found{{ request('role') ? ' for role: ' . request('role') : '' }}.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('user-view-modal');
            const modalOverlay = document.getElementById('user-view-overlay');
            const modalCloseButtons = document.querySelectorAll('[data-user-modal-close]');

            function openUserModal(row) {
                if (!modal) return;

                const fullName = row.dataset.userName || '';
                const email = row.dataset.userEmail || '';
                const role = row.dataset.userRole || '';
                const division = row.dataset.userDivision || '';
                const isActive = (row.dataset.userStatus || '').toLowerCase() === 'active';

                document.getElementById('modal-user-name').textContent = fullName;
                document.getElementById('modal-user-email-display').textContent = email;
                document.getElementById('modal-user-role-display').textContent = role;
                document.getElementById('modal-user-full-name').value = fullName;
                document.getElementById('modal-user-email').value = email;
                document.getElementById('modal-user-role').value = role;
                document.getElementById('modal-user-division').value = division;
                document.getElementById('modal-current-status').textContent = isActive ? 'Account Active' : 'Account Suspended';

                const statusChip = document.getElementById('modal-status-chip');
                const statusText = document.getElementById('modal-status-text');

                statusChip.classList.toggle('inactive', !isActive);
                statusChip.textContent = isActive ? 'Active Account' : 'Suspended Account';
                statusText.textContent = isActive ? 'Active' : 'Suspended';

                modal.classList.add('open');
                modal.setAttribute('aria-hidden', 'false');
            }

            function closeUserModal() {
                if (!modal) return;

                modal.classList.remove('open');
                modal.setAttribute('aria-hidden', 'true');
            }

            document.querySelectorAll('tr[data-user-modal="1"]').forEach((row) => {
                row.addEventListener('click', (event) => {
                    if (event.target.closest('form, button, select, option, a, input, label')) {
                        return;
                    }

                    openUserModal(row);
                });
            });

            modalCloseButtons.forEach((button) => {
                button.addEventListener('click', closeUserModal);
            });

            if (modalOverlay) {
                modalOverlay.addEventListener('click', closeUserModal);
            }

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeUserModal();
                }
            });
        });
    </script>

    <div id="user-view-modal" class="user-modal" aria-hidden="true">
        <div id="user-view-overlay" class="absolute inset-0"></div>
        <div class="user-modal-card relative">
            <div class="user-modal-hero">
                <div id="modal-user-name" class="user-modal-title"></div>
                <div id="modal-user-email-display" class="user-modal-subtitle"></div>
            </div>

            <div class="modal-summary-grid">
                <div class="modal-summary-card">
                    <div class="modal-summary-label">Current Status</div>
                    <div class="modal-summary-value">
                        <span id="modal-status-text" class="role-badge badge-approved">Active</span>
                    </div>
                </div>
                <div class="modal-summary-card">
                    <div class="modal-summary-label">Current Role</div>
                    <div id="modal-user-role-display" class="modal-summary-value"></div>
                </div>
            </div>

            <div class="modal-section-title">Account Information</div>
            <div class="modal-fields">
                <div class="modal-field">
                    <label>Full Name *</label>
                    <input id="modal-user-full-name" type="text" readonly>
                </div>
                <div class="modal-field">
                    <label>Email Address *</label>
                    <input id="modal-user-email" type="email" readonly>
                </div>
                <div class="modal-field">
                    <label>Assigned Role *</label>
                    <input id="modal-user-role" type="text" readonly>
                </div>
                <div class="modal-field">
                    <label>Division / Office *</label>
                    <input id="modal-user-division" type="text" readonly>
                </div>
            </div>

            <div class="modal-section-title">Account Status</div>
            <div class="modal-status-strip">
                <div id="modal-status-chip" class="modal-status-chip">Active Account</div>
                <div id="modal-current-status" class="modal-status-note">Account Active</div>
                <div></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="modal-close-btn" data-user-modal-close>Close</button>
            </div>
        </div>
    </div>
</x-app-layout>
