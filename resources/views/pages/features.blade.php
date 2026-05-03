<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Purchase Request Tracker') }} - Features</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Float animation on hover */
        .float-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .float-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
        }

        /* Subtle continuous float for the who-uses cards when hovered */
        @keyframes floatBounce {
            0%, 100% { transform: translateY(-8px); }
            50%       { transform: translateY(-14px); }
        }
        .float-card:hover {
            animation: floatBounce 1.4s ease-in-out infinite;
            box-shadow: 0 20px 48px rgba(0, 0, 0, 0.13);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    {{-- Header --}}
    @include('layouts.public-topbar')

    <!-- Hero Section -->
    <section class="relative w-full overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-700 via-blue-700 to-blue-900"></div>
        <div class="absolute inset-0 opacity-15"
             style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 8px 8px;"></div>
        <div class="relative w-full h-full px-4 sm:px-6 lg:px-8 pt-32 pb-32 text-left text-white">
            <h1 class="text-lg md:text-xl font-semibold text-yellow-300 mb-2">
                PURCHASE REQUEST TRACKER SYSTEM
            </h1>
            <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-3">
                System Features
            </h2>
            <p class="max-w-3xl text-white/90 text-base md:text-lg mt-2">
                A comprehensive digital procurement platform designed to streamline every step of the purchase request lifecycle—from proposal to payment.
            </p>
        </div>
    </section>

    {{-- Feature Cards --}}
    <main class="max-w-5xl mx-auto px-6 py-14">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            <div class="float-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-blue-700 mb-1">Activity Proposal Management</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">End Users can create, submit, and track activity proposals through a guided 3-step wizard. Proposals include item lists, budget estimates, and required attachments.</p>
                </div>
            </div>

            <div class="float-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-blue-700 mb-1">Procurement Approval Workflow</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Procurement reviews and approves or returns proposals with remarks. Upon approval, documents automatically enter BAC processing with an auto-generated PR number.</p>
                </div>
            </div>

            <div class="float-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-blue-700 mb-1">BAC Processing & PO Generation</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Step-by-step BAC checklist covering document evaluation, price matrix canvassing, abstract of quotation, and automated Purchase Order generation.</p>
                </div>
            </div>

            <div class="float-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-cyan-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-blue-700 mb-1">FA II Document Validation</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Finance Division validates all procurement documents using an 8-point compliance checklist. Findings are flagged and returned to the End User for correction.</p>
                </div>
            </div>

            <div class="float-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-blue-700 mb-1">ADA Payment Processing</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Cleared documents proceed to ADA (Advice to Debit Account) payment release. Budget obligation and fund availability are confirmed before processing.</p>
                </div>
            </div>

            <div class="float-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-pink-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-blue-700 mb-1">Real-Time Status Tracking</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">All users can track their document's exact position in the 5-stage procurement pipeline at any time, with live notifications sent at each stage transition.</p>
                </div>
            </div>

            <div class="float-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-blue-700 mb-1">Role-Based Access Control</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Five distinct roles - End User, Approver, Procurement, FA II, and Super Admin - each with tailored dashboards showing only the screens and actions relevant to their function.</p>
                </div>
            </div>

            <div class="float-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex gap-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-blue-700 mb-1">Audit Trail & System Oversight</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Every action is timestamped and logged in a searchable audit trail. Super Admin monitors system health, manages accounts, and configures permissions system-wide.</p>
                </div>
            </div>

        </div>
    </main>

    {{-- Who Uses PRTS --}}
    <section class="max-w-5xl mx-auto px-6 pb-20">
        <h2 class="text-2xl font-bold text-blue-900 mb-6">Who Uses PRTS</h2>
        <div class="flex flex-col sm:flex-row gap-4">

            {{-- End User --}}
            <div class="float-card flex-1 rounded-2xl p-6 flex flex-col items-center text-center"
                 style="background-color: #eff6ff; border: 2px solid #93c5fd;">
                <div class="mb-3">
                    <svg viewBox="0 0 24 24" class="w-8 h-8 fill-current" style="color: #2563eb;">
                        <circle cx="12" cy="12" r="10" />
                    </svg>
                </div>
                <h4 class="font-bold text-sm mb-2" style="color: #1d4ed8;">End User</h4>
                <p class="text-xs leading-relaxed" style="color: #6b7280;">Creates proposals, tracks status, submits documents</p>
            </div>

            {{-- Procurement --}}
            <div class="float-card flex-1 rounded-2xl p-6 flex flex-col items-center text-center"
                 style="background-color: #faf5ff; border: 2px solid #d8b4fe;">
                <div class="mb-3">
                    <svg viewBox="0 0 24 24" class="w-8 h-8 fill-current" style="color: #7c3aed;">
                        <circle cx="12" cy="12" r="10" />
                    </svg>
                </div>
                <h4 class="font-bold text-sm mb-2" style="color: #6d28d9;">Procurement</h4>
                <p class="text-xs leading-relaxed" style="color: #6b7280;">Approves proposals, runs BAC process, signs PRs</p>
            </div>

            {{-- Approver --}}
            <div class="float-card flex-1 rounded-2xl p-6 flex flex-col items-center text-center"
                 style="background-color: #fff7ed; border: 2px solid #fdba74;">
                <div class="mb-3">
                    <svg viewBox="0 0 24 24" class="w-8 h-8 fill-current" style="color: #ea580c;">
                        <path d="M12 2l3.5 7.1L23 10l-5.5 5.3L18.8 23 12 19.3 5.2 23 7.5 15.3 2 10l7.5-.9L12 2z" />
                    </svg>
                </div>
                <h4 class="font-bold text-sm mb-2" style="color: #c2410c;">Approver</h4>
                <p class="text-xs leading-relaxed" style="color: #6b7280;">Reviews and signs off proposals before procurement</p>
            </div>

            {{-- FA II --}}
            <div class="float-card flex-1 rounded-2xl p-6 flex flex-col items-center text-center"
                 style="background-color: #f0fdfa; border: 2px solid #5eead4;">
                <div class="mb-3">
                    <svg viewBox="0 0 24 24" class="w-8 h-8 fill-current" style="color: #0d9488;">
                        <path d="M12 2L22 12L12 22L2 12Z" />
                    </svg>
                </div>
                <h4 class="font-bold text-sm mb-2" style="color: #0f766e;">FA II</h4>
                <p class="text-xs leading-relaxed" style="color: #6b7280;">Validates docs, flags findings, releases ADA payment</p>
            </div>

            {{-- Super Admin --}}
            <div class="float-card flex-1 rounded-2xl p-6 flex flex-col items-center text-center"
                 style="background-color: #f9fafb; border: 2px solid #d1d5db;">
                <div class="mb-3">
                    <svg viewBox="0 0 24 24" class="w-8 h-8 fill-current" style="color: #f59e0b;">
                        <path d="M13 2L4.5 13.5H11L10 22L19.5 10.5H13L13 2Z" />
                    </svg>
                </div>
                <h4 class="font-bold text-sm mb-2" style="color: #374151;">Super Admin</h4>
                <p class="text-xs leading-relaxed" style="color: #6b7280;">Manages accounts, roles, permissions & system health</p>
            </div>

        </div>
    </section>

</body>
</html>
