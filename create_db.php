<?php
// 创建数据库文件

$dbPath = 'database/database.sqlite';

if (!file_exists($dbPath)) {
    // 确保目录存在
    if (!is_dir('database')) {
        mkdir('database', 0755, true);
    }
    
    // 创建空的SQLite数据库文件
    $db = new SQLite3($dbPath);
    $db->exec('CREATE TABLE IF NOT EXISTS test_table (id INTEGER PRIMARY KEY);');
    $db->exec('DROP TABLE test_table;'); // 删除测试表
    $db->close();
    
    echo "SQLite数据库文件已创建: " . realpath($dbPath) . "\n";
} else {
    echo "SQLite数据库文件已存在: " . realpath($dbPath) . "\n";
}