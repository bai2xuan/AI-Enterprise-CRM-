<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

$subpanel_layout = array (
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
  'where' => '',
  'list_fields' => 
  array (
    'NAME' => 
    array (
      'vname' => 'LBL_NAME',
      'width' => '25%',
      'widget_class' => 'SubPanelDetailViewLink',
    ),
    'REQ_NO_C' => 
    array (
      'vname' => 'LBL_REQ_NO_C',
      'width' => '9%',
    ),
    'ACCOUNT_NAME' => 
    array (
      'vname' => 'LBL_ACCOUNT_NAME',
      'width' => '14%',
    ),
    'OPPORTUNITY_NAME' => 
    array (
      'vname' => 'LBL_OPPORTUNITY_NAME',
      'width' => '14%',
    ),
    'REQ_STATUS_C' => 
    array (
      'vname' => 'LBL_REQ_STATUS_C',
      'width' => '8%',
    ),
    'PRIORITY_C' => 
    array (
      'vname' => 'LBL_PRIORITY_C',
      'width' => '7%',
    ),
    'EDIT_BUTTON' => 
    array (
      'widget_class' => 'SubPanelEditButton',
      'module' => 'CReq_CustomerRequirements',
      'width' => '4%',
      'default' => true,
    ),
    'REMOVE_BUTTON' => 
    array (
      'widget_class' => 'SubPanelRemoveButton',
      'module' => 'CReq_CustomerRequirements',
      'width' => '4%',
      'default' => true,
    ),
  ),
);
