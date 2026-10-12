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
    /*'ADMIN_EXPORT_ONLY'=>'Admin export only',*/
    'ADVANCED' => '高级',
    'DEFAULT_CURRENCY_ISO4217' => 'ISO 4217 货币代码',
    'DEFAULT_CURRENCY_NAME' => '货币名称',
    'DEFAULT_CURRENCY_SYMBOL' => '货币符号',
    'DEFAULT_DATE_FORMAT' => '默认日期格式',
    'DEFAULT_DECIMAL_SEP' => '小数点符号',
    'DEFAULT_LANGUAGE' => '默认语言',
    'DEFAULT_SYSTEM_SETTINGS' => '系统设置',
    'DEFAULT_THEME' => '默认主题',
    'DEFAULT_TIME_FORMAT' => '默认时间格式',

    'DISPLAY_RESPONSE_TIME' => '显示服务器响应时间',

    'IMAGES' => 'Logos',
    'LBL_ALLOW_USER_TABS' => '允许用户隐藏标签',
    'LBL_CONFIGURE_SETTINGS_TITLE' => '系统设置',
    'LBL_LOGVIEW' => '查看日志',
    'LBL_MAIL_SMTPAUTH_REQ' => 'Use SMTP Authentication?',
    'LBL_MAIL_SMTPPASS' => 'SMTP Password:',
    'LBL_MAIL_SMTPPORT' => 'SMTP Port:',
    'LBL_MAIL_SMTPSERVER' => 'SMTP Server:',
    'LBL_MAIL_SMTPUSER' => 'SMTP Username:',
    'LBL_MAIL_SMTP_SETTINGS' => 'SMTP Server Specification',
    'LBL_CHOOSE_EMAIL_PROVIDER' => 'Choose your Email provider:',
    'LBL_YAHOOMAIL_SMTPPASS' => 'Yahoo! Mail Password:',
    'LBL_YAHOOMAIL_SMTPUSER' => 'Yahoo! Mail ID:',
    'LBL_GMAIL_SMTPPASS' => 'Gmail Password:',
    'LBL_GMAIL_SMTPUSER' => 'Gmail Email Address:',
    'LBL_EXCHANGE_SMTPPASS' => 'Exchange Password:',
    'LBL_EXCHANGE_SMTPUSER' => 'Exchange Username:',
    'LBL_EXCHANGE_SMTPPORT' => 'Exchange Server Port:',
    'LBL_EXCHANGE_SMTPSERVER' => 'Exchange Server:',
    'LBL_ALLOW_DEFAULT_SELECTION' => 'Allow users to use this account for outgoing email:',
    'LBL_ALLOW_DEFAULT_SELECTION_HELP' => 'When this option is selected, all users will be able to send emails using the same outgoing mail account used to send system notifications and alerts. If the option is not selected, users can still use the outgoing mail server after providing their own account information.',
    'LBL_MAILMERGE' => '邮件合并',
    'LBL_MIN_AUTO_REFRESH_INTERVAL' => 'Dashlet 自动刷新间隔',
    'LBL_MIN_AUTO_REFRESH_INTERVAL_HELP' => '设置组件自动刷新间隔的时间。设置为 "从不" 将禁用自动刷新。',
    'LBL_MODULE_FAVICON' => '模块图标作为 favicon 图标',
    'LBL_MODULE_FAVICON_HELP' => '如果模块有图标，将使用模块的图标作为 favicon 图标。',
    'LBL_MODULE_NAME' => '系统设置',
    'LBL_MODULE_ID' => '配置',
    'LBL_MODULE_TITLE' => '用户界面',
    'LBL_NOTIFY_FROMADDRESS' => '"From" Address:',
    'LBL_NOTIFY_SUBJECT' => '主题',

    'LBL_PROXY_AUTH' => '身份验证',
    'LBL_PROXY_HOST' => '代理服务器地址',
    'LBL_PROXY_ON_DESC' => '配置代理服务器的地址以及身份验证设置',
    'LBL_PROXY_ON' => '启用代理',
    'LBL_PROXY_PASSWORD' => '更改密码',
    'LBL_PROXY_PORT' => '代理服务器端口',
    'LBL_PROXY_TITLE' => '代理设置',
    'LBL_PROXY_USERNAME' => '用户名',
    'LBL_RESTORE_BUTTON_LABEL' => '还原',
    'LBL_SYSTEM_SETTINGS' => '系统设置',
    'LBL_USE_REAL_NAMES' => '负责人字段显示全名',
    'LBL_USE_REAL_NAMES_DESC' => '在负责人字段中显示用户全名而不是用户名。',
    'LBL_DISALBE_CONVERT_LEAD' => '禁止转化已转化的潜在客户',
    'LBL_DISALBE_CONVERT_LEAD_DESC' => '如果一个潜在客户已转化过，启用此选项后将移除转化操作。',
    'LBL_ENABLE_ACTION_MENU' => '在菜单中显示动作',
    'LBL_ENABLE_ACTION_MENU_DESC' => '如果选中，以下拉菜单的方式显示详细信息视图和子面板的可操作动作。如果未选择，操作动作将显示为单独的按钮。',
    'LBL_ENABLE_INLINE_EDITING_LIST' => '在列表视图上启用行内编辑',
    'LBL_ENABLE_INLINE_EDITING_LIST_DESC' => '选择以允许行内编辑列表视图字段。如果未选择，将禁用行内编辑。',
    'LBL_ENABLE_INLINE_EDITING_DETAIL' => '在详细视图上启用行内编辑',
    'LBL_ENABLE_INLINE_EDITING_DETAIL_DESC' => '选择以允许行内编辑详细视图字段。如果未选择，将禁用行内编辑。',
    'LBL_HIDE_SUBPANELS' => '隐藏子面板',
    'LIST_ENTRIES_PER_LISTVIEW' => '列表视图的每页记录数',
    'LIST_ENTRIES_PER_SUBPANEL' => '子面板视图的每页记录数',
    'LOG_MEMORY_USAGE' => '记录内存使用',
    'LOG_SLOW_QUERIES' => '记录慢查询',
    'CURRENT_LOGO' => 'Current Logo:',
    'CURRENT_LOGO_HELP' => '这个图标显示在 SuiteCRM登录界面的中心。',
    'NEW_LOGO' => 'Select Logo:',
    'NEW_LOGO_HELP' => '图像文件格式可以是 .jpg 或 .png。最大高度 170px，最大宽度 450px。任何上传的图像大于最大尺寸将自动缩放。',
    'NEW_LOGO_HELP_NO_SPACE' => '图像文件格式可以是 .jpg 或 .png。最大高度 170px，最大宽度 450px。任何上传的图像大于最大尺寸将自动缩放。',
    'SLOW_QUERY_TIME_MSEC' => '慢查询时间阈值（毫秒）',
    'STACK_TRACE_ERRORS' => '显示错误的堆栈跟踪',
    'UPLOAD_MAX_SIZE' => '最大上传文件大小',
    'VERIFY_CLIENT_IP' => '验证用户 IP 地址',
    'LOCK_HOMEPAGE' => '禁止用户自定义首页布局',
    'LOCK_SUBPANELS' => '禁止用户自定义子面板布局',
    'MAX_DASHLETS' => '首页组件个数上限',
    'SYSTEM_NAME' => '设置系统名称',
    'SYSTEM_NAME_WIZARD' => '营销活动名称',
    'SYSTEM_NAME_HELP' => 'This is the name that displays in the title bar of your browser.',
    'LBL_LDAP_TITLE' => 'LDAP 身份验证',
    'LBL_LDAP_ENABLE' => '启用 LDAP 身份验证',
    'LBL_LDAP_SERVER_HOSTNAME' => 'Server:',
    'LBL_LDAP_SERVER_PORT' => 'Port Number:',
    'LBL_LDAP_ADMIN_USER' => 'User Name:',
    'LBL_LDAP_ADMIN_USER_DESC' => '用于搜索 SuiteCRM 用户，可能需要完全限定。',
    'LBL_LDAP_ADMIN_PASSWORD' => 'Password:',
    'LBL_LDAP_AUTHENTICATION' => 'Authentication:',
    'LBL_LDAP_AUTHENTICATION_DESC' => '使用特定的用户凭据绑定到 LDAP 服务器。如果没有提供，将使用匿名绑定。',
    'LBL_LDAP_AUTO_CREATE_USERS' => 'Auto Create Users:',
    'LBL_LDAP_USER_DN' => 'User DN:',
    'LBL_LDAP_GROUP_DN' => 'Group DN:',
    'LBL_LDAP_GROUP_DN_DESC' => 'Example: <em>ou=groups,dc=example,dc=com</em>',
    'LBL_LDAP_USER_FILTER' => 'User Filter:',
    'LBL_LDAP_GROUP_MEMBERSHIP' => 'Group Membership:',
    'LBL_LDAP_GROUP_MEMBERSHIP_DESC' => 'Users must be a member of a specific group',
    'LBL_LDAP_GROUP_USER_ATTR' => 'User Attribute:',
    'LBL_LDAP_GROUP_USER_ATTR_DESC' => 'The unique identifier of the person that will be used to check if they are a member of the group Example: <em>uid</em>',
    'LBL_LDAP_GROUP_ATTR_DESC' => 'The attribute of the Group that will be used to filter against the User Attribute Example: <em>memberUid</em>',
    'LBL_LDAP_GROUP_ATTR' => 'Group Attribute:',
    'LBL_LDAP_USER_FILTER_DESC' => '用户进行身份验证时要应用的额外的筛选参数，或留空。示例：<em>is_suitecrm_user=1</em> 或 <em>(is_suitecrm_user=1) (is_sales=1)</em>',
    'LBL_LDAP_LOGIN_ATTRIBUTE' => 'Login Attribute:',
    'LBL_LDAP_BIND_ATTRIBUTE' => 'Bind Attribute:',
    'LBL_LDAP_BIND_ATTRIBUTE_DESC' => '绑定 LDAP 用户示例：[<b>AD:</b>&nbsp;userPrincipalName] [<b>openLDAP:</b>&nbsp;dn] [<b>Mac&nbsp;OS&nbsp;X:</b>&nbsp;uid] ',
    'LBL_LDAP_LOGIN_ATTRIBUTE_DESC' => '搜索 LDAP 用户示例：[<b>AD:</b>&nbsp;userPrincipalName] [<b>openLDAP:</b>&nbsp;cn] [<b>Mac&nbsp;OS&nbsp;X:</b>&nbsp;dn] ',
    'LBL_LDAP_SERVER_HOSTNAME_DESC' => '例如：ldap.example.com 或 SSL 连接 ldaps://ldap.example.com',
    'LBL_LDAP_SERVER_PORT_DESC' => '示例：<em>389</em> 或 <em>636</em>（SSL）',
    'LBL_LDAP_GROUP_NAME' => 'Group Name:',
    'LBL_LDAP_GROUP_NAME_DESC' => '示例：<em>cn=suitecrm</em>',
    'LBL_LDAP_USER_DN_DESC' => '指定用于检索用户的完整 DN 条目。示例：<em>ou=people,dc=example,dc=com</em>',
    'LBL_LDAP_AUTO_CREATE_USERS_DESC' => '如果已通过身份验证的用户在系统中不存在，将自动创建。',
    'LBL_LDAP_ENC_KEY' => 'Encryption Key:',
    'DEVELOPER_MODE' => '开发者模式',

    'SHOW_DOWNLOADS_TAB' => '显示下载标签',
    'SHOW_DOWNLOADS_TAB_HELP' => '选择此选项后, "下载" 选项卡将显示在 "用户" 设置中, 并为用户提供对 SuiteCRM 插件和其他可用文件的访问权限',
    'LBL_LDAP_ENC_KEY_DESC' => '在使用 LDAP 时进行 SOAP 认证',
    'LDAP_ENC_KEY_NO_FUNC_DESC' => '必须在 php.ini 文件中启用 php_mcrypt 扩展。',
    'LDAP_ENC_KEY_NO_FUNC_OPENSSL_DESC' => '必须在 php. ini 文件中启用 openssl 扩展。',
    'LBL_ALL' => '全部模块',
    'LBL_MARK_POINT' => '标记点',
    'LBL_NEXT_' => '下一步',
    'LBL_REFRESH_FROM_MARK' => '从标记刷新',
    'LBL_SEARCH' => '搜索',
    'LBL_REG_EXP' => '正则表达式',
    'LBL_IGNORE_SELF' => '忽略自身',
    'LBL_MARKING_WHERE_START_LOGGING' => '标记开始日志的位置',
    'LBL_DISPLAYING_LOG' => '正在显示日志',
    'LBL_YOUR_PROCESS_ID' => '您的进程 ID',
    'LBL_YOUR_IP_ADDRESS' => '您的 IP 地址是',
    'LBL_IT_WILL_BE_IGNORED' => '它将被忽略',
    'LBL_LOG_NOT_CHANGED' => '日志没有改变',
    'LBL_ALERT_JPG_IMAGE' => '图片的文件格式必须是 JPEG 格式。 请上传文件扩展名为 .jpg 的文件。',
    'LBL_ALERT_TYPE_IMAGE' => '图片的文件格式必须是 JPEG 或者 PNG 格式。 请上传文件扩展名为 .jpg 或者 .png 的文件。',
    'LBL_ALERT_SIZE_RATIO' => '图片的长宽比应该是 1:1 到 10:1 之间。图片将被重新调整。',
    'ERR_ALERT_FILE_UPLOAD' => '文件上传时出错。',
    'LBL_LOGGER' => '日志设置',
    'LBL_LOGGER_FILENAME' => '日志文件名',
    'LBL_LOGGER_FILE_EXTENSION' => '扩展名',
    'LBL_LOGGER_MAX_LOG_SIZE' => '最大日志大小',
    'LBL_STACK_TRACE' => '启用堆栈跟踪',
    'LBL_LOGGER_DEFAULT_DATE_FORMAT' => 'Default date format',
    'LBL_LOGGER_LOG_LEVEL' => '日志级别',
    'LBL_LEAD_CONV_OPTION' => '潜在客户转化选项',
    'LEAD_CONV_OPT_HELP' => "<b>复制</b> - 创建并关联所有潜在客户的活动记录到转化过程中新创建的记录上。<br /><br /><b>移动</b> - 移动潜在客户的所有活动记录，关联到转化过程中新创建的记录上。<br /><br /><b>无</b> - 转化过程中不修改任何潜在客户的活动记录，活动记录仍旧只和潜在客户关联。",
    'LBL_CONFIG_AJAX' => 'Configure AJAX User Interface',
    'LBL_CONFIG_AJAX_DESC' => '设置特定的模块启用或禁用 AJAX 。',
    'LBL_LOGGER_MAX_LOGS' => '日志文件最大数量',
    'LBL_LOGGER_FILENAME_SUFFIX' => '在文件名后附加',
    'LBL_VCAL_PERIOD' => 'vCal 更新时间段',
    'LBL_IMPORT_MAX_RECORDS' => '最大数据导入行数',
    'LBL_IMPORT_MAX_RECORDS_HELP' => '设定在导入文件时的最大处理行数。<br />如果导入时超过该行数，将提醒用户。<br />不输入任何数字，将不做限制。',
    'vCAL_HELP' => '此设置用来决定电话和会议的闲忙信息更新时间范围.</BR>关闭闲忙信息更新请输入"0".  最小值1个月; 最大值12个月.',

// Wizard
    //Wizard Scenarios
    'LBL_WIZARD_SCENARIOS' => '您的场景',
    'LBL_WIZARD_SCENARIOS_EMPTY_LIST' => '当前未配置任何场景',
    'LBL_WIZARD_SCENARIOS_DESC' => '选择适合的场景，您也可以在安装后更改这些选项。',

    'LBL_WIZARD_TITLE' => '设置向导',
    'LBL_WIZARD_WELCOME_TAB' => '欢迎使用',
    'LBL_WIZARD_WELCOME_TITLE' => '欢迎使用 SuiteCRM！',
    'LBL_WIZARD_WELCOME' => '单击 <b>下一个</b> 配置系统的基本设置。如果您想要在以后配置这些选项，请点击 <b>跳过</b>。',
    'LBL_WIZARD_NEXT_BUTTON' => '下一步',
    'LBL_WIZARD_BACK_BUTTON' => '返回',
    'LBL_WIZARD_SKIP_BUTTON' => '跳过',
    'LBL_WIZARD_CONTINUE_BUTTON' => '继续',
    'LBL_WIZARD_FINISH_TITLE' => '完成',
    'LBL_WIZARD_SYSTEM_TITLE' => 'Branding',
    'LBL_WIZARD_SYSTEM_DESC' => 'Provide your organization\'s name and logo in order to brand your SuiteCRM.',
    'LBL_WIZARD_LOCALE_DESC' => 'Specify how you would like data in SuiteCRM to be displayed, based on your geographical location. The settings you provide here will be the default settings. Users will be able set their own preferences.',
    'LBL_WIZARD_SMTP_DESC' => 'Provide the email account that will be used to send emails, such as the assignment notifications and new user passwords. Users will receive emails from SuiteCRM, as sent from the specified email account.',
    'LBL_LOADING' => '正在加载...' /*for 508 compliance fix*/,
    'LBL_DELETE' => '删除' /*for 508 compliance fix*/,
    'LBL_WELCOME' => '欢迎使用' /*for 508 compliance fix*/,
    'LBL_LOGO' => 'Logo' /*for 508 compliance fix*/,
    'LBL_ENABLE_HISTORY_CONTACTS_EMAILS' => '在历史记录子面板中显示关联联系人的邮件记录',
);
