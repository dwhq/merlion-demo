<?php
// 创建SQLite数据库文件的脚本

// 确保database目录存在
if (!is_dir('database')) {
    mkdir('database', 0755, true);
    echo "Created database directory\n";
} else {
    echo "Database directory already exists\n";
}

// 检查数据库文件是否存在
$dbPath = 'database/database.sqlite';

if (!file_exists($dbPath)) {
    // 创建一个空的SQLite数据库文件
    $fp = fopen($dbPath, 'w');
    if ($fp) {
        fclose($fp);
        echo "Created empty SQLite database file\n";
    } else {
        echo "Failed to create database file\n";
    }
    
    // 验证是否成功创建
    if (file_exists($dbPath)) {
        echo "Database file exists at: " . realpath($dbPath) . "\n";
        
        // 尝试用SQLite3打开并初始化
        try {
            $db = new SQLite3($dbPath);
            $db->exec('CREATE TABLE IF NOT EXISTS migrations (id INTEGER PRIMARY KEY);');
            $db->exec('DROP TABLE migrations;'); // 清理测试表
            $db->close();
            echo "Database file is valid SQLite file\n";
        } catch (Exception $e) {
            echo "Error with SQLite file: " . $e->getMessage() . "\n";
        }
    }
} else {
    echo "Database file already exists at: " . realpath($dbPath) . "\n";
}