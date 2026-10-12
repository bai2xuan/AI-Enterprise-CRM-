<?php
/**
 * AI Enterprise CRM —— 业务下拉选项定义（英文基准）
 * ------------------------------------------------------------------
 * 二次开发扩展文件。定义智联AI科技业务所需的全部自定义下拉选项。
 * Key 使用英文（稳定标识，便于统计与图表聚合），显示文本在各语言包中翻译。
 * 本文件不修改 SuiteCRM 任何核心代码。
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/* ========== 企业类型 ========== */
$app_list_strings['ai_enterprise_type_list'] = array(
    '' => '',
    'State-owned' => 'State-owned',
    'Private' => 'Private',
    'Foreign' => 'Foreign',
    'Joint Venture' => 'Joint Venture',
    'Listed' => 'Listed',
    'Government' => 'Government',
);

/* ========== 公司规模 ========== */
$app_list_strings['ai_company_size_list'] = array(
    '' => '',
    '1-50' => '1-50',
    '51-200' => '51-200',
    '201-500' => '201-500',
    '501-1000' => '501-1000',
    'Above 1000' => 'Above 1000',
);

/* ========== 客户等级 ========== */
$app_list_strings['ai_customer_level_list'] = array(
    '' => '',
    'A' => 'A - Strategic',
    'B' => 'B - Key',
    'C' => 'C - Normal',
    'D' => 'D - Potential',
);

/* ========== 客户来源 ========== */
$app_list_strings['ai_customer_source_list'] = array(
    '' => '',
    'Website' => 'Website',
    'Exhibition' => 'Exhibition',
    'Referral' => 'Referral',
    'Cold Call' => 'Cold Call',
    'Marketing' => 'Marketing',
    'Channel' => 'Channel',
    'Search Engine' => 'Search Engine',
);

/* ========== 预算范围 ========== */
$app_list_strings['ai_budget_range_list'] = array(
    '' => '',
    'Under 10W' => 'Under 10W',
    '10W-30W' => '10W-30W',
    '30W-50W' => '30W-50W',
    '50W-100W' => '50W-100W',
    'Above 100W' => 'Above 100W',
);

/* ========== 决策周期 ========== */
$app_list_strings['ai_decision_cycle_list'] = array(
    '' => '',
    'Within 1 Month' => 'Within 1 Month',
    '1-3 Months' => '1-3 Months',
    '3-6 Months' => '3-6 Months',
    'Above 6 Months' => 'Above 6 Months',
);

/* ========== 产品类型（商机主推产品，单选便于聚合统计）========== */
$app_list_strings['ai_product_type_list'] = array(
    '' => '',
    'AI Knowledge Base' => 'AI Knowledge Base',
    'AI Customer Service' => 'AI Customer Service',
    'AI Office Assistant' => 'AI Office Assistant',
    'Data Analytics Platform' => 'Data Analytics Platform',
);

/* ========== 输单原因 ========== */
$app_list_strings['ai_lost_reason_list'] = array(
    '' => '',
    'Price' => 'Price',
    'Features' => 'Features',
    'Delivery' => 'Delivery',
    'Competitor' => 'Competitor',
    'Budget' => 'Budget',
    'Decision Process' => 'Decision Process',
    'Relationship' => 'Relationship',
    'Other' => 'Other',
);
