<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FAII Dashboard – PROMIS</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:    #0f1c2e;
            --navy2:   #162436;
            --accent:  #3b82f6;
            --gold:    #f59e0b;
            --green:   #10b981;
            --red:     #ef4444;
            --purple:  #8b5cf6;
            --text:    #e2e8f0;
            --muted:   #64748b;
            --border:  rgba(255,255,255,0.07);
            --card:    rgba(255,255,255,0.04);
        }

        body { font-family: 'DM Sans', sans-serif; background: var(--navy); color: var(--text); min-height: 100vh; display: flex; }

        /* SIDEBAR */
        .sidebar { width: 220px; min-height: 100vh; background: var(--navy2); border-right: 1px solid var(--border); display: flex; flex-direction: column; flex-shrink: 0; }
        .sidebar-brand { padding: 24px 20px 20px; border-bottom: 1px solid var(--border); }
        .sidebar-brand .app-name { font-size: 13px; font-weight: 600; letter-spacing: 0.12em; color: var(--accent); text-transform: uppercase; }
        .sidebar-brand .app-sub { font-size: 10px; color: var(--muted); letter-spacing: 0.08em; text-transform: uppercase; margin-top: 2px; }
        .nav-section { padding: 20px 12px 6px; }
        .nav-label { font-size: 10px; font-weight: 500; letter-spacing: 0.1em; color: var(--muted); text-transform: uppercase; padding: 0 8px; margin-bottom: 6px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: 8px; font-size: 13.5px; font-weight: 400; color: #94a3b8; cursor: pointer; transition: all 0.15s; text-decoration: none; margin-bottom: 2px; }
        .nav-item:hover { background: var(--card); color: var(--text); }
        .nav-item.active { background: rgba(59,130,246,0.15); color: var(--accent); font-weight: 500; }
        .nav-item svg { width: 16px; height: 16px; flex-shrink: 0; }
        .badge { margin-left: auto; background: var(--accent); color: #fff; font-size: 10px; font-weight: 600; padding: 2px 7px; border-radius: 20px; font-family: 'DM Mono', monospace; }

        .logout-btn { display: flex; align-items: center; gap: 10px; width: 100%; padding: 9px 12px; border-radius: 8px; font-size: 13.5px; font-weight: 400; color: #94a3b8; cursor: pointer; transition: all 0.15s; background: none; border: none; font-family: 'DM Sans', sans-serif; text-align: left; }
        .logout-btn:hover { background: rgba(239,68,68,0.1); color: var(--red); }
        .logout-btn svg { width: 16px; height: 16px; flex-shrink: 0; }

        .sidebar-footer { margin-top: auto; padding: 16px 12px; border-top: 1px solid var(--border); }
        .user-card { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; background: var(--card); margin-bottom: 10px; }
        .avatar { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), var(--purple)); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; color: #fff; flex-shrink: 0; }
        .user-info .name { font-size: 13px; font-weight: 500; color: var(--text); }
        .user-info .role-tag { font-size: 11px; color: var(--accent); font-weight: 500; }

        /* MAIN */
        .main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .topbar { height: 60px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 28px; background: var(--navy2); flex-shrink: 0; }
        .breadcrumb { font-size: 12px; color: var(--muted); }
        .breadcrumb span { color: var(--text); font-weight: 500; }
        .page-title { font-size: 15px; font-weight: 600; color: var(--text); }
        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .topbar-user { font-size: 13px; color: var(--text); font-weight: 500; text-align: right; }
        .topbar-role { font-size: 11px; color: var(--accent); }

        /* PAGES */
        .page { display: none; flex: 1; overflow-y: auto; }
        .page.active { display: block; }
        .page-center { display: none; flex: 1; align-items: center; justify-content: center; flex-direction: column; gap: 12px; color: var(--muted); text-align: center; padding: 60px; }
        .page-center.active { display: flex; }
        .page-center-icon { font-size: 48px; opacity: 0.3; }
        .page-center h2 { font-size: 18px; color: var(--text); font-weight: 600; }
        .page-center p { font-size: 13px; max-width: 300px; line-height: 1.6; }

        /* DASHBOARD CONTENT */
        .content-inner { padding: 28px; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
        .stat-card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 20px 22px; position: relative; overflow: hidden; transition: transform 0.15s, border-color 0.15s; }
        .stat-card:hover { transform: translateY(-2px); border-color: rgba(255,255,255,0.14); }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; border-radius: 12px 12px 0 0; }
        .stat-card.blue::before  { background: var(--accent); }
        .stat-card.gold::before  { background: var(--gold); }
        .stat-card.green::before { background: var(--green); }
        .stat-card.red::before   { background: var(--red); }
        .stat-number { font-size: 32px; font-weight: 600; color: var(--text); font-family: 'DM Mono', monospace; line-height: 1; margin-bottom: 6px; }
        .stat-label { font-size: 11px; font-weight: 500; letter-spacing: 0.08em; text-transform: uppercase; color: var(--muted); }

        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .section-title { font-size: 14px; font-weight: 600; color: var(--text); }
        .search-box { display: flex; align-items: center; gap: 8px; background: var(--card); border: 1px solid var(--border); border-radius: 8px; padding: 7px 14px; font-size: 12.5px; color: var(--muted); }
        .search-box svg { width: 14px; height: 14px; }

        .table-wrap { background: var(--card); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: rgba(255,255,255,0.03); border-bottom: 1px solid var(--border); }
        th { padding: 12px 18px; font-size: 10.5px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); text-align: left; }
        td { padding: 14px 18px; font-size: 13px; color: var(--text); border-bottom: 1px solid var(--border); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tbody tr { transition: background 0.12s; }
        tbody tr:hover { background: rgba(255,255,255,0.03); }

        .empty-state { text-align: center; padding: 60px 20px; color: var(--muted); }
        .empty-icon { font-size: 36px; margin-bottom: 12px; opacity: 0.4; }
        .empty-text { font-size: 13px; }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="app-name">PROMIS v5</div>
        <div class="app-sub">Procurement ERP</div>
    </div>

    <div class="nav-section">
        <div class="nav-label">Overview</div>
        <a href="#" class="nav-item active" onclick="showPage('dashboard', this, 'Dashboard', 'Management Dashboard')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
        <a href="#" class="nav-item" onclick="showPage('tracker', this, 'Transaction Tracker', 'Transaction Tracker')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Transaction Tracker
            <span class="badge">0</span>
        </a>
    </div>

    <div class="nav-section">
        <div class="nav-label">My Work</div>
        <a href="#" class="nav-item" onclick="showPage('workspace', this, 'My Workspace', 'My Workspace')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            My Workspace
            <span class="badge">0</span>
        </a>
    </div>

    <div class="nav-section">
        <div class="nav-label">Records</div>
        <a href="#" class="nav-item" onclick="showPage('vault', this, 'Document Vault', 'Document Vault')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
            Document Vault
        </a>
        <a href="#" class="nav-item" onclick="showPage('archive', this, 'Archive History', 'Archive History')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Archive History
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="avatar">{{ substr(auth()->user()->firstname, 0, 1) }}{{ substr(auth()->user()->lastname, 0, 1) }}</div>
            <div class="user-info">
                <div class="name">{{ auth()->user()->firstname }}</div>
                <div class="role-tag">FA II</div>
            </div>
        </div>

        {{-- Breeze Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>

<!-- MAIN -->
<div class="main">

    <!-- TOP BAR -->
    <div class="topbar">
        <div>
            <div class="breadcrumb">PROMIS v5 › <span id="breadcrumb-text">Dashboard</span></div>
            <div class="page-title" id="topbar-title">Management Dashboard</div>
        </div>
        <div class="topbar-right">
            <div>
                <div class="topbar-user">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</div>
                <div class="topbar-role">FA II</div>
            </div>
            <div class="avatar">{{ substr(auth()->user()->firstname, 0, 1) }}{{ substr(auth()->user()->lastname, 0, 1) }}</div>
        </div>
    </div>

    {{-- DASHBOARD --}}
    <div class="page active" id="page-dashboard">
        <div class="content-inner">
            <div class="stats-grid">
                <div class="stat-card blue">
                    <div class="stat-number">0</div>
                    <div class="stat-label">Active Requests</div>
                </div>
                <div class="stat-card gold">
                    <div class="stat-number">0</div>
                    <div class="stat-label">With Procurement</div>
                </div>
                <div class="stat-card green">
                    <div class="stat-number">0</div>
                    <div class="stat-label">With FA II</div>
                </div>
                <div class="stat-card red">
                    <div class="stat-number">0</div>
                    <div class="stat-label">With Findings</div>
                </div>
            </div>

            <div class="section-header">
                <div class="section-title">Active Procurement Pipeline</div>
                <div class="search-box">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search ID or title...
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Document ID</th>
                            <th>Activity / Description</th>
                            <th>Current Stage</th>
                            <th>Lane</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon">📋</div>
                                    <div class="empty-text">No active requests yet. Documents submitted by other roles will appear here.</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- TRANSACTION TRACKER --}}
    <div class="page-center" id="page-tracker">
        <div class="page-center-icon">📊</div>
        <h2>Transaction Tracker</h2>
        <p>Track all transactions assigned to FA II. This section will be available once transactions are submitted.</p>
    </div>

    {{-- MY WORKSPACE --}}
    <div class="page-center" id="page-workspace">
        <div class="page-center-icon">💼</div>
        <h2>My Workspace</h2>
        <p>Your personal workspace for managing assigned tasks and documents.</p>
    </div>

    {{-- DOCUMENT VAULT --}}
    <div class="page-center" id="page-vault">
        <div class="page-center-icon">🗄️</div>
        <h2>Document Vault</h2>
        <p>Securely stored documents and files related to FA II processes.</p>
    </div>

    {{-- ARCHIVE HISTORY --}}
    <div class="page-center" id="page-archive">
        <div class="page-center-icon">🕐</div>
        <h2>Archive History</h2>
        <p>View all archived and completed transactions handled by FA II.</p>
    </div>

</div>

<script>
    function showPage(pageId, el, breadcrumb, title) {
        // hide all pages
        document.querySelectorAll('.page, .page-center').forEach(p => {
            p.classList.remove('active');
        });

        // show target
        const target = document.getElementById('page-' + pageId);
        if (target) target.classList.add('active');

        // update nav active state
        document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
        if (el) el.classList.add('active');

        // update topbar
        document.getElementById('breadcrumb-text').textContent = breadcrumb;
        document.getElementById('topbar-title').textContent = title;
    }
</script>

</body>
</html>