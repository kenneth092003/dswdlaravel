<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Super Admin — Dashboard') }}
        </h2>
    </x-slot>

    {{-- Custom styles --}}
    <style>
        .tab-nav button.active {
            background: #1e3a5f;
            color: #fff;
            border-bottom: 3px solid #2563eb;
        }
        .tab-nav button {
            border-bottom: 3px solid transparent;
        }
        .stat-card { min-width: 120px; }
        .role-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-approved  { background:#d1fae5; color:#065f46; }
        .badge-enduser   { background:#dbeafe; color:#1e40af; }
        .badge-procurement { background:#ede9fe; color:#5b21b6; }
        .badge-faii      { background:#fef9c3; color:#92400e; }

        .activity-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; margin-top:4px; }
        .dot-green  { background:#22c55e; }
        .dot-blue   { background:#3b82f6; }
        .dot-red    { background:#ef4444; }
        .dot-yellow { background:#f59e0b; }
        .dot-purple { background:#a855f7; }
        .dot-gray   { background:#9ca3af; }

        .pending-badge {
            background: #fef3c7;
            color: #92400e;
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 999px;
            font-weight: 700;
        }

        .role-label {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .status-all-active   { background:#d1fae5; color:#065f46; }
        .status-inactive     { background:#fef9c3; color:#92400e; }
        .status-suspended    { background:#fee2e2; color:#991b1b; }

        .btn-manage {
            background: #1d4ed8;
            color: #fff;
            padding: 5px 14px;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }
        .btn-manage:hover { background: #1e40af; }

        .btn-view-users {
            background: #fff;
            color: #374151;
            border: 1px solid #d1d5db;
            padding: 5px 14px;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
        }
        .btn-view-users:hover { background: #f3f4f6; }

        .approve-btn { background:#16a34a; color:#fff; font-size:0.72rem; padding:3px 10px; border-radius:5px; font-weight:600; border:none; cursor:pointer; }
        .approve-btn:hover { background:#15803d; }
        .reject-btn  { background:#dc2626; color:#fff; font-size:0.72rem; padding:3px 10px; border-radius:5px; font-weight:600; border:none; cursor:pointer; }
        .reject-btn:hover  { background:#b91c1c; }
        .view-btn    { background:none; color:#2563eb; font-size:0.72rem; font-weight:600; border:none; cursor:pointer; text-decoration:underline; }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Page heading --}}
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Super Admin — Dashboard</h1>
                <p class="text-sm text-gray-500 mt-0.5">Manage role-based access and system permissions</p>
            </div>

            {{-- Tab navigation --}}
            <div class="tab-nav flex gap-1 bg-white border border-gray-200 rounded-lg p-1 shadow-sm w-full overflow-x-auto">
                <button class="active flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold transition">
                    <div class="font-bold">Overview</div>
                    <div class="text-xs font-normal opacity-80">System snapshot</div>
                </button>
                <a href="{{ route('admin.users.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Account Management</div>
                    <div class="text-xs font-normal text-gray-400">Users &amp; accounts</div>
                </a>
                <a href="{{ route('admin.roles.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Permission Control</div>
                    <div class="text-xs font-normal text-gray-400">Roles &amp; access</div>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">System Oversight</div>
                    <div class="text-xs font-normal text-gray-400">Settings &amp; health</div>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Audit Logs</div>
                    <div class="text-xs font-normal text-gray-400">Activity trail</div>
                </a>
            </div>

            {{-- Stat cards --}}
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                <div class="stat-card bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <p class="text-xs text-gray-500 font-medium">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\User::count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Registered accounts</p>
                </div>
                <div class="stat-card bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <p class="text-xs text-gray-500 font-medium">Active</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\User::where('is_approved', true)->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Currently enabled</p>
                </div>
                <div class="stat-card bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <p class="text-xs text-gray-500 font-medium">Suspended</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">0</p>
                    <p class="text-xs text-gray-400 mt-1">Access restricted</p>
                </div>
                <div class="stat-card bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <p class="text-xs text-gray-500 font-medium">Pending Approval</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\User::where('is_approved', false)->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">New account requests</p>
                </div>
                <div class="stat-card bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <p class="text-xs text-gray-500 font-medium">Audit Events Today</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">—</p>
                    <p class="text-xs text-gray-400 mt-1">System activities</p>
                </div>
            </div>

            {{-- Users by Role + Recent Activity --}}
            <div class="flex gap-4 flex-col lg:flex-row">

                {{-- Users by Role --}}
                <div class="flex-1 bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <span>👥</span> Users by Role
                        </h3>
                        <a href="{{ route('admin.users.index') }}" class="btn-manage text-xs">Manage All Users →</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-xs text-blue-700 font-bold border-b border-gray-100 bg-blue-50">
                                    <th class="px-5 py-3">Role</th>
                                    <th class="px-5 py-3">Users</th>
                                    <th class="px-5 py-3">Active</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\Spatie\Permission\Models\Role::withCount('users')->get() as $role)
                                @php
                                    $colors = ['super-admin'=>'badge-approved','end-user'=>'badge-enduser','procurement'=>'badge-procurement','fa-ii'=>'badge-faii'];
                                    $badgeClass = $colors[strtolower(str_replace(' ','-',$role->name))] ?? 'badge-enduser';
                                    $activeCount = $role->users()->where('is_approved', true)->count();
                                @endphp
                                <tr class="border-b border-gray-50 hover:bg-gray-50">
                                    <td class="px-5 py-3">
                                        <span class="role-badge {{ $badgeClass }}">• {{ $role->name }}</span>
                                    </td>
                                    <td class="px-5 py-3 font-semibold">{{ $role->users_count }}</td>
                                    <td class="px-5 py-3 font-semibold">{{ $activeCount }}</td>
                                    <td class="px-5 py-3">
                                        <span class="role-label status-all-active">• All Active</span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <a href="{{ route('admin.users.index') }}">
                                            <button class="btn-view-users">View Users</button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Recent System Activity --}}
                <div class="w-full lg:w-72 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center justify-between px-4 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-800 text-sm">Recent System Activity</h3>
                        <a href="{{ route('admin.reports.index') }}" class="text-xs text-blue-600 hover:underline font-semibold">View All</a>
                    </div>
                    <div class="px-4 py-3 space-y-3 text-xs text-gray-700">
                        <div class="flex gap-2">
                            <span class="activity-dot dot-green mt-1"></span>
                            <div><span class="font-semibold">New user account created</span><br><span class="text-gray-400">Today, 9:14 AM</span></div>
                        </div>
                        <div class="flex gap-2">
                            <span class="activity-dot dot-blue mt-1"></span>
                            <div><span class="font-semibold">Account approved</span><br><span class="text-gray-400">Today, 8:52 AM</span></div>
                        </div>
                        <div class="flex gap-2">
                            <span class="activity-dot dot-red mt-1"></span>
                            <div><span class="font-semibold">Account suspended</span><br><span class="text-gray-400">Today, 8:10 AM</span></div>
                        </div>
                        <div class="flex gap-2">
                            <span class="activity-dot dot-yellow mt-1"></span>
                            <div><span class="font-semibold">Failed login attempt</span><br><span class="text-gray-400">Yesterday, 11:45 PM</span></div>
                        </div>
                        <div class="flex gap-2">
                            <span class="activity-dot dot-purple mt-1"></span>
                            <div><span class="font-semibold">Permission updated — FA II role modified</span><br><span class="text-gray-400">Yesterday, 4:20 PM</span></div>
                        </div>
                        <div class="flex gap-2">
                            <span class="activity-dot dot-gray mt-1"></span>
                            <div><span class="font-semibold">System backup completed successfully</span><br><span class="text-gray-400">Yesterday, 2:00 AM</span></div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Pending Account Requests --}}
            @php $pendingUsers = \App\Models\User::where('is_approved', false)->latest()->take(10)->get(); @endphp
            @if($pendingUsers->count())
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        ⏳ Pending Account Requests
                    </h3>
                    <span class="pending-badge">• {{ $pendingUsers->count() }} Pending</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs text-blue-700 font-bold border-b border-gray-100 bg-blue-50">
                                <th class="px-5 py-3">Name</th>
                                <th class="px-5 py-3">Email</th>
                                <th class="px-5 py-3">Requested Role</th>
                                <th class="px-5 py-3">Division</th>
                                <th class="px-5 py-3">Date Requested</th>
                                <th class="px-5 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingUsers as $u)
                            <tr class="border-b border-gray-50 hover:bg-gray-50">
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                            {{ strtoupper(substr($u->firstname,0,1).substr($u->lastname,0,1)) }}
                                        </div>
                                        <span class="font-medium">{{ $u->firstname }} {{ $u->lastname }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3 text-gray-500">{{ $u->email }}</td>
                                <td class="px-5 py-3">
                                    <span class="role-badge badge-enduser">{{ $u->getRoleNames()->first() ?? 'N/A' }}</span>
                                </td>
                                <td class="px-5 py-3 text-gray-500">{{ $u->division ?? '—' }}</td>
                                <td class="px-5 py-3 text-gray-500">{{ $u->created_at->format('M d, Y') }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex gap-2 items-center">
                                        <form method="POST" action="{{ route('admin.users.approve', $u) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="approve-btn">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline"
                                              onsubmit="return confirm('Reject and delete this user?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="reject-btn">Rejected</button>
                                        </form>
                                        <button class="view-btn">View</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>