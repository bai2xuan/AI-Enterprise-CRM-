<?php
/**
 * AI Enterprise CRM —— 客户(Accounts)字段扩展
 * ------------------------------------------------------------------
 * 让"客户"对象承载完整 B 端客户画像，覆盖四组信息：
 *   ① 基础信息：所属行业 / 公司规模 / 企业类型
 *   ② 客户价值：客户等级 / 客户来源 / 潜在价值
 *   ③ 业务信息：当前痛点 / 使用系统 / 预算范围 / 决策周期
 *   ④ 负责人  ：销售负责人 / 售前负责人
 *
 * 命名约定：自定义字段统一 `_c` 后缀，避免与原生字段冲突。
 * 本文件不修改 SuiteCRM 核心代码，仅通过 vardefs 扩展机制追加。
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/* ==================================================================
 * 覆盖原生字段：所属行业 → 采用"智联AI"业务行业分类
 * ================================================================== */
$dictionary['Account']['fields']['industry']['options'] = 'ai_industry_list';

/* ==================================================================
 * ① 基础信息
 * ================================================================== */
$dictionary['Account']['fields']['company_size_c'] = array(
    'name' => 'company_size_c',
    'vname' => 'LBL_COMPANY_SIZE',
    'type' => 'enum',
    'options' => 'ai_company_size_list',
    'len' => 100,
    'audited' => true,
    'massupdate' => true,
    'reportable' => true,
    'unified_search' => true,
    'merge_filter' => 'enabled',
    'comment' => '公司人员规模区间',
);

$dictionary['Account']['fields']['enterprise_type_c'] = array(
    'name' => 'enterprise_type_c',
    'vname' => 'LBL_ENTERPRISE_TYPE',
    'type' => 'enum',
    'options' => 'ai_enterprise_type_list',
    'len' => 100,
    'audited' => true,
    'massupdate' => true,
    'reportable' => true,
    'unified_search' => true,
    'merge_filter' => 'enabled',
    'comment' => '企业所有制类型',
);

/* ==================================================================
 * ② 客户价值
 * ================================================================== */
$dictionary['Account']['fields']['customer_level_c'] = array(
    'name' => 'customer_level_c',
    'vname' => 'LBL_CUSTOMER_LEVEL',
    'type' => 'enum',
    'options' => 'ai_customer_level_list',
    'len' => 100,
    'audited' => true,
    'massupdate' => true,
    'reportable' => true,
    'unified_search' => true,
    'merge_filter' => 'enabled',
    'comment' => '客户价值/重要度分级',
);

$dictionary['Account']['fields']['customer_source_c'] = array(
    'name' => 'customer_source_c',
    'vname' => 'LBL_CUSTOMER_SOURCE',
    'type' => 'enum',
    'options' => 'ai_customer_source_list',
    'len' => 100,
    'audited' => true,
    'massupdate' => true,
    'reportable' => true,
    'unified_search' => true,
    'merge_filter' => 'enabled',
    'comment' => '客户获取渠道来源',
);

$dictionary['Account']['fields']['potential_value_c'] = array(
    'name' => 'potential_value_c',
    'vname' => 'LBL_POTENTIAL_VALUE',
    'type' => 'currency',
    'dbType' => 'decimal',
    'len' => '26,6',
    'audited' => true,
    'massupdate' => false,
    'reportable' => true,
    'comment' => '客户预计可挖掘的合同总价值（潜在价值）',
);

/* ==================================================================
 * ③ 业务信息
 * ================================================================== */
$dictionary['Account']['fields']['current_pain_points_c'] = array(
    'name' => 'current_pain_points_c',
    'vname' => 'LBL_CURRENT_PAIN_POINTS',
    'type' => 'text',
    'audited' => true,
    'massupdate' => false,
    'reportable' => true,
    'comment' => '客户当前业务痛点',
);

$dictionary['Account']['fields']['current_system_c'] = array(
    'name' => 'current_system_c',
    'vname' => 'LBL_CURRENT_SYSTEM',
    'type' => 'varchar',
    'len' => 255,
    'audited' => true,
    'massupdate' => false,
    'reportable' => true,
    'unified_search' => true,
    'comment' => '客户当前在用的系统 / 竞品',
);

$dictionary['Account']['fields']['budget_range_c'] = array(
    'name' => 'budget_range_c',
    'vname' => 'LBL_BUDGET_RANGE',
    'type' => 'enum',
    'options' => 'ai_budget_range_list',
    'len' => 100,
    'audited' => true,
    'massupdate' => true,
    'reportable' => true,
    'unified_search' => true,
    'merge_filter' => 'enabled',
    'comment' => '客户预算区间',
);

$dictionary['Account']['fields']['decision_cycle_c'] = array(
    'name' => 'decision_cycle_c',
    'vname' => 'LBL_DECISION_CYCLE',
    'type' => 'enum',
    'options' => 'ai_decision_cycle_list',
    'len' => 100,
    'audited' => true,
    'massupdate' => true,
    'reportable' => true,
    'unified_search' => true,
    'merge_filter' => 'enabled',
    'comment' => '客户采购决策周期',
);

/* ==================================================================
 * ④ 负责人（关联 Users）
 * ================================================================== */
$dictionary['Account']['fields']['sales_owner_c'] = array(
    'name' => 'sales_owner_c',
    'vname' => 'LBL_SALES_OWNER',
    'type' => 'relate',
    'source' => 'non-db',
    'id_name' => 'sales_owner_c_user_id',
    'ext2' => 'Users',
    'module' => 'Users',
    'rname' => 'user_name',
    'quicksearch' => 'enabled',
    'required' => false,
    'massupdate' => false,
    'reportable' => true,
    'comment' => '客户销售负责人',
);
$dictionary['Account']['fields']['sales_owner_c_user_id'] = array(
    'name' => 'sales_owner_c_user_id',
    'vname' => 'LBL_SALES_OWNER_USER_ID',
    'type' => 'id',
    'required' => false,
    'reportable' => false,
);

$dictionary['Account']['fields']['presales_owner_c'] = array(
    'name' => 'presales_owner_c',
    'vname' => 'LBL_PRESALES_OWNER',
    'type' => 'relate',
    'source' => 'non-db',
    'id_name' => 'presales_owner_c_user_id',
    'ext2' => 'Users',
    'module' => 'Users',
    'rname' => 'user_name',
    'quicksearch' => 'enabled',
    'required' => false,
    'massupdate' => false,
    'reportable' => true,
    'comment' => '客户售前负责人',
);
$dictionary['Account']['fields']['presales_owner_c_user_id'] = array(
    'name' => 'presales_owner_c_user_id',
    'vname' => 'LBL_PRESALES_OWNER_USER_ID',
    'type' => 'id',
    'required' => false,
    'reportable' => false,
);
