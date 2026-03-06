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
</head>
<body class="font-sans antialiased bg-gray-100">
    {{-- Header --}}
    @include('layouts.public-topbar')

    <!-- Hero Section with Blue Gradient Background -->
<section class="relative w-full overflow-hidden">
    {{-- Blue patterned background --}}
    <div class="absolute inset-0 bg-gradient-to-b from-blue-700 via-blue-700 to-blue-900"></div>
    <div class="absolute inset-0 opacity-15"
         style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 8px 8px;"></div>

    <!-- Hero Content -->
    <div class="relative w-full h-full px-4 sm:px-6 lg:px-8 pt-32 pb-32 text-left text-white">
        <!-- Small Yellow Subheading -->
        <h1 class="text-lg md:text-xl font-semibold text-yellow-300 mb-2">
            PURCHASE REQUEST TRACKER SYSTEM
        </h1>

        <!-- Big Main Heading -->
        <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-3">
            System Features
        </h2>

        <!-- Description -->
        <p class="max-w-3xl text-white/90 text-base md:text-lg mt-2">
            A comprehensive digital procurement platform designed to streamline every step of the purchase request lifecycle—from proposal to payment.
        </p>
    </div>
</section>

   <!-- Features Grid -->
<main class="max-w-7xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Feature Card -->
        <div class="bg-white border border-gray-200 shadow rounded-xl p-6 hover:shadow-md transition h-56 flex flex-col">
            <h3 class="text-lg font-bold text-indigo-600 mb-2">
                Activity Proposal Management
            </h3>
            <p class="text-gray-700 text-sm leading-relaxed flex-grow">
                End users can create, submit, and track activity proposals through a guided 5-step process including Work Item Lists, budget estimates, and attachments.
            </p>
        </div>

        <!-- Feature Card -->
        <div class="bg-white border border-gray-200 shadow rounded-xl p-6 hover:shadow-md transition h-56 flex flex-col">
            <h3 class="text-lg font-bold text-indigo-600 mb-2">
                Procurement Approval Workflow
            </h3>
            <p class="text-gray-700 text-sm leading-relaxed flex-grow">
                Reviews and approves or returns proposals with remarks. Upon approval, the system automatically generates a PR number and PR summary.
            </p>
        </div>

        <!-- Feature Card -->
        <div class="bg-white border border-gray-200 shadow rounded-xl p-6 hover:shadow-md transition h-56 flex flex-col">
            <h3 class="text-lg font-bold text-indigo-600 mb-2">
                BAC Processing & PO Generation
            </h3>
            <p class="text-gray-700 text-sm leading-relaxed flex-grow">
                Step-by-step BAC checklist covering document evaluation, price matrix canvassing, abstract of quotation, and automated Purchase Order generation.
            </p>
        </div>

        <!-- Feature Card -->
        <div class="bg-white border border-gray-200 shadow rounded-xl p-6 hover:shadow-md transition h-56 flex flex-col">
            <h3 class="text-lg font-bold text-indigo-600 mb-2">
                FA II Document Validation
            </h3>
            <p class="text-gray-700 text-sm leading-relaxed flex-grow">
                Finance Division validates procurement documents using an 8-point compliance checklist. Findings are flagged and returned for correction.
            </p>
        </div>

        <!-- Feature Card -->
        <div class="bg-white border border-gray-200 shadow rounded-xl p-6 hover:shadow-md transition h-56 flex flex-col">
            <h3 class="text-lg font-bold text-indigo-600 mb-2">
                ADA Payment Processing
            </h3>
            <p class="text-gray-700 text-sm leading-relaxed flex-grow">
                Cleared documents proceed to ADA (Advice to Debit Account) processing, including Budget Obligation and Fund Availability before confirmation.
            </p>
        </div>

        <!-- Feature Card -->
        <div class="bg-white border border-gray-200 shadow rounded-xl p-6 hover:shadow-md transition h-56 flex flex-col">
            <h3 class="text-lg font-bold text-indigo-600 mb-2">
                Real-Time Status Validation
            </h3>
            <p class="text-gray-700 text-sm leading-relaxed flex-grow">
                All users can track their document’s procurement pipeline in real-time, with notifications sent at each stage transition.
            </p>
        </div>

        <!-- Feature Card -->
        <div class="bg-white border border-gray-200 shadow rounded-xl p-6 hover:shadow-md transition h-56 flex flex-col">
            <h3 class="text-lg font-bold text-indigo-600 mb-2">
                Role-Based Access Control
            </h3>
            <p class="text-gray-700 text-sm leading-relaxed flex-grow">
                Four distinct roles: End User, Procurement, FA II, and Super Admin. Each role has defined permissions showing documents and actions relevant to the role.
            </p>
        </div>

        <!-- Feature Card -->
        <div class="bg-white border border-gray-200 shadow rounded-xl p-6 hover:shadow-md transition h-56 flex flex-col">
            <h3 class="text-lg font-bold text-indigo-600 mb-2">
                Audit Trail & System Oversight
            </h3>
            <p class="text-gray-700 text-sm leading-relaxed flex-grow">
                Every action is timestamped and logged in a searchable audit trail. Super Admin manages user accounts, assigns roles, and configures permissions.
            </p>
        </div>
    </div>
</main>
</body>
</html>