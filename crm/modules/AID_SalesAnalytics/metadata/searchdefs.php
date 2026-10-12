<?php
if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

$searchdefs = array (
  'AID_SalesAnalytics' => 
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
      ),
      'advanced_search' => 
      array (
        0 => 'name',
      ),
    ),
  ),
);
