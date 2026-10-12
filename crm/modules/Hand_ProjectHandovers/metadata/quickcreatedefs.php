<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

$viewdefs = array (
  'Hand_ProjectHandovers' => 
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
              'name' => 'handover_status_c',
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
              'name' => 'product_type_c',
            ),
            1 => 
            array (
              'name' => 'contract_amount_c',
            ),
          ),
          3 => 
          array (
            0 => 
            array (
              'name' => 'delivery_owner_name',
            ),
            1 => 
            array (
              'name' => 'handover_date_c',
            ),
          ),
        ),
      ),
    ),
  ),
);
