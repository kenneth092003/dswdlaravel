<header class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <div class="flex items-center gap-3">
            {{-- Use url('/') to go back to welcome --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('image/dswd3.png') }}" alt="Logo" class="h-12 w-12 object-contain">
                <div class="leading-tight">
                    <div class="text-sm text-slate-700 font-semibold">Republic of the Philippines</div>
                    <div class="text-xl font-extrabold text-slate-900">DSWD</div>
                    <div class="text-xs text-rose-700 font-semibold">Dept. of Social Welfare and Development</div>
                </div>
            </a>
        </div>

        <nav class="hidden md:flex items-center gap-8 text-slate-700 font-medium">
            <a class="hover:text-slate-900" href="{{ route('about') }}">About</a>
            <a class="hover:text-slate-900" href="{{ route('features') }}">Feature</a>
            <a class="hover:text-slate-900" href="{{ route('support') }}">Support</a>
        </nav>

        <a href="{{ route('login') }}"
           class="px-6 py-3 rounded-full bg-blue-800 text-white font-semibold shadow hover:bg-blue-900">
            Sign In to System
        </a>
    </div>

    {{-- optional red line like your About mockup --}}
    <div class="h-1 bg-rose-700"></div>
</header>