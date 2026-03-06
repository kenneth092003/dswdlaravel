{{-- resources/views/pages/about.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PRTS') }} - About</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    @include('layouts.public-topbar')

    <section class="max-w-7xl mx-auto px-6 py-14">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            {{-- LEFT: Logos --}}
                <div class="space-y-12">
            {{-- DSWD Logo --}}
            <div class="flex items-center justify-center">
             <img src="{{ asset('image/dswd2.png') }}" 
             alt="DSWD" 
             class="max-h-[420px] w-auto object-contain">
            </div>

            {{-- Pantawid Logo --}}
            <div class="flex items-center justify-center">
          <img src="{{ asset('image/pantawid blue font.png') }}" 
             alt="Pantawid" 
             class="max-h-[220px] w-auto object-contain"> 
             {{-- pinalaki mula 140px → 220px --}}
            </div>
        </div>

            {{-- RIGHT: Text blocks --}}
            <div class="space-y-12">
                <div>
                    <h1 class="text-5xl font-extrabold text-slate-900">About Us</h1>
                    <p class="mt-6 text-xl leading-relaxed text-slate-900 font-semibold">
                        The Purchase Request Tracker System (PRTS) is a collaborative initiative of the Department of Social Welfare and Development (DSWD) and Holy Cross of Davao College. Built to support the Pantawid Pamilyang Pilipino Program, the system digitizes the entire purchase request lifecycle from submission to payment ensuring transparency, efficiency, and accountability in government procurement.
                    </p>
                </div>

                <div>
                    <h2 class="text-5xl font-extrabold text-slate-900">Our Mission</h2>
                    <p class="mt-6 text-xl leading-relaxed text-slate-900 font-semibold">
                        To provide a reliable, real-time platform that empowers agencies and stakeholders to track purchase requests seamlessly, reducing delays and promoting compliance with procurement standards.
                    </p>
                </div>

                <div>
                    <h2 class="text-5xl font-extrabold text-slate-900">Our Vision</h2>
                    <p class="mt-6 text-xl leading-relaxed text-slate-900 font-semibold">
                        A transparent and efficient procurement environment where every request is processed with speed, accuracy, and integrity strengthening public trust in government systems.
                    </p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>