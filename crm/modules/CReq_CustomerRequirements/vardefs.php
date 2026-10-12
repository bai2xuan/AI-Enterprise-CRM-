<?php
/**
 * 智联AI科技有限公司 · AI Enterprise CRM
 * 基于 SuiteCRM 7.15.2 二次开发（AGPL-3.0）
 * 本文件为新增扩展文件，不修改 SuiteCRM 核心代码。
 */

$dictionary['CReq_CustomerRequirements'] = array (
  'table' => 'creq_customerrequirements',
  'audited' => true,
  'inline_edit' => true,
  'unified_search' => true,
  'full_text_search' => true,
  'unified_search_default_enabled' => true,
  'duplicate_merge' => true,
  'comment' => '客户需求调研单：售前顾问记录客户业务/技术需求、竞争与风险分析',
  'fields' => 
  array (
    'req_no_c' => 
    array (
      'name' => 'req_no_c',
      'vname' => 'LBL_REQ_NO_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'varchar',
      'len' => 60,
      'unified_search' => true,
      'merge_filter' => 'enabled',
    ),
    'req_status_c' => 
    array (
      'name' => 'req_status_c',
      'vname' => 'LBL_REQ_STATUS_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'enum',
      'options' => 'ai_req_status_list',
      'len' => 100,
      'unified_search' => true,
    ),
    'priority_c' => 
    array (
      'name' => 'priority_c',
      'vname' => 'LBL_PRIORITY_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'enum',
      'options' => 'ai_req_priority_list',
      'len' => 100,
      'unified_search' => true,
    ),
    'customer_background_c' => 
    array (
      'name' => 'customer_background_c',
      'vname' => 'LBL_CUSTOMER_BACKGROUND_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'text',
    ),
    'current_pain_points_c' => 
    array (
      'name' => 'current_pain_points_c',
      'vname' => 'LBL_CURRENT_PAIN_POINTS_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'text',
    ),
    'current_system_c' => 
    array (
      'name' => 'current_system_c',
      'vname' => 'LBL_CURRENT_SYSTEM_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'varchar',
      'len' => 255,
      'unified_search' => true,
      'merge_filter' => 'enabled',
    ),
    'requirement_desc_c' => 
    array (
      'name' => 'requirement_desc_c',
      'vname' => 'LBL_REQUIREMENT_DESC_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'text',
    ),
    'functional_req_c' => 
    array (
      'name' => 'functional_req_c',
      'vname' => 'LBL_FUNCTIONAL_REQ_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'text',
    ),
    'technical_req_c' => 
    array (
      'name' => 'technical_req_c',
      'vname' => 'LBL_TECHNICAL_REQ_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'text',
    ),
    'expected_solution_c' => 
    array (
      'name' => 'expected_solution_c',
      'vname' => 'LBL_EXPECTED_SOLUTION_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'text',
    ),
    'budget_c' => 
    array (
      'name' => 'budget_c',
      'vname' => 'LBL_BUDGET_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'currency',
      'dbType' => 'double',
      'len' => 26,
      'precision' => 6,
      'default' => 0.0,
      'required' => false,
      'enable_range_search' => true,
      'options' => 'numeric_range_search_dom',
    ),
    'go_live_date_c' => 
    array (
      'name' => 'go_live_date_c',
      'vname' => 'LBL_GO_LIVE_DATE_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'date',
      'enable_range_search' => true,
      'options' => 'date_range_search_dom',
    ),
    'key_decision_maker_c' => 
    array (
      'name' => 'key_decision_maker_c',
      'vname' => 'LBL_KEY_DECISION_MAKER_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'varchar',
      'len' => 255,
      'unified_search' => true,
      'merge_filter' => 'enabled',
    ),
    'competitor_c' => 
    array (
      'name' => 'competitor_c',
      'vname' => 'LBL_COMPETITOR_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'varchar',
      'len' => 255,
      'unified_search' => true,
      'merge_filter' => 'enabled',
    ),
    'risk_factor_c' => 
    array (
      'name' => 'risk_factor_c',
      'vname' => 'LBL_RISK_FACTOR_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'text',
    ),
    'account_name' => 
    array (
      'name' => 'account_name',
      'rname' => 'name',
      'id_name' => 'account_id',
      'vname' => 'LBL_ACCOUNT_NAME',
      'type' => 'relate',
      'table' => 'accountss',
      'isnull' => 'true',
      'module' => 'Accounts',
      'dbType' => 'varchar',
      'link' => 'accounts',
      'len' => 255,
      'source' => 'non-db',
      'unified_search' => true,
      'required' => false,
      'reportable' => true,
      'importable' => true,
      'massupdate' => false,
    ),
    'account_id' => 
    array (
      'name' => 'account_id',
      'vname' => 'LBL_ACCOUNT_ID',
      'type' => 'id',
      'audited' => false,
      'reportable' => false,
      'massupdate' => false,
    ),
    'accounts' => 
    array (
      'name' => 'accounts',
      'type' => 'link',
      'relationship' => 'creq_accounts',
      'source' => 'non-db',
      'vname' => 'LBL_ACCOUNTS',
    ),
    'opportunity_name' => 
    array (
      'name' => 'opportunity_name',
      'rname' => 'name',
      'id_name' => 'opportunity_id',
      'vname' => 'LBL_OPPORTUNITY_NAME',
      'type' => 'relate',
      'table' => 'opportunities',
      'isnull' => 'true',
      'module' => 'Opportunities',
      'dbType' => 'varchar',
      'link' => 'opportunities',
      'len' => 255,
      'source' => 'non-db',
      'unified_search' => true,
      'required' => false,
      'reportable' => true,
      'importable' => true,
      'massupdate' => false,
    ),
    'opportunity_id' => 
    array (
      'name' => 'opportunity_id',
      'vname' => 'LBL_OPPORTUNITY_ID',
      'type' => 'id',
      'audited' => false,
      'reportable' => false,
      'massupdate' => false,
    ),
    'opportunities' => 
    array (
      'name' => 'opportunities',
      'type' => 'link',
      'relationship' => 'creq_opportunities',
      'source' => 'non-db',
      'vname' => 'LBL_OPPORTUNITIES',
    ),
    'currency_id' => 
    array (
      'name' => 'currency_id',
      'type' => 'id',
      'group' => 'currency_id',
      'vname' => 'LBL_CURRENCY',
      'function' => 
      array (
        'name' => 'getCurrencyDropDown',
        'returns' => 'html',
        'onListView' => true,
      ),
      'required' => false,
      'reportable' => false,
      'comment' => 'Currency used for display purposes',
    ),
  ),
  'relationships' => 
  array (
    'creq_accounts' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'CReq_CustomerRequirements',
      'rhs_table' => 'creq_customerrequirements',
      'rhs_key' => 'account_id',
      'relationship_type' => 'one-to-many',
    ),
    'creq_opportunities' => 
    array (
      'lhs_module' => 'Opportunities',
      'lhs_table' => 'opportunities',
      'lhs_key' => 'id',
      'rhs_module' => 'CReq_CustomerRequirements',
      'rhs_table' => 'creq_customerrequirements',
      'rhs_key' => 'opportunity_id',
      'relationship_type' => 'one-to-many',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_creq_account',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'account_id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_creq_opportunity',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'opportunity_id',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_creq_status',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'req_status_c',
      ),
    ),
  ),
  'optimistic_locking' => true,
);

if (!class_exists('VardefManager')) {
    require_once 'include/SugarObjects/VardefManager.php';
}
VardefManager::createVardef('CReq_CustomerRequirements', 'CReq_CustomerRequirements', array('basic', 'assignable'));
