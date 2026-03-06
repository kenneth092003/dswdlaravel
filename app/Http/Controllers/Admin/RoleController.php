<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.roles.index');
    }

    public function update(Request $request)
    {
        $permissions = $request->input('permissions', []);

        $roleMap = [
            'super_admin' => 'Super Admin',
            'end_user'    => 'End User',
            'procurement' => 'Procurement',
            'fa_ii'       => 'FA II',
        ];

        foreach ($roleMap as $key => $roleName) {
            $role = Role::findByName($roleName, 'web');
            $granted = array_keys($permissions[$key] ?? []);

            // Ensure permissions exist, then sync
            $permissionModels = collect($granted)->map(function ($perm) {
                return Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
            });

            $role->syncPermissions($permissionModels);
        }

        return response()->json(['message' => 'Permissions saved successfully!']);
    }
}