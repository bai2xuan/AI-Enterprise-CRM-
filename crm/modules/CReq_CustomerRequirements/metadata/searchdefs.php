<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

$searchdefs = array (
  'CReq_CustomerRequirements' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => 3,
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10%',
          'field' => '30%',
        ),
        1 => 
        array (
          'label' => '10%',
          'field' => '30%',
        ),
        2 => 
        array (
          'label' => '10%',
          'field' => '30%',
        ),
      ),
    ),
    'layout' => 
    array (
      'basic_search' => 
      array (
        0 => 'name',
        1 => 'account_name',
        2 => 'req_status_c',
        3 => 'priority_c',
      ),
      'advanced_search' => 
      array (
        0 => 'name',
        1 => 'req_no_c',
        2 => 'account_name',
        3 => 'opportunity_name',
        4 => 'req_status_c',
        5 => 'priority_c',
        6 => 'assigned_user_name',
        7 => 'budget_c',
        8 => 'go_live_date_c',
      ),
    ),
  ),
);
