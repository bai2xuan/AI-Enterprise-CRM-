<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

$searchFields['AID_SalesAnalytics'] = array (
  'NAME' => 
  array (
    'query_type' => 'default',
  ),
  'CURRENT_USER_ONLY' => 
  array (
    'query_type' => 'default',
    'db_field' => 
    array (
      0 => 'assigned_user_id',
    ),
  ),
);
