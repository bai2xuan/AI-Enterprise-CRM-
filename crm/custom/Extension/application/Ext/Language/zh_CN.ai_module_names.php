<?php
/**
 * AI Enterprise CRM —— 模块名称中文优化
 * ------------------------------------------------------------------
 * SuiteCRM 官方将 Opportunities 译为"商业机会"，按国内 B 端 SaaS 习惯
 * 统一简化为"商机"，与产品需求文档口径保持一致。
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$app_list_strings['moduleList']['Opportunities'] = '商机';
$app_list_strings['moduleListSingular']['Opportunities'] = '商机';
