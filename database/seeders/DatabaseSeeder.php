<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 创建权限
        $permissions = [
            ['name' => 'view_users', 'display_name' => 'View Users', 'description' => 'Can view users'],
            ['name' => 'create_users', 'display_name' => 'Create Users', 'description' => 'Can create users'],
            ['name' => 'edit_users', 'display_name' => 'Edit Users', 'description' => 'Can edit users'],
            ['name' => 'delete_users', 'display_name' => 'Delete Users', 'description' => 'Can delete users'],
            ['name' => 'view_roles', 'display_name' => 'View Roles', 'description' => 'Can view roles'],
            ['name' => 'create_roles', 'display_name' => 'Create Roles', 'description' => 'Can create roles'],
            ['name' => 'edit_roles', 'display_name' => 'Edit Roles', 'description' => 'Can edit roles'],
            ['name' => 'delete_roles', 'display_name' => 'Delete Roles', 'description' => 'Can delete roles'],
            ['name' => 'view_permissions', 'display_name' => 'View Permissions', 'description' => 'Can view permissions'],
            ['name' => 'create_permissions', 'display_name' => 'Create Permissions', 'description' => 'Can create permissions'],
            ['name' => 'edit_permissions', 'display_name' => 'Edit Permissions', 'description' => 'Can edit permissions'],
            ['name' => 'delete_permissions', 'display_name' => 'Delete Permissions', 'description' => 'Can delete permissions'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        // 创建角色
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Administrator',
                'description' => 'Administrator role with full permissions'
            ]
        );
        
        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            [
                'display_name' => 'User',
                'description' => 'Regular user role'
            ]
        );

        // 将所有权限分配给管理员角色
        $adminRole->permissions()->sync(Permission::all()->pluck('id')->toArray());
        
        // 创建管理员用户
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
            ]
        );
        
        $adminUser->roles()->sync([$adminRole->id]);

        // 创建普通用户
        $regularUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password123'),
            ]
        );
        
        $regularUser->roles()->sync([$userRole->id]);
        
        echo "Database seeded successfully!\n";
        echo "Admin login: admin@example.com / password123\n";
        echo "User login: user@example.com / password123\n";
    }
}