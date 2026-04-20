<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure the Super Admin role exists
        Role::firstOrCreate([
            'name'       => 'Super Admin',
            'guard_name' => 'web'
        ]);

        // Create the default Super Admin user
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

        // Assign role via Spatie
        $admin->syncRoles(['Super Admin']);
    }
}
