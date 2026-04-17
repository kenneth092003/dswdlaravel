<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Support Complaints
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

        .issue-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 28px 32px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        }

        .issue-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .issue-row:last-child {
            border-bottom: none;
        }
        .issue-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 5px;
        }
        .dot-open {
            background: #f59e0b;
        }
        .dot-resolved {
            background: #22c55e;
        }
        .dot-inprog {
            background: #3b82f6;
        }
        .alert-success {
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            color: #065f46;
            border-radius: 8px;
            padding: 14px 18px;
            font-size: 0.88rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="tab-nav flex gap-1 bg-white border border-gray-200 rounded-lg p-1 shadow-sm w-full overflow-x-auto">
                <a href="{{ route('dashboard') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Overview</div>
                    <div class="text-xs font-normal text-gray-400">System snapshot</div>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Account Management</div>
                    <div class="text-xs font-normal text-gray-400">Users &amp; accounts</div>
                </a>
                <a href="{{ route('admin.attendance.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Attendance</div>
                    <div class="text-xs font-normal text-gray-400">Login &amp; logout logs</div>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="active flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold transition">
                    <div class="font-bold">Report Issue</div>
                    <div class="text-xs font-normal opacity-80">Submit system issues</div>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex-1 text-center px-4 py-3 rounded-md text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">
                    <div class="font-bold">Audit Logs</div>
                    <div class="text-xs font-normal text-gray-400">Activity trail</div>
                </a>
            </div>

            @if(session('status'))
                <div class="alert-success">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" fill="#34d399"/>
                        <path d="M7 13l3 3 7-7" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            <div class="issue-card">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div>
                        <p class="text-[0.78rem] font-bold uppercase tracking-[0.07em] text-gray-500 mb-3">Support Complaints</p>
                        
                    </div>
                </div>

                <div class="mt-6">
                    @if(isset($recentIssues) && $recentIssues->count())
                        <div class="space-y-4">
                            @foreach($recentIssues as $issue)
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 md:p-5">
                                    <div class="flex flex-wrap items-start justify-between gap-3">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <p class="text-base font-bold text-slate-900">{{ $issue->subject }}</p>
                                                <span class="rounded-full bg-blue-100 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide text-blue-700">{{ $issue->status }}</span>
                                            </div>
                                            <p class="mt-1 text-xs text-slate-500">
                                                {{ $issue->issue_type }} • {{ \Carbon\Carbon::parse($issue->created_at)->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="rounded-full bg-rose-100 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide text-rose-700">
                                                {{ $issue->priority }}
                                            </span>

                                            <form method="POST" action="{{ route('admin.settings.destroy', $issue) }}" onsubmit="return confirm('Delete this support complaint?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 rounded-full bg-red-600 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-white transition hover:bg-red-700">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="mt-4 grid gap-2 text-sm text-slate-600 sm:grid-cols-2 lg:grid-cols-4">
                                        <p><span class="font-semibold text-slate-700">Reporter:</span> {{ $issue->reporter_name ?? $issue->reportedBy?->full_name ?? 'Anonymous' }}</p>
                                        <p><span class="font-semibold text-slate-700">Email:</span> {{ $issue->reporter_email ?? $issue->reportedBy?->email ?? 'Not provided' }}</p>
                                        <p><span class="font-semibold text-slate-700">Role:</span> {{ $issue->reporter_role ?? 'Not provided' }}</p>
                                        <p><span class="font-semibold text-slate-700">Module:</span> {{ $issue->affected_module ?? 'Not specified' }}</p>
                                    </div>

                                    <div class="mt-4 rounded-xl bg-white p-4 text-sm text-slate-700 leading-7 border border-slate-200">
                                        {{ $issue->description }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="text-4xl mb-2">📋</div>
                            <p class="text-sm text-gray-400">No reports submitted yet.</p>
                            <p class="text-xs text-gray-300 mt-1">Reports from the support page will appear here once submitted.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
