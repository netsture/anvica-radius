<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $userRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'manager']);
        $userRole = Role::firstOrCreate(['name' => 'billing']);
        $userRole = Role::firstOrCreate(['name' => 'eligibility']);

        // Create permissions
        // $permissions = ['edit posts', 'delete posts', 'create posts'];
        // foreach ($permissions as $permission) {
        //     Permission::firstOrCreate(['name' => $permission]);
        // }

        // Assign permissions to roles
        // $adminRole->syncPermissions($permissions);
        // $userRole->syncPermissions(['create posts']);

        // Create an Admin User
        $superadmin = User::firstOrCreate([
            'email' => 'abhay@admin.com',
        ], [
            'username' => 'vijay',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);
        $superadmin->assignRole('superadmin');

        $admin = User::firstOrCreate([
            'email' => 'samir@gmail.com',
        ], [
            'username' => 'samir',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);
        $admin->assignRole('admin');

        // Create a Normal User
        // $user = User::firstOrCreate([
        //     'email' => 'user@user.com',
        // ], [
        //     'username' => 'user',
        //     'password' => Hash::make('123456'),
        // ]);
        // $user->assignRole('user');
    }
}
