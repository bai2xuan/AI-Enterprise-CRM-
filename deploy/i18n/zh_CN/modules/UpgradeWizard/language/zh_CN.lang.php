<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SuiteCRM Ltd.
 * Copyright (C) 2011 - 2025 SuiteCRM Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$mod_strings = array(
    'ERR_UW_CANNOT_DETERMINE_GROUP' => '无法确定所属组',
    'ERR_UW_CANNOT_DETERMINE_USER' => '无法确定所有者',
    'ERR_UW_CONFIG_WRITE' => 'Error updating config.php with new version information.',
    'ERR_UW_CONFIG' => '请确保 config.php 文件可写并刷新当前页面。',
    'ERR_UW_DIR_NOT_WRITABLE' => '目录无法写入',
    'ERR_UW_FILE_NOT_COPIED' => '文件未复制',
    'ERR_UW_FILE_NOT_DELETED' => '文件未删除',
    'ERR_UW_FILE_NOT_READABLE' => '文件不可读',
    'ERR_UW_FILE_NOT_WRITABLE' => '无法移动或写入文件',
    'ERR_UW_FLAVOR_2' => '更新版本：',
    'ERR_UW_FLAVOR' => 'SuiteCRM 系统版本：',
    'ERR_UW_LOG_FILE_UNWRITABLE' => '无法创建或写入 ./upradeWizard.log 文件，请检查并修复文件权限。',
    'ERR_UW_MBSTRING_FUNC_OVERLOAD' => 'mbstring.func_overload 设置了大于1的值。请修改 php.ini 配置文件或通过其他途径修改此设置，并重启 Web 务器。',
    'ERR_UW_NO_FILE_UPLOADED' => '请指定一个文件并重试！',
    'ERR_UW_NO_FILES' => '出现了一个错误，未找到要检查的文件。',
    'ERR_UW_NO_MANIFEST' => 'The zip file is missing a manifest.php file. Cannot proceed.',
    'ERR_UW_NO_VIEW' => '指定的视图无效。',
    'ERR_UW_NOT_VALID_UPLOAD' => '无效的上传。',
    'ERR_UW_NO_CREATE_TMP_DIR' => '无法创建临时目录，请检查文件权限。',
    'ERR_UW_ONLY_PATCHES' => 'You can only upload patches on this page.',
    'ERR_UW_PREFLIGHT_ERRORS' => '安装前检查期间发现错误',
    'ERR_UW_UPLOAD_ERR' => '上传文件时出错，请重试！<br />' . PHP_EOL,
    'ERR_UW_VERSION' => 'SuiteCRM 系统版本：',
    'ERR_UW_PHP_VERSION' => 'PHP 版本：',
    'ERR_UW_SUITECRM_VERSION' => 'SuiteCRM System Version: ',
    'ERR_UW_WRONG_TYPE' => '此页面不能运行',
    'LBL_BUTTON_BACK' => '< Back',
    'LBL_BUTTON_CANCEL' => '取消',
    'LBL_BUTTON_DELETE' => 'Delete Package',
    'LBL_BUTTON_DONE' => 'Done',
    'LBL_BUTTON_EXIT' => 'Exit',
    'LBL_BUTTON_NEXT' => '下一步',
    'LBL_BUTTON_RECHECK' => '重新检查',
    'LBL_BUTTON_RESTART' => '重新开始',

    'LBL_UPLOAD_UPGRADE' => '上传更新包',
    'LBL_UW_BACKUP_FILES_EXIST_TITLE' => '文件备份',
    'LBL_UW_BACKUP_FILES_EXIST' => '本次更新的备份文件在这里',
    'LBL_UW_BACKUP' => '备份',
    'LBL_UW_CANCEL_DESC' => '更新已取消，所有临时文件和上传的更新文件已被删除。',
    'LBL_UW_CHECK_ALL' => '全选',
    'LBL_UW_CHECKLIST' => '更新步骤',
    'LBL_UW_COMMIT_ADD_TASK_DESC_1' => '被覆盖的文件的备份在下面的目录里： ' . PHP_EOL,
    'LBL_UW_COMMIT_ADD_TASK_DESC_2' => '手工合并下述文件：' . PHP_EOL,
    'LBL_UW_COMMIT_ADD_TASK_NAME' => '更新进程：手动合并文件',
    'LBL_UW_COMMIT_ADD_TASK_OVERVIEW' => '请使用您最熟悉的方法来合并这些文件，在完成这些步骤之前 SuiteCRM 安装将处于不确定的状态并且无法进行完整更新。',
    'LBL_UW_COMPLETE' => '完成',
    'LBL_UW_COMPLIANCE_ALL_OK' => '所有服务器设置符合',
    'LBL_UW_COMPLIANCE_CALLTIME' => 'PHP 设置：Call Time Pass By Reference',
    'LBL_UW_COMPLIANCE_CURL' => 'cURL 库',
    'LBL_UW_COMPLIANCE_IMAP' => 'IMAP 模块',
    'LBL_UW_COMPLIANCE_MBSTRING' => 'mbstring 模块',
    'LBL_UW_COMPLIANCE_MBSTRING_FUNC_OVERLOAD' => 'MBStrings mbstring.func_overload 参数',
    'LBL_UW_COMPLIANCE_MEMORY' => 'PHP 设置：内存限制',
    'LBL_UW_COMPLIANCE_STREAM' => 'PHP 设置：Stream',
    'LBL_UW_COMPLIANCE_DB' => '最低数据库版本',
    'LBL_UW_COMPLIANCE_PHP_INI' => 'php.ini 文件位置',
    'LBL_UW_COMPLIANCE_PHP_VERSION' => '最低 PHP 版本',
    'LBL_UW_COMPLIANCE_SAFEMODE' => 'PHP 设置：安全模式',
    'LBL_UW_COMPLIANCE_TITLE2' => '服务器设置',
    'LBL_UW_COMPLIANCE_XML' => 'XML 解析',
    'LBL_UW_COMPLIANCE_ZIPARCHIVE' => 'zip 支持',
    'LBL_UW_COMPLIANCE_PCRE_VERSION' => 'pcre 版本',
    'LBL_UW_COPIED_FILES_TITLE' => '文件已成功复制',

    'LBL_UW_DB_CHOICE1' => '更新向导运行 SQL',
    'LBL_UW_DB_CHOICE2' => '手动运行 SQL 语句',
    'LBL_UW_DB_ISSUES_PERMS' => '数据库权限',
    'LBL_UW_DB_METHOD' => '数据库更新方法',
    'LBL_UW_DB_NO_ADD_COLUMN' => 'ALTER TABLE [table] ADD COLUMN [column]',
    'LBL_UW_DB_NO_CHANGE_COLUMN' => 'ALTER TABLE [table] CHANGE COLUMN [column]',
    'LBL_UW_DB_NO_CREATE' => 'CREATE TABLE [table]',
    'LBL_UW_DB_NO_DELETE' => 'DELETE FROM [table]',
    'LBL_UW_DB_NO_DROP_COLUMN' => 'ALTER TABLE [table] DROP COLUMN [column]',
    'LBL_UW_DB_NO_DROP_TABLE' => 'DROP TABLE [table]',
    'LBL_UW_DB_NO_ERRORS' => '所有权限有效',
    'LBL_UW_DB_NO_INSERT' => 'INSERT INTO [table]',
    'LBL_UW_DB_NO_SELECT' => 'SELECT [x] FROM [table]',
    'LBL_UW_DB_NO_UPDATE' => 'UPDATE [table]',
    'LBL_UW_DB_PERMS' => '必要权限',

    'LBL_UW_DESC_MODULES_INSTALLED' => '已安装',
    'LBL_UW_END_LOGOUT_PRE' => '已完成更新。',
    'LBL_UW_END_LOGOUT_PRE2' => '点击 完成 退出更新向导。',
    'LBL_UW_END_LOGOUT' => '如果您要使用更新向导继续更新，请先 退出 再重新登录进行更新。',

    'LBL_UW_FILE_DELETED' => ' 已删除。<br />',
    'LBL_UW_FILE_GROUP' => '群组',
    'LBL_UW_FILE_ISSUES_PERMS' => '文件权限',
    'LBL_UW_FILE_NO_ERRORS' => '<b>所有文件可写</b>',
    'LBL_UW_FILE_OWNER' => '负责人',
    'LBL_UW_FILE_PERMS' => '权限',
    'LBL_UW_FILE_UPLOADED' => '已上传',
    'LBL_UW_FILE' => '文件名',
    'LBL_UW_FILES_QUEUED' => '准备安装',
    'LBL_UW_FILES_REMOVED' => '下列文件会被删除：<br>' . PHP_EOL,
    'LBL_UW_NEXT_TO_UPLOAD' => '<b>点击 下一步 上传更新包。</b>',
    'LBL_UW_FROZEN' => '请先上传更新包。',
    'LBL_UW_HIDE_DETAILS' => 'Hide Details',
    'LBL_UW_IN_PROGRESS' => '处理中',
    'LBL_UW_INCLUDING' => '包括',
    'LBL_UW_INCOMPLETE' => '不完整',
    'LBL_UW_MANUAL_MERGE' => '手动合并',
    'LBL_UW_MODULE_READY' => '准备安装',
    'LBL_UW_NO_INSTALLED_UPGRADES' => '未检测到更新记录。',
    'LBL_UW_NONE' => '-无-',
    'LBL_UW_OVERWRITE_DESC' => '所有已更改的文件将被覆盖，包括任何自定义和模板更改，您确定要继续吗？',

    'LBL_UW_PREFLIGHT_ADD_TASK' => '为手动合并创建任务记录？',
    'LBL_UW_PREFLIGHT_EMAIL_REMINDER' => '为手动合并发送邮件提醒？',
    'LBL_UW_PREFLIGHT_FILES_DESC' => '下列文件已被修改。没有选中的文件需要手动合并。<i>任何检测到的布局更改都会自动取消选中；选择任何要被覆盖的文件。',
    'LBL_UW_PREFLIGHT_NO_DIFFS' => '不需要手动合并文件。',
    'LBL_UW_PREFLIGHT_NOT_NEEDED' => '不需要。',
    'LBL_UW_PREFLIGHT_PRESERVE_FILES' => '自动保留的文件：',
    'LBL_UW_PREFLIGHT_TESTS_PASSED' => '已通过所有检查测试。',
    'LBL_UW_PREFLIGHT_TESTS_PASSED2' => '点击 下一步 将更新文件复制到系统。',
    'LBL_UW_PREFLIGHT_TESTS_PASSED3' => '<b>注意：</b>接下来的更新过程是强制性的，点击 <b>下一步</b> 进行更新。如果您不希望继续，请点击 <b>取消</b> 。',
    'LBL_UW_PREFLIGHT_TOGGLE_ALL' => '选中所有文件',

    'LBL_UW_REBUILD_TITLE' => '重建',
    'LBL_UW_SCHEMA_CHANGE' => 'Schema 更改',

    'LBL_UW_SHOW_COMPLIANCE' => '显示检测到的设置',
    'LBL_UW_SHOW_DB_PERMS' => '显示缺少的数据库权限',
    'LBL_UW_SHOW_DETAILS' => '显示详细信息',
    'LBL_UW_SHOW_DIFFS' => '显示需要手动合并的文件',
    'LBL_UW_SHOW_NW_FILES' => '显示错误权限的文件',
    'LBL_UW_SHOW_SCHEMA' => '显示 Schema 更改脚本',
    'LBL_UW_SHOW_SQL_ERRORS' => '显示错误的查询',
    'LBL_UW_SHOW' => '显示',

    'LBL_UW_SKIPPED_FILES_TITLE' => '跳过的文件',
    'LBL_UW_SQL_RUN' => '当手动运行 SQL 时检查',
    'LBL_UW_START_DESC' => '此向导将帮助您更新 SuiteCRM。',
    'LBL_UW_START_DESC2' => '注意: 我们强烈建议您创建您创建一个生产环境中的SuiteCRM的副本， 用于在部署新版本之前测试升级包。 如果您已经修改了“composer.json”，请在升级过程完成后运行此命令：<br/><br/><pre>compposer install --no-dev</pre>', // Keep the <pre>composer install --no-dev</pre> words at the end of the sentence and do not translate it
    'LBL_UW_START_DESC3' => '点击 下一步 进行系统更新检查，包括文件权限、数据库权限以及服务器设置。',
    'LBL_UW_START_UPGRADED_UW_DESC' => '更新向导现在将恢复更新进程，请继续您的更新。',
    'LBL_UW_START_UPGRADED_UW_TITLE' => '欢迎使用更新向导',

    'LBL_UW_TITLE_CANCEL' => '取消',
    'LBL_UW_TITLE_COMMIT' => '提交更新',
    'LBL_UW_TITLE_END' => '汇报',
    'LBL_UW_TITLE_PREFLIGHT' => '安装前检查',
    'LBL_UW_TITLE_START' => '欢迎使用',
    'LBL_UW_TITLE_SYSTEM_CHECK' => '系统检查',
    'LBL_UW_TITLE_UPLOAD' => '上传',
    'LBL_UW_TITLE' => '更新向导',
    'LBL_UW_UNINSTALL' => 'Uninstall',
    //500 upgrade labels
    'LBL_UW_ACCEPT_THE_LICENSE' => '接受许可证',
    'LBL_UW_CONVERT_THE_LICENSE' => '转换许可证',

    'LBL_START_UPGRADE_IN_PROGRESS' => '开始执行',
    'LBL_SYSTEM_CHECKS_IN_PROGRESS' => '正在执行系统检查',
    'LBL_LICENSE_CHECK_IN_PROGRESS' => '正在执行许可检查',
    'LBL_PREFLIGHT_CHECK_IN_PROGRESS' => '正在执行安装前检查',
    'LBL_PREFLIGHT_FILE_COPYING_PROGRESS' => '正在复制文件',
    'LBL_COMMIT_UPGRADE_IN_PROGRESS' => '正在执行更新',
    'LBL_UW_COMMIT_DESC' => '点击 下一步 运行额外的更新脚本。',
    'LBL_UPGRADE_SCRIPTS_IN_PROGRESS' => '正在运行更新脚本',
    'LBL_UPGRADE_SUMMARY_IN_PROGRESS' => '正在执行更新汇总',
    'LBL_UPGRADE_IN_PROGRESS' => '正在执行',
    'LBL_UPGRADE_TIME_ELAPSED' => '已使用时间',
    'LBL_UPGRADE_CANCEL_IN_PROGRESS' => '正在取消更新并清理',
    'LBL_UPGRADE_TAKES_TIME_HAVE_PATIENCE' => '更新可能需要一些时间',
    'LBL_UPLOADE_UPGRADE_IN_PROGRESS' => '正在检查上传',
    'LBL_UPLOADING_UPGRADE_PACKAGE' => '正在上传',
    'LBL_UW_DROP_SCHEMA_UPGRADE_WIZARD' => '更新向导删除',
    'LBL_UW_DROP_SCHEMA_MANUAL' => '更新后手动删除',
    'LBL_UW_DROP_SCHEMA_METHOD' => '旧 Schema 删除方法',
    'LBL_UW_SHOW_OLD_SCHEMA_TO_DROP' => '显示可以废弃的旧 Schema',
    'LBL_UW_SKIPPED_QUERIES_ALREADY_EXIST' => '跳过的查询',
    'LBL_INCOMPATIBLE_PHP_VERSION' => 'PHP 版本不兼容。',
    'ERR_CHECKSYS_PHP_INVALID_VER' => 'Your version of PHP is not supported by SuiteCRM. You will need to install a version that is compatible with the SuiteCRM application. Please consult the Compatibility Matrix in the Release Notes for supported PHP Versions. Your version is ',
    'LBL_BACKWARD_COMPATIBILITY_ON' => 'Php Backward Compatibility mode is turned on. Set zend.ze1_compatibility_mode to Off for proceeding further',
    //including some strings from moduleinstall that are used in Upgrade
    'LBL_ML_ACTION' => '动作',
    'LBL_ML_CANCEL' => '取消',
    'LBL_ML_COMMIT' => 'Commit',
    'LBL_ML_DESCRIPTION' => '说明',
    'LBL_ML_INSTALLED' => 'Date Installed',
    'LBL_ML_NAME' => '追踪器',
    'LBL_ML_PUBLISHED' => 'Date Published',
    'LBL_ML_TYPE' => '类型',
    'LBL_ML_UNINSTALLABLE' => 'Uninstallable',
    'LBL_ML_VERSION' => '版本',
    'LBL_ML_INSTALL' => 'Install',
    //adding the string used in tracker. copying from homepage
    'LBL_CURRENT_PHP_VERSION' => '当前 PHP 版本 ',
    'LBL_RECOMMENDED_PHP_VERSION_1' => '推荐 PHP 版本 ',
    'LBL_RECOMMENDED_PHP_VERSION_2' => '及以上版本',  // End of a sentence as in Recommended PHP version is version X.Y or above

    'LBL_MODULE_NAME' => '更新向导',
    'LBL_UPLOAD_SUCCESS' => '更新包上传成功。点击 下一步 执行最后一次检查。',
    'LBL_UW_TITLE_LAYOUTS' => '确认布局',
    'LBL_LAYOUT_MODULE_TITLE' => '布局',
    'LBL_LAYOUT_MERGE_DESC' => '本次更新包含一些新可用的字段，他们可以自动追加到当前已经存在的布局中，详细信息请参阅版本发行说明。<br /><br />如果您不想追加这些新字段，请取消选中下面的模块，相应的自定义布局将不会被改变。更新后，这些字段仍然可以在工作室中使用。',
    'LBL_LAYOUT_MERGE_TITLE' => '点击 下一步 来确定更改并完成更新。',
    'LBL_LAYOUT_MERGE_TITLE2' => '点击 下一步 完成更新。',
    'LBL_UW_CONFIRM_LAYOUTS' => 'Confirm Layouts',
    'LBL_UW_CONFIRM_LAYOUT_RESULTS' => '布局确认结果',
    'LBL_UW_CONFIRM_LAYOUT_RESULTS_DESC' => '下列布局合并成功',
    'LBL_SELECT_FILE' => '选择文件',
    'ERROR_VERSION_INCOMPATIBLE' => 'The uploaded file is not compatible with this version of SuiteCRM: ',
    'ERROR_PHP_VERSION_INCOMPATIBLE' => '上传的文件和当前 PHP 版本不兼容：',
    'ERROR_SUITECRM_VERSION_INCOMPATIBLE' => 'The uploaded file is not compatible with this version of SuiteCRM: ',
    'LBL_LANGPACKS' => '语言包' /*for 508 compliance fix*/,
    'LBL_MODULELOADER' => '模块加载器' /*for 508 compliance fix*/,
    'LBL_PATCHUPGRADES' => 'Patch Upgrades' /*for 508 compliance fix*/,
    'LBL_THEMES' => 'Themes' /*for 508 compliance fix*/,
    'LBL_WORKFLOW' => '工作流' /*for 508 compliance fix*/,
    'LBL_UPGRADE' => '更新' /*for 508 compliance fix*/,
    'LBL_PROCESSING' => '正在处理' /*for 508 compliance fix*/,
    'ERROR_NO_VERSION_SET' => '未在 manifest.php 中设置兼容版本',
    'LBL_UPGRD_CSTM_CHK' => '更新过程会更新一些文件，但这些文件也存在于 custom 文件夹中。请在继续之前检查下列文件的更改：',
    'ERR_UW_PHP_FILE_ERRORS' => array(
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        3 => '文件只有部分被上传。',
        4 => 'No file was uploaded.',
        5 => '出现未知错误。',
        6 => '缺少临时文件夹。',
        7 => 'Failed to write file to disk.',
        8 => '文件上传被扩展停止。',
    ),
    'LBL_PASSWORD_EXPIRATON_CHANGED' => '警告：密码过期日期没有设置',
    'LBL_PASSWORD_EXPIRATON_REDIRECT' => '请在这里更新您的设置',
);
