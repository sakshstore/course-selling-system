<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $adminRole = Role::create(['name' => 'admin']);

        // Find the user with ID 1
        $user = User::find(1);

        // Assign the admin role to the user
        if ($user) {
            $user->assignRole($adminRole);
        }



    }
}
