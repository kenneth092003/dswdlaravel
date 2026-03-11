<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'End User Panel' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-700">
    <div class="flex w-full min-h-screen">
        <!-- Sidebar -->
        <aside class="flex flex-col min-h-screen px-6 py-8 text-white shadow-xl w-72 bg-gradient-to-b from-blue-900 to-blue-700">
            <div class="mb-10">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-12 h-12 text-xl font-bold rounded-2xl bg-white/20">
                        PR
                    </div>
                    <div>
                        <h1 class="text-lg font-bold leading-tight">Purchase Request</h1>
                        <p class="text-sm text-white/80">Tracker System</p>
                    </div>
                </div>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('enduser.dashboard') }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('enduser.dashboard') ? 'bg-white text-blue-900 font-semibold shadow-sm' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                    <span>🏠</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('enduser.requests.index') }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('enduser.requests.index') ? 'bg-white text-blue-900 font-semibold shadow-sm' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                    <span>📄</span>
                    <span>My Requests</span>
                </a>

                <a href="{{ route('enduser.requests.create') }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('enduser.requests.create') ? 'bg-white text-blue-900 font-semibold shadow-sm' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                    <span>➕</span>
                    <span>New Proposal</span>
                </a>

                <a href="{{ route('enduser.notifications.index') }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('enduser.notifications.*') ? 'bg-white text-blue-900 font-semibold shadow-sm' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                    <span>🔔</span>
                    <span>Notifications</span>
                </a>

                <a href="{{ route('enduser.profile.edit') }}"
                   class="flex items-center gap-3 rounded-2xl px-4 py-3 transition {{ request()->routeIs('enduser.profile.*') ? 'bg-white text-blue-900 font-semibold shadow-sm' : 'bg-white/10 hover:bg-white/20 text-white' }}">
                    <span>👤</span>
                    <span>Profile</span>
                </a>
            </nav>

            <div class="p-4 mt-10 border rounded-3xl bg-white/10 border-white/10">
                <p class="text-sm font-semibold">Need help?</p>
                <p class="mt-1 text-xs text-white/80">Track your requests and proposals in one place.</p>
            </div>

            <div class="pt-6 mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-3 text-sm font-semibold text-left text-white transition rounded-2xl bg-white/10 hover:bg-red-500/90">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 min-h-screen bg-slate-100">
            <header class="flex items-center justify-between px-8 py-5 bg-white border-b shadow-sm border-slate-200">
                <div>
                    <h2 class="text-2xl font-bold text-blue-900">{{ $pageTitle ?? 'Dashboard' }}</h2>
                    <p class="text-sm text-slate-500">{{ $pageSubtitle ?? 'Welcome back' }}</p>
                </div>

                @php
                    $fullName = trim((auth()->user()->firstname ?? '') . ' ' . (auth()->user()->lastname ?? ''));
                    $displayName = $fullName !== '' ? $fullName : 'End User';
                    $initial = strtoupper(substr(auth()->user()->firstname ?? 'U', 0, 1));
                @endphp

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-slate-800">{{ $displayName }}</p>
                        <p class="text-xs text-slate-500">End User</p>
                    </div>
                    <div class="flex items-center justify-center font-bold text-blue-900 bg-blue-100 rounded-full h-11 w-11">
                        {{ $initial }}
                    </div>
                </div>
            </header>

            <section class="p-8">
                @if(session('success'))
                    <div class="px-4 py-3 mb-6 text-green-700 border border-green-200 shadow-sm rounded-2xl bg-green-50">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="px-4 py-3 mb-6 text-red-700 border border-red-200 shadow-sm rounded-2xl bg-red-50">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>