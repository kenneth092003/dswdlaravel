<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DSWD') }} — Admin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── DSWD Navigation ─────────────────────────── */
        .dswd-nav {
            background: #fff;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        }
        .dswd-accent {
            height: 4px;
            background: linear-gradient(to right, #1a3a6b 62%, #d4a017 62%);
        }
        .dswd-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px 0 16px;
            min-height: 62px;
            border-bottom: 2.5px solid #1a3a6b;
        }

        /* Hamburger toggle button */
        .dswd-hamburger {
            display: flex; align-items: center; justify-content: center;
            width: 38px; height: 38px; border-radius: 8px;
            background: none; border: none; cursor: pointer;
            margin-right: 12px; flex-shrink: 0;
            transition: background 0.15s;
        }
        .dswd-hamburger:hover { background: #eef2ff; }

        /* Hamburger icon lines */
        .hb-icon { display: flex; flex-direction: column; gap: 5px; }
        .hb-line {
            display: block; width: 22px; height: 2px;
            background: #1a3a6b; border-radius: 2px;
            transition: all 0.25s ease;
            transform-origin: center;
        }
        /* X state when sidebar is hidden */
        .sidebar-hidden .hb-line:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .sidebar-hidden .hb-line:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .sidebar-hidden .hb-line:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* Left brand area */
        .dswd-brand {
            display: flex; align-items: center; text-decoration: none; flex-shrink: 0;
        }
        .dswd-seal {
            width: 46px; height: 46px; object-fit: contain; flex-shrink: 0;
            margin-right: 10px;
        }
        .dswd-agency  { display: flex; flex-direction: column; line-height: 1.2; }
        .dswd-republic { font-size: 0.63rem; color: #6b7280; font-weight: 500; }
        .dswd-abbr    { font-size: 1.35rem; font-weight: 900; color: #1a3a6b; letter-spacing: 0.04em; line-height: 1; }
        .dswd-fullname { font-size: 0.58rem; color: #6b7280; font-weight: 500; }

        /* Left wrapper (hamburger + brand together) */
        .dswd-left-group { display: flex; align-items: center; }

        /* Center */
        .dswd-center   { display: flex; align-items: center; gap: 20px; }
        .dswd-vdivider { width: 1px; height: 40px; background: #d1d5db; flex-shrink: 0; }
        .dswd-system   { display: flex; flex-direction: column; line-height: 1.2; }
        .dswd-sys-label { font-size: 0.62rem; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; }
        .dswd-sys-name  { font-size: 1.05rem; font-weight: 900; color: #111827; letter-spacing: 0.02em; }

        /* Right */
        .dswd-right { display: flex; align-items: center; gap: 14px; position: relative; }

        .dswd-notif-wrap {
            position: relative;
        }

        .dswd-notif-btn {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            color: #1a3a6b;
            cursor: pointer;
            transition: background 0.15s, transform 0.15s, border-color 0.15s;
        }

        .dswd-notif-btn:hover {
            background: #eef4ff;
            border-color: #c7d2fe;
            transform: translateY(-1px);
        }

        .dswd-notif-btn svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
        }

        .dswd-notif-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 999px;
            background: #dc2626;
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 2px #fff;
        }

        .dswd-notif-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: min(340px, calc(100vw - 24px));
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.14);
            overflow: hidden;
            z-index: 120;
        }

        .dswd-notif-dropdown.open {
            display: block;
        }

        .dswd-notif-header {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            background: #f8fafc;
        }

        .dswd-notif-title {
            font-size: 0.82rem;
            font-weight: 800;
            color: #111827;
        }

        .dswd-notif-subtitle {
            margin-top: 2px;
            font-size: 0.72rem;
            color: #6b7280;
        }

        .dswd-notif-list {
            max-height: 320px;
            overflow: auto;
        }

        .dswd-notif-item {
            display: block;
            padding: 12px 16px;
            text-decoration: none;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.12s;
        }

        .dswd-notif-item:hover {
            background: #f8fafc;
        }

        .dswd-notif-item:last-child {
            border-bottom: none;
        }

        .dswd-notif-item-title {
            font-size: 0.8rem;
            font-weight: 800;
            color: #111827;
        }

        .dswd-notif-item-msg {
            margin-top: 4px;
            font-size: 0.75rem;
            line-height: 1.45;
            color: #4b5563;
        }

        .dswd-notif-item-time {
            margin-top: 6px;
            font-size: 0.68rem;
            color: #9ca3af;
        }

        .dswd-notif-footer {
            padding: 10px 16px;
            background: #f8fafc;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            gap: 10px;
            align-items: center;
        }

        .dswd-notif-footer a,
        .dswd-notif-footer button {
            font-size: 0.75rem;
            font-weight: 800;
            color: #1a3a6b;
            background: none;
            border: none;
            text-decoration: none;
            cursor: pointer;
            padding: 0;
        }

        .dswd-user-btn {
            display: flex; align-items: center; gap: 9px;
            background: none; border: none; cursor: pointer;
            padding: 5px 8px; border-radius: 8px; transition: background 0.15s;
        }
        .dswd-user-btn:hover { background: #f3f4f6; }

        .dswd-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: #1a3a6b; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 800; flex-shrink: 0;
        }
        .dswd-uname   { font-size: 0.82rem; font-weight: 700; color: #111827; max-width: 140px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .dswd-urole   { font-size: 0.65rem; color: #6b7280; font-weight: 500; }
        .dswd-chevron { font-size: 0.6rem; color: #9ca3af; transition: transform 0.2s; margin-left: 2px; }
        .dswd-user-btn[aria-expanded="true"] .dswd-chevron { transform: rotate(180deg); }

        /* Dropdown */
        .dswd-dropdown {
            display: none; position: absolute; top: calc(100% + 8px); right: 0;
            background: #fff; border: 1px solid #e5e7eb; border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12); min-width: 210px;
            z-index: 100; overflow: hidden;
        }
        .dswd-dropdown.open { display: block; }

        .dd-header { padding: 12px 16px; background: #f8fafc; border-bottom: 1px solid #f1f5f9; }
        .dd-header .dd-name  { font-size: 0.82rem; font-weight: 700; color: #111827; }
        .dd-header .dd-email { font-size: 0.7rem; color: #6b7280; margin-top: 1px; }

        .dd-item {
            display: flex; align-items: center; gap: 9px;
            padding: 10px 16px; font-size: 0.8rem; color: #374151; font-weight: 500;
            text-decoration: none; transition: background 0.12s;
            cursor: pointer; width: 100%; background: none; border: none; text-align: left;
        }
        .dd-item:hover { background: #f3f4f6; }
        .dd-item.danger { color: #dc2626; }
        .dd-item.danger:hover { background: #fef2f2; }
        .dd-divider { height: 1px; background: #f1f5f9; margin: 2px 0; }

        /* Sidebar toggle transition */
        #app-sidebar {
            transition: width 0.25s ease, opacity 0.25s ease, transform 0.25s ease;
            overflow: hidden;
            flex-shrink: 0;
        }
        #app-sidebar.sidebar-collapsed {
            width: 0 !important;
            opacity: 0;
            transform: translateX(-10px);
            pointer-events: none;
        }

        @media (max-width: 640px) {
            .dswd-center { display: none; }
            .dswd-uname, .dswd-urole, .dswd-chevron { display: none; }
            .dswd-bar { padding: 0 12px; }
        }
    </style>
</head>

<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">

    @php
        $currentRole = strtolower(auth()->user()->getRoleNames()->first() ?? '');
        $isSuperAdmin = str_contains($currentRole, 'super');
    @endphp

    {{-- ── DSWD Navigation ── --}}
    <nav class="dswd-nav" id="dswd-nav">
        <div class="dswd-accent"></div>
        <div class="dswd-bar">

            {{-- Left: Hamburger (hidden for Super Admin) + Brand --}}
            <div class="dswd-left-group">

                {{-- Hamburger toggle — hidden for Super Admin --}}
                @if(!$isSuperAdmin)
                <button class="dswd-hamburger" id="hamburger-btn" onclick="toggleSidebar()" title="Toggle sidebar">
                    <span class="hb-icon" id="hb-icon">
                        <span class="hb-line"></span>
                        <span class="hb-line"></span>
                        <span class="hb-line"></span>
                    </span>
                </button>
                @endif

                {{-- DSWD Brand --}}
                <a href="{{ route('dashboard') }}" class="dswd-brand">
                    <img
                     src="{{ asset('image/dswd3.png') }}"
                     alt="DSWD Seal"
                     class="dswd-seal"
                 />
                     <div class="dswd-agency">
                     <span class="dswd-republic">Republic of the Philippines</span>
                     <span class="dswd-abbr">DSWD</span>
                     <span class="dswd-fullname">Dept. of Social Welfare and Development</span>
                    </div>
                </a>
            </div>

            {{-- Center: system label --}}
            <div class="dswd-center">
                <div class="dswd-vdivider"></div>
                <div class="dswd-system">
                    <span class="dswd-sys-label">Internal System</span>
                    <span class="dswd-sys-name">
                        @auth
                        @php
                            $roleName = strtolower(auth()->user()->getRoleNames()->first() ?? '');
                        @endphp
                            @if(str_contains($roleName, 'super'))       SUPER ADMIN
                            @elseif(str_contains($roleName, 'procure')) PROCUREMENT
                            @elseif(str_contains($roleName, 'fa'))      FA II
                            @elseif(str_contains($roleName, 'end'))     END USER
                            @else                                        {{ strtoupper($roleName) }}
                            @endif
                        @endauth
                    </span>
                </div>
            </div>

            {{-- Right: user dropdown --}}
    @auth
    @php
        $u        = auth()->user();
        $initials = strtoupper(substr($u->firstname ?? $u->name ?? 'U', 0, 1) . substr($u->lastname ?? '', 0, 1));
        $fullname = trim(($u->firstname ?? '') . ' ' . ($u->lastname ?? '')) ?: ($u->name ?? 'User');
        $role     = $u->getRoleNames()->first() ?? 'User';
        $adminNotifications = collect();
        $adminUnreadCount = 0;
        $markAdminNotificationsReadUrl = route('admin.settings.notifications.readall');

        if ($isSuperAdmin) {
            $adminNotifications = \App\Models\UserNotification::where('user_id', $u->id)
                ->where('is_read', false)
                ->latest()
                ->limit(5)
                ->get();

            $adminUnreadCount = \App\Models\UserNotification::where('user_id', $u->id)
                ->where('is_read', false)
                ->count();
        }
    @endphp
            <div class="dswd-right">
                @if($isSuperAdmin)
                <div class="dswd-notif-wrap">
                    <button type="button"
                        class="dswd-notif-btn"
                        id="admin-notif-btn"
                        data-live-url="{{ route('admin.settings.notifications.live') }}"
                        data-mark-read-url="{{ $markAdminNotificationsReadUrl }}"
                        data-open-complaints-url="{{ route('admin.settings.index') }}"
                        aria-expanded="false"
                        aria-label="Notifications">
                        <svg viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4a2 2 0 01-.6-1.4V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0m6 0H9" />
                        </svg>
                        <span class="dswd-notif-badge" id="admin-notif-badge" @if($adminUnreadCount === 0) style="display:none" @endif>
                            {{ $adminUnreadCount > 9 ? '9+' : $adminUnreadCount }}
                        </span>
                    </button>

                    <div class="dswd-notif-dropdown" id="admin-notif-drop">
                        <div class="dswd-notif-header">
                            <div class="dswd-notif-title">Admin Notifications</div>
                            <div class="dswd-notif-subtitle" id="admin-notif-subtitle">
                                {{ $adminUnreadCount }} unread notification{{ $adminUnreadCount === 1 ? '' : 's' }}
                            </div>
                        </div>

                        <div class="dswd-notif-list" id="admin-notif-list">
                            @forelse($adminNotifications as $notif)
                                <a href="{{ route('admin.settings.index') }}" class="dswd-notif-item">
                                    <div class="dswd-notif-item-title">{{ $notif->title }}</div>
                                    <div class="dswd-notif-item-msg">{{ $notif->message }}</div>
                                    <div class="dswd-notif-item-time">{{ $notif->created_at?->diffForHumans() }}</div>
                                </a>
                            @empty
                                <div class="px-4 py-5 text-sm text-slate-500">
                                    No unread notifications.
                                </div>
                            @endforelse
                        </div>

                        <div class="dswd-notif-footer" id="admin-notif-footer">
                            <a href="{{ route('admin.settings.index') }}">Open admin settings</a>
                            @if($adminUnreadCount > 0)
                                <form method="POST" action="{{ route('admin.settings.notifications.readall') }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit">Mark all as read</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <button class="dswd-user-btn" id="user-btn" onclick="toggleDrop()" aria-expanded="false">
                    <div class="dswd-avatar">{{ $initials }}</div>
                    <div style="text-align:left">
                        <div class="dswd-uname">{{ $fullname }}</div>
                        <div class="dswd-urole">{{ $role }}</div>
                    </div>
                    <span class="dswd-chevron">▼</span>
                </button>

                <div class="dswd-dropdown" id="user-drop">
                    <div class="dd-header">
                        <div class="dd-name">{{ $fullname }}</div>
                        <div class="dd-email">{{ $u->email }}</div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dd-item">👤 Edit Profile</a>
                    <div class="dd-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dd-item danger">🚪 Log Out</button>
                    </form>
                </div>
            </div>
            @endauth

        </div>
    </nav>

    {{-- ── Sidebar + Content ── --}}
    <div class="flex">

        {{-- Sidebar — hidden entirely for Super Admin --}}
        @if(!$isSuperAdmin)
        <div id="app-sidebar">
            @include('layouts.sidebar')
        </div>
        @endif

        <div class="flex-1 min-w-0">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mx-6 mt-4 p-3 rounded-lg bg-green-50 text-green-800 text-sm font-semibold border border-green-200 flex items-center gap-2">
                    ✓ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mx-6 mt-4 p-3 rounded-lg bg-red-50 text-red-800 text-sm font-semibold border border-red-200 flex items-center gap-2">
                    ✕ {{ session('error') }}
                </div>
            @endif

            {{-- Page Content --}}
            <main>
                {{ $slot }}
            </main>

        </div>
    </div>

</div>

<script>
    // ── Sidebar toggle (only runs for non-Super Admin) ──
    const SIDEBAR_KEY = 'dswd_sidebar_open';

    function toggleSidebar() {
        const sidebar = document.getElementById('app-sidebar');
        const icon    = document.getElementById('hb-icon');
        if (!sidebar) return;
        const isOpen  = !sidebar.classList.contains('sidebar-collapsed');

        if (isOpen) {
            sidebar.classList.add('sidebar-collapsed');
            icon.classList.add('sidebar-hidden');
            localStorage.setItem(SIDEBAR_KEY, '0');
        } else {
            sidebar.classList.remove('sidebar-collapsed');
            icon.classList.remove('sidebar-hidden');
            localStorage.setItem(SIDEBAR_KEY, '1');
        }
    }

    // Restore sidebar state on page load (only for non-Super Admin)
    document.addEventListener('DOMContentLoaded', function () {
        const saved   = localStorage.getItem(SIDEBAR_KEY);
        const sidebar = document.getElementById('app-sidebar');
        const icon    = document.getElementById('hb-icon');
        if (!sidebar) return;

        if (saved === '0') {
            sidebar.classList.add('sidebar-collapsed');
            if (icon) icon.classList.add('sidebar-hidden');
        }
    });

    // ── User dropdown ───────────────────────────────────
    function toggleDrop() {
        const btn  = document.getElementById('user-btn');
        const drop = document.getElementById('user-drop');
        const open = drop.classList.toggle('open');
        btn.setAttribute('aria-expanded', open);
    }

    function toggleAdminNotif() {
        const btn = document.getElementById('admin-notif-btn');
        const drop = document.getElementById('admin-notif-drop');
        if (!btn || !drop) return;

        const open = drop.classList.toggle('open');
        btn.setAttribute('aria-expanded', open);
    }

    function renderAdminNotifications(payload) {
        const badge = document.getElementById('admin-notif-badge');
        const subtitle = document.getElementById('admin-notif-subtitle');
        const list = document.getElementById('admin-notif-list');
        const footer = document.getElementById('admin-notif-footer');
        const openUrl = document.getElementById('admin-notif-btn')?.dataset.openComplaintsUrl;

        if (badge) {
            if (payload.count > 0) {
                badge.style.display = '';
                badge.textContent = payload.count > 9 ? '9+' : payload.count;
            } else {
                badge.style.display = 'none';
            }
        }

        if (subtitle) {
            subtitle.textContent = `${payload.count} unread notification${payload.count === 1 ? '' : 's'}`;
        }

        if (list) {
            if (!payload.notifications || payload.notifications.length === 0) {
                list.innerHTML = '<div class="px-4 py-5 text-sm text-slate-500">No unread notifications.</div>';
            } else {
                list.innerHTML = payload.notifications.map((notification) => `
                    <a href="${openUrl || '#'}" class="dswd-notif-item">
                        <div class="dswd-notif-item-title">${notification.title ?? 'Notification'}</div>
                        <div class="dswd-notif-item-msg">${notification.message ?? ''}</div>
                        <div class="dswd-notif-item-time">${notification.time ?? ''}</div>
                    </a>
                `).join('');
            }
        }

        if (footer) {
            footer.innerHTML = `
                <a href="${openUrl || '#'}">Open admin settings</a>
                ${payload.count > 0 ? `
                    <form method="POST" action="${document.getElementById('admin-notif-btn')?.dataset.markReadUrl || '#'}">
                        <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''}">
                        <input type="hidden" name="_method" value="PATCH">
                        <button type="submit">Mark all as read</button>
                    </form>
                ` : ''}
            `;
        }
    }

    async function refreshAdminNotifications() {
        const btn = document.getElementById('admin-notif-btn');
        if (!btn || !btn.dataset.liveUrl) return;

        try {
            const response = await fetch(btn.dataset.liveUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!response.ok) return;

            const payload = await response.json();
            renderAdminNotifications(payload);
        } catch (error) {
            console.error('Failed to refresh admin notifications:', error);
        }
    }

    async function markAdminNotificationsRead() {
        const btn = document.getElementById('admin-notif-btn');
        if (!btn) return;

        const url = btn.dataset.markReadUrl;
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!url || !token) return;

        try {
            await fetch(url, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });
            await refreshAdminNotifications();
        } catch (error) {
            console.error('Failed to mark notifications as read:', error);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('admin-notif-btn');
        if (btn) {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                toggleAdminNotif();
                markAdminNotificationsRead();
            });

            refreshAdminNotifications();
            setInterval(refreshAdminNotifications, 15000);
        }
    });
    document.addEventListener('click', function(e) {
        const btn  = document.getElementById('user-btn');
        const drop = document.getElementById('user-drop');
        const notifBtn = document.getElementById('admin-notif-btn');
        const notifDrop = document.getElementById('admin-notif-drop');
        if (btn && drop && !btn.contains(e.target) && !drop.contains(e.target)) {
            drop.classList.remove('open');
            btn.setAttribute('aria-expanded', 'false');
        }
        if (notifBtn && notifDrop && !notifBtn.contains(e.target) && !notifDrop.contains(e.target)) {
            notifDrop.classList.remove('open');
            notifBtn.setAttribute('aria-expanded', 'false');
        }
    });
</script>

</body>
</html>
