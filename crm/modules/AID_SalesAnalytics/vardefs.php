<?php
/**
 * 智联AI科技有限公司 · AI Enterprise CRM
 * 基于 SuiteCRM 7.15.2 二次开发（AGPL-3.0）
 * 本文件为新增扩展文件，不修改 SuiteCRM 核心代码。
 */

$dictionary['AID_SalesAnalytics'] = array (
  'table' => 'aid_salesanalytics',
  'audited' => true,
  'inline_edit' => true,
  'unified_search' => true,
  'full_text_search' => true,
  'unified_search_default_enabled' => true,
  'duplicate_merge' => true,
  'comment' => '销售漏斗与经营分析看板：核心指标 / 阶段漏斗 / 产品与行业分布 / 输单归因',
  'fields' => 
  array (
  ),
  'relationships' => 
  array (
  ),
  'indices' => 
  array (
  ),
  'optimistic_locking' => true,
);

if (!class_exists('VardefManager')) {
    require_once 'include/SugarObjects/VardefManager.php';
}
VardefManager::createVardef('AID_SalesAnalytics', 'AID_SalesAnalytics', array('basic', 'assignable'));
