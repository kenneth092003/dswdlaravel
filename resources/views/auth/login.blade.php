<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PRTS') }} - Login</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white overflow-hidden">
<div class="h-screen grid grid-cols-1 lg:grid-cols-2">

    {{-- LEFT PANEL --}}
    <div class="relative hidden lg:block h-screen overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('image/pic1.png') }}" class="h-full w-full object-cover" alt="Background">
            <div class="absolute inset-0 bg-blue-900/60"></div>
        </div>

        <div class="relative p-10 h-full flex flex-col justify-between text-white">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('image/dswd3.png') }}" class="h-14 w-14 object-contain" alt="DSWD">
                    <div class="leading-tight">
                        <div class="text-3xl font-extrabold">DSWD</div>
                        <div class="text-sm font-semibold text-white/90">Dept. of Social Welfare and Development</div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <img src="{{ asset('image/logo1.png') }}" class="h-13 w-20 object-contain" alt="Pantawid">
                    <div class="text-sm font-semibold leading-tight">
                        Pantawid Pamilyang<br/>Pilipino Program
                    </div>
                </div>
            </div>

            <div class="pb-8">
                <div class="text-yellow-300 text-7xl font-semibold italic tracking-wide">
                    Padayon!
                </div>
                <div class="mt-4 text-2xl font-semibold text-white/95">
                    Steering Towards Beneficiaries Self-Sufficiency
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="flex items-center justify-center p-6 sm:p-10 bg-white h-screen overflow-hidden">
        <div class="w-full max-w-xl">

            <div class="text-sm font-extrabold tracking-widest text-slate-500">
                SECURE ACCESS PORTAL
            </div>
            <h1 class="mt-2 text-5xl font-extrabold text-slate-900"
                style="font-family: ui-serif, Georgia, Cambria, 'Times New Roman', Times, serif;">
                Welcome Back
            </h1>
            <p class="mt-2 text-slate-600 font-semibold">
                Sign in to your DSWD account to continue
            </p>

            <div class="mt-10">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="!font-extrabold !text-slate-700 tracking-wide" />
                        <x-text-input id="email" class="block mt-2 w-full !rounded-xl !py-3"
                                      type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- PASSWORD WITH RIGHT-SIDE TOGGLE --}}
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="!font-extrabold !text-slate-700 tracking-wide" />

                        <div class="relative mt-2">
                            <x-text-input id="passwordField"
                                          class="block w-full !rounded-xl !py-3 !pr-12"
                                          type="password"
                                          name="password"
                                          required
                                          autocomplete="current-password" />

                            <button type="button"
                                    onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-500 hover:text-slate-700">

                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>

                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center gap-2">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300" name="remember">
                            <span class="text-sm font-semibold text-slate-600">REMEMBER ME</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-semibold text-blue-900 hover:underline"
                               href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                            class="w-full py-4 rounded-2xl bg-blue-950 text-white font-extrabold text-lg shadow hover:bg-blue-900">
                        Sign In to System
                    </button>

                    @if (Route::has('register'))
                        <div class="text-center text-sm font-semibold text-slate-700">
                            Don’t have an account?
                            <a class="text-blue-900 hover:underline" href="{{ route('register') }}">SIGN UP</a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="mt-10">
                <div class="flex items-center gap-4">
                    <div class="h-px bg-slate-300 flex-1"></div>
                    <div class="text-sm font-extrabold text-slate-600">Need assistance ?</div>
                    <div class="h-px bg-slate-300 flex-1"></div>
                </div>

                <div class="mt-4 border rounded-2xl p-4 flex items-center gap-4">
                    <div class="h-12 w-12 rounded-full border flex items-center justify-center">
                        <svg viewBox="0 0 24 24" class="h-7 w-7 text-rose-700" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.9v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.86.3 1.7.54 2.5a2 2 0 0 1-.45 2.11L8.1 9.9a16 16 0 0 0 6 6l1.57-1.1a2 2 0 0 1 2.11-.45c.8.24 1.64.42 2.5.54A2 2 0 0 1 22 16.9z"/>
                        </svg>
                    </div>

                    <div>
                        <div class="font-extrabold text-slate-900">Contact IT Support</div>
                        <div class="text-sm font-semibold text-slate-600">
                            For account issues, call ext. 2100 or email itsupport@dswd.gov.ph
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
function togglePassword() {
    const input = document.getElementById('passwordField');
    const icon = document.getElementById('eyeIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20C5 20 1 12 1 12a21.77 21.77 0 0 1 5.06-6.94"/>
            <path d="M9.53 9.53a3 3 0 0 0 4.24 4.24"/>
            <path d="M1 1l22 22"/>
        `;
    } else {
        input.type = 'password';
        icon.innerHTML = `
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
            <circle cx="12" cy="12" r="3"/>
        `;
    }
}
</script>

</body>
</html>
