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
            ['name' => 'view_dashboard', 'display_name' => 'View Dashboard'],

            // Member Management
            ['name' => 'create_member', 'display_name' => 'Create Member'],
            ['name' => 'view_member', 'display_name' => 'View Member'],
            ['name' => 'update_member', 'display_name' => 'Update Member'],
            ['name' => 'delete_member', 'display_name' => 'Delete Member'],
            ['name' => 'approve_member', 'display_name' => 'Approve Member Registration'],

            // Loan Management
            ['name' => 'create_loan', 'display_name' => 'Create Loan'],
            ['name' => 'view_loan', 'display_name' => 'View Loan'],
            ['name' => 'update_loan', 'display_name' => 'Update Loan'],
            ['name' => 'delete_loan', 'display_name' => 'Delete Loan'],
            ['name' => 'approve_loan', 'display_name' => 'Approve Loan Applications'],
            ['name' => 'reject_loan', 'display_name' => 'Reject Loan Applications'],

            // Savings Account Management
            ['name' => 'create_savings', 'display_name' => 'Create Savings Account'],
            ['name' => 'view_savings', 'display_name' => 'View Savings Account'],
            ['name' => 'update_savings', 'display_name' => 'Update Savings Account'],
            ['name' => 'delete_savings', 'display_name' => 'Delete Savings Account'],

            // Transaction Management
            ['name' => 'manage_transactions', 'display_name' => 'Manage Transactions'],
            ['name' => 'view_transactions', 'display_name' => 'View Transactions'],
            ['name' => 'create_transaction', 'display_name' => 'Create Transaction'],
            ['name' => 'update_transaction', 'display_name' => 'Update Transaction'],
            ['name' => 'delete_transaction', 'display_name' => 'Delete Transaction'],

            // Reporting and Settings
            ['name' => 'generate_reports', 'display_name' => 'Generate Reports'],
            ['name' => 'manage_settings', 'display_name' => 'Manage Settings'],

            // Notifications
            ['name' => 'send_notifications', 'display_name' => 'Send Notifications'],

            // Audit Logs
            ['name' => 'view_audit_logs', 'display_name' => 'View Audit Logs'],
        ];

        // Create permissions in the database
        foreach ($permissions as $permission) {
            $createdPermission = Permission::create($permission);
            \Log::info('Created Permission:', ['id' => $createdPermission->id, 'name' => $createdPermission->name]);
        }

        // Assign permissions to roles
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissions(Permission::all()); // Admin gets all permissions

        $managerRole = Role::where('name', 'manager')->first();
        $managerRole->givePermissions([
            'view_dashboard', // Grant access to the dashboard
            'view_reports',
            'create_member',
            'view_member',
            'update_member',
            'delete_member',
            'approve_member',
            'create_loan',
            'view_loan',
            'update_loan',
            'approve_loan',
            'reject_loan',
            'create_savings',
            'view_savings',
            'update_savings',
            'manage_transactions',
            'view_transactions',
            'generate_reports',
            'send_notifications',
        ]);

        $tellerRole = Role::where('name', 'teller')->first();
        $tellerRole->givePermissions([
            'view_dashboard', // Grant access to the dashboard
            'view_member',
            'view_loan',
            'view_savings',
            'view_transactions',
            'create_transaction',
            'update_transaction',
            'delete_transaction',
        ]);

        $collectorRole = Role::where('name', 'collector')->first();
        $collectorRole->givePermissions([
            'view_dashboard', // Grant access to the dashboard
            'view_member',
            'view_loan',
            'view_transactions',
            'create_transaction',
            'delete_transaction',
        ]);

        // Call UserSeeder to create users
        $this->call(UserSeeder::class);
    }
}
