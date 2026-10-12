<?php
/**
 * apply-locale-preferences.php —— 统一"本地化显示偏好"（日期 / 时间 / 货币）
 * ==================================================================
 * 背景：
 *   `config_override.php` 里的 default_date_format 只影响【新建用户】的初始值，
 *   已存在的用户（尤其静默安装阶段创建的 admin）仍会保留 en_us 的
 *   `datef = m/d/Y`，于是所有列表页的日期都显示成 09/24/2026，
 *   对中文项目演示很不友好。
 *
 * 本脚本把「日期 / 时间」显示偏好直接写入每个用户的全局偏好，
 * 不改核心代码，也不影响 SuiteCRM 升级。
 *
 * 用法：php scripts/apply-locale-preferences.php
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

chdir(dirname(__DIR__, 2) . '/crm');
require_once 'include/entryPoint.php';

/** 目标偏好：ISO 风格的日期 + 24 小时制时间，符合中文用户阅读习惯 */
$prefs = array(
    'datef' => 'Y-m-d',
    'timef' => 'H:i',
);

$db = DBManagerFactory::getInstance();
$res = $db->query("SELECT id, user_name, is_admin FROM users WHERE deleted=0 ORDER BY is_admin DESC, user_name");

$updated = 0;
$skipped = 0;
echo "==> 应用本地化显示偏好（datef=Y-m-d, timef=H:i）\n";

while ($row = $db->fetchByAssoc($res)) {
    $user = BeanFactory::getBean('Users', $row['id']);
    if (empty($user->id)) {
        $skipped++;
        continue;
    }
    $before = $user->getPreference('datef');
    foreach ($prefs as $k => $v) {
        $user->setPreference($k, $v);
    }
    $user->savePreferencesToDB();
    printf("  [完成] %-14s %s → %s\n", $row['user_name'], $before ?: '(空)', $prefs['datef']);
    $updated++;
}

/* TimeDate 会把用户时区/格式解析结果缓存在实例里，重新取一次实例确保立即生效 */
$_SESSION[' authenticated_user_id'] = '1';
$GLOBALS['current_user'] = BeanFactory::getBean('Users', '1');
TimeDate::getInstance()->clearCache();

echo "\n==> 已更新 {$updated} 个用户" . ($skipped ? "，跳过 {$skipped} 个" : "") . "\n";
echo "[DONE] 本地化显示偏好应用完成\n";
