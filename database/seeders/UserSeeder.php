<?php

namespace Database\Seeders;

use App\Models\User; // Import the User model
use Illuminate\Database\Seeder;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database with users.
     */
    public function run(): void
    {
        // Sample users data
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'), // Use a secure password
                'role' => 'admin',
            ],
            [
                'name' => 'Manager User',
                'email' => 'manager@example.com',
                'password' => bcrypt('password'), // Use a secure password
                'role' => 'manager',
            ],
            [
                'name' => 'Teller User',
                'email' => 'teller@example.com',
                'password' => bcrypt('password'), // Use a secure password
                'role' => 'teller',
            ],
            [
                'name' => 'Collector User',
                'email' => 'collector@example.com',
                'password' => bcrypt('password'), // Use a secure password
                'role' => 'collector',
            ],
        ];

        foreach ($users as $userData) {
            // Create the user
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
            ]);

            // Assign the role to the user
            $role = Role::where('name', $userData['role'])->first();
            if ($role) {
                $user->addRole($role);
            }
        }
    }
}
