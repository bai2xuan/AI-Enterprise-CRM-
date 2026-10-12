<?php
/**
 * SuiteCRM 部署自检脚本
 * 用途：验证 config.php、数据库连接、admin 账号状态
 */
$root = __DIR__ . '/../../';
chdir($root);

require_once 'config.php';

echo "=== config.php 读取 ===\n";
echo "site_url     : " . ($sugar_config['site_url'] ?? '(未设置)') . "\n";
echo "db_host_name : " . ($sugar_config['dbconfig']['db_host_name'] ?? '') . "\n";
echo "db_port      : " . ($sugar_config['dbconfig']['db_port'] ?? '') . "\n";
echo "db_user_name : " . ($sugar_config['dbconfig']['db_user_name'] ?? '') . "\n";
echo "db_name      : " . ($sugar_config['dbconfig']['db_name'] ?? '') . "\n";
echo "db_password 长度: " . strlen($sugar_config['dbconfig']['db_password'] ?? '') . "\n";

echo "\n=== 数据库连接测试 ===\n";
$db = mysqli_connect(
    $sugar_config['dbconfig']['db_host_name'],
    $sugar_config['dbconfig']['db_user_name'],
    $sugar_config['dbconfig']['db_password'],
    $sugar_config['dbconfig']['db_name'],
    (int) ($sugar_config['dbconfig']['db_port'] ?: 3306)
);
if ($db) {
    echo "连接成功\n";
    $r = mysqli_query($db, "SELECT count(*) AS c FROM information_schema.tables WHERE table_schema='suitecrm'");
    $row = mysqli_fetch_assoc($r);
    echo "表数量: " . $row['c'] . "\n";
    $r2 = mysqli_query($db, "SELECT id, user_name, is_admin, status, LENGTH(user_hash) AS hlen FROM users");
    while ($u = mysqli_fetch_assoc($r2)) {
        echo "用户: {$u['user_name']} | admin={$u['is_admin']} | status={$u['status']} | hash_len={$u['hlen']}\n";
    }
} else {
    echo "连接失败: " . mysqli_connect_error() . "\n";
}
