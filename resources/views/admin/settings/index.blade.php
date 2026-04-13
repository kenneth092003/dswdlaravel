<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Report Issue
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

        .form-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: #374151;
            display: block;
            margin-bottom: 6px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            padding: 9px 14px;
            font-size: 0.88rem;
            color: #111827;
            outline: none;
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px #bfdbfe;
        }
        .form-textarea { resize: vertical; min-height: 110px; }

        .btn-submit {
            background: #1d4ed8;
            color: #fff;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 10px 28px;
            border-radius: 7px;
            border: none;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-submit:hover { background: #1e40af; }

        .btn-reset {
            background: #f3f4f6;
            color: #374151;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 10px 20px;
            border-radius: 7px;
            border: 1px solid #d1d5db;
            cursor: pointer;
        }
        .btn-reset:hover { background: #e5e7eb; }

        .required { color: #ef4444; margin-left: 2px; }

        .priority-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
        }
        .priority-low      { background:#d1fae5; color:#065f46; }
        .priority-medium   { background:#fef3c7; color:#92400e; }
        .priority-high     { background:#fee2e2; color:#991b1b; }
        .priority-critical { background:#fce7f3; color:#9d174d; }

        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 14px 18px;
            font-size: 0.82rem;
            color: #1e40af;
        }
        .info-box svg { display: inline; vertical-align: middle; margin-right: 6px; }

        .section-title {
            font-size: 0.78rem;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f3f4f6;
        }

        .char-count {
            font-size: 0.72rem;
            color: #9ca3af;
            text-align: right;
            margin-top: 4px;
        }

        /* Success alert */
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

        /* Recent issues list */
        .issue-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .issue-row:last-child { border-bottom: none; }
        .issue-dot {
            width: 8px; height: 8px; border-radius: 50%;
            flex-shrink: 0; margin-top: 5px;
        }
        .dot-open     { background: #f59e0b; }
        .dot-resolved { background: #22c55e; }
        .dot-inprog   { background: #3b82f6; }
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

            {{-- Success message --}}
            @if(session('status'))
                <div class="alert-success">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" fill="#34d399"/>
                        <path d="M7 13l3 3 7-7" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Left: Form --}}
                <div class="lg:col-span-2 space-y-5">
                    <div class="issue-card">
                        <p class="section-title">Issue Details</p>

                        <div class="info-box mb-5">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" fill="#3b82f6"/>
                                <path d="M12 8v4m0 4h.01" stroke="#fff" stroke-width="2.2" stroke-linecap="round"/>
                            </svg>
                            Use this form to report bugs, system errors, or any issues you encounter. Your report will be logged and reviewed by the system administrator.
                        </div>

                        <form method="POST" action="{{ route('admin.settings.store') }}" onsubmit="return validateForm()">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                                {{-- Issue Type --}}
                                <div>
                                    <label class="form-label">Issue Type <span class="required">*</span></label>
                                    <select name="issue_type" class="form-select" required>
                                        <option value="" disabled selected>Select a category…</option>
                                        <option value="Bug / Error" {{ old('issue_type') == 'Bug / Error' ? 'selected' : '' }}>🐛 Bug / Error</option>
                                        <option value="Login / Access" {{ old('issue_type') == 'Login / Access' ? 'selected' : '' }}>🔐 Login / Access</option>
                                        <option value="Performance" {{ old('issue_type') == 'Performance' ? 'selected' : '' }}>⚡ Performance</option>
                                        <option value="Data Issue" {{ old('issue_type') == 'Data Issue' ? 'selected' : '' }}>📊 Data Issue</option>
                                        <option value="UI / Display" {{ old('issue_type') == 'UI / Display' ? 'selected' : '' }}>🖥️ UI / Display</option>
                                        <option value="Feature Request" {{ old('issue_type') == 'Feature Request' ? 'selected' : '' }}>💡 Feature Request</option>
                                        <option value="Other" {{ old('issue_type') == 'Other' ? 'selected' : '' }}>📋 Other</option>
                                    </select>
                                    @error('issue_type')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Priority --}}
                                <div>
                                    <label class="form-label">Priority <span class="required">*</span></label>
                                    <select name="priority" class="form-select" required>
                                        <option value="" disabled selected>Select priority…</option>
                                        <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>🟢 Low</option>
                                        <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>🟡 Medium</option>
                                        <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>🔴 High</option>
                                        <option value="Critical" {{ old('priority') == 'Critical' ? 'selected' : '' }}>🚨 Critical</option>
                                    </select>
                                    @error('priority')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Subject --}}
                            <div class="mb-5">
                                <label class="form-label">Subject / Title <span class="required">*</span></label>
                                <input type="text" name="subject" class="form-input"
                                    placeholder="Brief description of the issue…"
                                    value="{{ old('subject') }}"
                                    maxlength="150"
                                    oninput="updateChar(this, 'subjectCount', 150)"
                                    required />
                                <p class="char-count"><span id="subjectCount">0</span> / 150</p>
                                @error('subject')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="mb-5">
                                <label class="form-label">Description <span class="required">*</span></label>
                                <textarea name="description" class="form-textarea"
                                    placeholder="Describe the issue in detail. Include steps to reproduce, what you expected vs what happened, and any error messages you saw…"
                                    maxlength="2000"
                                    oninput="updateChar(this, 'descCount', 2000)"
                                    required>{{ old('description') }}</textarea>
                                <p class="char-count"><span id="descCount">0</span> / 2000</p>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Page / Module --}}
                            <div class="mb-5">
                                <label class="form-label">Affected Page / Module</label>
                                <input type="text" name="affected_module" class="form-input"
                                    placeholder="e.g. Attendance page, User Management, Login…"
                                    value="{{ old('affected_module') }}" />
                            </div>

                            {{-- Reported By (auto-filled, read-only) --}}
                            <div class="mb-6">
                                <label class="form-label">Reported By</label>
                                <input type="text" class="form-input bg-gray-50 text-gray-500"
                                    value="{{ auth()->user()->firstname }} {{ auth()->user()->lastname }} ({{ auth()->user()->email }})"
                                    readonly />
                                <input type="hidden" name="reported_by" value="{{ auth()->id() }}" />
                            </div>

                            <div class="flex items-center gap-3">
                                <button type="submit" class="btn-submit">
                                    Submit Report
                                </button>
                                <button type="reset" class="btn-reset" onclick="resetCounts()">
                                    Clear Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Right: Info panel --}}
                <div class="space-y-5">

                    {{-- Priority Guide --}}
                    <div class="issue-card">
                        <p class="section-title">Priority Guide</p>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start gap-3">
                                <span class="priority-badge priority-low mt-0.5">Low</span>
                                <span class="text-gray-500 text-xs">Minor cosmetic issues, no workflow impact.</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="priority-badge priority-medium mt-0.5">Medium</span>
                                <span class="text-gray-500 text-xs">Feature partially broken, workaround available.</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="priority-badge priority-high mt-0.5">High</span>
                                <span class="text-gray-500 text-xs">Important feature broken, affects daily operations.</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="priority-badge priority-critical mt-0.5">Critical</span>
                                <span class="text-gray-500 text-xs">System down or data loss — needs immediate attention.</span>
                            </div>
                        </div>
                    </div>

                    {{-- Recent Reports --}}
                    <div class="issue-card">
                        <p class="section-title">Recent Reports</p>

                        @if(isset($recentIssues) && $recentIssues->count())
                            @foreach($recentIssues as $issue)
                            <div class="issue-row">
                                <span class="issue-dot
                                    {{ $issue->status === 'Resolved' ? 'dot-resolved' : ($issue->status === 'In Progress' ? 'dot-inprog' : 'dot-open') }}">
                                </span>
                                <div>
                                    <div class="text-sm font-semibold text-gray-800">{{ $issue->subject }}</div>
                                    <div class="text-xs text-gray-400">
                                        {{ $issue->issue_type }} •
                                        {{ \Carbon\Carbon::parse($issue->created_at)->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-6">
                                <div class="text-3xl mb-2">📋</div>
                                <p class="text-sm text-gray-400">No reports submitted yet.</p>
                                <p class="text-xs text-gray-300 mt-1">Reports will appear here once submitted.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Contact --}}
                    <div class="issue-card">
                        <p class="section-title">Need Urgent Help?</p>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            For critical system failures, contact the system administrator directly:
                        </p>
                        <p class="text-sm font-semibold text-blue-700 mt-2">admin@example.com</p>
                        <p class="text-xs text-gray-400 mt-1">DSWD — Dept. of Social Welfare and Development</p>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        function updateChar(el, countId, max) {
            document.getElementById(countId).textContent = el.value.length;
        }
        function resetCounts() {
            document.getElementById('subjectCount').textContent = '0';
            document.getElementById('descCount').textContent = '0';
        }
        function validateForm() {
            const subject = document.querySelector('[name="subject"]').value.trim();
            const desc    = document.querySelector('[name="description"]').value.trim();
            if (!subject || !desc) {
                alert('Please fill in all required fields.');
                return false;
            }
            return true;
        }
        // Init char counts from old() values
        document.addEventListener('DOMContentLoaded', function () {
            const subjectEl = document.querySelector('[name="subject"]');
            const descEl    = document.querySelector('[name="description"]');
            if (subjectEl) document.getElementById('subjectCount').textContent = subjectEl.value.length;
            if (descEl)    document.getElementById('descCount').textContent    = descEl.value.length;
        });
    </script>

</x-app-layout>