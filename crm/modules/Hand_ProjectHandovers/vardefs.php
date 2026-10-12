<?php
/**
 * 智联AI科技有限公司 · AI Enterprise CRM
 * 基于 SuiteCRM 7.15.2 二次开发（AGPL-3.0）
 * 本文件为新增扩展文件，不修改 SuiteCRM 核心代码。
 */

$dictionary['Hand_ProjectHandovers'] = array (
  'table' => 'hand_projecthandovers',
  'audited' => true,
  'inline_edit' => true,
  'unified_search' => true,
  'full_text_search' => true,
  'unified_search_default_enabled' => true,
  'duplicate_merge' => true,
  'comment' => '项目交接单：商机成交后，销售向售前与交付团队移交项目信息',
  'fields' => 
  array (
    'handover_no_c' => 
    array (
      'name' => 'handover_no_c',
      'vname' => 'LBL_HANDOVER_NO_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'varchar',
      'len' => 60,
      'unified_search' => true,
      'merge_filter' => 'enabled',
    ),
    'handover_status_c' => 
    array (
      'name' => 'handover_status_c',
      'vname' => 'LBL_HANDOVER_STATUS_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'enum',
      'options' => 'ai_handover_status_list',
      'len' => 100,
      'unified_search' => true,
    ),
    'product_type_c' => 
    array (
      'name' => 'product_type_c',
      'vname' => 'LBL_PRODUCT_TYPE_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'enum',
      'options' => 'ai_product_type_list',
      'len' => 100,
      'unified_search' => true,
    ),
    'contract_amount_c' => 
    array (
      'name' => 'contract_amount_c',
      'vname' => 'LBL_CONTRACT_AMOUNT_C',
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
    'handover_date_c' => 
    array (
      'name' => 'handover_date_c',
      'vname' => 'LBL_HANDOVER_DATE_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'date',
      'enable_range_search' => true,
      'options' => 'date_range_search_dom',
    ),
    'start_date_c' => 
    array (
      'name' => 'start_date_c',
      'vname' => 'LBL_START_DATE_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'date',
      'enable_range_search' => true,
      'options' => 'date_range_search_dom',
    ),
    'implementation_cycle_c' => 
    array (
      'name' => 'implementation_cycle_c',
      'vname' => 'LBL_IMPLEMENTATION_CYCLE_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'varchar',
      'len' => 100,
      'unified_search' => true,
      'merge_filter' => 'enabled',
    ),
    'project_goal_c' => 
    array (
      'name' => 'project_goal_c',
      'vname' => 'LBL_PROJECT_GOAL_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'text',
    ),
    'customer_requirement_c' => 
    array (
      'name' => 'customer_requirement_c',
      'vname' => 'LBL_CUSTOMER_REQUIREMENT_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'text',
    ),
    'committed_features_c' => 
    array (
      'name' => 'committed_features_c',
      'vname' => 'LBL_COMMITTED_FEATURES_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'text',
    ),
    'contract_scope_c' => 
    array (
      'name' => 'contract_scope_c',
      'vname' => 'LBL_CONTRACT_SCOPE_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'text',
    ),
    'risk_items_c' => 
    array (
      'name' => 'risk_items_c',
      'vname' => 'LBL_RISK_ITEMS_C',
      'audited' => true,
      'reportable' => true,
      'importable' => true,
      'type' => 'text',
    ),
    'acceptance_criteria_c' => 
    array (
      'name' => 'acceptance_criteria_c',
      'vname' => 'LBL_ACCEPTANCE_CRITERIA_C',
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
      'relationship' => 'hand_accounts',
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
      'relationship' => 'hand_opportunities',
      'source' => 'non-db',
      'vname' => 'LBL_OPPORTUNITIES',
    ),
    'delivery_owner_name' => 
    array (
      'name' => 'delivery_owner_name',
      'rname' => 'last_name',
      'id_name' => 'delivery_owner_id',
      'vname' => 'LBL_DELIVERY_OWNER_NAME',
      'type' => 'relate',
      'table' => 'users',
      'isnull' => 'true',
      'module' => 'Users',
      'dbType' => 'varchar',
      'link' => 'users',
      'len' => 255,
      'source' => 'non-db',
      'unified_search' => true,
      'required' => false,
      'reportable' => true,
      'importable' => true,
      'massupdate' => false,
    ),
    'delivery_owner_id' => 
    array (
      'name' => 'delivery_owner_id',
      'vname' => 'LBL_DELIVERY_OWNER_ID',
      'type' => 'id',
      'audited' => false,
      'reportable' => false,
      'massupdate' => false,
    ),
    'users' => 
    array (
      'name' => 'users',
      'type' => 'link',
      'relationship' => 'hand_delivery_owner',
      'source' => 'non-db',
      'vname' => 'LBL_USERS',
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
    'hand_accounts' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'Hand_ProjectHandovers',
      'rhs_table' => 'hand_projecthandovers',
      'rhs_key' => 'account_id',
      'relationship_type' => 'one-to-many',
    ),
    'hand_opportunities' => 
    array (
      'lhs_module' => 'Opportunities',
      'lhs_table' => 'opportunities',
      'lhs_key' => 'id',
      'rhs_module' => 'Hand_ProjectHandovers',
      'rhs_table' => 'hand_projecthandovers',
      'rhs_key' => 'opportunity_id',
      'relationship_type' => 'one-to-many',
    ),
    'hand_delivery_owner' => 
    array (
      'lhs_module' => 'Users',
      'lhs_table' => 'users',
      'lhs_key' => 'id',
      'rhs_module' => 'Hand_ProjectHandovers',
      'rhs_table' => 'hand_projecthandovers',
      'rhs_key' => 'delivery_owner_id',
      'relationship_type' => 'one-to-many',
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'idx_hand_account',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'account_id',
      ),
    ),
    1 => 
    array (
      'name' => 'idx_hand_opportunity',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'opportunity_id',
      ),
    ),
    2 => 
    array (
      'name' => 'idx_hand_status',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'handover_status_c',
      ),
    ),
  ),
  'optimistic_locking' => true,
);

if (!class_exists('VardefManager')) {
    require_once 'include/SugarObjects/VardefManager.php';
}
VardefManager::createVardef('Hand_ProjectHandovers', 'Hand_ProjectHandovers', array('basic', 'assignable'));
