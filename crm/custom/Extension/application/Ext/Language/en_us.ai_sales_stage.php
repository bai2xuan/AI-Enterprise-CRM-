<?php
/**
 * AI Enterprise CRM —— 销售阶段重构（英文基准）
 * ------------------------------------------------------------------
 * 将 SuiteCRM 默认的 10 段销售阶段，按"AI 解决方案销售"业务重构为 7 段。
 *
 * ⚠️ 核心设计约束：
 *   1. Key 必须保留 SuiteCRM 原生英文值，尤其是 `Closed Won` / `Closed Lost`
 *      —— 系统内部硬编码这两个 Key 判断商机是否关闭、驱动漏斗与预测金额统计。
 *   2. 本文件仅覆盖"显示标签"与"默认成交概率"，不改变 Key 语义。
 *   3. 7 段映射：Prospecting→初步接触 / Needs Analysis→需求调研 /
 *      Value Proposition→方案设计 / Perception Analysis→产品演示 /
 *      Negotiation/Review→商务谈判 / Closed Won→成交 / Closed Lost→输单
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$app_list_strings['sales_stage_dom'] = array(
    'Prospecting' => 'Prospecting',
    'Needs Analysis' => 'Needs Analysis',
    'Value Proposition' => 'Value Proposition',
    'Perception Analysis' => 'Perception Analysis',
    'Negotiation/Review' => 'Negotiation/Review',
    'Closed Won' => 'Closed Won',
    'Closed Lost' => 'Closed Lost',
);

// 阶段默认成交概率（Key 必须与 sales_stage_dom 完全一致）
$app_list_strings['sales_probability_dom'] = array(
    'Prospecting' => '10',
    'Needs Analysis' => '25',
    'Value Proposition' => '40',
    'Perception Analysis' => '55',
    'Negotiation/Review' => '75',
    'Closed Won' => '100',
    'Closed Lost' => '0',
);

$app_list_strings['sales_stage_default_key'] = 'Prospecting';
