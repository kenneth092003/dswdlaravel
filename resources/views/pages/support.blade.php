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
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease, padding 0.35s ease, opacity 0.25s ease;
            opacity: 0;
        }

        .faq-answer.open {
            max-height: 300px;
            opacity: 1;
        }

        .faq-item.open .faq-arrow {
            transform: rotate(180deg);
        }

        .faq-arrow {
            transition: transform 0.3s ease;
        }

        .glass-card {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-800">
    @include('layouts.public-topbar')

    <main class="relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-0 w-72 h-72 bg-blue-100 rounded-full blur-3xl opacity-40"></div>
            <div class="absolute top-32 right-0 w-72 h-72 bg-red-100 rounded-full blur-3xl opacity-30"></div>
        </div>

        <div class="relative max-w-5xl mx-auto px-6 pt-14 pb-24">

            @if(session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Hero / Header --}}
            <section class="mb-10">
                <div class="inline-flex items-center gap-2 text-xs font-bold text-red-600 border border-red-200 bg-red-50 rounded-full px-4 py-1.5 uppercase tracking-[0.18em] shadow-sm">
                    Help Center
                </div>

                <div class="mt-5 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div class="max-w-2xl">
                        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-blue-950 leading-tight">
                            Support & Assistance
                        </h1>
                        <p class="mt-3 text-slate-600 text-base leading-7">
                            Need help with PRTS? Contact the support teams, browse common questions,
                            or submit an issue report below.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-center">
                        <div class="bg-white border border-slate-200 rounded-2xl px-4 py-3 shadow-sm">
                            <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Channels</p>
                            <p class="text-lg font-extrabold text-blue-900">2 Teams</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl px-4 py-3 shadow-sm">
                            <p class="text-xs uppercase tracking-wide text-slate-500 font-semibold">Response</p>
                            <p class="text-lg font-extrabold text-red-700">Fast Help</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 h-px bg-gradient-to-r from-blue-200 via-slate-200 to-red-200"></div>
            </section>

            {{-- Contact Cards --}}
            <section class="mb-14">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- DSWD Card --}}
                    <div class="relative overflow-hidden rounded-3xl p-6 md:p-7 text-white shadow-xl shadow-blue-900/10"
                         style="background: linear-gradient(135deg, #1e3a6e 0%, #284c8d 100%);">
                        <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-white/10"></div>
                        <div class="absolute bottom-0 right-0 w-24 h-24 rounded-full bg-red-400/10"></div>

                        <div class="relative">
                            <div class="flex items-start gap-3 mb-6">
                                <div class="w-11 h-11 rounded-2xl bg-red-500/90 flex items-center justify-center shadow-lg shadow-red-900/20">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-extrabold leading-tight">DSWD Regional Office</p>
                                    <p class="text-sm text-blue-100">Technical Support & Inquiries</p>
                                </div>
                            </div>

                            <div class="space-y-4 text-sm">
                                <div class="flex gap-3 rounded-2xl bg-white/10 px-4 py-3 border border-white/10">
                                    <svg class="w-4 h-4 text-red-300 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <div>
                                        <p class="text-[11px] uppercase tracking-[0.2em] text-blue-100/80">Hotline</p>
                                        <p class="font-bold text-white">(082) 297-0300</p>
                                    </div>
                                </div>

                                <div class="flex gap-3 rounded-2xl bg-white/10 px-4 py-3 border border-white/10">
                                    <svg class="w-4 h-4 text-red-300 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <div>
                                        <p class="text-[11px] uppercase tracking-[0.2em] text-blue-100/80">Email</p>
                                        <p class="font-bold text-white break-all">prts.support@dswd.gov.ph</p>
                                    </div>
                                </div>

                                <div class="flex gap-3 rounded-2xl bg-white/10 px-4 py-3 border border-white/10">
                                    <svg class="w-4 h-4 text-red-300 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <div>
                                        <p class="text-[11px] uppercase tracking-[0.2em] text-blue-100/80">Office Hours</p>
                                        <p class="font-bold text-white">Mon – Fri: 8:00 AM – 5:00 PM</p>
                                    </div>
                                </div>

                                <div class="flex gap-3 rounded-2xl bg-white/10 px-4 py-3 border border-white/10">
                                    <svg class="w-4 h-4 text-red-300 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <div>
                                        <p class="text-[11px] uppercase tracking-[0.2em] text-blue-100/80">Address</p>
                                        <p class="font-bold text-white">Region XI, Davao City</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- HCDC Card --}}
                    <div class="relative overflow-hidden rounded-3xl p-6 md:p-7 text-white shadow-xl shadow-red-900/10"
                         style="background: linear-gradient(135deg, #7b1e1e 0%, #992727 100%);">
                        <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-white/10"></div>
                        <div class="absolute bottom-0 right-0 w-24 h-24 rounded-full bg-blue-400/10"></div>

                        <div class="relative">
                            <div class="flex items-start gap-3 mb-6">
                                <div class="w-11 h-11 rounded-2xl bg-red-800/80 flex items-center justify-center shadow-lg shadow-black/20">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-extrabold leading-tight">Holy Cross of Davao College</p>
                                    <p class="text-sm text-red-100">System Development Team</p>
                                </div>
                            </div>

                            <div class="space-y-4 text-sm">
                                <div class="flex gap-3 rounded-2xl bg-white/10 px-4 py-3 border border-white/10">
                                    <svg class="w-4 h-4 text-red-200 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <div>
                                        <p class="text-[11px] uppercase tracking-[0.2em] text-red-100/80">Contact No.</p>
                                        <p class="font-bold text-white">(082) 221-1983</p>
                                    </div>
                                </div>

                                <div class="flex gap-3 rounded-2xl bg-white/10 px-4 py-3 border border-white/10">
                                    <svg class="w-4 h-4 text-red-200 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <div>
                                        <p class="text-[11px] uppercase tracking-[0.2em] text-red-100/80">Email</p>
                                        <p class="font-bold text-white break-all">info@hcdc.edu.ph</p>
                                    </div>
                                </div>

                                <div class="flex gap-3 rounded-2xl bg-white/10 px-4 py-3 border border-white/10">
                                    <svg class="w-4 h-4 text-red-200 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/></svg>
                                    <div>
                                        <p class="text-[11px] uppercase tracking-[0.2em] text-red-100/80">Website</p>
                                        <p class="font-bold text-white">www.hcdc.edu.ph</p>
                                    </div>
                                </div>

                                <div class="flex gap-3 rounded-2xl bg-white/10 px-4 py-3 border border-white/10">
                                    <svg class="w-4 h-4 text-red-200 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <div>
                                        <p class="text-[11px] uppercase tracking-[0.2em] text-red-100/80">Address</p>
                                        <p class="font-bold text-white">Sta. Ana Ave., Davao City</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- FAQ --}}
            <section class="mb-14">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-2xl font-extrabold text-blue-950">Frequently Asked Questions</h2>
                        <p class="text-sm text-slate-500 mt-1">Quick answers to common support concerns.</p>
                    </div>
                </div>

                <div class="space-y-3">
                    @php
                        $faqs = [
                            [
                                'q' => 'How do I create a new Activity Proposal?',
                                'a' => 'Log in to your account and navigate to Activity Proposals from your dashboard. Click Create New Proposal and follow the guided steps: fill in the activity details, add work items and budget estimates, attach required documents, and submit for Procurement review.'
                            ],
                            [
                                'q' => 'What happens after my proposal is submitted?',
                                'a' => 'Once submitted, your proposal enters the Procurement review queue. You will receive a notification when it is approved or returned with remarks. Upon approval, a PR number is automatically generated and the document proceeds to BAC processing.'
                            ],
                            [
                                'q' => 'My document was returned by FA II — what should I do?',
                                'a' => 'Review the findings listed by the FA II validator in your document\'s activity log. Correct the flagged items, re-attach any required documents, and resubmit. You will be notified once the document passes validation.'
                            ],
                            [
                                'q' => 'How long does the full procurement process take?',
                                'a' => 'Processing time varies depending on document completeness and approving officer availability. Typically, a fully compliant document moves from proposal to ADA payment release within 5–10 working days.'
                            ],
                            [
                                'q' => 'Who do I contact to get a system account?',
                                'a' => 'Contact your DSWD Super Admin or IT Administrator to request an account. You will need to provide your full name, official DSWD email address, division/office, and intended role. Accounts are activated within 1–2 working days.'
                            ]
                        ];
                    @endphp

                    @foreach ($faqs as $faq)
                        <div class="faq-item group bg-white/90 glass-card rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
                            <button onclick="toggleFaq(this)"
                                class="w-full flex items-center justify-between gap-4 px-5 py-5 text-left">
                                <span class="text-sm md:text-[15px] font-bold text-slate-800 group-hover:text-blue-900 transition">
                                    {{ $faq['q'] }}
                                </span>
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-100 group-hover:bg-blue-50 transition">
                                    <svg class="faq-arrow w-4 h-4 text-slate-500 group-hover:text-blue-700 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="faq-answer px-5 text-sm text-slate-600 leading-7">
                                <div class="pb-5 border-t border-slate-100 pt-1">
                                    {{ $faq['a'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Report Form --}}
            <section class="bg-white/95 glass-card rounded-[28px] border border-slate-200 shadow-xl shadow-slate-200/60 overflow-hidden">
                <div class="grid lg:grid-cols-[1.1fr,1.6fr]">
                    <div class="p-8 md:p-10 text-white" style="background: linear-gradient(180deg, #1e3a6e 0%, #274784 100%);">
                        <div class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/10 px-3 py-1.5 text-xs font-semibold tracking-wide uppercase">
                            Support Form
                        </div>

                        <h2 class="mt-5 text-3xl font-extrabold leading-tight">
                            Report an Issue
                        </h2>

                        <p class="mt-3 text-blue-100 leading-7 text-sm">
                            Give us the details of the problem so the team can review and assist you faster.
                        </p>

                        <div class="mt-8 space-y-4 text-sm">
                            <div class="rounded-2xl bg-white/10 border border-white/10 p-4">
                                <p class="font-bold">Helpful tip</p>
                                <p class="text-blue-100 mt-1">
                                    Include the page name, document number, and any error message shown on your screen.
                                </p>
                            </div>

                            <div class="rounded-2xl bg-white/10 border border-white/10 p-4">
                                <p class="font-bold">Best for faster support</p>
                                <p class="text-blue-100 mt-1">
                                    Use your official email address and choose the correct issue type.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 md:p-10">
                        <form class="space-y-5" method="POST" action="{{ route('support.store') }}">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.18em] mb-2">Full Name</label>
                                    <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Your full name"
                                        class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                    @error('full_name')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.18em] mb-2">Email Address</label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="your.email@dswd.gov.ph"
                                        class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                    @error('email')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.18em] mb-2">Role / Position</label>
                                    <select name="role" class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-3 text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>— Select Role —</option>
                                        <option value="End User" {{ old('role') === 'End User' ? 'selected' : '' }}>End User</option>
                                        <option value="Procurement" {{ old('role') === 'Procurement' ? 'selected' : '' }}>Procurement</option>
                                        <option value="FA II" {{ old('role') === 'FA II' ? 'selected' : '' }}>FA II</option>
                                        <option value="Super Admin" {{ old('role') === 'Super Admin' ? 'selected' : '' }}>Super Admin</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.18em] mb-2">Issue Type</label>
                                    <select name="issue_type" class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-3 text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                        <option value="" disabled {{ old('issue_type') ? '' : 'selected' }}>— Select Issue Type —</option>
                                        <option value="Login / Access Problem" {{ old('issue_type') === 'Login / Access Problem' ? 'selected' : '' }}>Login / Access Problem</option>
                                        <option value="Document Submission Error" {{ old('issue_type') === 'Document Submission Error' ? 'selected' : '' }}>Document Submission Error</option>
                                        <option value="Approval Workflow Issue" {{ old('issue_type') === 'Approval Workflow Issue' ? 'selected' : '' }}>Approval Workflow Issue</option>
                                        <option value="Notification Not Received" {{ old('issue_type') === 'Notification Not Received' ? 'selected' : '' }}>Notification Not Received</option>
                                        <option value="Other" {{ old('issue_type') === 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('issue_type')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.18em] mb-2">Subject</label>
                                <input type="text" name="subject" value="{{ old('subject') }}" placeholder="Short summary of the issue"
                                    class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                @error('subject')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.18em] mb-2">Describe the Issue</label>
                                <textarea name="description" rows="5" placeholder="Please describe what happened, which screen or document is affected, and any error messages you saw..."
                                    class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition resize-none">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.18em] mb-2">Affected Page / Module</label>
                                <input type="text" name="affected_module" value="{{ old('affected_module') }}" placeholder="Example: Dashboard, Login page, Request submission"
                                    class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                            </div>

                            <div class="pt-2 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                                <p class="text-xs text-slate-500">
                                    Your report will be reviewed by the appropriate support team.
                                </p>

                                <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 hover:bg-blue-800 active:scale-[0.99] text-white text-sm font-bold px-6 py-3.5 shadow-lg shadow-blue-700/20 transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    Submit Report
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>

    {{-- Scroll to top --}}
    <button id="scrollTopBtn"
        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-6 right-6 z-50 w-12 h-12 rounded-full bg-blue-700 text-white flex items-center justify-center shadow-xl opacity-0 pointer-events-none transition-all duration-300 hover:bg-blue-800 hover:scale-110"
        aria-label="Scroll to top">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    <script>
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

        function toggleFaq(btn) {
            const item = btn.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const isOpen = item.classList.contains('open');

            document.querySelectorAll('.faq-item').forEach(el => {
                el.classList.remove('open');
                el.querySelector('.faq-answer').classList.remove('open');
            });

            if (!isOpen) {
                item.classList.add('open');
                answer.classList.add('open');
            }
        }
    </script>
</body>
</html>
