<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Super Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    
                    {{-- Welcome message --}}
                    <h3 class="text-lg font-bold">Welcome, {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h3>
                    <p>You are logged in as <strong>{{ auth()->user()->email }}</strong></p>
                    <p>Your role: <strong>{{ auth()->user()->getRoleNames()->join(', ') }}</strong></p>

                    {{-- Super Admin features --}}
                    <div class="mt-6">
                        <h4 class="text-md font-semibold">Super Admin Tools</h4>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline">Manage Users</a></li>
                            {{-- Add these routes in web.php if needed --}}
                            <li><a href="{{ route('admin.roles.index') }}" class="text-blue-600 hover:underline">Manage Roles</a></li>
                            <li><a href="{{ route('admin.settings.index') }}" class="text-blue-600 hover:underline">System Settings</a></li>
                            <li><a href="{{ route('admin.reports.index') }}" class="text-blue-600 hover:underline">View Reports</a></li>
                        </ul>
                    </div>

                    {{-- Optional quick stats --}}
                    <div class="mt-6">
                        <h4 class="text-md font-semibold">Quick Stats</h4>
                        <p>Total Users: {{ \App\Models\User::count() }}</p>
                        <p>Total Roles: {{ \Spatie\Permission\Models\Role::count() }}</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>