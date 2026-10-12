<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

$viewdefs = array (
  'Hand_ProjectHandovers' => 
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
          'LBL_PANEL_CONTRACT' => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
          ),
          'LBL_PANEL_DELIVERY' => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
          ),
          'LBL_PANEL_RISK' => 
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
              'name' => 'handover_no_c',
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
              'name' => 'name',
            ),
            1 => 
            array (
              'name' => 'product_type_c',
            ),
          ),
          2 => 
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
        ),
        'LBL_PANEL_CONTRACT' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'contract_amount_c',
            ),
            1 => 
            array (
              'name' => 'handover_date_c',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'start_date_c',
            ),
            1 => 
            array (
              'name' => 'implementation_cycle_c',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'contract_scope_c',
            ),
          ),
        ),
        'LBL_PANEL_DELIVERY' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'project_goal_c',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'customer_requirement_c',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'committed_features_c',
            ),
          ),
          3 => 
          array (
            0 => 
            array (
              'name' => 'acceptance_criteria_c',
            ),
          ),
        ),
        'LBL_PANEL_RISK' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'delivery_owner_name',
            ),
            1 => 
            array (
              'name' => 'assigned_user_name',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'risk_items_c',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'description',
            ),
          ),
        ),
      ),
    ),
  ),
);
