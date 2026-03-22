<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PRTS') }} - Register</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white">
<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    {{-- LEFT PANEL --}}
    <div class="relative hidden lg:block">
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
    <div class="flex items-center justify-center p-6 sm:p-10 bg-white">
        <div class="w-full max-w-xl">

            <div class="text-sm font-extrabold tracking-widest text-slate-500">
                SECURE ACCESS PORTAL
            </div>
            <h1 class="mt-2 text-5xl font-extrabold text-slate-900"
                style="font-family: ui-serif, Georgia, Cambria, 'Times New Roman', Times, serif;">
                Welcome Back
            </h1>
            <p class="mt-2 text-slate-600 font-semibold">
                Sign Up to you DSWD account to continue
            </p>

            <form method="POST" action="{{ route('register') }}" class="mt-10 space-y-6">
                @csrf

                {{-- LASTNAME + FIRSTNAME --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="lastname" class="block text-sm font-extrabold text-slate-700 tracking-wide">
                            LASTNAME
                        </label>
                        <input id="lastname" name="lastname" type="text" value="{{ old('lastname') }}"
                               required autofocus autocomplete="family-name"
                               class="mt-2 w-full rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700 py-3 px-4">
                        <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
                    </div>

                    <div>
                        <label for="firstname" class="block text-sm font-extrabold text-slate-700 tracking-wide">
                            FIRSTNAME
                        </label>
                        <input id="firstname" name="firstname" type="text" value="{{ old('firstname') }}"
                               required autocomplete="given-name"
                               class="mt-2 w-full rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700 py-3 px-4">
                        <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
                    </div>
                </div>

                {{-- EMPLOYEE ID --}}
                <div>
                    <label for="employee_id" class="block text-sm font-extrabold text-slate-700 tracking-wide">
                        EMPLOYEE ID
                    </label>
                    <input id="employee_id" name="employee_id" type="text" value="{{ old('employee_id') }}"
                           required autocomplete="off"
                           class="mt-2 w-full rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700 py-3 px-4">
                    <x-input-error :messages="$errors->get('employee_id')" class="mt-2" />
                </div>

                {{-- EMAIL --}}
            <div>
                <label for="email" class="block text-sm font-extrabold text-slate-700 tracking-wide">
                    EMAIL
                </label>
                <input id="email" name="email" type="email" value="{{ old('email') }}"
           required autocomplete="email"
           class="mt-2 w-full rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700 py-3 px-4">
                  <x-input-error :messages="$errors->get('email')" class="mt-2" />
               </div>

                {{-- PASSWORD --}}
                <div>
                    <label for="password" class="block text-sm font-extrabold text-slate-700 tracking-wide">
                        PASSWORD
                    </label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                           class="mt-2 w-full rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700 py-3 px-4">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-extrabold text-slate-700 tracking-wide">
                        CONFIRM PASSWORD
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           required autocomplete="new-password"
                           class="mt-2 w-full rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700 py-3 px-4">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                {{-- ROLE --}}
                <div>
                    <label for="role" class="block text-sm font-extrabold text-slate-700 tracking-wide">
                        ROLE
                    </label>

                    <select id="role" name="role" required
                            class="mt-2 w-full rounded-xl border-slate-300 focus:border-slate-700 focus:ring-slate-700 py-3 px-4">
                        <option value="" disabled @selected(old('role') === null)>Select role</option>
                        <option value="End User" @selected(old('role')==='End User')>Enduser</option>
                        <option value="Procurement" @selected(old('role')==='Procurement')>Procurement</option>
                        <option value="FA II" @selected(old('role')==='FA II')>FA II</option>
                        <option value="Super Admin" @selected(old('role')==='Super Admin')>Super Admin</option>
                    </select>

                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <button type="submit"
                        class="w-full py-4 rounded-2xl bg-blue-950 text-white font-extrabold text-lg shadow hover:bg-blue-900">
                    Approve to Admin
                </button>

                <div class="text-center text-sm font-semibold text-slate-700">
                    You have an account?
                    <a class="text-blue-900 hover:underline" href="{{ route('login') }}">SIGN IN</a>
                </div>
            </form>

        </div>
    </div>

</div>
</body>
</html>
