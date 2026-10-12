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
      'popup_module' => 'Hand_ProjectHandovers',
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
    'HANDOVER_NO_C' => 
    array (
      'vname' => 'LBL_HANDOVER_NO_C',
      'width' => '9%',
    ),
    'ACCOUNT_NAME' => 
    array (
      'vname' => 'LBL_ACCOUNT_NAME',
      'width' => '14%',
    ),
    'PRODUCT_TYPE_C' => 
    array (
      'vname' => 'LBL_PRODUCT_TYPE_C',
      'width' => '11%',
    ),
    'HANDOVER_STATUS_C' => 
    array (
      'vname' => 'LBL_HANDOVER_STATUS_C',
      'width' => '9%',
    ),
    'CONTRACT_AMOUNT_C' => 
    array (
      'vname' => 'LBL_CONTRACT_AMOUNT_C',
      'width' => '10%',
    ),
    'EDIT_BUTTON' => 
    array (
      'widget_class' => 'SubPanelEditButton',
      'module' => 'Hand_ProjectHandovers',
      'width' => '4%',
      'default' => true,
    ),
    'REMOVE_BUTTON' => 
    array (
      'widget_class' => 'SubPanelRemoveButton',
      'module' => 'Hand_ProjectHandovers',
      'width' => '4%',
      'default' => true,
    ),
  ),
);
