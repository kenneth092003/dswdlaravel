<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private const AVAILABLE_ROLES = ['End User', 'Procurement', 'FA II', 'Super Admin'];

    public function index()
    {
        $users = User::query()
            ->with('roles')
            ->when(request('role'), function ($query, $role) {
                $query->whereHas('roles', fn($q) => $q->where('name', $role));
            })
            ->orderBy('employee_id')
            ->paginate(10);
        $pendingApprovalCount = User::where('is_approved', false)->count();
        $signupNotificationCount = UserNotification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->where('title', 'New User Registration')
            ->count();
        $complaintNotificationCount = UserNotification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->whereNotNull('system_issue_id')
            ->count();

        return view('admin.users.index', [
            'users' => $users,
            'availableRoles' => self::AVAILABLE_ROLES,
            'pendingApprovalCount' => $pendingApprovalCount,
            'signupNotificationCount' => $signupNotificationCount,
            'complaintNotificationCount' => $complaintNotificationCount,
        ]);
    }

    public function edit(User $user)
    {
        $user->load('roles');

        return view('admin.users.edit', [
            'user' => $user,
            'availableRoles' => self::AVAILABLE_ROLES,
        ]);
    }

    public function approve(User $user): RedirectResponse
    {
        $user->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        return back()->with('status', 'User approved successfully.');
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'string', Rule::in(self::AVAILABLE_ROLES)],
        ]);

        DB::transaction(function () use ($user, $validated): void {
            $user->update([
                'role' => $validated['role'],
            ]);

            $user->syncRoles([$validated['role']]);
        });

        return back()->with('status', 'User role updated successfully.');
    }

    public function toggleApproval(User $user): RedirectResponse
    {
        $isApproved = ! $user->is_approved;

        $user->update([
            'is_approved' => $isApproved,
            'approved_at' => $isApproved ? now() : null,
        ]);

        $message = $isApproved
            ? 'User account activated successfully.'
            : 'User account suspended successfully.';

        return back()->with('status', $message);
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('status', 'User deleted successfully.');
    }
}
