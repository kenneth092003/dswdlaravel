<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">

                    {{-- Welcome message --}}
                    <div>{{ __("You're logged in!") }}</div>

                    {{-- Show logged in account --}}
                    <div>
                        User: <strong>{{ auth()->user()->email }}</strong>
                    </div>

                    {{-- Show roles (names) --}}
                    <div>
                        Role:
                        <strong>
                            {{ auth()->user()->getRoleNames()->join(', ') }}
                        </strong>
                    </div>

                    {{-- Super Admin dashboard --}}
                    @role('Super Admin')
                        <div class="mt-6">
                            <h3 class="text-lg font-bold">Super Admin Dashboard</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><a href="{{ route('users.index') }}" class="text-blue-600 hover:underline">Manage Users</a></li>
                                <li><a href="{{ route('roles.index') }}" class="text-blue-600 hover:underline">Manage Roles</a></li>
                                <li><a href="{{ route('settings.index') }}" class="text-blue-600 hover:underline">System Settings</a></li>
                                <li><a href="{{ route('reports.index') }}" class="text-blue-600 hover:underline">View Reports</a></li>
                            </ul>
                        </div>
                    @endrole

                    {{-- End-user dashboard --}}
                    @role('End User')
                        <div class="mt-6">
                            <h3 class="text-lg font-bold">End-user Dashboard</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><a href="{{ route('requests.create') }}" class="text-blue-600 hover:underline">Create Request</a></li>
                                <li><a href="{{ route('requests.index') }}" class="text-blue-600 hover:underline">Track Requests</a></li>
                            </ul>
                        </div>
                    @endrole

                    @role('Approver')
                        <div class="mt-6">
                            <h3 class="text-lg font-bold">Approver Dashboard</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li>Review proposals submitted by End Users</li>
                                <li>Approve or return PRs for revision</li>
                            </ul>
                        </div>
                    @endrole

                    {{-- Budget dashboard --}}
                    @role('Budget')
                        <div class="mt-6">
                            <h3 class="text-lg font-bold">Budget Dashboard</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><a href="{{ route('budget.approvals') }}" class="text-blue-600 hover:underline">Approve Budgets</a></li>
                                <li><a href="{{ route('budget.reports') }}" class="text-blue-600 hover:underline">View Budget Reports</a></li>
                            </ul>
                        </div>
                    @endrole

                    {{-- Cash dashboard --}}
                    @role('Cash')
                        <div class="mt-6">
                            <h3 class="text-lg font-bold">Cash Dashboard</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><a href="{{ route('cash.disbursements') }}" class="text-blue-600 hover:underline">Manage Disbursements</a></li>
                                <li><a href="{{ route('cash.reports') }}" class="text-blue-600 hover:underline">Cash Reports</a></li>
                            </ul>
                        </div>
                    @endrole

                    {{-- FA II dashboard --}}
                    @role('FA II')
                        <div class="mt-6">
                            <h3 class="text-lg font-bold">FA II Dashboard</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><a href="{{ route('fa.approvals') }}" class="text-blue-600 hover:underline">Approve Requests</a></li>
                                <li><a href="{{ route('fa.reports') }}" class="text-blue-600 hover:underline">Financial Reports</a></li>
                            </ul>
                        </div>
                    @endrole

                    {{-- Procurement dashboard --}}
                    @role('Procurement')
                        <div class="mt-6">
                            <h3 class="text-lg font-bold">Procurement Dashboard</h3>
                            <ul class="list-disc pl-6 space-y-2">
                                <li><a href="{{ route('procurement.requests') }}" class="text-blue-600 hover:underline">Manage Procurement Requests</a></li>
                                <li><a href="{{ route('procurement.reports') }}" class="text-blue-600 hover:underline">Procurement Reports</a></li>
                            </ul>
                        </div>
                    @endrole

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
