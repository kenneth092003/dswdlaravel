<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Attendance
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
        .badge-enduser     { background:#dbeafe; color:#1e40af; }
        .badge-procurement { background:#ede9fe; color:#5b21b6; }
        .badge-faii        { background:#fef9c3; color:#92400e; }
        .badge-superadmin  { background:#fee2e2; color:#991b1b; }

        .status-in     { background:#d1fae5; color:#065f46; padding:3px 10px; border-radius:999px; font-size:0.72rem; font-weight:700; }
        .status-out    { background:#fee2e2; color:#991b1b; padding:3px 10px; border-radius:999px; font-size:0.72rem; font-weight:700; }
        .status-none   { background:#f3f4f6; color:#6b7280; padding:3px 10px; border-radius:999px; font-size:0.72rem; font-weight:700; }

        thead th { font-size:0.78rem; font-weight:700; color:#1d4ed8; }

        .avatar {
            width: 32px; height: 32px; border-radius:50%;
            background:#2563eb; color:#fff;
            display:inline-flex; align-items:center; justify-content:center;
            font-size:0.72rem; font-weight:700; flex-shrink:0;
        }

        .search-input {
            border:1px solid #d1d5db; border-radius:7px; padding:7px 14px;
            font-size:0.85rem; outline:none; width:220px;
        }
        .search-input:focus { border-color:#3b82f6; box-shadow:0 0 0 2px #bfdbfe; }

        .stat-card { min-width: 120px; }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">


            {{-- Tab navigation --}}
            <div class="tab-nav flex gap-1 bg-white border border-gray-200 rounded-lg p-1 shadow-sm w-full overflow-x-auto">
                <a href="/dashboard" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Overview</div>
                    <div class="text-xs font-normal text-gray-400">System snapshot</div>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Account Management</div>
                    <div class="text-xs font-normal text-gray-400">Users &amp; accounts</div>
                </a>
                {{-- ✅ Fixed: attendance.index na --}}
                <a href="{{ route('admin.attendance.index') }}" class="active flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold transition">
                    <div class="font-bold">Attendance</div>
                    <div class="text-xs font-normal opacity-80">Login &amp; logout logs</div>
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

            {{-- Stat cards --}}
            @php
                $totalLogs    = $attendances->count();
                $todayLogs    = $attendances->filter(fn($a) => \Carbon\Carbon::parse($a->login_at)->isToday())->count();
                $loggedIn     = $attendances->whereNull('logout_at')->count();
                $loggedOut    = $attendances->whereNotNull('logout_at')->count();
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="stat-card bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <p class="text-xs text-gray-500 font-medium">Total Records</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalLogs }}</p>
                    <p class="text-xs text-gray-400 mt-1">All attendance logs</p>
                </div>
                <div class="stat-card bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <p class="text-xs text-gray-500 font-medium">Today's Logins</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $todayLogs }}</p>
                    <p class="text-xs text-gray-400 mt-1">Logged in today</p>
                </div>
                <div class="stat-card bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <p class="text-xs text-gray-500 font-medium">Currently Online</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $loggedIn }}</p>
                    <p class="text-xs text-gray-400 mt-1">Still logged in</p>
                </div>
                <div class="stat-card bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <p class="text-xs text-gray-500 font-medium">Logged Out</p>
                    <p class="text-3xl font-bold text-red-500 mt-1">{{ $loggedOut }}</p>
                    <p class="text-xs text-gray-400 mt-1">Already logged out</p>
                </div>
            </div>

            {{-- Attendance Table --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">

                {{-- Toolbar --}}
                <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-gray-700">Attendance Logs</span>
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ $totalLogs }}
                        </span>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="text" id="search-input" placeholder="Search user…" class="search-input" oninput="searchTable()" />
                        {{-- ✅ Fixed: attendance.index na --}}
                        <a href="{{ route('admin.attendance.index') }}" class="text-xs text-blue-600 hover:underline font-semibold">Refresh</a>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm" id="attendance-table">
                        <thead>
                            <tr class="text-left border-b border-gray-100 bg-blue-50">
                                <th class="px-5 py-3">#</th>
                                <th class="px-5 py-3">Name</th>
                                <th class="px-5 py-3">Role</th>
                                <th class="px-5 py-3">Date</th>
                                <th class="px-5 py-3">🟢 Log In</th>
                                <th class="px-5 py-3">🔴 Log Out</th>
                                <th class="px-5 py-3">Duration</th>
                                <th class="px-5 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $i => $log)
                            @php
                                $user      = $log->user;
                                $roleName  = strtolower(str_replace([' ','_'], '-', $user->getRoleNames()->first() ?? ''));
                                $badgeMap  = ['super-admin'=>'badge-superadmin','end-user'=>'badge-enduser','procurement'=>'badge-procurement','fa-ii'=>'badge-faii'];
                                $badgeClass = $badgeMap[$roleName] ?? 'badge-enduser';
                                $initials  = strtoupper(substr($user->firstname,0,1).substr($user->lastname,0,1));
                                $avatarColors = ['bg-blue-600','bg-purple-600','bg-green-600','bg-rose-500','bg-amber-500'];
                                $color     = $avatarColors[$user->id % count($avatarColors)];
                                $loginAt   = \Carbon\Carbon::parse($log->login_at);
                                $logoutAt  = $log->logout_at ? \Carbon\Carbon::parse($log->logout_at) : null;
                                $duration  = $logoutAt ? $loginAt->diff($logoutAt)->format('%Hh %Im') : '—';
                            @endphp
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition attendance-row">
                                <td class="px-5 py-3 text-gray-400 font-mono text-xs">{{ $i + 1 }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="avatar {{ $color }}">{{ $initials }}</div>
                                        <div>
                                            <div class="font-semibold text-gray-800">{{ $user->firstname }} {{ $user->lastname }}</div>
                                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="role-badge {{ $badgeClass }}">{{ $user->getRoleNames()->first() ?? 'No Role' }}</span>
                                </td>
                                <td class="px-5 py-3 text-gray-500 text-xs">{{ $loginAt->format('M d, Y') }}</td>
                                <td class="px-5 py-3 font-semibold text-green-600">{{ $loginAt->format('h:i A') }}</td>
                                <td class="px-5 py-3 font-semibold text-red-500">
                                    {{ $logoutAt ? $logoutAt->format('h:i A') : '—' }}
                                </td>
                                <td class="px-5 py-3 text-gray-500 text-xs">{{ $duration }}</td>
                                <td class="px-5 py-3">
                                    @if($logoutAt)
                                        <span class="status-out">Logged Out</span>
                                    @else
                                        <span class="status-in">● Online</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-5 py-10 text-center text-gray-400 text-sm">
                                    No attendance records found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $attendances->links() }}
                </div>

            </div>
        </div>
    </div>

    <script>
        function searchTable() {
            const input = document.getElementById('search-input').value.toLowerCase();
            const rows  = document.querySelectorAll('.attendance-row');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(input) ? '' : 'none';
            });
        }
    </script>

</x-app-layout>