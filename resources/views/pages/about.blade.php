{{-- resources/views/pages/about.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PRTS') }} - About</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --navy: #0f2557;
            --navy-mid: #1a3a7a;
            --gold: #d4a843;
            --gold-light: #f0c96a;
            --cream: #fafaf7;
        }

        body { background-color: var(--cream); }

        /* Fade-up animation on scroll */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Hero diagonal clip */
        .hero-clip {
            clip-path: polygon(0 0, 100% 0, 100% 82%, 0 100%);
        }

        /* Gold accent line */
        .gold-line::before {
            content: '';
            display: block;
            width: 48px;
            height: 4px;
            background: var(--gold);
            border-radius: 2px;
            margin-bottom: 16px;
        }

        /* Section divider */
        .section-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #e8e8e0;
            box-shadow: 0 4px 24px rgba(15, 37, 87, 0.06);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }
        .section-card:hover {
            box-shadow: 0 12px 40px rgba(15, 37, 87, 0.12);
            transform: translateY(-4px);
        }

        /* Logo container */
        .logo-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #e8e8e0;
            box-shadow: 0 4px 24px rgba(15, 37, 87, 0.06);
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: box-shadow 0.3s ease;
        }
        .logo-card:hover {
            box-shadow: 0 12px 40px rgba(15, 37, 87, 0.14);
        }

        /* Playfair for headings */
        .font-display { font-family: 'Playfair Display', serif; }

        /* Numbered badge */
        .step-badge {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--navy);
            color: white;
            font-size: 0.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
    </style>
</head>

<body class="font-sans antialiased">
    @include('layouts.public-topbar')

    {{-- ── Hero Banner ── --}}
    <section class="hero-clip relative w-full overflow-hidden" style="padding: 7rem 0 8rem;">
        {{-- Blue gradient background (matches reference) --}}
        <div class="absolute inset-0 bg-gradient-to-b from-blue-700 via-blue-700 to-blue-900"></div>

        {{-- Dot grid texture (matches reference) --}}
        <div class="absolute inset-0 opacity-15"
             style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 8px 8px;"></div>

        <div class="relative max-w-5xl mx-auto px-6 text-center">
            <p class="text-xs font-semibold tracking-[0.25em] uppercase mb-4" style="color: var(--gold-light);">
                Department of Social Welfare and Development
            </p>
            <h1 class="font-display text-white mb-4" style="font-size: clamp(2.5rem, 6vw, 4.5rem); line-height: 1.1;">
                About <span style="color: var(--gold-light);">PRTS</span>
            </h1>
            <p class="text-blue-200 text-base md:text-lg max-w-2xl mx-auto leading-relaxed">
                Digitizing government procurement for greater transparency, efficiency, and accountability.
            </p>
        </div>
    </section>

    {{-- ── Main Content ── --}}
    <main class="max-w-5xl mx-auto px-6 -mt-8 pb-24 space-y-8">

        {{-- ── Logo Row ── --}}
        <div class="reveal grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="logo-card">
                <img src="{{ asset('image/dswd2.png') }}"
                     alt="DSWD"
                     class="max-h-48 w-auto object-contain">
            </div>
            <div class="logo-card">
                <img src="{{ asset('image/pantawid blue font.png') }}"
                     alt="Pantawid"
                     class="max-h-36 w-auto object-contain">
            </div>
        </div>

        {{-- ── About Us ── --}}
        <div class="reveal section-card p-8 md:p-10">
            <div class="gold-line">
                <p class="text-xs font-bold tracking-widest uppercase mb-2" style="color: var(--gold);">Who We Are</p>
                <h2 class="font-display text-3xl md:text-4xl font-bold mb-4" style="color: var(--navy);">About Us</h2>
            </div>
            <p class="text-gray-600 text-base md:text-lg leading-relaxed">
                The <strong class="text-gray-800">Purchase Request Tracker System (PRTS)</strong> is a collaborative initiative of the
                <strong class="text-gray-800">Department of Social Welfare and Development (DSWD)</strong> and
                <strong class="text-gray-800">Holy Cross of Davao College</strong>. Built to support the
                <strong class="text-gray-800">Pantawid Pamilyang Pilipino Program</strong>, the system digitizes the entire purchase
                request lifecycle — from submission to payment — ensuring transparency, efficiency, and accountability
                in government procurement.
            </p>
        </div>

        {{-- ── Mission & Vision side by side ── --}}
        <div class="reveal grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Mission --}}
            <div class="section-card p-8 relative overflow-hidden">
                {{-- Accent corner --}}
                <div class="absolute top-0 right-0 w-24 h-24 rounded-bl-full opacity-10" style="background: var(--gold);"></div>
                <div class="gold-line">
                    <p class="text-xs font-bold tracking-widest uppercase mb-2" style="color: var(--gold);">Purpose</p>
                    <h2 class="font-display text-2xl md:text-3xl font-bold mb-4" style="color: var(--navy);">Our Mission</h2>
                </div>
                <p class="text-gray-600 text-sm md:text-base leading-relaxed">
                    To provide a reliable, real-time platform that empowers agencies and stakeholders to track purchase
                    requests seamlessly — reducing delays and promoting compliance with procurement standards.
                </p>
                <div class="mt-6 flex items-start gap-3 p-4 rounded-xl" style="background: #f0f5ff;">
                    <div class="step-badge">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed pt-1">
                        Streamlining every step from proposal creation to ADA payment release.
                    </p>
                </div>
            </div>

            {{-- Vision --}}
            <div class="section-card p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 rounded-bl-full opacity-10" style="background: var(--gold);"></div>
                <div class="gold-line">
                    <p class="text-xs font-bold tracking-widest uppercase mb-2" style="color: var(--gold);">Direction</p>
                    <h2 class="font-display text-2xl md:text-3xl font-bold mb-4" style="color: var(--navy);">Our Vision</h2>
                </div>
                <p class="text-gray-600 text-sm md:text-base leading-relaxed">
                    A transparent and efficient procurement environment where every request is processed with speed,
                    accuracy, and integrity — strengthening public trust in government systems.
                </p>
                <div class="mt-6 flex items-start gap-3 p-4 rounded-xl" style="background: #f0f5ff;">
                    <div class="step-badge">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed pt-1">
                        Building a future-ready procurement ecosystem grounded in integrity and service.
                    </p>
                </div>
            </div>

        </div>

        {{-- ── Key Stats Strip ── --}}
        <div class="reveal rounded-2xl overflow-hidden" style="background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);">
            <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-white/10">
                <div class="p-6 text-center">
                    <p class="font-display text-3xl font-bold" style="color: var(--gold-light);">5</p>
                    <p class="text-blue-200 text-xs mt-1 leading-tight">Procurement Stages</p>
                </div>
                <div class="p-6 text-center">
                    <p class="font-display text-3xl font-bold" style="color: var(--gold-light);">4</p>
                    <p class="text-blue-200 text-xs mt-1 leading-tight">User Roles</p>
                </div>
                <div class="p-6 text-center">
                    <p class="font-display text-3xl font-bold" style="color: var(--gold-light);">8</p>
                    <p class="text-blue-200 text-xs mt-1 leading-tight">Compliance Checkpoints</p>
                </div>
                <div class="p-6 text-center">
                    <p class="font-display text-3xl font-bold" style="color: var(--gold-light);">100%</p>
                    <p class="text-blue-200 text-xs mt-1 leading-tight">Digital & Paperless</p>
                </div>
            </div>
        </div>

    </main>

    {{-- Scroll to Top --}}
    <button id="scrollTopBtn"
        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-6 right-6 z-50 w-11 h-11 rounded-full text-white flex items-center justify-center shadow-lg opacity-0 pointer-events-none transition-all duration-300 hover:scale-110"
        style="background: var(--navy);"
        aria-label="Scroll to top">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    <script>
        // Scroll-to-top
        const btn = document.getElementById('scrollTopBtn');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                btn.classList.remove('opacity-0', 'pointer-events-none');
                btn.classList.add('opacity-100', 'pointer-events-auto');
            } else {
                btn.classList.add('opacity-0', 'pointer-events-none');
                btn.classList.remove('opacity-100', 'pointer-events-auto');
            }
        });

        // Reveal on scroll
        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visible'), i * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        reveals.forEach(el => observer.observe(el));
    </script>

</body>
</html>