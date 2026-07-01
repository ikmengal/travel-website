<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'dashboard',
            'users',
            'roles',
            'permissions',
            'countries',
            'states',
            'cities',
            'destinations',
            'categories',
            'packages',
            'bookings',
            'payments',
            'coupons',
            'reviews',
            'blogs',
            'faqs',
            'contacts',
            'newsletters',
            'settings',
            'profile',
        ];

        $actions = [
            'list',
            'view',
            'create',
            'edit',
            'delete',
            'restore',
            'force-delete',
            'export',
            'print',
            'change-status',
        ];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'label' => "{$module}",
                    'name' => "{$module}-{$action}",
                    'guard_name' => 'web',
                ]);
            }
        }
    }
}
