<?php
/**
 * AI Enterprise CRM —— 业务下拉选项（简体中文显示）
 * ------------------------------------------------------------------
 * 与 en_us.ai_crm_dropdowns.php 的 Key 一一对应，仅翻译显示文本。
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/* ========== 企业类型 ========== */
$app_list_strings['ai_enterprise_type_list'] = array(
    '' => '',
    'State-owned' => '国有企业',
    'Private' => '民营企业',
    'Foreign' => '外资企业',
    'Joint Venture' => '合资企业',
    'Listed' => '上市公司',
    'Government' => '政府机构',
);

/* ========== 公司规模 ========== */
$app_list_strings['ai_company_size_list'] = array(
    '' => '',
    '1-50' => '1-50 人',
    '51-200' => '51-200 人',
    '201-500' => '201-500 人',
    '501-1000' => '501-1000 人',
    'Above 1000' => '1000 人以上',
);

/* ========== 客户等级 ========== */
$app_list_strings['ai_customer_level_list'] = array(
    '' => '',
    'A' => 'A - 战略客户',
    'B' => 'B - 重点客户',
    'C' => 'C - 普通客户',
    'D' => 'D - 潜在客户',
);

/* ========== 客户来源 ========== */
$app_list_strings['ai_customer_source_list'] = array(
    '' => '',
    'Website' => '官网咨询',
    'Exhibition' => '行业展会',
    'Referral' => '客户转介绍',
    'Cold Call' => '陌生拜访',
    'Marketing' => '市场活动',
    'Channel' => '渠道合作',
    'Search Engine' => '搜索引擎',
);

/* ========== 预算范围 ========== */
$app_list_strings['ai_budget_range_list'] = array(
    '' => '',
    'Under 10W' => '10 万以下',
    '10W-30W' => '10-30 万',
    '30W-50W' => '30-50 万',
    '50W-100W' => '50-100 万',
    'Above 100W' => '100 万以上',
);

/* ========== 决策周期 ========== */
$app_list_strings['ai_decision_cycle_list'] = array(
    '' => '',
    'Within 1 Month' => '1 个月内',
    '1-3 Months' => '1-3 个月',
    '3-6 Months' => '3-6 个月',
    'Above 6 Months' => '6 个月以上',
);

/* ========== 产品类型 ========== */
$app_list_strings['ai_product_type_list'] = array(
    '' => '',
    'AI Knowledge Base' => 'AI 知识库系统',
    'AI Customer Service' => '企业智能客服',
    'AI Office Assistant' => 'AI 办公助手',
    'Data Analytics Platform' => '数据智能分析平台',
);

/* ========== 输单原因 ========== */
$app_list_strings['ai_lost_reason_list'] = array(
    '' => '',
    'Price' => '价格竞争力不足',
    'Features' => '产品功能不满足',
    'Delivery' => '实施与交付周期',
    'Competitor' => '选择竞品',
    'Budget' => '预算取消或延期',
    'Decision Process' => '决策流程变更',
    'Relationship' => '客户关系因素',
    'Other' => '其他',
);
