<?php

// 清除Laravel缓存的脚本

require_once __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\Artisan;

// 创建应用实例
$app = require_once __DIR__.'/bootstrap/app.php';

// 启动内核
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // 清除配置缓存
    echo "清除配置缓存...\n";
    Artisan::call('config:clear');
    echo "配置缓存已清除。\n";

    // 清除路由缓存
    echo "清除路由缓存...\n";
    Artisan::call('route:clear');
    echo "路由缓存已清除。\n";

    // 清除视图缓存
    echo "清除视图缓存...\n";
    Artisan::call('view:clear');
    echo "视图缓存已清除。\n";

    // 清除所有缓存
    echo "清除应用缓存...\n";
    Artisan::call('cache:clear');
    echo "应用缓存已清除。\n";

    echo "\n所有缓存已清除，现在可以访问管理界面查看新菜单项。\n";
} catch (Exception $e) {
    echo "错误: " . $e->getMessage() . "\n";
}