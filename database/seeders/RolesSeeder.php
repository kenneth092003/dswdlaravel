<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Delete old incorrect role names
        Role::whereIn('name', ['Superadmin', 'Enduser', 'FAII', 'End-user', 'Budget', 'Cash'])
            ->delete();

        // ✅ Create correct role names (must match exactly what the code checks)
        foreach (['Super Admin', 'End User', 'Approver', 'Procurement', 'FA II'] as $r) {
            Role::firstOrCreate(['name' => $r, 'guard_name' => 'web']);
        }

        // ✅ Create or find the default Super Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'firstname'   => 'System',
                'lastname'    => 'Administrator',
                'employee_id' => '000001',
                'password'    => Hash::make('password'),
                'is_approved' => true,
                'approved_at' => now(),
                'role'        => 'Super Admin',
            ]
        );

        // ✅ Assign Spatie role — this is what getRoleNames() reads
        $admin->syncRoles(['Super Admin']);
    }
}
