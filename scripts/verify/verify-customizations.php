<?php
/**
 * AI Enterprise CRM —— 二次开发扩展验证
 * ------------------------------------------------------------------
 * 校验：自定义下拉选项、销售阶段、字段定义是否已被 SuiteCRM 正确加载。
 * 用法：php scripts/verify-customizations.php
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

chdir(dirname(__DIR__, 2) . '/crm');
require_once 'include/entryPoint.php';

$PASS = 0;
$FAIL = 0;

function check($label, $ok, $detail = '')
{
    global $PASS, $FAIL;
    if ($ok) {
        $PASS++;
        echo "  [PASS] {$label}" . ($detail !== '' ? "  {$detail}" : '') . "\n";
    } else {
        $FAIL++;
        echo "  [FAIL] {$label}" . ($detail !== '' ? "  {$detail}" : '') . "\n";
    }
}

/* =============== 1. 下拉选项 =============== */
echo "\n[1] 自定义下拉选项（zh_CN）\n";
$app_strings_cn = return_app_list_strings_language('zh_CN');

$expectLists = array(
    'ai_product_type_list',
    'ai_lost_reason_list',
    'ai_customer_level_list',
    'ai_customer_source_list',
    'ai_budget_range_list',
    'ai_decision_cycle_list',
    'ai_company_size_list',
    'ai_enterprise_type_list',
    'ai_industry_list',
    'sales_stage_dom',
);
foreach ($expectLists as $list) {
    $items = isset($app_strings_cn[$list]) ? $app_strings_cn[$list] : null;
    check("下拉 {$list}", is_array($items) && count($items) > 1, '共 ' . (is_array($items) ? count($items) : 0) . ' 项');
}

/* =============== 2. 销售阶段（7 段） =============== */
echo "\n[2] 销售阶段重构结果\n";
$stage = isset($app_strings_cn['sales_stage_dom']) ? $app_strings_cn['sales_stage_dom'] : array();
$expectedStage = array(
    'Prospecting' => '初步接触',
    'Needs Analysis' => '需求调研',
    'Value Proposition' => '方案设计',
    'Perception Analysis' => '产品演示',
    'Negotiation/Review' => '商务谈判',
    'Closed Won' => '成交',
    'Closed Lost' => '输单',
);
foreach ($expectedStage as $key => $label) {
    $actual = isset($stage[$key]) ? $stage[$key] : null;
    check("阶段 {$key}", $actual === $label, "期望『{$label}』实际『{$actual}』");
}
check('阶段总数 = 7', count($stage) === 7, '实际 ' . count($stage) . ' 段');

$prob = isset($app_strings_cn['sales_probability_dom']) ? $app_strings_cn['sales_probability_dom'] : array();
check('成交概率键与阶段一致', array_keys($prob) == array_keys($stage));

/* =============== 3. 字段定义 =============== */
echo "\n[3] 自定义字段定义\n";
$accountFields = array(
    'company_size_c', 'enterprise_type_c', 'customer_level_c', 'customer_source_c',
    'potential_value_c', 'current_pain_points_c', 'current_system_c', 'budget_range_c',
    'decision_cycle_c', 'sales_owner_c', 'presales_owner_c', 'sales_owner_c_user_id',
    'presales_owner_c_user_id',
);
$accBean = BeanFactory::getBean('Accounts');
foreach ($accountFields as $f) {
    check("Accounts.{$f}", isset($accBean->field_defs[$f]), isset($accBean->field_defs[$f]) ? '类型=' . $accBean->field_defs[$f]['type'] : '');
}

$oppFields = array('product_type_c', 'lost_reason_c', 'next_step');
$oppBean = BeanFactory::getBean('Opportunities');
foreach ($oppFields as $f) {
    check("Opportunities.{$f}", isset($oppBean->field_defs[$f]), isset($oppBean->field_defs[$f]) ? '类型=' . $oppBean->field_defs[$f]['type'] : '');
}

/* =============== 4. 数据库列 =============== */
echo "\n[4] 数据库物理列\n";
global $db;
$beans = array('accounts' => $accBean, 'opportunities' => $oppBean);
$colsByTable = array('accounts' => $accountFields, 'opportunities' => array('product_type_c', 'lost_reason_c'));
foreach ($colsByTable as $table => $cols) {
    $fields = $db->get_columns($table);
    $bean = $beans[$table];
    foreach ($cols as $c) {
        // non-db 字段（如 relate 的显示字段）不落库，数据存于对应的 _id 列，跳过校验
        if (isset($bean->field_defs[$c]['source']) && $bean->field_defs[$c]['source'] === 'non-db') {
            continue;
        }
        check("{$table}.{$c}", isset($fields[$c]));
    }
}

/* =============== 5. 自定义模块注册 =============== */
echo "\n[5] 自定义模块注册（模块 3 / 4 / 5）\n";
$customModules = array(
    'CReq_CustomerRequirements' => 'creq_customerrequirements',
    'Hand_ProjectHandovers'     => 'hand_projecthandovers',
    'AID_SalesAnalytics'        => 'aid_salesanalytics',
);
foreach ($customModules as $mod => $table) {
    check("beanList 含 {$mod}", isset($GLOBALS['beanList'][$mod]));
    check("moduleList 含 {$mod}", in_array($mod, (array)$GLOBALS['moduleList'], true));

    $bean = BeanFactory::getBean($mod);
    check("Bean 可实例化 {$mod}", !empty($bean->object_name), '表=' . $bean->table_name);

    $tables = $db->get_columns($table);
    check("数据表 {$table}", !empty($tables), count((array)$tables) . ' 列');

    foreach (array('detailviewdefs', 'editviewdefs', 'listviewdefs', 'searchdefs', 'SearchFields', 'subpaneldefs') as $meta) {
        $file = "modules/{$mod}/metadata/{$meta}.php";
        check("元数据 {$mod}/{$meta}", file_exists($file));
    }
}

/* =============== 6. 导航与权限 =============== */
echo "\n[6] 导航可见性与权限动作\n";
$admin = BeanFactory::getBean('Users');
$admin->retrieve_by_string_fields(array('is_admin' => '1', 'deleted' => '0'));
$GLOBALS['current_user'] = $admin;

$administration = BeanFactory::newBean('Administration');
$administration->retrieveSettings('MySettings');
$rawTabs = isset($administration->settings['MySettings_tab']) ? $administration->settings['MySettings_tab'] : '';
$tabs = @unserialize(base64_decode($rawTabs), array('allowed_classes' => false));
$tabs = is_array($tabs) ? $tabs : array();
foreach (array_keys($customModules) as $mod) {
    check("顶部导航含 {$mod}", in_array($mod, $tabs, true), '导航模块数 ' . count($tabs));
}

foreach (array_keys($customModules) as $mod) {
    $n = (int)$db->getOne("SELECT COUNT(*) FROM acl_actions WHERE deleted=0 AND category = " . $db->quoted($mod));
    check("ACL 动作 {$mod}", $n >= 8, "{$n} 个动作");
}

/* =============== 7. 界面语言包完整性 =============== */
echo "\n[7] 中文化完整性（关键标签无 LBL_ 残留）\n";
$langChecks = array(
    'CReq_CustomerRequirements' => array('LBL_MODULE_NAME', 'LBL_PANEL_BASIC', 'LBL_PANEL_REQUIREMENT', 'LBL_PANEL_COMMERCIAL'),
    'Hand_ProjectHandovers'     => array('LBL_MODULE_NAME', 'LBL_PANEL_BASIC', 'LBL_PANEL_DELIVERY', 'LBL_PANEL_RISK'),
    'AID_SalesAnalytics'        => array('LBL_MODULE_NAME', 'LNK_VIEW_DASHBOARD'),
);
foreach ($langChecks as $mod => $keys) {
    $lang = return_module_language('zh_CN', $mod);
    foreach ($keys as $k) {
        $v = isset($lang[$k]) ? $lang[$k] : null;
        check("{$mod}.{$k}", !empty($v) && strpos($v, 'LBL_') !== 0, "『{$v}』");
    }
}

/* =============== 8. 业务自动化（逻辑钩子） =============== */
echo "\n[8] 业务自动化注册\n";
$hookFile = 'custom/modules/Opportunities/Ext/LogicHooks/logichooks.ext.php';
$hookSrc = file_exists($hookFile) ? file_get_contents($hookFile) : '';
check('成交→交接单 逻辑钩子已合并', strpos((string)$hookSrc, 'ai_handover_hook') !== false);
check('逻辑钩子实现文件存在', file_exists('custom/modules/Opportunities/ai_handover_hook.php'));

/* =============== 汇总 =============== */
echo "\n----------------------------------------\n";
echo "验证结果：通过 {$PASS} 项，失败 {$FAIL} 项\n";
exit($FAIL > 0 ? 1 : 0);
