<?php
/**
 * register-modules.php —— 让自定义模块「真正生效」的三件事
 * ------------------------------------------------------------------
 * SuiteCRM 中新增一个模块，除了代码与数据表，还必须在两处「运行时注册表」登记，
 * 否则表现为：模块能访问（URL 直接打开 200），但导航栏里看不到、权限页里不出现。
 *
 *   1) ACL 动作注册 —— acl_actions 表
 *      Navigation 之外，ACLRole / 权限矩阵都依赖它。
 *      调用内置 ACLAction::addActions() 补齐默认动作（幂等）。
 *
 *   2) 系统 Tab 设置 —— config 表 MySettings.tab
 *      TabController::get_system_tabs() 读的是 Administration 设置里
 *      序列化保存的模块清单（即「Admin ▸ 配置模块菜单过滤器」保存的内容），
 *      而不是 include/tabConfig.php。新模块必须写进这份清单才会出现在顶部导航。
 *
 *   3) 校验 —— 打印最终结果
 *
 * 用法：php scripts/register-modules.php
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

chdir(dirname(__DIR__, 2) . '/crm');
require_once 'include/entryPoint.php';
require_once 'modules/ACLActions/ACLAction.php';
if (empty($GLOBALS['ACLActions'])) {
    require_once 'modules/ACLActions/actiondefs.php';
}

/* CLI 无会话，显式指定管理员作为操作者 */
$adminUser = BeanFactory::getBean('Users');
$adminUser->retrieve_by_string_fields(array('is_admin' => '1', 'deleted' => '0'));
if (empty($adminUser->id)) {
    $adminUser = BeanFactory::getBean('Users', '1');
}
$GLOBALS['current_user'] = $adminUser;

$customModules = array(
    'CReq_CustomerRequirements',
    'Hand_ProjectHandovers',
    'AID_SalesAnalytics',
);

/* ---------- 1. ACL 动作 ---------- */
echo "==> [1/2] 注册 ACL 动作\n";
foreach ($customModules as $module) {
    if (!isset($GLOBALS['beanList'][$module])) {
        echo "  [跳过] {$module}（未注册进 beanList，请先运行 repair.php）\n";
        continue;
    }
    ACLAction::addActions($module, 'module');
    echo "  [完成] {$module}\n";
}

/* ---------- 2. 系统 Tab 设置 ---------- */
echo "\n==> [2/2] 注册顶部导航 Tab\n";
$administration = BeanFactory::newBean('Administration');
$administration->retrieveSettings('MySettings');

$raw = isset($administration->settings['MySettings_tab'])
    ? $administration->settings['MySettings_tab']
    : '';
$tabs = array();
if (!empty(trim((string)$raw))) {
    $decoded = @unserialize(base64_decode($raw), array('allowed_classes' => false));
    if (is_array($decoded)) {
        $tabs = $decoded;
    }
}
if (empty($tabs)) {
    // 系统尚未保存过 tab 设置时，默认使用全部模块
    $tabs = $GLOBALS['moduleList'];
    echo "  （系统未保存 Tab 设置，使用完整模块列表作为基线）\n";
}

$before = count($tabs);
foreach ($customModules as $module) {
    if (!in_array($module, $tabs, true)) {
        $tabs[] = $module;
        echo "  [新增到导航] {$module}\n";
    } else {
        echo "  [已存在]     {$module}\n";
    }
}
$tabs = array_values(array_unique($tabs));

$administration->saveSetting(
    'MySettings',
    'tab',
    base64_encode(serialize($tabs))
);
echo "  导航模块数：{$before} → " . count($tabs) . "\n";

/* ---------- 3. 校验 ---------- */
echo "\n==> 校验\n";
$db = DBManagerFactory::getInstance();
$res = $db->query("SELECT category, COUNT(*) AS c FROM acl_actions WHERE category IN ('CReq_CustomerRequirements','Hand_ProjectHandovers') AND deleted=0 GROUP BY category");
while ($row = $db->fetchByAssoc($res)) {
    echo "  acl_actions · {$row['category']}: {$row['c']} 个动作\n";
}

$administration->retrieveSettings('MySettings', true);
$check = @unserialize(base64_decode($administration->settings['MySettings_tab']));
foreach ($customModules as $module) {
    echo "  MySettings.tab 含 {$module}: " . (in_array($module, (array)$check, true) ? 'YES' : 'NO') . "\n";
}

echo "\n[DONE] 模块运行时注册完成\n";
