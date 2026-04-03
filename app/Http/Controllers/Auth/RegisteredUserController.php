<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname'   => ['required', 'string', 'max:255'],
            'lastname'    => ['required', 'string', 'max:255'],
            'employee_id' => ['required', 'string', 'max:50', 'unique:users,employee_id'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
            // ✅ Fixed: exact Spatie role names (no hyphen, correct spacing)
            'role'        => ['required', Rule::in(['End User', 'Procurement', 'FA II', 'Super Admin'])],
        ]);

        $user = User::create([
            'employee_id' => $request->employee_id,
            'firstname'   => $request->firstname,
            'lastname'    => $request->lastname,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'is_approved' => false,
            'approved_at' => null,
            'role'        => $request->role,
        ]);

        // ✅ Assign Spatie role using exact role name
        $user->assignRole($request->role);

        event(new Registered($user));

        return redirect()->route('login')
            ->with('status', 'Registration successful. Your account is pending approval.');
    }
}