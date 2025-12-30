<?php

require_once __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Create the application
$app = require_once __DIR__.'/bootstrap/app.php';

// Set the application in the container
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Run migrations
$exitCode = Artisan::call('migrate', [
    '--force' => true // This is required for production envs
]);

echo "Migration completed with exit code: $exitCode\n";

// Add a test user
use App\Models\User;

if (User::count() === 0) {
    User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);
    echo "Created admin user: admin@example.com / password\n";
}

// Add some test roles
use App\Models\Role;

if (Role::count() === 0) {
    Role::create([
        'name' => 'admin',
        'display_name' => 'Administrator',
        'description' => 'Administrator role with full permissions'
    ]);
    
    Role::create([
        'name' => 'user',
        'display_name' => 'Regular User',
        'description' => 'Regular user role'
    ]);
    
    echo "Created test roles\n";
}

// Add some test permissions
use App\Models\Permission;

if (Permission::count() === 0) {
    Permission::create([
        'name' => 'manage_users',
        'display_name' => 'Manage Users',
        'description' => 'Permission to manage users'
    ]);
    
    Permission::create([
        'name' => 'manage_roles',
        'display_name' => 'Manage Roles',
        'description' => 'Permission to manage roles'
    ]);
    
    echo "Created test permissions\n";
}

echo "Setup completed successfully!\n";