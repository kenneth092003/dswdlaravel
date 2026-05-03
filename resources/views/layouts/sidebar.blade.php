<aside class="w-64 bg-white border-r min-h-[calc(100vh-4rem)]">
    <div class="p-4 font-semibold text-gray-700">
        Menu
    </div>

    <nav class="px-2 pb-4 space-y-1">
        <a href="{{ route('dashboard') }}"
           class="block px-3 py-2 rounded hover:bg-gray-100">
            Dashboard
        </a>

        @role('Approver')
            <a href="{{ route('approver.dashboard') }}"
               class="block px-3 py-2 rounded hover:bg-gray-100">
                Approver Dashboard
            </a>
        @endrole

        @role('Super Admin')
            <a href="{{ route('admin.users.index') }}"
               class="block px-3 py-2 rounded hover:bg-gray-100">
                All Users
            </a>
        @endrole
    </nav>
</aside>
