<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Purchase Request Tracker') }} - Support</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* FAQ accordion animation */
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }
        .faq-answer.open {
            max-height: 300px;
        }
        .faq-item.open .faq-arrow {
            transform: rotate(180deg);
        }
        .faq-arrow {
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    {{-- Header --}}
    @include('layouts.public-topbar')

    <main class="max-w-4xl mx-auto px-6 pt-16 pb-24">

        {{-- Page Label & Heading --}}
        <div class="mb-8">
            <span class="inline-block text-xs font-semibold text-red-600 border border-red-400 rounded-full px-3 py-1 mb-3 tracking-wide uppercase">
                Help Center
            </span>
            <h1 class="text-4xl font-extrabold text-blue-900 mb-2">Support</h1>
            <p class="text-gray-500 text-sm">
                Need help with PRTS? Reach out to our team, browse frequently asked questions, or report an issue below.
            </p>
            <hr class="mt-4 border-gray-200">
        </div>

        {{-- Contact Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-12">

            {{-- DSWD Regional Office --}}
            <div class="rounded-xl p-5 text-white" style="background-color: #1e3a6e;">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-full bg-red-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm leading-tight">DSWD Regional Office</p>
                        <p class="text-xs text-blue-200">Technical Support & Inquiries</p>
                    </div>
                </div>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <div>
                            <p class="text-blue-200 text-xs uppercase tracking-wide">Hotline</p>
                            <p class="font-semibold">(082) 297-0300</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <div>
                            <p class="text-blue-200 text-xs uppercase tracking-wide">Email</p>
                            <p class="font-semibold">prts.support@dswd.gov.ph</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="text-blue-200 text-xs uppercase tracking-wide">Office Hours</p>
                            <p class="font-semibold">Mon – Fri: 8:00 AM – 5:00 PM</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div>
                            <p class="text-blue-200 text-xs uppercase tracking-wide">Address</p>
                            <p class="font-semibold">Region XI, Davao City</p>
                        </div>
                    </li>
                </ul>
            </div>

            {{-- Holy Cross of Davao College --}}
            <div class="rounded-xl p-5 text-white" style="background-color: #7b1e1e;">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-full bg-red-700 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-sm leading-tight">Holy Cross of Davao College</p>
                        <p class="text-xs text-red-200">System Development Team</p>
                    </div>
                </div>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-red-300 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <div>
                            <p class="text-red-200 text-xs uppercase tracking-wide">Contact No.</p>
                            <p class="font-semibold">(082) 221-1983</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-red-300 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <div>
                            <p class="text-red-200 text-xs uppercase tracking-wide">Email</p>
                            <p class="font-semibold">info@hcdc.edu.ph</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-red-300 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/></svg>
                        <div>
                            <p class="text-red-200 text-xs uppercase tracking-wide">Website</p>
                            <p class="font-semibold">www.hcdc.edu.ph</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-red-300 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <div>
                            <p class="text-red-200 text-xs uppercase tracking-wide">Address</p>
                            <p class="font-semibold">Sta. Ana Ave., Davao City</p>
                        </div>
                    </li>
                </ul>
            </div>

        </div>

        {{-- FAQ Section --}}
        <div class="mb-12">
            <h2 class="text-xl font-bold text-blue-900 mb-4">Frequently Asked Questions</h2>

            <div class="space-y-2">

                {{-- FAQ Item 1 --}}
                <div class="faq-item bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between px-5 py-4 text-left text-sm font-semibold text-gray-800 hover:bg-gray-50 transition-colors">
                        <span>How do I create a new Activity Proposal?</span>
                        <svg class="faq-arrow w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer px-5 text-sm text-gray-600 leading-relaxed">
                        <div class="pb-4">
                            Log in to your account and navigate to <strong>Activity Proposals</strong> from your dashboard. Click <strong>Create New Proposal</strong> and follow the guided steps: fill in the activity details, add work items and budget estimates, attach required documents, and submit for Procurement review.
                        </div>
                    </div>
                </div>

                {{-- FAQ Item 2 --}}
                <div class="faq-item bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between px-5 py-4 text-left text-sm font-semibold text-gray-800 hover:bg-gray-50 transition-colors">
                        <span>What happens after my proposal is submitted?</span>
                        <svg class="faq-arrow w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer px-5 text-sm text-gray-600 leading-relaxed">
                        <div class="pb-4">
                            Once submitted, your proposal enters the <strong>Procurement review queue</strong>. You will receive a notification when it is approved or returned with remarks. Upon approval, a PR number is automatically generated and the document proceeds to BAC processing.
                        </div>
                    </div>
                </div>

                {{-- FAQ Item 3 --}}
                <div class="faq-item bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between px-5 py-4 text-left text-sm font-semibold text-gray-800 hover:bg-gray-50 transition-colors">
                        <span>My document was returned by FA II — what should I do?</span>
                        <svg class="faq-arrow w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer px-5 text-sm text-gray-600 leading-relaxed">
                        <div class="pb-4">
                            Review the findings listed by the FA II validator in your document's activity log. Correct the flagged items, re-attach any required documents, and resubmit. You will be notified once the document passes validation.
                        </div>
                    </div>
                </div>

                {{-- FAQ Item 4 --}}
                <div class="faq-item bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between px-5 py-4 text-left text-sm font-semibold text-gray-800 hover:bg-gray-50 transition-colors">
                        <span>How long does the full procurement process take?</span>
                        <svg class="faq-arrow w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer px-5 text-sm text-gray-600 leading-relaxed">
                        <div class="pb-4">
                            Processing time varies depending on document completeness and approving officer availability. Typically, a fully compliant document moves from proposal to ADA payment release within <strong>5–10 working days</strong>.
                        </div>
                    </div>
                </div>

                {{-- FAQ Item 5 --}}
                <div class="faq-item bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full flex items-center justify-between px-5 py-4 text-left text-sm font-semibold text-gray-800 hover:bg-gray-50 transition-colors">
                        <span>Who do I contact to get a system account?</span>
                        <svg class="faq-arrow w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer px-5 text-sm text-gray-600 leading-relaxed">
                        <div class="pb-4">
                            Contact your <strong>DSWD Super Admin</strong> or IT Administrator to request an account. You will need to provide your full name, official DSWD email address, division/office, and intended role (End User, Procurement, or FA II). Accounts are activated within 1–2 working days.
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Report an Issue --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
            <h2 class="text-xl font-bold text-blue-900 mb-6">Report an Issue</h2>

            <form>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    {{-- Full Name --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Full Name</label>
                        <input type="text" placeholder="Your full name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition">
                    </div>
                    {{-- Email Address --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Email Address</label>
                        <input type="email" placeholder="your.email@dswd.gov.ph"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    {{-- Role / Position --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Role / Position</label>
                        <select class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition">
                            <option value="" disabled selected>— Select Role —</option>
                            <option>End User</option>
                            <option>Procurement</option>
                            <option>FA II</option>
                            <option>Super Admin</option>
                        </select>
                    </div>
                    {{-- Issue Type --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Issue Type</label>
                        <select class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition">
                            <option value="" disabled selected>— Select Issue Type —</option>
                            <option>Login / Access Problem</option>
                            <option>Document Submission Error</option>
                            <option>Approval Workflow Issue</option>
                            <option>Notification Not Received</option>
                            <option>Other</option>
                        </select>
                    </div>
                </div>

                {{-- Describe the Issue --}}
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1">Describe the Issue</label>
                    <textarea rows="4" placeholder="Please describe what happened, which screen or document is affected, and any error messages you saw..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition resize-none"></textarea>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold px-6 py-3 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Submit Report
                </button>
            </form>
        </div>

    </main>

    {{-- Scroll to Top Button --}}
    <button id="scrollTopBtn"
        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-6 right-6 z-50 w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-lg opacity-0 pointer-events-none transition-all duration-300 hover:bg-blue-700 hover:scale-110"
        aria-label="Scroll to top">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    <script>
        // Scroll to top visibility
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

        // FAQ accordion toggle
        function toggleFaq(btn) {
            const item = btn.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const isOpen = item.classList.contains('open');

            // Close all
            document.querySelectorAll('.faq-item').forEach(el => {
                el.classList.remove('open');
                el.querySelector('.faq-answer').classList.remove('open');
            });

            // Open clicked if it was closed
            if (!isOpen) {
                item.classList.add('open');
                answer.classList.add('open');
            }
        }
    </script>

</body>
</html>