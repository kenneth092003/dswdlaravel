<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
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
            'role'        => ['required', Rule::in(['End User', 'Procurement', 'FA II', 'Super Admin'])],
        ]);

        $user = DB::transaction(function () use ($request) {
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

            $user->assignRole($request->role);

            $superAdmins = User::role('Super Admin')->get();

            foreach ($superAdmins as $admin) {
                UserNotification::create([
                    'user_id' => $admin->id,
                    'title' => 'New User Registration',
                    'message' => $request->firstname . ' ' . $request->lastname .
                        ' registered as ' . $request->role .
                        ' with employee ID ' . $request->employee_id . '.',
                    'is_read' => false,
                ]);
            }

            return $user;
        });

        event(new Registered($user));

        return redirect()->route('login')
            ->with('status', 'Registration successful. Your account is pending approval.');
    }
}
