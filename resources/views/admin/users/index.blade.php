<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Users
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6 overflow-x-auto">

                @if (session('status'))
                    <div class="mb-4 p-3 rounded bg-green-50 text-green-800 text-sm font-semibold">
                        {{ session('status') }}
                    </div>
                @endif

                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="py-2 pr-4">Employee ID</th>
                            <th class="py-2 pr-4">First name</th>
                            <th class="py-2 pr-4">Last name</th>
                            <th class="py-2 pr-4">Email</th>
                            <th class="py-2 pr-4">Role</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2 pr-4">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $u)
                            <tr class="border-b align-top">
                                <td class="py-2 pr-4">{{ $u->employee_id }}</td>
                                <td class="py-2 pr-4">{{ $u->firstname }}</td>
                                <td class="py-2 pr-4">{{ $u->lastname }}</td>
                                <td class="py-2 pr-4">{{ $u->email }}</td>
                                <td class="py-2 pr-4">{{ $u->getRoleNames()->join(', ') }}</td>

                                <td class="py-2 pr-4">
                                    @if ($u->is_approved)
                                        <span class="inline-flex px-2 py-1 rounded bg-green-100 text-green-800 text-xs font-semibold">
                                            Approved
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 rounded bg-yellow-100 text-yellow-800 text-xs font-semibold">
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                <td class="py-2 pr-4 space-x-2">
                                    @if (! $u->is_approved)
                                        <form method="POST" action="{{ route('admin.users.approve', $u) }}" class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-2 rounded bg-blue-700 text-white text-xs font-semibold hover:bg-blue-800">
                                                Approve
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Delete button --}}
                                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-2 rounded bg-red-600 text-white text-xs font-semibold hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>