@extends('layouts.enduser')

@section('content')
<div class="container px-4 py-6 mx-auto">

    <h1 class="mb-6 text-2xl font-bold">Edit Profile</h1>

    @if(session('success'))
        <div class="p-3 mb-4 text-green-700 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('enduser.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            <div>
                <label class="block font-medium">First Name</label>
                <input type="text"
                       name="firstname"
                       value="{{ old('firstname', auth()->user()->firstname) }}"
                       class="w-full px-3 py-2 border rounded">
            </div>

            <div>
                <label class="block font-medium">Last Name</label>
                <input type="text"
                       name="lastname"
                       value="{{ old('lastname', auth()->user()->lastname) }}"
                       class="w-full px-3 py-2 border rounded">
            </div>

            <div>
                <label class="block font-medium">Employee ID</label>
                <input type="text"
                       name="employee_id"
                       value="{{ old('employee_id', auth()->user()->employee_id) }}"
                       class="w-full px-3 py-2 border rounded">
            </div>

            <div>
                <label class="block font-medium">Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email', auth()->user()->email) }}"
                       class="w-full px-3 py-2 border rounded">
            </div>

        </div>

        <div class="mt-6">
            <button class="px-4 py-2 text-white bg-blue-600 rounded">
                Update Profile
            </button>
        </div>

    </form>

</div>
@endsection