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
    'LBL_ASSIGNED_TO_ID' => '负责人ID',
    'LBL_ASSIGNED_TO_NAME' => '分配给',
    'LBL_ID' => 'ID',
    'LBL_DATE_ENTERED' => '创建日期',
    'LBL_DATE_MODIFIED' => '修改日期',
    'LBL_MODIFIED' => '修改人',
    'LBL_MODIFIED_NAME' => '修改人姓名',
    'LBL_CREATED' => '创建人',
    'LBL_DESCRIPTION' => '说明',
    'LBL_DELETED' => '已删除',
    'LBL_NAME' => '名称',
    'LBL_CREATED_USER' => '创建人',
    'LBL_MODIFIED_USER' => '修改人',
    'LBL_LIST_NAME' => '追踪器',
    'LBL_EDIT_BUTTON' => '编辑',
    'LBL_REMOVE' => '删除',
    'LBL_LIST_FORM_TITLE' => '邮件发送账户列表',
    'LBL_MODULE_NAME' => 'Outbound Email Accounts',
    'LBL_MODULE_TITLE' => 'Outbound Email Accounts',
    'LBL_HOMEPAGE_TITLE' => '邮件发送账户',
    'LNK_NEW_RECORD' => '创建邮件发送账户',

    'LNK_LIST_CREATE_NEW_PERSONAL' => 'New Personal Outbound Email Account',
    'LNK_LIST_CREATE_NEW_GROUP' => 'New Group Outbound Email Account',
    'LNK_LIST_CREATE_SYSTEM_OVERRIDE_GROUP' => '新建系统覆盖邮件发送账户',

    'LNK_LIST' => 'Outbound Email Accounts',
    'LNK_LIST_INBOUND_EMAIL_ACCOUNTS' => '邮件接收账户',
    'LBL_SEARCH_FORM_TITLE' => '搜索',
    'LBL_HISTORY_SUBPANEL_TITLE' => '历史记录',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => '活动',
    'LBL_NEW_FORM_TITLE' => '新建',
    'LBL_USERNAME' => '用户名',
    'LBL_PASSWORD' => '更改密码',
    'LBL_SMTP_SERVERNAME' => '服务器地址',
    'LBL_SMTP_AUTH' => '需要身份验证',
    'LBL_SMTP_PORT' => 'SMTP Port',
    'LBL_SMTP_PROTOCOL' => '协议',
    'LBL_EDITVIEW_PANEL1' => '邮件发送账户',
    'LBL_OUTBOUND_CONFIGURATION' => '出站配置',
    'LBL_CONNECTION_CONFIGURATION' => '服务器配置',
    'LBL_CHANGE_PASSWORD' => '更改密码',
    'LBL_SEND_TEST_EMAIL' => 'Send Test Email',

    // for outbound email dialog
    'LBL_MISSING_DEFAULT_OUTBOUND_SMTP_SETTINGS' => 'The administrator has not yet configured the default outbound account. Unable to send test email.',
    'LBL_MAIL_SMTPAUTH_REQ' => 'Use SMTP Authentication?',
    'LBL_MAIL_SMTPPASS' => '更改密码',
    'LBL_MAIL_SMTPPORT' => '代理服务器端口',
    'LBL_MAIL_SMTPSERVER' => '服务器',
    'LBL_MAIL_SMTPUSER' => '用户名',
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

    'LBL_TYPE' => '类型',
    'LBL_MAIL_SENDTYPE' => '邮件发送协议',
    'LBL_MAIL_SMTPSSL' => '使用 SSL',
    'LBL_SMTP_FROM_NAME' => '设置发件人地址',
    'LBL_SMTP_FROM_ADDR' => '设置发件人名称',
    'LBL_REPLY_TO_NAME' => '"回复"名称',
    'LBL_REPLY_TO_ADDR' => '"回复"地址',

    'LBL_SECURITYGROUPS_SUBPANEL_TITLE' => '用户组',

    'LBL_OWNER' => '负责人',
    'LBL_OWNER_NAME' => '负责人',

    'LBL_AUTH_TYPE' => '认证类型',

    'LBL_EXTERNAL_OAUTH_CONNECTION' => '外部 OAuth 连接',
    'LBL_EXTERNAL_OAUTH_CONNECTION_ID' => '外部 OAuth 连接 ID',
    'LBL_EXTERNAL_OAUTH_CONNECTION_NAME' => '外部 OAuth 连接',
    'LNK_EXTERNAL_OAUTH_CONNECTIONS' => '外部 OAuth 连接',

    'LBL_ERROR_OUTBOUND_EMAIL_SYSTEM_EXISTS' => 'System Outbound Email Account already exists. Please remove it before creating a new one.',
    'LBL_ERROR_OUTBOUND_EMAIL_SYSTEM_IS_NOT_GROUP' => 'When configuring the System Outbound account using OAuth, you must select a Group-Type External Oauth Connection',
    'LBL_ERROR_OUTBOUND_EMAIL_CONNECTION_TYPE_MISMATCH' => 'When configuring the Outbound account using OAuth, you must select a External Oauth Connection the same type as the Outbound Email Account (Group or Personal)',
);
