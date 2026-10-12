<?php
/**
 * 智联AI科技有限公司 · AI Enterprise CRM
 * 基于 SuiteCRM 7.15.2 二次开发（AGPL-3.0）
 * 本文件为新增扩展文件，不修改 SuiteCRM 核心代码。
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$module_menu = array();
$module_menu[] = array('index.php?module=Hand_ProjectHandovers&action=EditView&return_module=Hand_ProjectHandovers&return_action=DetailView', $mod_strings['LNK_NEW_RECORD'], 'Create');
$module_menu[] = array('index.php?module=Hand_ProjectHandovers&action=index&return_module=Hand_ProjectHandovers&return_action=DetailView', $mod_strings['LNK_LIST'], 'List');
$module_menu[] = array('index.php?module=Hand_ProjectHandovers&action=Import&return_module=Hand_ProjectHandovers&return_action=DetailView', $mod_strings['LNK_IMPORT'], 'Import');
