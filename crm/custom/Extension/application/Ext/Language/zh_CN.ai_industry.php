<?php
/**
 * AI Enterprise CRM —— 业务行业分类（简体中文显示）
 * ------------------------------------------------------------------
 * 智联AI 的 9 大目标行业。
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$app_list_strings['ai_industry_list'] = array(
    '' => '',
    'Manufacturing' => '制造业',
    'Finance' => '金融',
    'Healthcare' => '医疗健康',
    'Internet' => '互联网',
    'Education' => '教育',
    'Energy' => '能源',
    'Government' => '政府机构',
    'Retail' => '零售',
    'Logistics' => '物流',
);

$app_list_strings['industry_dom'] = $app_list_strings['ai_industry_list'];
