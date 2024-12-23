<?php

namespace Database\Seeders;

use App\Models\User; // Make sure to import the User model
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Laratrust\Models\LaratrustRole;
use Laratrust\Models\LaratrustPermission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Truncate tables if needed
        if (config('laratrust.truncate_tables')) {
            Role::truncate();
            Permission::truncate();
            User::truncate(); // Truncate users table
        }

        // Create roles
        $roles = [
            ['name' => 'admin', 'display_name' => 'Admin'],
            ['name' => 'manager', 'display_name' => 'Manager'],
            ['name' => 'teller', 'display_name' => 'Teller'],
            ['name' => 'collector', 'display_name' => 'Collector'],
        ];

        foreach ($roles as $role) {
            $createdRole = Role::create($role);
            \Log::info('Created Role:', ['id' => $createdRole->id, 'name' => $createdRole->name]);
        }

        // Create permissions
        $permissions = [
            ['name' => 'manage_users', 'display_name' => 'Manage Users'],
            ['name' => 'view_reports', 'display_name' => 'View Reports'],
            ['name' => 'create_payments', 'display_name' => 'Create Payments'],
            ['name' => 'read_payments', 'display_name' => 'Read Payments'],
            ['name' => 'update_payments', 'display_name' => 'Update Payments'],
            ['name' => 'delete_payments', 'display_name' => 'Delete Payments'],
            ['name' => 'view-dashboard', 'display_name' => 'View Dashboard'],
        ];

        foreach ($permissions as $permission) {
            $createdPermission = Permission::create($permission);
            \Log::info('Created Permission:', ['id' => $createdPermission->id, 'name' => $createdPermission->name]);
        }

        // Assign permissions to roles
        $managerRole = Role::where('name', 'manager')->first();
        $managerRole->givePermissions(['manage_users', 'view_reports', 'create_payments', 'read_payments', 'update_payments', 'delete_payments', 'view-dashboard']);

        // Create users
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
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
            ]);

            // Assign the role to the user
            $role = Role::where('name', $userData['role'])->first();
            $user->addRole($role);
        }
    }
}
