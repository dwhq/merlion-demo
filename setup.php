<?php

// 设置脚本，用于初始化项目
echo "Setting up Merlion Demo Project...\n";

// 检查是否已安装 composer 依赖
if (!file_exists('vendor/autoload.php')) {
    echo "Installing composer dependencies...\n";
    exec('composer install');
}

// 检查 .env 文件是否存在
if (!file_exists('.env')) {
    echo "Creating .env file...\n";
    if (file_exists('.env.example')) {
        copy('.env.example', '.env');
    } else {
        echo "Error: .env.example file not found\n";
        exit(1);
    }
}

// 生成应用密钥
echo "Generating application key...\n";
exec('php artisan key:generate');

// 运行数据库迁移
echo "Running database migrations...\n";
exec('php artisan migrate --force');

// 运行数据库种子
echo "Seeding database...\n";
exec('php artisan db:seed');

echo "Setup completed successfully!\n";
echo "To start the server, run: php artisan serve\n";
echo "Admin login: admin@example.com / password123\n";
