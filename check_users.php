<?php

require_once __DIR__.'/vendor/autoload.php';

use App\Models\User;

// 创建 Laravel 应用实例
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// 检查用户
$users = User::all();
echo "Users in database:\n";
foreach ($users as $user) {
    echo "- {$user->email} - {$user->name}\n";
}

// 检查特定用户是否存在
$adminUser = User::where('email', 'admin@example.com')->first();
if ($adminUser) {
    echo "\nAdmin user found:\n";
    echo "Email: {$adminUser->email}\n";
    echo "Name: {$adminUser->name}\n";
} else {
    echo "\nAdmin user NOT found!\n";
}