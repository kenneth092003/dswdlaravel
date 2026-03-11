<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Procurement Management System' }}</title>
    <style>
        :root{
            --blue:#0d4fb3;
            --blue-dark:#1f3f7d;
            --blue-soft:#d9e7ff;
            --border:#cfd6df;
            --bg:#eef2f6;
            --panel:#ffffff;
            --text:#263238;
            --muted:#6c7785;
            --success:#8cd57e;
            --warning:#f1c84b;
            --danger:#e57f7f;
        }

        *{box-sizing:border-box;margin:0;padding:0;}

        html, body{
            width:100%;
            height:100%;
            font-family:Arial, Helvetica, sans-serif;
            background:#f5f6f9;
            color:var(--text);
        }

        body{
            min-height:100vh;
        }

        .app-shell{
            width:100%;
            min-height:100vh;
            display:flex;
            flex-direction:column;
        }

        .topbar-line{
            height:12px;
            background:var(--blue);
            width:100%;
            flex-shrink:0;
        }

        .topbar{
            background:#efefef;
            border-bottom:1px solid #d77f7f;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:10px 18px;
            width:100%;
            flex-shrink:0;
        }

        .brand-wrap{
            display:flex;
            align-items:center;
            gap:14px;
            flex-wrap:wrap;
        }

        .brand-logo{
            width:58px;
            height:58px;
            border-radius:6px;
            background:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
            border:1px solid #d8d8d8;
        }

        .brand-logo img{
            width:100%;
            height:100%;
            object-fit:contain;
        }

        .brand-text small{
            display:block;
            color:#666;
            font-size:12px;
        }

        .brand-text strong{
            display:block;
            font-size:18px;
            margin-top:2px;
        }

        .bell{
            font-size:28px;
            color:#222;
            line-height:1;
        }

        .content-shell{
            display:flex;
            flex:1;
            min-height:0;
            width:100%;
            height:calc(100vh - 90px);
        }

        .sidebar{
            width:235px;
            min-width:235px;
            background:#f1f2f4;
            border-right:1px solid var(--border);
            display:flex;
            flex-direction:column;
            height:100%;
            position:sticky;
            top:0;
            overflow-y:auto;
        }

        .sidebar-title{
            background:var(--blue-dark);
            color:#fff;
            padding:10px 14px;
            font-weight:700;
            border-radius:0 0 12px 0;
            width:118px;
            margin:0 0 12px 0;
        }

        .menu-section{
            padding:0 12px 14px;
            flex:1;
        }

        .menu-label{
            color:#9aa3ad;
            font-size:12px;
            text-transform:uppercase;
            margin:8px 0 6px;
        }

        .menu-link{
            display:block;
            padding:4px 0;
            color:#4a5562;
            text-decoration:none;
            font-size:14px;
        }

        .menu-link:hover,
        .menu-link.active{
            color:var(--blue-dark);
            font-weight:700;
        }

        .sidebar-bottom{
            padding:12px;
            font-size:13px;
            color:#4a5562;
            border-top:1px solid var(--border);
            background:#e8eaed;
        }

        .main{
            flex:1;
            min-width:0;
            padding:10px 12px 18px;
            overflow-y:auto;
            height:100%;
        }

        .stats{
            display:grid;
            grid-template-columns:repeat(4, 1fr);
            gap:14px;
            margin-bottom:10px;
        }

        .stat-card{
            background:#fff;
            border:1px solid var(--border);
            border-radius:12px 12px 0 0;
            border-bottom:4px solid var(--blue-dark);
            padding:8px 12px 10px;
            min-height:82px;
        }

        .stat-title{
            font-size:13px;
            color:#444;
            margin-bottom:4px;
        }

        .stat-value{
            font-size:40px;
            line-height:1;
            margin:2px 0;
        }

        .stat-sub{
            font-size:12px;
            color:#555;
        }

        .panel{
            background:#fff;
            border:1px solid var(--border);
            border-radius:0 0 14px 14px;
            overflow:hidden;
        }

        .panel-header{
            background:var(--blue-dark);
            color:#fff;
            padding:12px 16px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:10px;
            font-weight:700;
        }

        .btn-primary{
            background:#fff;
            color:#1f3f7d;
            border:1px solid #dfe6ef;
            border-radius:8px;
            padding:6px 14px;
            font-size:12px;
            font-weight:700;
            text-decoration:none;
            display:inline-block;
        }

        .btn-outline{
            background:#fff;
            color:#4b5563;
            border:1px solid #bfc7d1;
            border-radius:8px;
            padding:8px 14px;
            font-size:12px;
            font-weight:700;
            text-decoration:none;
            display:inline-block;
            cursor:pointer;
        }

        .btn-red{
            background:#fff2f2;
            color:#ba2f2f;
            border:1px solid #efadad;
            border-radius:8px;
            padding:8px 14px;
            font-size:12px;
            font-weight:700;
            cursor:pointer;
        }

        .btn-green{
            background:#4b9f39;
            color:#fff;
            border:1px solid #408631;
            border-radius:8px;
            padding:8px 14px;
            font-size:12px;
            font-weight:700;
            cursor:pointer;
        }

        .btn-purple{
            background:#d9c8ff;
            color:#51339d;
            border:1px solid #b79ef5;
            border-radius:8px;
            padding:8px 14px;
            font-size:12px;
            font-weight:700;
            cursor:pointer;
        }

        .panel-body{
            padding:14px;
        }

        .tabs{
            display:flex;
            justify-content:space-around;
            font-size:14px;
            color:#3d4650;
            margin:2px 0 10px;
        }

        .table-wrap{
            width:100%;
            overflow:auto;
        }

        table{
            width:100%;
            border-collapse:collapse;
            font-size:13px;
        }

        th,td{
            padding:10px 8px;
            border-bottom:1px solid #eceff3;
            vertical-align:top;
        }

        th{
            color:#214b86;
            text-align:left;
            font-size:13px;
        }

        .doc-no{
            font-weight:700;
            color:#111827;
        }

        .muted{
            color:#8c97a5;
            font-size:12px;
        }

        .badge{
            display:inline-block;
            font-size:11px;
            padding:4px 10px;
            border-radius:999px;
            font-weight:700;
            white-space:nowrap;
        }

        .badge-draft{ background:#e7dcff; color:#7a54c7; }
        .badge-pending{ background:#ffe28f; color:#8a5b00; }
        .badge-approved{ background:#ccefc5; color:#2a7a2f; }
        .badge-returned,
        .badge-rejected{ background:#ffd3d3; color:#b53b3b; }
        .badge-processing,
        .badge-submitted_to_rd,
        .badge-bac_processing,
        .badge-signed_pr,
        .badge-validated_payment{ background:#dbe9ff; color:#2d5ca8; }

        .view-btn{
            border:1px solid #6c8bb3;
            border-radius:999px;
            padding:4px 16px;
            color:#2b4770;
            text-decoration:none;
            font-size:12px;
            display:inline-block;
            background:#fff;
        }

        .notice-row{
            min-height:54px;
            border-bottom:1px solid #dde3ea;
            display:flex;
            align-items:center;
            padding:0 16px;
            font-size:14px;
        }

        .wizard-overlay{
            background:rgba(107, 122, 138, 0.45);
            padding:24px;
            border-radius:16px;
        }

        .wizard{
            width:min(980px, 100%);
            margin:0 auto;
            background:#fff;
            border-radius:16px;
            overflow:hidden;
            border:1px solid #b9c6d8;
            box-shadow:0 20px 40px rgba(0,0,0,.18);
        }

        .wizard-header{
            background:var(--blue);
            color:#fff;
            padding:18px 20px 16px;
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
        }

        .wizard-title{
            font-size:18px;
            font-weight:700;
        }

        .wizard-sub{
            font-size:12px;
            opacity:.92;
            margin-top:6px;
        }

        .close-x{
            width:28px;
            height:28px;
            border-radius:8px;
            background:rgba(255,255,255,.25);
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
            font-size:20px;
            line-height:1;
            cursor:pointer;
        }

        .steps{
            background:#dfe9f8;
            padding:14px 28px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:10px;
        }

        .step{
            display:flex;
            align-items:center;
            gap:10px;
            flex:1;
            color:#224375;
            font-size:13px;
            font-weight:700;
        }

        .step:not(:last-child)::after{
            content:"";
            flex:1;
            height:1px;
            background:#9fb3d6;
            margin-left:6px;
        }

        .step-circle{
            width:32px;
            height:32px;
            border-radius:50%;
            border:2px solid #bdc7d6;
            background:#f8f8f8;
            color:#4b5563;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
            flex:0 0 auto;
        }

        .step.active .step-circle{
            background:#1f478f;
            color:#fff;
            border-color:#1f478f;
        }

        .step.done .step-circle{
            background:#a8e58f;
            border-color:#67b755;
            color:#1f5c1e;
        }

        .wizard-body{
            padding:22px 28px 18px;
            background:#f5f3ef;
        }

        .hint-box{
            background:#d6e2f6;
            border-radius:8px;
            padding:14px 16px;
            margin-bottom:18px;
            font-size:13px;
            color:#374151;
        }

        .section-title{
            color:#214b86;
            font-size:13px;
            font-weight:700;
            text-transform:uppercase;
            border-bottom:1px solid #c8d1dc;
            padding-bottom:6px;
            margin:16px 0 12px;
        }

        .grid-3{
            display:grid;
            grid-template-columns:repeat(3, 1fr);
            gap:12px;
        }

        .grid-2{
            display:grid;
            grid-template-columns:repeat(2, 1fr);
            gap:12px;
        }

        .field label{
            display:block;
            font-size:12px;
            font-weight:700;
            margin-bottom:5px;
            color:#222;
        }

        .field input,
        .field select,
        .field textarea{
            width:100%;
            border:1px solid #c7cfd8;
            background:#fff;
            border-radius:3px;
            padding:10px 9px;
            font-size:13px;
            font-family:inherit;
        }

        .field textarea{
            resize:vertical;
            min-height:90px;
        }

        .wizard-footer{
            border-top:1px solid #d6dce3;
            background:#f8f6f2;
            padding:12px 18px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:12px;
        }

        .footer-note{
            font-size:12px;
            color:#8b8f96;
        }

        .actions{
            display:flex;
            gap:8px;
            flex-wrap:wrap;
        }

        .lifecycle-box{
            background:#fff;
            border:1px solid #cfd6df;
            border-radius:6px;
            overflow:hidden;
        }

        .lifecycle-head{
            background:#b8cfef;
            color:#1b2b44;
            font-size:12px;
            font-weight:700;
            padding:7px 12px;
        }

        .lifecycle-item{
            display:flex;
            gap:12px;
            align-items:flex-start;
            padding:8px 12px;
            border-top:1px solid #e2e6eb;
            font-size:13px;
        }

        .life-num{
            width:24px;
            height:24px;
            border-radius:50%;
            background:#efefef;
            border:1px solid #b7bec8;
            color:#1e293b;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:12px;
            font-weight:700;
            flex:0 0 auto;
        }

        .life-num.active{ background:#ffe38d; border-color:#e1b841; }
        .life-num.done{ background:#ccefc5; border-color:#66b657; }

        .life-title{ font-weight:700; }

        .life-text{
            font-size:12px;
            color:#555;
            margin-top:2px;
        }

        .empty-card{
            min-height:160px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#7d8793;
            font-size:14px;
        }

        @media (max-width: 1024px){
            .stats{ grid-template-columns:repeat(2,1fr); }
            .grid-3{ grid-template-columns:1fr; }
            .grid-2{ grid-template-columns:1fr; }
            .content-shell{ flex-direction:column; height:auto; }
            .sidebar{ width:100%; min-width:100%; height:auto; position:relative; }
            .sidebar-title{ border-radius:0; width:100%; }
            .main{ height:auto; }
        }
    </style>
</head>
<body>
    <div class="app-shell">
        <div class="topbar-line"></div>

        <div class="topbar">
            <div class="brand-wrap">
                <div class="brand-logo">
                    <img src="{{ asset('images/dswd-logo.png') }}" alt="DSWD Logo" onerror="this.style.display='none'">
                </div>
                <div class="brand-text">
                    <small>Republic of the Philippines</small>
                    <strong>DSWD</strong>
                    <small>Dept. of Social Welfare and Development</small>
                </div>
                <div style="width:1px;height:52px;background:#c8ccd1;margin:0 8px;"></div>
                <div class="brand-text">
                    <small>Internal System</small>
                    <strong>Procurement Management System</strong>
                </div>
            </div>
            <div class="bell">🔔</div>
        </div>

        <div class="content-shell">
            <aside class="sidebar">
                <div class="sidebar-title">END USER</div>

                <div class="menu-section">
                    <div class="menu-label">Main Menu</div>
                    <a href="{{ route('enduser.dashboard') }}" class="menu-link {{ request()->routeIs('enduser.dashboard') ? 'active' : '' }}">Dashboard</a>

                    <div class="menu-label">Activity Proposals</div>
                    <a href="{{ route('enduser.requests.create') }}" class="menu-link {{ request()->routeIs('enduser.requests.create') ? 'active' : '' }}">New Activity Proposal</a>
                    <a href="{{ route('enduser.requests.index') }}" class="menu-link {{ request()->routeIs('enduser.requests.index') ? 'active' : '' }}">My Proposals</a>
                    <a href="{{ route('enduser.requests.index', ['filter' => 'pending']) }}" class="menu-link">Pending Approval</a>
                    <a href="{{ route('enduser.requests.index', ['filter' => 'returned']) }}" class="menu-link">Returned / Rejected</a>

                    <div class="menu-label">Documents</div>
                    <a href="{{ route('enduser.requests.index') }}" class="menu-link">Purchase Requests</a>
                    <a href="{{ route('enduser.requests.index') }}" class="menu-link">RFQ Submissions</a>
                    <a href="{{ route('enduser.requests.index') }}" class="menu-link">Final Documents</a>

                    <div class="menu-label">Account</div>
                    <a href="{{ route('enduser.notifications.index') }}" class="menu-link {{ request()->routeIs('enduser.notifications.*') ? 'active' : '' }}">Notifications</a>
                    <a href="{{ route('enduser.profile.edit') }}" class="menu-link {{ request()->routeIs('enduser.profile.*') ? 'active' : '' }}">Profile</a>
                </div>

                {{-- ✅ Fixed: Working logout with user info --}}
                <div class="sidebar-bottom">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                        <div style="width:32px;height:32px;border-radius:50%;background:var(--blue-dark);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;">
                            {{ strtoupper(substr(auth()->user()->firstname, 0, 1) . substr(auth()->user()->lastname, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight:700;font-size:13px;">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</div>
                            <div style="font-size:11px;color:#9aa3ad;">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="width:100%;background:#c53030;color:#fff;border:none;border-radius:7px;padding:8px 0;font-size:13px;font-weight:700;cursor:pointer;letter-spacing:0.3px;">
                            🔓 Logout
                        </button>
                    </form>
                </div>
            </aside>

            <main class="main">
                @if(session('success'))
                    <div style="margin-bottom:10px;background:#e8f7e6;border:1px solid #9ed598;padding:10px 12px;border-radius:8px;font-size:13px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div style="margin-bottom:10px;background:#fff2f2;border:1px solid #f1b0b0;padding:10px 12px;border-radius:8px;font-size:13px;">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>