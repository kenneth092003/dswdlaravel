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
        .badge-approved    { background:#d1fae5; color:#065f46; }
        .badge-enduser     { background:#dbeafe; color:#1e40af; }
        .badge-procurement { background:#ede9fe; color:#5b21b6; }
        .badge-faii        { background:#fef9c3; color:#92400e; }
        .badge-superadmin  { background:#fee2e2; color:#991b1b; }

        .status-approved { background:#d1fae5; color:#065f46; padding:3px 10px; border-radius:999px; font-size:0.72rem; font-weight:700; }
        .status-pending  { background:#fef3c7; color:#92400e; padding:3px 10px; border-radius:999px; font-size:0.72rem; font-weight:700; }

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
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            

            {{-- Tab navigation --}}
            <div class="tab-nav flex gap-1 bg-white border border-gray-200 rounded-lg p-1 shadow-sm w-full overflow-x-auto">
                <a href="{{ route('dashboard') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Overview</div>
                    <div class="text-xs font-normal text-gray-400">System snapshot</div>
                </a>
                <a href="{{ route('admin.users.index') }}" class="active flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold transition">
                    <div class="font-bold">Account Management</div>
                    <div class="text-xs font-normal opacity-80">Users &amp; accounts</div>
                </a>
                <a href="{{ route('admin.roles.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Attendance</div>
                    <div class="text-xs font-normal text-gray-400">Roles &amp; access</div>
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

            {{-- Table card --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden border border-gray-200">

                {{-- Toolbar --}}
                <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ request('role') ? request('role') . ' Users' : 'All Users' }}
                        </span>
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ $users->total() }}
                        </span>

                        {{-- Active role filter badge with clear button --}}
                        @if(request('role'))
                            <span class="filter-badge">
                                Filtered: {{ request('role') }}
                                <a href="{{ route('admin.users.index') }}" title="Clear filter">✕</a>
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="text" placeholder="Search users…" class="search-input" />
                        <a href="{{ route('admin.users.index', request('role') ? ['role' => request('role')] : []) }}"
                           class="text-xs text-blue-600 hover:underline font-semibold">Refresh</a>
                    </div>
                </div>

                @if (session('status'))
                    <div class="mx-6 mt-4 p-3 rounded bg-green-50 text-green-800 text-sm font-semibold border border-green-200">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Table --}}
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
                            @endphp
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                <td class="px-5 py-3 text-gray-500 font-mono text-xs">{{ $u->employee_id }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="avatar {{ $color }}">{{ $initials }}</div>
                                        <div>
                                            <div class="font-semibold text-gray-800">{{ $u->firstname }} {{ $u->lastname }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-gray-500">{{ $u->email }}</td>
                                <td class="px-5 py-3">
                                    <span class="role-badge {{ $badgeClass }}">
                                        {{ $u->getRoleNames()->join(', ') ?: 'No Role' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    @if ($u->is_approved)
                                        <span class="status-approved">✓ Approved</span>
                                    @else
                                        <span class="status-pending">⏳ Pending</span>
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

                {{-- Pagination (preserve role filter across pages) --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $users->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>