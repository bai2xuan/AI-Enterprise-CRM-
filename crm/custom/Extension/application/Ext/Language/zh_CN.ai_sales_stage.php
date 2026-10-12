<?php
/**
 * AI Enterprise CRM —— 销售阶段重构（简体中文显示）
 * ------------------------------------------------------------------
 * 7 段 AI 解决方案销售流程（Key 保持 SuiteCRM 原生英文值不动）：
 *   1. 初步接触  Prospecting          10%
 *   2. 需求调研  Needs Analysis       25%
 *   3. 方案设计  Value Proposition    40%
 *   4. 产品演示  Perception Analysis  55%
 *   5. 商务谈判  Negotiation/Review   75%
 *   6. 成交      Closed Won          100%
 *   7. 输单      Closed Lost           0%
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$app_list_strings['sales_stage_dom'] = array(
    'Prospecting' => '初步接触',
    'Needs Analysis' => '需求调研',
    'Value Proposition' => '方案设计',
    'Perception Analysis' => '产品演示',
    'Negotiation/Review' => '商务谈判',
    'Closed Won' => '成交',
    'Closed Lost' => '输单',
);

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
