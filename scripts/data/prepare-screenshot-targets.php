<?php
/**
 * prepare-screenshot-targets.php —— 为截图脚本准备「代表性记录 ID」
 * ==================================================================
 * 截图脚本需要固定几个 id 才能打开详情页（客户详情 / 商机详情 / 需求详情 / 交接单详情）。
 * 但每次 `seed-demo-data.php --reset` 都会重新生成 UUID，硬编码 id 会失效。
 * 因此这里用一段查询把「当前库里最有展示价值的那几条记录」挑出来，
 * 写成 data/screenshot-targets.json 供 capture-screenshots.js 读取。
 *
 * 用法：php scripts/data/prepare-screenshot-targets.php
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

$root = dirname(__DIR__, 2);
chdir($root . '/crm');
require_once 'include/entryPoint.php';

global $db;

/**
 * 取一行（找不到返回 null）
 */
function pick($db, $sql)
{
    $res = $db->query($sql);
    if (!$res) {
        return null;
    }
    $row = $db->fetchByAssoc($res);
    return $row ?: null;
}

$targets = array();

/* ---- 客户：优先选「画像字段填得最全」的一家，详情页才有内容可看 ---- */
$acc = pick($db, "SELECT id, name FROM accounts
                  WHERE deleted=0 AND IFNULL(industry,'')<>'' AND IFNULL(company_size_c,'')<>''
                  ORDER BY CHAR_LENGTH(IFNULL(current_pain_points_c,'')) DESC, date_entered ASC
                  LIMIT 1");
if (!$acc) {
    $acc = pick($db, "SELECT id, name FROM accounts WHERE deleted=0 ORDER BY date_entered ASC LIMIT 1");
}
$targets['account'] = array('id' => $acc['id'] ?? '', 'name' => $acc['name'] ?? '');

/* ---- 商机：分「在途 / 成交 / 输单」各取一条，覆盖不同阶段样式 ---- */
$oppOpen = pick($db, "SELECT id, name FROM opportunities
                      WHERE deleted=0 AND sales_stage NOT IN ('Closed Won','Closed Lost')
                      ORDER BY amount DESC LIMIT 1");
$oppWon  = pick($db, "SELECT id, name FROM opportunities
                      WHERE deleted=0 AND sales_stage='Closed Won' ORDER BY amount DESC LIMIT 1");
$oppLost = pick($db, "SELECT id, name FROM opportunities
                      WHERE deleted=0 AND sales_stage='Closed Lost'
                      ORDER BY CHAR_LENGTH(IFNULL(lost_reason_c,'')) DESC LIMIT 1");
$targets['opportunity_open']   = array('id' => $oppOpen['id'] ?? '', 'name' => $oppOpen['name'] ?? '');
$targets['opportunity_won']    = array('id' => $oppWon['id'] ?? '',  'name' => $oppWon['name'] ?? '');
$targets['opportunity_lost']   = array('id' => $oppLost['id'] ?? '', 'name' => $oppLost['name'] ?? '');

/* ---- 需求调研：优先选需求描述写得最完整的一条 ---- */
$creq = pick($db, "SELECT id, name FROM creq_customerrequirements
                   WHERE deleted=0
                   ORDER BY CHAR_LENGTH(IFNULL(requirement_desc_c,'')) DESC, date_entered ASC
                   LIMIT 1");
$targets['requirement'] = array('id' => $creq['id'] ?? '', 'name' => $creq['name'] ?? '');

/* ---- 项目交接：优先选已关联商机/客户、字段最全的一条 ---- */
$hand = pick($db, "SELECT id, name FROM hand_projecthandovers
                   WHERE deleted=0 ORDER BY date_entered ASC LIMIT 1");
$targets['handover'] = array('id' => $hand['id'] ?? '', 'name' => $hand['name'] ?? '');

/* ---- 输出 ---- */
$outFile = $root . '/data/screenshot-targets.json';
$json = json_encode($targets, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if ($json === false) {
    fwrite(STDERR, "[错误] JSON 编码失败：" . json_last_error_msg() . "\n");
    exit(1);
}
file_put_contents($outFile, $json . "\n");

echo "==> 已写入 {$outFile}\n";
foreach ($targets as $k => $v) {
    printf("  %-16s %s  %s\n", $k, $v['id'] !== '' ? $v['id'] : '(缺失)', $v['name']);
}
echo "\n[DONE] 截图目标就绪\n";
