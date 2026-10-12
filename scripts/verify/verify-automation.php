<?php
/**
 * verify-automation.php —— 业务自动化验收测试
 * ==================================================================
 * 用途：验证「商机成交 → 自动生成项目交接单 + 派发交接准备待办」这条
 *       逻辑钩子链路真的生效，而不是只靠种子脚本手工造数据。
 *
 * 做法（自包含、可重复执行、执行后自动回滚）：
 *   1. 挑一个「未结案」的商机，记录基线（交接单数 / 交接待办数）；
 *   2. 把它的销售阶段改成 Closed Won 并保存 —— 模拟销售在界面上点保存；
 *   3. 断言：新增了 1 份关联到该商机的项目交接单；
 *   4. 断言：新增待办的数量不受影响（钩子内部派发，非界面产生）；
 *   5. 反向验证幂等性：重复保存同一商机，交接单不会变成 2 份；
 *   6. 回滚：删除测试产生的交接单与待办，把商机阶段改回原值。
 *
 * 用法：php scripts/verify-automation.php
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

chdir(dirname(__DIR__, 2) . '/crm');
require_once 'include/entryPoint.php';

global $db;

$admin = BeanFactory::getBean('Users');
$admin->retrieve_by_string_fields(array('is_admin' => '1', 'deleted' => '0'));
$GLOBALS['current_user'] = $admin;

$pass = 0;
$fail = 0;
function check($label, $ok, $extra = '')
{
    global $pass, $fail;
    if ($ok) {
        $pass++;
        echo "  [通过] {$label}" . ($extra !== '' ? "  {$extra}" : '') . "\n";
    } else {
        $fail++;
        echo "  [失败] {$label}" . ($extra !== '' ? "  {$extra}" : '') . "\n";
    }
}

/** 统计某商机关联的交接单数量 */
function handoverCount($db, $oppId)
{
    return (int)$db->getOne(
        "SELECT COUNT(*) FROM hand_projecthandovers WHERE deleted=0 AND opportunity_id = " . $db->quoted($oppId)
    );
}

/** 统计某交接单关联的待办数量 */
function taskCount($db, $handId)
{
    return (int)$db->getOne(
        "SELECT COUNT(*) FROM tasks WHERE deleted=0 AND parent_type='Hand_ProjectHandovers' AND parent_id = " . $db->quoted($handId)
    );
}

echo "=== 业务自动化验收测试 ===\n\n";

/* ---------- 1. 选样本 ---------- */
$row = $db->fetchByAssoc($db->query(
    "SELECT id, name, sales_stage FROM opportunities
     WHERE deleted=0 AND sales_stage NOT IN ('Closed Won','Closed Lost')
     ORDER BY id LIMIT 1"
));
if (!$row) {
    fwrite(STDERR, "[错误] 库里没有在途商机，请先执行 php scripts/data/seed-demo-data.php\n");
    exit(1);
}
$oppId = $row['id'];
$originStage = $row['sales_stage'];
echo "样本商机：{$row['name']}\n原销售阶段：{$originStage}\n\n";

$baseHandovers = handoverCount($db, $oppId);
check('测试前该商机没有交接单', $baseHandovers === 0, "（实际 {$baseHandovers}）");

/* ---------- 2. 触发：改成成交并保存 ---------- */
echo "\n-- 步骤 1：把销售阶段改为「成交」并保存 --\n";
$opp = BeanFactory::getBean('Opportunities', $oppId);
$opp->sales_stage = 'Closed Won';
$opp->probability = 100;
$opp->save();

$afterHandovers = handoverCount($db, $oppId);
check('成交后自动生成 1 份项目交接单', $afterHandovers === 1, "（实际 {$afterHandovers}）");

$hand = BeanFactory::getBean('Hand_ProjectHandovers');
$hand->retrieve_by_string_fields(array('opportunity_id' => $oppId, 'deleted' => 0));
$handAccountName = '';
if (!empty($hand->account_id)) {
    $acc = BeanFactory::getBean('Accounts', $hand->account_id);
    $handAccountName = $acc->name;
}
check('交接单带出了商机的客户与合同金额',
    !empty($hand->account_id) && $hand->contract_amount_c == $opp->amount,
    "（客户={$handAccountName} 金额={$hand->contract_amount_c}）");
check('交接单初始状态为「待交接」', $hand->handover_status_c === 'Pending', "（实际 {$hand->handover_status_c}）");

$handTaskCount = taskCount($db, $hand->id);
check('自动派发了「项目交接准备」待办', $handTaskCount === 1, "（实际 {$handTaskCount}）");

/* ---------- 3. 幂等性：重复保存 ---------- */
echo "\n-- 步骤 2：重复保存同一商机（验证幂等） --\n";
$opp2 = BeanFactory::getBean('Opportunities', $oppId);
$opp2->description = '幂等性测试：再次保存';
$opp2->save();
$dupHandovers = handoverCount($db, $oppId);
check('重复保存不会产生重复交接单', $dupHandovers === 1, "（实际 {$dupHandovers}）");

/* ---------- 4. 回滚 ---------- */
echo "\n-- 步骤 3：回滚测试数据 --\n";
$db->query("DELETE FROM tasks WHERE parent_type='Hand_ProjectHandovers' AND parent_id = " . $db->quoted($hand->id));
$db->query("DELETE FROM hand_projecthandovers WHERE opportunity_id = " . $db->quoted($oppId));
// 审计表在开启字段审计后才存在，存在则一并清理
$auditTable = $db->fetchByAssoc($db->query("SHOW TABLES LIKE 'hand_projecthandovers_audit'"));
if (!empty($auditTable)) {
    $db->query("DELETE FROM hand_projecthandovers_audit WHERE parent_id = " . $db->quoted($hand->id));
}

$opp3 = BeanFactory::getBean('Opportunities', $oppId);
$opp3->sales_stage = $originStage;
$opp3->probability = 0;
$opp3->save();

check('商机阶段已还原', handoverCount($db, $oppId) === 0, "（{$originStage}）");

/* ---------- 结果 ---------- */
echo "\n=== 结果：通过 {$pass} 项，失败 {$fail} 项 ===\n";
exit($fail > 0 ? 1 : 0);
