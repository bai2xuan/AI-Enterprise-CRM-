<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

$viewdefs = array (
  'AID_SalesAnalytics' => 
  array (
    'QuickCreate' => 
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
        'includes' => 
        array (
        ),
      ),
      'panels' => 
      array (
        'LBL_PANEL_QUICKCREATE' => 
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
