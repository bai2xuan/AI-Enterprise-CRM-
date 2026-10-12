<?php
/**
 * ============================================================
 * SuiteCRM 管理员密码重置脚本
 * ============================================================
 * 用途：在自动化部署场景下，确定性地设置/重置指定用户的登录密码，
 *       避免人工通过网页修改。
 *
 * 用法：
 *   php scripts/reset-admin-password.php [用户名]
 *
 * 密码来源：读取 data/.pw 文件（避免命令行中出现明文密码）
 *
 * 算法说明（SuiteCRM 7.15）：
 *   user_hash = password_hash( strtolower( md5($password) ), PASSWORD_DEFAULT )
 * ============================================================
 */

$projectRoot = dirname(__DIR__, 2);
$crmRoot     = $projectRoot . '/crm';

$userName = $argv[1] ?? 'admin';

// ---- 读取密码 ----
$pwFile = $projectRoot . '/data/.pw';
if (!is_file($pwFile)) {
    fwrite(STDERR, "找不到密码文件：{$pwFile}\n");
    exit(1);
}
$password = trim(file_get_contents($pwFile));
if ($password === '') {
    fwrite(STDERR, "密码为空\n");
    exit(1);
}

// ---- 读取数据库配置 ----
$configFile = $crmRoot . '/config.php';
if (!is_file($configFile)) {
    fwrite(STDERR, "找不到 config.php，请先完成 SuiteCRM 安装\n");
    exit(1);
}
require $configFile;
$dbc = $sugar_config['dbconfig'];

$port = (int)($dbc['db_port'] ?: 3306);
$db = mysqli_connect($dbc['db_host_name'], $dbc['db_user_name'], $dbc['db_password'], $dbc['db_name'], $port);
if (!$db) {
    fwrite(STDERR, "数据库连接失败: " . mysqli_connect_error() . "\n");
    exit(1);
}
mysqli_set_charset($db, 'utf8mb4');

// ---- 生成哈希 ----
$hash = password_hash(strtolower(md5($password)), PASSWORD_DEFAULT);

// ---- 更新 ----
$stmt = mysqli_prepare($db, "UPDATE users SET user_hash = ? WHERE user_name = ?");
mysqli_stmt_bind_param($stmt, 'ss', $hash, $userName);
mysqli_stmt_execute($stmt);
$affected = mysqli_stmt_affected_rows($stmt);

if ($affected > 0) {
    echo "[OK] 用户 {$userName} 的密码已重置（影响 {$affected} 行）\n";
    echo "     密码长度: " . strlen($password) . " 字符\n";
} else {
    echo "[WARN] 未找到用户 {$userName}，或密码未发生变化\n";
}

mysqli_close($db);
