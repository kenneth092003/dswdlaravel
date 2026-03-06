<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Purchase Request Tracker') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    @include('layouts.public-topbar')

    {{-- Hero --}}
    <section class="relative min-h-screen w-full overflow-hidden flex items-center justify-center">
        {{-- Blue patterned background --}}
        <div class="absolute inset-0 bg-gradient-to-b from-blue-700 via-blue-700 to-blue-900"></div>
        <div class="absolute inset-0 opacity-15"
             style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 8px 8px;"></div>

        <div class="relative w-full h-full px-4 sm:px-6 lg:px-8 py-32 text-center text-white">
            <div class="inline-flex items-center gap-2 px-6 py-2 rounded-full bg-white/15 border border-white/20">
                <span class="font-semibold tracking-wide text-yellow-200">Real-Time Document Tracker</span>
            </div>

            <h1 class="mt-6 text-4xl md:text-6xl font-extrabold tracking-tight">
                Purchase Request Tracker System
            </h1>

            <p class="mt-4 text-xl md:text-2xl font-extrabold text-yellow-300">
                A Pantawid Pamilyang Pilipino Program and Holy Cross of Davao College Initiative
            </p>

            <p class="mt-6 max-w-3xl mx-auto text-white/90 text-base md:text-lg">
                The DSWD Procurement Management System digitizes the entire purchase request lifecycle—from submission to payment—ensuring transparency, speed, and compliance.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('login') }}"
                   class="w-full sm:w-auto px-8 py-4 rounded-full bg-blue-600 text-white font-bold shadow hover:bg-blue-500">
                    Access The System →
                </a>

                {{-- Put your PDF in: public/docs/user-guide.pdf --}}
                <a href="{{ asset('docs/user-guide.pdf') }}"
                   class="w-full sm:w-auto px-8 py-4 rounded-full bg-white text-slate-900 font-bold shadow hover:bg-slate-100">
                    View User Guide
                </a>
            </div>

            {{-- Stats --}}
            <div class="mt-14 max-w-5xl mx-auto bg-black/20 border border-white/15 rounded-2xl p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div>
                        <div class="text-4xl font-extrabold text-yellow-300">48</div>
                        <div class="mt-1 text-white/80 font-semibold">Active PRs</div>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold text-yellow-300">₱3.8M</div>
                        <div class="mt-1 text-white/80 font-semibold">Obligated This Month</div>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold text-yellow-300">11</div>
                        <div class="mt-1 text-white/80 font-semibold">Completed This Month</div>
                    </div>
                    <div>
                        <div class="text-4xl font-extrabold text-yellow-300">38</div>
                        <div class="mt-1 text-white/80 font-semibold">System Users</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>