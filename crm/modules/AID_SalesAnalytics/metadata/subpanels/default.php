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
      'popup_module' => 'AID_SalesAnalytics',
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
    'EDIT_BUTTON' => 
    array (
      'widget_class' => 'SubPanelEditButton',
      'module' => 'AID_SalesAnalytics',
      'width' => '4%',
      'default' => true,
    ),
    'REMOVE_BUTTON' => 
    array (
      'widget_class' => 'SubPanelRemoveButton',
      'module' => 'AID_SalesAnalytics',
      'width' => '4%',
      'default' => true,
    ),
  ),
);
