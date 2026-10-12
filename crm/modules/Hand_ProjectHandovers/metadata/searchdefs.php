<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

$searchdefs = array (
  'Hand_ProjectHandovers' => 
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
        2 => 'handover_status_c',
        3 => 'product_type_c',
      ),
      'advanced_search' => 
      array (
        0 => 'name',
        1 => 'handover_no_c',
        2 => 'account_name',
        3 => 'opportunity_name',
        4 => 'handover_status_c',
        5 => 'product_type_c',
        6 => 'delivery_owner_name',
        7 => 'handover_date_c',
      ),
    ),
  ),
);
