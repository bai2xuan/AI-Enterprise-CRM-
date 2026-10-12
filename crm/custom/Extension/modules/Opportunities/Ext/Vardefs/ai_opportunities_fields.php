<?php
/**
 * AI Enterprise CRM —— 商机(Opportunities)字段扩展
 * ------------------------------------------------------------------
 * 将通用商机对象改造为"AI 解决方案销售管道"商机：
 *   - 产品类型（主推产品，单选便于按产品聚合统计销售额）
 *   - 下一步计划
 *   - 输单原因（仅"输单"阶段显示/必填）
 *
 * 说明：预计金额(amount)、成交概率(probability)、预计成交时间(date_closed)、
 *       销售阶段(sales_stage) 均复用 SuiteCRM 原生字段，不重复定义。
 * 本文件不修改 SuiteCRM 核心代码。
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/* ========== 产品类型（主推产品，单选）========== */
$dictionary['Opportunity']['fields']['product_type_c'] = array(
    'name' => 'product_type_c',
    'vname' => 'LBL_PRODUCT_TYPE',
    'type' => 'enum',
    'options' => 'ai_product_type_list',
    'len' => 100,
    'required' => true,
    'audited' => true,
    'massupdate' => true,
    'reportable' => true,
    'unified_search' => true,
    'merge_filter' => 'enabled',
    'comment' => '主推的 AI 解决方案产品类型',
);

/* ========== 下一步计划 ==========
 * 说明：SuiteCRM 原生 Opportunities 已内置 `next_step` 字段
 *       （varchar(100)，语义为 "The next step in the sales process"），
 *       本项目直接复用该字段，仅通过语言包将其标签中文化为「下一步计划」，
 *       避免重复建字段造成语义冗余。此处不再新增 next_step_c。
 */

/* ========== 输单原因（仅输单阶段）========== */
$dictionary['Opportunity']['fields']['lost_reason_c'] = array(
    'name' => 'lost_reason_c',
    'vname' => 'LBL_LOST_REASON',
    'type' => 'enum',
    'options' => 'ai_lost_reason_list',
    'len' => 100,
    'audited' => true,
    'massupdate' => true,
    'reportable' => true,
    'merge_filter' => 'enabled',
    'dependency' => 'equal($sales_stage,"Closed Lost")',
    'comment' => '商机输单原因（仅当销售阶段为"输单"时填写）',
);
