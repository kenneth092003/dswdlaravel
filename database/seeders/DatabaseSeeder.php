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
        $roles = [
            'End-user',
            'Procurement',
            'FA II',
            'Super Admin',
        ];

        foreach ($roles as $r) {
            Role::firstOrCreate(['name' => $r, 'guard_name' => 'web']);
        }

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

        $admin->assignRole('Super Admin'); // ✅ eksakto sa role name
    }
}