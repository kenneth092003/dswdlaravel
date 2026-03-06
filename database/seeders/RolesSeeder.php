<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure roles exist
        foreach (['Superadmin','Enduser','Budget','Cash','FAII','Procurement'] as $r) {
            Role::firstOrCreate(['name' => $r]);
        }

        // Find YOUR existing user and make them Superadmin
        $user = User::where('email', 'kinley.cartagenas@hcdc.edu.ph')->first();

        if (! $user) {
            // If user doesn't exist yet, stop with a clear message
            $this->command?->error('User kinley.cartagenas@hcdc.edu.ph not found in users table.');
            return;
        }

        // Make Superadmin (syncRoles replaces any existing roles) [web:124]
        $user->syncRoles(['Superadmin']); // [web:124]

        // If you want to keep existing roles and just add Superadmin, use this instead: [web:124]
        // $user->assignRole('Superadmin'); // [web:124]
    }
}
