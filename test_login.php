<?php

require_once __DIR__.'/vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// 创建 Laravel 应用实例
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// 检查用户密码
$adminUser = User::where('email', 'admin@example.com')->first();
if ($adminUser) {
    echo "Testing login for: {$adminUser->email}\n";
    $password = 'password123';
    $isValid = Hash::check($password, $adminUser->password);
    echo "Password 'password123' is " . ($isValid ? "VALID" : "INVALID") . "\n";
    
    echo "Hash in database: {$adminUser->password}\n";
} else {
    echo "Admin user NOT found!\n";
}