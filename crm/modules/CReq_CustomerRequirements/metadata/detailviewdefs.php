<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

$viewdefs = array (
  'CReq_CustomerRequirements' => 
  array (
    'DetailView' => 
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
          'LBL_PANEL_BACKGROUND' => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
          ),
          'LBL_PANEL_REQUIREMENT' => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
          ),
          'LBL_PANEL_COMMERCIAL' => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
          ),
          'LBL_PANEL_ASSIGN' => 
          array (
            'newTab' => true,
            'panelDefault' => 'expanded',
          ),
        ),
        'form' => 
        array (
          'buttons' => 
          array (
            0 => 'EDIT',
            1 => 'DUPLICATE',
            2 => 'DELETE',
          ),
        ),
      ),
      'panels' => 
      array (
        'LBL_PANEL_BASIC' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'req_no_c',
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
              'name' => 'name',
            ),
            1 => 
            array (
              'name' => 'priority_c',
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
        'LBL_PANEL_BACKGROUND' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'customer_background_c',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'current_pain_points_c',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'current_system_c',
            ),
          ),
        ),
        'LBL_PANEL_REQUIREMENT' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'requirement_desc_c',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'functional_req_c',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'technical_req_c',
            ),
          ),
          3 => 
          array (
            0 => 
            array (
              'name' => 'expected_solution_c',
            ),
          ),
        ),
        'LBL_PANEL_COMMERCIAL' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'budget_c',
            ),
            1 => 
            array (
              'name' => 'go_live_date_c',
            ),
          ),
          1 => 
          array (
            0 => 
            array (
              'name' => 'key_decision_maker_c',
            ),
            1 => 
            array (
              'name' => 'competitor_c',
            ),
          ),
          2 => 
          array (
            0 => 
            array (
              'name' => 'risk_factor_c',
            ),
          ),
        ),
        'LBL_PANEL_ASSIGN' => 
        array (
          0 => 
          array (
            0 => 
            array (
              'name' => 'assigned_user_name',
            ),
            1 => 
            array (
              'name' => 'date_modified',
            ),
          ),
          1 => 
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
