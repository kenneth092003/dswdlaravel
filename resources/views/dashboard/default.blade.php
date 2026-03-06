<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Default Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <h3 class="text-lg font-bold">Welcome, {{ auth()->user()->name }}</h3>
                    <p>You are logged in as <strong>{{ auth()->user()->email }}</strong></p>
                    <p>Your role: <strong>{{ auth()->user()->getRoleNames()->join(', ') }}</strong></p>

                    <div class="mt-6">
                        <h4 class="text-md font-semibold">User Tools</h4>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><a href="{{ route('profile.edit') }}" class="text-blue-600 hover:underline">Edit Profile</a></li>
                            <li><a href="#" class="text-blue-600 hover:underline">View Requests</a></li>
                            <li><a href="#" class="text-blue-600 hover:underline">Support</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>