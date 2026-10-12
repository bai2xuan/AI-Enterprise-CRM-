<?php
/**
 * 智联AI科技有限公司 · AI Enterprise CRM
 * 基于 SuiteCRM 7.15.2 二次开发（AGPL-3.0）
 * 本文件为新增扩展文件，不修改 SuiteCRM 核心代码。
 */

$layout_defs['Accounts']['subpanel_setup']['creq_creq_customerrequirements'] = array (
  'order' => 95,
  'module' => 'CReq_CustomerRequirements',
  'subpanel_name' => 'default',
  'sort_order' => 'desc',
  'sort_by' => 'date_entered',
  'title_key' => 'LBL_CREQ_SUBPANEL_TITLE',
  'get_subpanel_data' => 'creq_accounts',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopCreateButton',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'popup_module' => 'CReq_CustomerRequirements',
    ),
  ),
);
