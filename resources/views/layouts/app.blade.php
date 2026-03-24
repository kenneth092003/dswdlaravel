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
            @endphp
            <div class="dswd-right">
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
    document.addEventListener('click', function(e) {
        const btn  = document.getElementById('user-btn');
        const drop = document.getElementById('user-drop');
        if (btn && drop && !btn.contains(e.target) && !drop.contains(e.target)) {
            drop.classList.remove('open');
            btn.setAttribute('aria-expanded', 'false');
        }
    });
</script>

</body>
</html>