<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

$listViewDefs['CReq_CustomerRequirements'] = array (
  'NAME' => 
  array (
    'width' => '18%',
    'label' => 'LBL_NAME',
    'default' => true,
    'link' => true,
  ),
  'REQ_NO_C' => 
  array (
    'width' => '9%',
    'label' => 'LBL_REQ_NO_C',
    'default' => true,
    'type' => 'varchar',
    'studio' => 'visible',
  ),
  'ACCOUNT_NAME' => 
  array (
    'width' => '14%',
    'label' => 'LBL_ACCOUNT_NAME',
    'default' => true,
    'link' => true,
  ),
  'OPPORTUNITY_NAME' => 
  array (
    'width' => '14%',
    'label' => 'LBL_OPPORTUNITY_NAME',
    'default' => true,
    'link' => true,
  ),
  'REQ_STATUS_C' => 
  array (
    'width' => '8%',
    'label' => 'LBL_REQ_STATUS_C',
    'default' => true,
    'type' => 'varchar',
    'studio' => 'visible',
  ),
  'PRIORITY_C' => 
  array (
    'width' => '7%',
    'label' => 'LBL_PRIORITY_C',
    'default' => true,
    'type' => 'varchar',
    'studio' => 'visible',
  ),
  'BUDGET_C' => 
  array (
    'width' => '9%',
    'label' => 'LBL_BUDGET_C',
    'default' => true,
    'type' => 'varchar',
    'studio' => 'visible',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_USER_NAME',
    'default' => true,
    'link' => false,
    'type' => 'relate',
    'id' => 'ASSIGNED_USER_ID',
  ),
  'GO_LIVE_DATE_C' => 
  array (
    'width' => '8%',
    'label' => 'LBL_GO_LIVE_DATE_C',
    'default' => true,
    'type' => 'varchar',
    'studio' => 'visible',
  ),
  'DATE_MODIFIED' => 
  array (
    'width' => '8%',
    'label' => 'LBL_DATE_MODIFIED',
    'default' => true,
  ),
);
