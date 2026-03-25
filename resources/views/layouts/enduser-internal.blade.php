<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title ?? 'Purchase Tracking System' }}</title>
<style>

/* ─── TOKENS ─────────────────────────────────── */
:root{
    --blue:              #0d4fb3;
    --blue-dark:         #1f3f7d;
    --blue-soft:         #eef4ff;
    --blue-soft-border:  #d9e7ff;
    --border:            #cfd6df;
    --border-md:         #d4dae2;
    --bg:                #f5f6f9;
    --surface:           #ffffff;
    --text:              #263238;
    --muted:             #6c7785;
    --sidebar-bg:        #ffffff; /* white with 80% opacity */
    --topbar-h:          64px;
    --sidebar-w:         235px;
    --radius:            8px;
    --success:           #8cd57e;
    --warning:           #f1c84b;
    --danger:            #e57f7f;

    /* badge tokens */
    --badge-draft-bg:         #e7dcff; --badge-draft-tx:         #7a54c7;
    --badge-pending-bg:       #ffe28f; --badge-pending-tx:       #8a5b00;
    --badge-approved-bg:      #ccefc5; --badge-approved-tx:      #2a7a2f;
    --badge-returned-bg:      #ffd3d3; --badge-returned-tx:      #b53b3b;
    --badge-rejected-bg:      #ffd3d3; --badge-rejected-tx:      #b53b3b;
    --badge-processing-bg:    #dbe9ff; --badge-processing-tx:    #2d5ca8;
}

/* ─── RESET ──────────────────────────────────── */
*,*::before,*::after{ box-sizing:border-box; margin:0; padding:0; }
html,body{
    height:100%;
    font-family:Arial,Helvetica,sans-serif;
    background:var(--bg);
    color:var(--text);
    font-size:13px;
}

/* ─── APP SHELL ──────────────────────────────── */
.app-shell{
    display:flex;
    flex-direction:column;
    height:100vh;
    overflow:hidden;
}

/* ─── TOP ACCENT LINE ────────────────────────── */
.topbar-line{
    height:5px;
    background:var(--blue);
    flex-shrink:0;
}

/* ─── TOPBAR ─────────────────────────────────── */
.topbar{
    height:var(--topbar-h);
    background:var(--surface);
    border-bottom:1px solid var(--border);
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 18px;
    gap:14px;
    flex-shrink:0;
    z-index:100;
}
.topbar-left{
    display:flex;
    align-items:center;
    gap:12px;
    min-width:0;
}
.topbar-right{
    display:flex;
    align-items:center;
    gap:12px;
    margin-left:auto;
    flex-wrap:wrap;
}

/* Hamburger */
.sidebar-toggle{
    width:38px; height:38px;
    border:1px solid var(--border-md);
    background:var(--surface);
    color:var(--blue-dark);
    border-radius:var(--radius);
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; flex-shrink:0;
}
.sidebar-toggle:hover{ background:var(--blue-soft); }
.sidebar-toggle svg{ width:18px; height:18px; stroke:var(--blue-dark); fill:none; stroke-width:2; }

/* Brand */
.brand-wrap{
    display:flex;
    align-items:center;
    gap:14px;
    flex-wrap:wrap;
    min-width:0;
}
.brand-logo{
    width:52px; height:52px;
    border-radius:var(--radius);
    background:var(--surface);
    display:flex; align-items:center; justify-content:center;
    overflow:hidden;
    border:1px solid #d8d8d8;
    flex-shrink:0;
}
.brand-logo img{ width:100%; height:100%; object-fit:contain; display:block; }
.brand-text{ display:flex; flex-direction:column; justify-content:center; line-height:1.3; }
.brand-text small{ display:block; color:var(--muted); font-size:10px; }
.brand-text strong{ display:block; font-size:15px; color:#1a2332; margin-top:1px; }

/* Vertical divider */
.topbar-divider{ width:1px; height:40px; background:var(--border); flex-shrink:0; margin:0 2px; }

/* System block */
.sys-block{ display:flex; flex-direction:column; justify-content:center; }
.sys-block .sys-label{ font-size:10px; color:var(--muted); text-transform:uppercase; letter-spacing:.5px; }
.sys-block .sys-name{ font-size:15px; font-weight:800; color:var(--blue-dark); line-height:1.2; }

/* Role pill — in topbar, replaces old sidebar END USER badge */
.role-pill{
    display:inline-flex; align-items:center; gap:6px;
    background:var(--blue-soft);
    border:1px solid #b8d0f8;
    padding:4px 12px 4px 8px;
    border-radius:999px;
    font-size:11px; font-weight:700; color:var(--blue-dark);
    margin-left:4px; flex-shrink:0;
}
.role-pill .dot{ width:7px; height:7px; border-radius:50%; background:var(--blue); }

/* Bell */
.notif-wrapper{ position:relative; }
.bell-btn{
    width:38px; height:38px;
    border:1px solid var(--border-md);
    border-radius:var(--radius);
    background:var(--surface);
    display:flex; align-items:center; justify-content:center;
    cursor:pointer;
}
.bell-btn:hover{ background:var(--blue-soft); }
.bell-btn svg{ width:18px; height:18px; stroke:#f4b53f; fill:none; stroke-width:2; }
.notif-badge-dot{
    position:absolute; top:6px; right:6px;
    width:8px; height:8px;
    border-radius:50%; background:#d92d20;
    border:2px solid var(--surface);
}

/* Notification dropdown */
.notif-dropdown{
    position:absolute; top:46px; right:0;
    width:320px;
    background:var(--surface);
    border:1px solid #dbe3ef;
    border-radius:12px;
    overflow:hidden;
    display:none;
    z-index:999;
    box-shadow:0 14px 30px rgba(15,23,42,.12);
}
.notif-dropdown.active{ display:block; }
.notif-dropdown-header{
    padding:12px 14px;
    font-size:13px; font-weight:700; color:#1f2937;
    background:#ffffff;
    border-bottom:1px solid #e5eaf1;
    display:flex; align-items:center; justify-content:space-between;
}
.notif-count{
    background:#d92d20; color:#fff;
    font-size:10px; padding:1px 7px; border-radius:999px;
}
.notif-body{ max-height:280px; overflow-y:auto; }
.notif-item{ padding:10px 13px; border-bottom:1px solid #eef2f6; font-size:12px; }
.notif-item:last-child{ border-bottom:none; }
.notif-item:hover{ background:#eef4ff; }
.notif-item strong{ display:block; font-weight:700; color:#1f2937; line-height:1.4; }
.notif-item span{ display:block; color:#6b7280; font-size:11px; margin-top:3px; line-height:1.45; }
.notif-item time{ display:block; font-size:10px; color:#94a3b8; margin-top:4px; }
.notif-empty{ padding:18px; text-align:center; font-size:12px; color:#94a3b8; }
.notif-footer{ padding:10px 13px; text-align:center; border-top:1px solid #e5eaf1; background:#fafbfd; }
.notif-footer a{ font-size:12px; font-weight:700; color:var(--blue-dark); text-decoration:none; }

/* User chip */
.user-topbar{
    display:flex; align-items:center; gap:8px;
    background:var(--surface);
    border:1px solid var(--border-md);
    border-radius:10px;
    padding:6px 10px;
}
.user-avatar{
    width:34px; height:34px;
    border-radius:50%;
    background:var(--blue-dark); color:#fff;
    display:flex; align-items:center; justify-content:center;
    font-size:12px; font-weight:700; flex-shrink:0;
}
.user-details{ display:flex; flex-direction:column; line-height:1.2; }
.user-name{ font-weight:700; font-size:13px; color:var(--text); }
.user-email{ font-size:11px; color:#7b8794; }

/* Logout */
.logout-form{ display:inline; }
.logout-btn-top{
    background:#c53030; color:#fff;
    border:none; border-radius:var(--radius);
    padding:9px 14px;
    font-size:12px; font-weight:700;
    cursor:pointer; letter-spacing:.3px;
    display:flex; align-items:center; gap:6px;
}
.logout-btn-top:hover{ background:#a92828; }
.logout-btn-top svg{ width:14px; height:14px; stroke:#fff; fill:none; stroke-width:2; }

/* ─── CONTENT SHELL ──────────────────────────── */
.content-shell{
    display:flex;
    flex:1;
    overflow:hidden;
    min-height:0;
}

/* ─── SIDEBAR ────────────────────────────────── */
.sidebar{
    width:var(--sidebar-w);
    min-width:var(--sidebar-w);
    background:var(--sidebar-bg);
    display:flex;
    flex-direction:column;
    border-right:1px solid #e5eaf1;
    height:100%;
    overflow-y:auto;
    overflow-x:hidden;
    transition:width .22s ease, min-width .22s ease, opacity .22s ease;
    flex-shrink:0;
}
.sidebar-accent{ height:3px; background:var(--blue); flex-shrink:0; }

.menu-label{
    font-size:10px;
    text-transform:uppercase;
    letter-spacing:1.2px;
    font-weight:700;
    color:#9aa3ad;
    padding:14px 16px 5px;
}
.menu-link{
    display:flex;
    align-items:center;
    gap:9px;
    padding:9px 16px;
    color:#374151;
    text-decoration:none;
    font-size:13px;
    border-left:3px solid transparent;
    transition:background .12s, color .12s, border-color .12s;
    white-space:nowrap;
}
.menu-link svg{
    width:15px; height:15px;
    stroke:currentColor; fill:none; stroke-width:2;
    flex-shrink:0; opacity:.8;
}
.menu-link:hover{ background:#f3f6fb; color:#0d4fb3; }
.menu-link.active{
     background:#eef4ff;
     color:#0d4fb3;
     border-left-color:#0d4fb3;
}
.menu-link.active svg{ opacity:1; }

.nav-badge{
    margin-left:auto;
    background:#d92d20; color:#fff;
    font-size:9px; font-weight:700;
    padding:1px 6px; border-radius:999px;
}
.sidebar-spacer{ flex:1; }
.sidebar-footer{
    padding:12px 16px;
    font-size:11px;
    color:rgba(255,255,255,.2);
    border-top:1px solid rgba(255,255,255,.06);
}

/* Collapsed */
.app-shell.sidebar-collapsed .sidebar{ width:0; min-width:0; overflow:hidden; opacity:0; }

/* ─── MAIN ───────────────────────────────────── */
.main{
    flex:1;
    min-width:0;
    padding:14px 18px 24px;
    overflow-y:auto;
    height:100%;
    transition:all .22s ease;
}

/* ─── ALERTS ─────────────────────────────────── */
.alert{
    display:flex; align-items:flex-start; gap:8px;
    padding:10px 13px; border-radius:7px;
    font-size:13px; margin-bottom:12px;
}
.alert svg{ width:15px; height:15px; flex-shrink:0; margin-top:1px; fill:none; stroke-width:2.5; }
.alert-success{ background:#e8f7e6; border:1px solid #9ed598; color:#276124; }
.alert-success svg{ stroke:#276124; }
.alert-danger{ background:#fff2f2; border:1px solid #f1b0b0; color:#b53b3b; }
.alert-danger svg{ stroke:#b53b3b; stroke-width:2; }

/* ─── STAT CARDS ─────────────────────────────── */
.stats{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:14px;
    margin-bottom:10px;
}
.stat-card{
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:12px 12px 0 0;
    border-bottom:4px solid var(--blue-dark);
    padding:8px 12px 10px;
    min-height:82px;
}
.stat-title{ font-size:13px; color:#444; margin-bottom:4px; }
.stat-value{ font-size:40px; line-height:1; margin:2px 0; font-weight:700; }
.stat-sub{ font-size:12px; color:#555; }

/* ─── PANEL ──────────────────────────────────── */
.panel{
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:0 0 14px 14px;
    overflow:hidden;
}
.panel-header{
    background:var(--blue-dark); color:#fff;
    padding:12px 16px;
    display:flex; align-items:center; justify-content:space-between; gap:10px;
    font-weight:700; font-size:13px;
}
.panel-header svg{ width:15px; height:15px; stroke:#fff; fill:none; stroke-width:2; opacity:.85; }
.panel-body{ padding:14px; }
.panel-footer{
    padding:11px 16px;
    border-top:1px solid var(--border);
    background:#f8f9fb;
    display:flex; justify-content:flex-end; align-items:center; gap:8px;
}

/* ─── BUTTONS ────────────────────────────────── */
.btn-primary{
    background:var(--surface); color:var(--blue-dark);
    border:1px solid #dfe6ef; border-radius:var(--radius);
    padding:6px 14px; font-size:12px; font-weight:700;
    text-decoration:none; display:inline-block; cursor:pointer;
}
.btn-primary:hover{ background:var(--blue-soft); }
.btn-primary-dark{
    background:var(--blue-dark); color:#fff;
    border:1px solid #183268; border-radius:7px;
    padding:7px 16px; font-size:12px; font-weight:700;
    cursor:pointer; display:inline-flex; align-items:center; gap:6px;
}
.btn-primary-dark:hover{ background:#17337a; }
.btn-primary-dark svg{ width:13px; height:13px; stroke:#fff; fill:none; stroke-width:2.5; }
.btn-outline{
    background:var(--surface); color:#4b5563;
    border:1px solid #bfc7d1; border-radius:var(--radius);
    padding:7px 14px; font-size:12px; font-weight:700;
    text-decoration:none; display:inline-block; cursor:pointer;
}
.btn-outline:hover{ background:#f3f4f6; }
.btn-red{ background:#fff2f2; color:#ba2f2f; border:1px solid #efadad; border-radius:var(--radius); padding:7px 14px; font-size:12px; font-weight:700; cursor:pointer; }
.btn-red:hover{ background:#ffe0e0; }
.btn-green{ background:#4b9f39; color:#fff; border:1px solid #408631; border-radius:var(--radius); padding:7px 14px; font-size:12px; font-weight:700; cursor:pointer; }
.btn-purple{ background:#d9c8ff; color:#51339d; border:1px solid #b79ef5; border-radius:var(--radius); padding:7px 14px; font-size:12px; font-weight:700; cursor:pointer; }

/* ─── TABLE ──────────────────────────────────── */
.table-wrap{ width:100%; overflow:auto; }
table{ width:100%; border-collapse:collapse; font-size:13px; }
th,td{ padding:10px 10px; border-bottom:1px solid #eceff3; vertical-align:middle; }
th{ color:var(--blue-dark); text-align:left; font-size:12px; font-weight:700; background:#f7f9fc; }
th:first-child,td:first-child{ padding-left:14px; }
tbody tr:hover{ background:#fafbfd; }

/* ─── BADGES ─────────────────────────────────── */
.badge{ display:inline-block; font-size:11px; padding:4px 10px; border-radius:999px; font-weight:700; white-space:nowrap; }
.badge-draft{      background:var(--badge-draft-bg);      color:var(--badge-draft-tx); }
.badge-pending{    background:var(--badge-pending-bg);    color:var(--badge-pending-tx); }
.badge-approved{   background:var(--badge-approved-bg);   color:var(--badge-approved-tx); }
.badge-returned,
.badge-rejected{   background:var(--badge-returned-bg);   color:var(--badge-returned-tx); }
.badge-processing,
.badge-submitted_to_rd,
.badge-bac_processing,
.badge-signed_pr,
.badge-validated_payment{ background:var(--badge-processing-bg); color:var(--badge-processing-tx); }

/* View button */
.view-btn{
    border:1px solid #6c8bb3; border-radius:999px;
    padding:4px 16px; color:#2b4770;
    text-decoration:none; font-size:12px;
    display:inline-block; background:var(--surface);
}
.view-btn:hover{ background:var(--blue-soft); }

/* ─── FORMS ──────────────────────────────────── */
.field label{ display:block; font-size:12px; font-weight:700; margin-bottom:5px; color:#374151; }
.field input,
.field select,
.field textarea{
    width:100%;
    border:1px solid #c7cfd8; background:var(--surface);
    border-radius:5px; padding:9px 10px;
    font-size:13px; font-family:inherit; color:var(--text);
    outline:none; transition:border-color .15s;
}
.field input:focus,
.field select:focus,
.field textarea:focus{ border-color:var(--blue); box-shadow:0 0 0 3px rgba(13,79,179,.1); }
.field input[readonly]{ background:#f1f2f4; color:var(--muted); cursor:not-allowed; }
.field textarea{ resize:vertical; min-height:90px; }
.field-hint{ font-size:11px; color:#9aa3ad; margin-top:4px; display:flex; align-items:center; gap:4px; }
.field-hint svg{ width:11px; height:11px; stroke:#9aa3ad; fill:none; stroke-width:2; }

/* ─── GRID HELPERS ───────────────────────────── */
.grid-2{ display:grid; grid-template-columns:repeat(2,1fr); gap:12px; }
.grid-3{ display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }

/* Section label */
.section-label{
    font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.8px;
    color:var(--blue); border-bottom:2px solid var(--blue-soft-border);
    padding-bottom:5px; margin-bottom:14px;
}

/* ─── WIZARD ─────────────────────────────────── */
.wizard-overlay{ background:rgba(107,122,138,.45); padding:24px; border-radius:16px; }
.wizard{ width:min(980px,100%); margin:0 auto; background:var(--surface); border-radius:16px; overflow:hidden; border:1px solid #b9c6d8; box-shadow:0 20px 40px rgba(0,0,0,.18); }
.wizard-header{ background:var(--blue); color:#fff; padding:18px 20px 16px; display:flex; align-items:flex-start; justify-content:space-between; }
.wizard-title{ font-size:18px; font-weight:700; }
.wizard-sub{ font-size:12px; opacity:.92; margin-top:6px; }
.close-x{ width:28px; height:28px; border-radius:var(--radius); background:rgba(255,255,255,.25); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:20px; cursor:pointer; }
.steps{ background:#dfe9f8; padding:14px 28px; display:flex; align-items:center; justify-content:space-between; gap:10px; }
.step{ display:flex; align-items:center; gap:10px; flex:1; color:#224375; font-size:13px; font-weight:700; }
.step:not(:last-child)::after{ content:""; flex:1; height:1px; background:#9fb3d6; margin-left:6px; }
.step-circle{ width:32px; height:32px; border-radius:50%; border:2px solid #bdc7d6; background:#f8f8f8; color:#4b5563; display:flex; align-items:center; justify-content:center; font-weight:700; flex:0 0 auto; }
.step.active .step-circle{ background:#1f478f; color:#fff; border-color:#1f478f; }
.step.done  .step-circle{ background:#a8e58f; border-color:#67b755; color:#1f5c1e; }
.wizard-body{ padding:22px 28px 18px; background:#f5f3ef; }
.hint-box{ background:#d6e2f6; border-radius:var(--radius); padding:14px 16px; margin-bottom:18px; font-size:13px; color:#374151; }
.section-title{ color:#214b86; font-size:13px; font-weight:700; text-transform:uppercase; border-bottom:1px solid #c8d1dc; padding-bottom:6px; margin:16px 0 12px; }
.wizard-footer{ border-top:1px solid #d6dce3; background:#f8f6f2; padding:12px 18px; display:flex; justify-content:space-between; align-items:center; gap:12px; }
.footer-note{ font-size:12px; color:#8b8f96; }
.actions{ display:flex; gap:8px; flex-wrap:wrap; }

/* ─── LIFECYCLE ──────────────────────────────── */
.lifecycle-box{ background:var(--surface); border:1px solid var(--border); border-radius:6px; overflow:hidden; }
.lifecycle-head{ background:#b8cfef; color:#1b2b44; font-size:12px; font-weight:700; padding:7px 12px; }
.lifecycle-item{ display:flex; gap:12px; align-items:flex-start; padding:8px 12px; border-top:1px solid #e2e6eb; font-size:13px; }
.life-num{ width:24px; height:24px; border-radius:50%; background:#efefef; border:1px solid #b7bec8; color:#1e293b; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex:0 0 auto; }
.life-num.active{ background:#ffe38d; border-color:#e1b841; }
.life-num.done{ background:#ccefc5; border-color:#66b657; }
.life-title{ font-weight:700; }
.life-text{ font-size:12px; color:#555; margin-top:2px; }

/* ─── MISC ───────────────────────────────────── */
.doc-no{ font-weight:700; color:#111827; }
.muted{ color:#8c97a5; font-size:12px; }
.notice-row{ min-height:54px; border-bottom:1px solid #dde3ea; display:flex; align-items:center; padding:0 16px; font-size:14px; }
.empty-card{ min-height:160px; display:flex; align-items:center; justify-content:center; color:#7d8793; font-size:14px; }
.empty-state{ padding:36px; text-align:center; color:var(--muted); font-size:13px; }
.empty-state svg{ display:block; margin:0 auto 12px; width:36px; height:36px; stroke:#cfd6df; fill:none; stroke-width:1.5; }
.tabs{ display:flex; justify-content:space-around; font-size:14px; color:#3d4650; margin:2px 0 10px; }

/* ─── RESPONSIVE ─────────────────────────────── */
@media(max-width:1024px){
    .stats{ grid-template-columns:repeat(2,1fr); }
    .grid-3,.grid-2{ grid-template-columns:1fr; }
    .content-shell{ flex-direction:column; height:auto; }
    .sidebar{ width:100%; min-width:100%; height:auto; }
    .main{ height:auto; }
}
@media(max-width:768px){
    .topbar{ height:auto; padding:10px 14px; flex-wrap:wrap; }
    .topbar-left,.topbar-right{ width:100%; }
    .topbar-right{ justify-content:space-between; flex-wrap:wrap; }
    .user-topbar{ max-width:100%; }
    .user-details{ overflow:hidden; }
    .user-name,.user-email{ white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:160px; }
    .notif-dropdown{ right:auto; left:0; width:min(320px,calc(100vw - 32px)); }
}

</style>
</head>
<body>

@php
    $layoutNotifications = $notifications ?? collect();
    $unreadCount = method_exists($layoutNotifications, 'count')
        ? $layoutNotifications->count()
        : count($layoutNotifications);
@endphp

<div class="app-shell" id="appShell">

    {{-- Top accent line --}}
    <div class="topbar-line"></div>

    {{-- ── TOPBAR ── --}}
    <header class="topbar">
        <div class="topbar-left">

            <button type="button" class="sidebar-toggle" id="sidebarToggle"
                    title="Toggle sidebar" aria-label="Toggle sidebar">
                <svg viewBox="0 0 24 24">
                    <line x1="3" y1="6"  x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>

            <div class="brand-wrap">
                <div class="brand-logo">
                    <img src="{{ asset('image/dswd3.png') }}" alt="DSWD Logo">
                </div>
                <div class="brand-text">
                    <small>Republic of the Philippines</small>
                    <strong>DSWD</strong>
                    <small>Dept. of Social Welfare and Development</small>
                </div>
                <div style="width:1px;height:40px;background:var(--border);margin:0 6px;"></div>
                <div class="sys-block">
                    <span class="sys-label">Internal System</span>
                    <span class="sys-name">Purchase Tracking System</span>
                </div>
            </div>

            {{-- Role pill: moved here from sidebar --}}
            <div class="role-pill">
                <span class="dot"></span>
                End User
            </div>

        </div>

        <div class="topbar-right">

            {{-- Notification bell --}}
            <div class="notif-wrapper">
                <button type="button" class="bell-btn" id="notifToggle"
                        title="Notifications" aria-label="Notifications">
                    <svg viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                </button>
                @if($unreadCount > 0)
                    <span class="notif-badge-dot"></span>
                @endif

                <div class="notif-dropdown" id="notifDropdown">
                    <div class="notif-dropdown-header">
                        Notifications
                        @if($unreadCount > 0)
                            <span class="notif-count">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                        @endif
                    </div>
                    <div class="notif-body">
                        @forelse($layoutNotifications as $notification)
                            <div class="notif-item">
                                <strong>{{ $notification->title }}</strong>
                                <span>{{ $notification->message }}</span>
                                @if(!empty($notification->created_at))
                                    <time>{{ \Carbon\Carbon::parse($notification->created_at)->format('M d, Y h:i A') }}</time>
                                @endif
                            </div>
                        @empty
                            <div class="notif-empty">No notifications yet.</div>
                        @endforelse
                    </div>
                    <div class="notif-footer">
                        <a href="{{ route('enduser.notifications.index') }}">View All Notifications</a>
                    </div>
                </div>
            </div>

            {{-- User chip --}}
            @auth
            <div class="user-topbar">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->firstname, 0, 1) . substr(auth()->user()->lastname, 0, 1)) }}
                </div>
                <div class="user-details">
                    <div class="user-name">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</div>
                    <div class="user-email">{{ auth()->user()->email }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn-top">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16,17 21,12 16,7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Logout
                </button>
            </form>
            @endauth

        </div>
    </header>

    {{-- ── BODY ── --}}
    <div class="content-shell">

        {{-- ── SIDEBAR — no END USER badge ── --}}
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-accent"></div>

            <div class="menu-label">Main Menu</div>
            <a href="{{ route('enduser.dashboard') }}"
               class="menu-link {{ request()->routeIs('enduser.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>

            <div class="menu-label">Activity Proposals</div>
            <a href="{{ route('enduser.requests.create') }}"
               class="menu-link {{ request()->routeIs('enduser.requests.create') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Activity Proposal
            </a>
            <a href="{{ route('enduser.requests.index') }}"
               class="menu-link {{ request()->routeIs('enduser.requests.index','enduser.requests.show','enduser.requests.edit') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                My Proposals
            </a>

            <div class="menu-label">Documents</div>
            <a href="{{ route('enduser.requests.index') }}" class="menu-link">
                <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                Purchase Requests
            </a>
            <a href="{{ route('enduser.requests.index') }}" class="menu-link">
                <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                RFQ Submissions
            </a>
            <a href="{{ route('enduser.requests.index') }}" class="menu-link">
                <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Final Documents
            </a>

            <div class="menu-label">Account</div>
            <a href="{{ route('enduser.notifications.index') }}"
               class="menu-link {{ request()->routeIs('enduser.notifications.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                Notifications
                @if($unreadCount > 0)
                    <span class="nav-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                @endif
            </a>
            <a href="{{ route('enduser.profile.edit') }}"
               class="menu-link {{ request()->routeIs('enduser.profile.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Profile
            </a>

            <div class="sidebar-spacer"></div>
            <div class="sidebar-footer">Purchase Tracking System &copy; {{ date('Y') }}</div>
        </aside>

        {{-- ── MAIN ── --}}
        <main class="main">

            @if(session('success'))
                <div class="alert alert-success">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            @yield('content')

        </main>

    </div>{{-- /content-shell --}}
</div>{{-- /app-shell --}}

<script>
(function () {
    const appShell      = document.getElementById('appShell');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const notifToggle   = document.getElementById('notifToggle');
    const notifDropdown = document.getElementById('notifDropdown');

    sidebarToggle?.addEventListener('click', () => {
        appShell.classList.toggle('sidebar-collapsed');
    });

    notifToggle?.addEventListener('click', (e) => {
        e.stopPropagation();
        notifDropdown.classList.toggle('active');
    });
    notifDropdown?.addEventListener('click', (e) => e.stopPropagation());
    document.addEventListener('click', () => notifDropdown?.classList.remove('active'));
})();
</script>
</body>
</html>
