<?php
/**
 * AI Enterprise CRM —— 业务行业分类（英文基准）
 * ------------------------------------------------------------------
 * 覆盖 SuiteCRM 原生 industry_dom，聚焦智联AI的 9 大目标行业。
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$app_list_strings['ai_industry_list'] = array(
    '' => '',
    'Manufacturing' => 'Manufacturing',
    'Finance' => 'Finance',
    'Healthcare' => 'Healthcare',
    'Internet' => 'Internet',
    'Education' => 'Education',
    'Energy' => 'Energy',
    'Government' => 'Government',
    'Retail' => 'Retail',
    'Logistics' => 'Logistics',
);

// 同步覆盖原生 industry_dom，保持全站行业口径一致
$app_list_strings['industry_dom'] = $app_list_strings['ai_industry_list'];
