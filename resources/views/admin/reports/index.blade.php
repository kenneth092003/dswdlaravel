<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Audit Logs
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

        .activity-dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; margin-top:4px; }
        .dot-green  { background:#22c55e; }
        .dot-blue   { background:#3b82f6; }
        .dot-red    { background:#ef4444; }
        .dot-yellow { background:#f59e0b; }
        .dot-purple { background:#a855f7; }
        .dot-gray   { background:#9ca3af; }

        .type-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
        }
        .badge-registration { background:#d1fae5; color:#065f46; }
        .badge-approval     { background:#dbeafe; color:#1e40af; }
        .badge-pending      { background:#fef3c7; color:#92400e; }
        .badge-deletion     { background:#fee2e2; color:#991b1b; }

        thead th { font-size:0.78rem; font-weight:700; color:#1d4ed8; }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Tab navigation --}}
            <div class="tab-nav flex gap-1 bg-white border border-gray-200 rounded-lg p-1 shadow-sm w-full overflow-x-auto">
                <a href="{{ route('dashboard') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Overview</div>
                    <div class="text-xs font-normal text-gray-400">System snapshot</div>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Account Management</div>
                    <div class="text-xs font-normal text-gray-400">Users &amp; accounts</div>
                </a>
                {{-- ✅ Fixed: attendance.index na --}}
                <a href="{{ route('admin.attendance.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Attendance</div>
                    <div class="text-xs font-normal text-gray-400">Login &amp; logout logs</div>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Report Issue</div>
                    <div class="text-xs font-normal text-gray-400">Submit system issues</div>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="active flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold transition">
                    <div class="font-bold">Audit Logs</div>
                    <div class="text-xs font-normal opacity-80">Activity trail</div>
                </a>
            </div>

            {{-- Summary cards --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <p class="text-xs text-gray-500 font-medium">Total Events</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $activities->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">All time</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <p class="text-xs text-gray-500 font-medium">Today's Events</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">
                        {{ $activities->filter(fn($a) => $a['time']->isToday())->count() }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Since midnight</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <p class="text-xs text-gray-500 font-medium">Approvals</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">
                        {{ $activities->filter(fn($a) => $a['type'] === 'Approval')->count() }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Accounts approved</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <p class="text-xs text-gray-500 font-medium">Pending</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">
                        {{ $activities->filter(fn($a) => $a['type'] === 'Pending')->count() }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Awaiting approval</p>
                </div>
            </div>

            {{-- Activity Table --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">All Activity Logs</h3>
                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded-full">
                        {{ $activities->count() }} events
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left border-b border-gray-100 bg-blue-50">
                                <th class="px-5 py-3">#</th>
                                <th class="px-5 py-3">Event</th>
                                <th class="px-5 py-3">Type</th>
                                <th class="px-5 py-3">Performed By</th>
                                <th class="px-5 py-3">Date & Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $i => $activity)
                            @php
                                $badgeMap = [
                                    'Registration' => 'badge-registration',
                                    'Approval'     => 'badge-approval',
                                    'Pending'      => 'badge-pending',
                                    'Deletion'     => 'badge-deletion',
                                ];
                                $badgeClass = $badgeMap[$activity['type']] ?? 'badge-pending';
                                $time = $activity['time'];
                                $timeLabel = $time->isToday()
                                    ? 'Today, ' . $time->format('g:i A')
                                    : ($time->isYesterday()
                                        ? 'Yesterday, ' . $time->format('g:i A')
                                        : $time->format('M d, Y g:i A'));
                            @endphp
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                <td class="px-5 py-3 text-gray-400 font-mono text-xs">{{ $i + 1 }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="activity-dot {{ $activity['dot'] }}"></span>
                                        <span class="font-medium text-gray-800">{{ $activity['event'] }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="type-badge {{ $badgeClass }}">{{ $activity['type'] }}</span>
                                </td>
                                <td class="px-5 py-3 text-gray-500">{{ $activity['performed_by'] }}</td>
                                <td class="px-5 py-3 text-gray-400 text-xs">{{ $timeLabel }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-gray-400 text-sm">
                                    No activity logs found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>