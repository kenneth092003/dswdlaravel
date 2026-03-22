<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Step 1 – Activity Proposal Approval – PROMIS</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy: #0f1c2e;
            --navy2: #162436;
            --accent: #3b82f6;
            --gold: #f59e0b;
            --green: #10b981;
            --red: #ef4444;
            --purple: #8b5cf6;
            --text: #e2e8f0;
            --muted: #64748b;
            --border: rgba(255,255,255,0.07);
            --card: rgba(255,255,255,0.04);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--navy);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 220px;
            min-height: 100vh;
            background: var(--navy2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-brand .app-name {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.12em;
            color: var(--accent);
            text-transform: uppercase;
        }

        .sidebar-brand .app-sub {
            font-size: 10px;
            color: var(--muted);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .nav-section {
            padding: 20px 12px 6px;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.1em;
            color: var(--muted);
            text-transform: uppercase;
            padding: 0 8px;
            margin-bottom: 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 400;
            color: #94a3b8;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
            margin-bottom: 2px;
        }

        .nav-item:hover {
            background: var(--card);
            color: var(--text);
        }

        .nav-item.active {
            background: rgba(59,130,246,0.15);
            color: var(--accent);
            font-weight: 500;
        }

        .nav-item svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .badge {
            margin-left: auto;
            background: var(--accent);
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 20px;
            font-family: 'DM Mono', monospace;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 400;
            color: #94a3b8;
            cursor: pointer;
            transition: all 0.15s;
            background: none;
            border: none;
            font-family: 'DM Sans', sans-serif;
            text-align: left;
        }

        .logout-btn:hover {
            background: rgba(239,68,68,0.1);
            color: var(--red);
        }

        .logout-btn svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px 12px;
            border-top: 1px solid var(--border);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            background: var(--card);
            margin-bottom: 10px;
        }

        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--purple));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            flex-shrink: 0;
        }

        .user-info .name {
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
        }

        .user-info .role-tag {
            font-size: 11px;
            color: var(--accent);
            font-weight: 500;
        }

        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .topbar {
            height: 60px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            background: var(--navy2);
            flex-shrink: 0;
        }

        .breadcrumb {
            font-size: 12px;
            color: var(--muted);
        }

        .breadcrumb span {
            color: var(--text);
            font-weight: 500;
        }

        .page-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-user {
            font-size: 13px;
            color: var(--text);
            font-weight: 500;
            text-align: right;
        }

        .topbar-role {
            font-size: 11px;
            color: var(--accent);
        }

        .steps-nav {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            padding: 0 0 8px;
            border-bottom: 1px solid var(--border);
        }

        .step-tab {
            padding: 10px 14px;
            border-radius: 12px;
            background: rgba(255,255,255,0.04);
            border: 1px solid transparent;
            color: var(--muted);
            font-size: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .step-tab.active {
            background: rgba(59,130,246,0.15);
            border-color: rgba(59,130,246,0.25);
            color: var(--accent);
        }

        .step-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
            font-size: 11px;
            font-weight: 600;
            color: var(--text);
        }

        .content-inner {
            padding: 28px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px 22px;
            position: relative;
            overflow: hidden;
            transition: transform 0.15s, border-color 0.15s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: rgba(255,255,255,0.14);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 12px 12px 0 0;
        }

        .stat-card.blue::before { background: var(--accent); }
        .stat-card.gold::before { background: var(--gold); }
        .stat-card.green::before { background: var(--green); }
        .stat-card.red::before { background: var(--red); }

        .stat-number {
            font-size: 32px;
            font-weight: 600;
            color: var(--text);
            font-family: 'DM Mono', monospace;
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-label {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 7px 14px;
            font-size: 12.5px;
            color: var(--muted);
        }

        .search-box svg {
            width: 14px;
            height: 14px;
        }

        .table-wrap {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: rgba(255,255,255,0.03);
            border-bottom: 1px solid var(--border);
        }

        th {
            padding: 12px 18px;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            text-align: left;
        }

        td {
            padding: 14px 18px;
            font-size: 13px;
            color: var(--text);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tbody tr {
            transition: background 0.12s;
        }

        tbody tr:hover {
            background: rgba(255,255,255,0.03);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            background: rgba(59,130,246,0.15);
            color: #93c5fd;
        }

        .action-btn {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 8px;
            background: rgba(59,130,246,0.15);
            color: #93c5fd;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
        }

        .empty-icon {
            font-size: 36px;
            margin-bottom: 12px;
            opacity: 0.4;
        }

        .empty-text {
            font-size: 13px;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="app-name">PROMIS v5</div>
        <div class="app-sub">Procurement ERP</div>
    </div>

    <div class="nav-section">
        <div class="nav-label">Main Menu</div>
        <a href="{{ route('procurement.dashboard') }}" class="nav-item active">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
    </div>

    <div class="nav-section">
        <div class="nav-label">Step 1 - Approval</div>
        <a href="{{ route('procurement.dashboard') }}" class="nav-item active">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m-6 4h6m-6 4h6M5 6h14M5 18h14"/></svg>
            Activity Proposals
            <span class="badge">{{ $forApprovalCount ?? 0 }}</span>
        </a>
    </div>

    <div class="nav-section">
        <div class="nav-label">Step 2 - BAC Processing</div>
        <a href="{{ route('procurement.step2') }}" class="nav-item {{ request()->routeIs('procurement.step2') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/></svg>
            Incoming PR
            <span class="badge">0</span>
        </a>
    </div>

    <div class="nav-section">
        <div class="nav-label">Step 3 - Sign PR</div>
        <a href="{{ route('procurement.step3') }}" class="nav-item {{ request()->routeIs('procurement.step3') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Sign Purchase Requests
        </a>
    </div>

    <div class="nav-section">
        <div class="nav-label">Records</div>
        <a href="#" class="nav-item">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
            Completed Documents
        </a>
        <a href="#" class="nav-item">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            History
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="avatar">{{ substr(auth()->user()->firstname, 0, 1) }}{{ substr(auth()->user()->lastname, 0, 1) }}</div>
            <div class="user-info">
                <div class="name">{{ auth()->user()->firstname }}</div>
                <div class="role-tag">Procurement</div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <div>
            <div class="breadcrumb">Procurement › <span>Step 1</span></div>
            <div class="page-title">Step 1 – Activity Proposal Approval</div>
        </div>
        <div class="topbar-right">
            <div>
                <div class="topbar-user">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</div>
                <div class="topbar-role">Procurement</div>
            </div>
            <div class="avatar">{{ substr(auth()->user()->firstname, 0, 1) }}{{ substr(auth()->user()->lastname, 0, 1) }}</div>
        </div>
    </div>

    <div class="content-inner">
        <div class="steps-nav">
            <a href="{{ route('procurement.dashboard') }}" class="step-tab">
                <span class="step-badge">1</span>
                Overview
            </a>
            <a href="{{ route('procurement.dashboard') }}" class="step-tab active">
                <span class="step-badge">2</span>
                Step 1 - Approve Proposals
            </a>
            <a href="{{ route('procurement.step2') }}" class="step-tab {{ request()->routeIs('procurement.step2') ? 'active' : '' }}">
                <span class="step-badge">3</span>
                Step 2 - BAC Processing
            </a>
            <a href="{{ route('procurement.step3') }}" class="step-tab {{ request()->routeIs('procurement.step3') ? 'active' : '' }}">
                <span class="step-badge">4</span>
                Step 3 - Sign PR
            </a>
        </div>

        <div class="stats-grid">
            <div class="stat-card blue">
                <div class="stat-number">{{ $forApprovalCount ?? 0 }}</div>
                <div class="stat-label">For Your Approval</div>
            </div>
            <div class="stat-card gold">
                <div class="stat-number">{{ $approvedThisMonth ?? 0 }}</div>
                <div class="stat-label">Approved This Month</div>
            </div>
            <div class="stat-card green">
                <div class="stat-number">{{ $returnedCount ?? 0 }}</div>
                <div class="stat-label">Returned to End User</div>
            </div>
            <div class="stat-card red">
                <div class="stat-number">{{ $processedCount ?? 0 }}</div>
                <div class="stat-label">Total Processed</div>
            </div>
        </div>

        <div class="section-header">
            <div class="section-title">Proposals Awaiting Approval</div>
            <div class="search-box">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Submitted purchase requests
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>DOC NO.</th>
                        <th>TITLE</th>
                        <th>END USER</th>
                        <th>DATE FILED</th>
                        <th>AMOUNT</th>
                        <th>STATUS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                        <tr>
                            <td>{{ $request->pr_number ?? '-' }}</td>
                            <td>
                                <div>{{ $request->purpose ?? '-' }}</div>
                                <div style="font-size:11px;color:#94a3b8;margin-top:4px;">
                                    {{ $request->office_department ?? '-' }}
                                </div>
                            </td>
                            <td>
                                {{ $request->user ? $request->user->firstname . ' ' . $request->user->lastname : 'N/A' }}
                            </td>
                            <td>
                                {{ $request->request_date ? \Carbon\Carbon::parse($request->request_date)->format('M d, Y') : '-' }}
                            </td>
                            <td>₱{{ number_format((float) ($request->total_amount ?? 0), 2) }}</td>
                            <td>
                                <span class="status-pill">
                                    {{ ucwords(str_replace('_', ' ', $request->status)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('procurement.requests.show', $request->id) }}" class="action-btn">Review</a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon">📄</div>
                                    <div class="empty-text">No submitted purchase requests found.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
