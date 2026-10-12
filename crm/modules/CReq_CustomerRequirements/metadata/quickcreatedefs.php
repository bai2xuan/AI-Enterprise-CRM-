<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

$viewdefs = array (
  'CReq_CustomerRequirements' => 
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
            1 => 
            array (
              'name' => 'req_status_c',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'account_name',
            ),
            1 => 
            array (
              'name' => 'opportunity_name',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'priority_c',
            ),
            1 => 
            array (
              'name' => 'go_live_date_c',
            ),
          ),
          3 => 
          array (
            0 => 
            array (
              'name' => 'requirement_desc_c',
            ),
          ),
        ),
      ),
    ),
  ),
);
