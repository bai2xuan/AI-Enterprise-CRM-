<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

$viewdefs = array (
  'AID_SalesAnalytics' => 
  array (
    'EditView' => 
    array (
      'templateMeta' => 
      array (
        'maxColumns' => '2',
        'widths' => 
        array (
          0 => 
          array (
            'label' => '10',
            'field' => '30',
          ),
          1 => 
          array (
            'label' => '10',
            'field' => '30',
          ),
        ),
        'useTabs' => true,
        'tabDefs' => 
        array (
          'LBL_PANEL_BASIC' => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
          ),
        ),
        'syncDetailEditViews' => true,
      ),
      'panels' => 
      array (
        'LBL_PANEL_BASIC' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'name',
            ),
          ),
        ),
      ),
    ),
  ),
);
