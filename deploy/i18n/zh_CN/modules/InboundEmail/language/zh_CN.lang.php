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


    'LBL_RE' => '回复',

    'ERR_BAD_LOGIN_PASSWORD' => '用户名或密码错误。',
    'ERR_INI_ZLIB' => '暂时无法关闭 zlib 压缩。"测试设置" 可能会失败。',
    'ERR_NO_IMAP' => '未检测到 IMAP 模块。请先解决此问题，然后再继续配置邮件接收账户。',
    'ERR_NO_OPTS_SAVED' => '未正确设置邮件接收账户。',
    'ERR_TEST_MAILBOX' => '请检查您的设置，然后重试。',
    'ERR_INVALID_PORT' => '无效端口',

    'LBL_ASSIGN_TO_USER' => '负责人',
    'LBL_AUTOREPLY' => '自动回复模板',
    'LBL_AUTOREPLY_HELP' => '选择自动回复通知邮件发件人。',
    'LBL_BASIC' => '基本设置',
    'LBL_CASE_MACRO' => 'Case Macro',
    'LBL_CASE_MACRO_DESC' => 'Set the macro which will be parsed and used to link imported email to a Case.',
    'LBL_CASE_MACRO_DESC2' => 'Set this to any value, but preserve the <b>"%1"</b>.',
    'LBL_CLOSE_POPUP' => '关闭',
    'LBL_CREATE_TEMPLATE' => '创建',
    'LBL_DELETE_SEEN' => '在导入后删除已读的电子邮件',
    'LBL_EDIT_TEMPLATE' => '编辑',
    'LBL_EMAIL_OPTIONS' => '邮件选项',
    'LBL_EMAIL_BOUNCE_OPTIONS' => '退信处理选项',
    'LBL_FILTER_DOMAIN_DESC' => '指定不发送自动回复邮件到这些域。',
    'LBL_ASSIGN_TO_GROUP_FOLDER_DESC' => '选择此项可在 SuiteCRM 中自动为所有收到的邮件创建电子邮件记录。',
    'LBL_FILTER_DOMAIN' => '不自动回复这些域',
    'LBL_FIND_SSL_WARN' => '<br />测试 SSL 可能需要一段时间。请耐心等待。<br />',
    'LBL_FROM_ADDR' => '设置发件人地址',
    'LBL_FROM_ADDR_DESC' => '这个邮件地址不能出现在发送的邮件的“From”地址中，因为收到邮件服务商的限制。这种情况下，在发送邮件服务器中定义的邮件地址会被使用。', // as long as XTemplate doesn't support output escaping, transform quotes to html-entities right here (bug #48913)
    'LBL_FROM_NAME' => '设置发件人名称',
    'LBL_GROUP_QUEUE' => '指派给组',
    'LBL_HOME' => '首页',
    'LBL_LIST_MAILBOX_TYPE' => '邮箱类型',
    'LBL_LIST_NAME' => '营销活动名称',
    'LBL_LIST_GLOBAL_PERSONAL' => '类型',
    'LBL_LIST_SERVER_URL' => '服务器地址',
    'LBL_SERVER_ADDRESS' => '服务器地址',
    'LBL_LIST_STATUS' => '状态',
    'LBL_LOGIN' => '用户名',
    'LBL_USERNAME' => '用户名',
    'LBL_MAILBOX_DEFAULT' => '收件箱',
    'LBL_MAILBOX_SSL' => '使用 SSL',
    'LBL_MAILBOX_TYPE' => '邮箱类型',
    'LBL_DISTRIBUTION_METHOD' => '分配方法',
    'LBL_CREATE_CASE_REPLY_TEMPLATE' => '新建客户反馈回复模板',
    'LBL_CREATE_CASE_REPLY_TEMPLATE_HELP' => '选择客户反馈创建时的自动告知电子邮件的发件人。邮件中将包含客户反馈号。只有当第一次收到收件人的邮件时才会创建这个邮件。',
    'LBL_MAILBOX' => '已监控的文件夹',
    'LBL_PRIMARY_FOLDER' => 'Primary Folder',
    'LBL_TRASH_FOLDER' => '垃圾箱',
    'LBL_SENT_FOLDER' => '已发送',
    'LBL_SELECT' => '选择',
    'LBL_MARK_READ_NO' => '导入后删除标记过的电子邮件',
    'LBL_MARK_READ_YES' => '导入后在服务器上保留电子邮件',
    'LBL_MARK_READ' => '在服务器上保留邮件',
    'LBL_MAX_AUTO_REPLIES' => '自动回复次数',
    'LBL_MAX_AUTO_REPLIES_DESC' => '设置在 24 小时时间内，自动回复同一个邮件地址的最大次数。',
    'LBL_PERSONAL_MODULE_NAME' => '个人邮件账户',
    'LBL_CREATE_CASE' => '创建客户反馈',
    'LBL_CREATE_CASE_HELP' => '选择此项可在 SuiteCRM 中自动为所有收到的邮件创建案件记录。',
    'LBL_MODULE_NAME' => 'Group Mail Account',
    'LBL_BOUNCE_MODULE_NAME' => '退信处理邮箱',
    'LBL_MODULE_TITLE' => '邮件接收账户',
    'LBL_NAME' => '名称',
    'LBL_NONE' => '-无-',
    'LBL_ONLY_SINCE_NO' => '不。检查此邮件服务器上的所有邮件。',
    'LBL_ONLY_SINCE_YES' => '是。',
    'LBL_PASSWORD' => '更改密码',
    'LBL_EMAIL_PASSWORD' => '更改密码',
    'LBL_POP3_SUCCESS' => 'POP3 协议测试连接成功。',
    'LBL_POPUP_TITLE' => '测试设置',
    'LBL_SELECT_SUBSCRIBED_FOLDERS' => '选择订阅的文件夹',
    'LBL_SELECT_TRASH_FOLDERS' => '选择垃圾箱',
    'LBL_SELECT_SENT_FOLDERS' => '选择已发送',
    'LBL_DELETED_FOLDERS_LIST' => '以下目录 %s 不存在或已从服务器上删除',
    'LBL_PORT' => '端口',
    'LBL_REPLY_TO_NAME' => '设置回复名称',
    'LBL_REPLY_TO_ADDR' => '设置回复地址',
    'LBL_SAME_AS_ABOVE' => '使用发件人名称/地址',
    'LBL_SERVER_OPTIONS' => '高级设置',
    'LBL_SERVER_TYPE' => 'Mail Server Protocol',
    'LBL_SERVER_PORT' => '端口',
    'LBL_SERVER_URL' => '服务器地址',
    'LBL_SSL_DESC' => 'If your mail server supports secure socket connections, enabling this will force SSL connections when importing email.',
    'LBL_ASSIGN_TO_TEAM_DESC' => '所选团队拥有此邮件帐号权限. 如果选择组文件夹,指派给该文件夹的团队将覆盖所选团队.',
    'LBL_SSL' => '使用 SSL',
    'LBL_STATUS' => '状态',
    'LBL_EMAIL_BODY_FILTERING' => '邮件正文过滤器类型',
    'LBL_SYSTEM_DEFAULT' => '系统默认',
    'LBL_TEST_BUTTON_TITLE' => '测试',
    'LBL_TEST_SETTINGS' => '测试设置',
    'LBL_TEST_CONNECTION_SETTINGS' => '测试连接设置',
    'LBL_TEST_SUCCESSFUL' => '连接测试成功。',
    'LBL_TEST_WAIT_MESSAGE' => '请稍后...',
    'LBL_WARN_IMAP_TITLE' => '未检测到 IMAP 模块',
    'LBL_WARN_IMAP' => '警告：',
    'LBL_WARN_NO_IMAP' => 'PHP 没有启用/编译 PHP IMAP 模块，邮件接收功能<b>无法正常使用</b>。请联系管理员解决此问题。',

    'LNK_LIST_CREATE_NEW_PERSONAL' => 'New Personal Inbound Email Account',
    'LNK_LIST_CREATE_NEW_GROUP' => 'New Group Inbound Email Account',
    'LNK_LIST_CREATE_NEW_CASES_TYPE' => 'New Case Handling Email Account',
    'LNK_LIST_CREATE_NEW_BOUNCE' => 'New Bounce Handling Email Account',
    'LNK_LIST_MAILBOXES' => '邮件接收账户',
    'LNK_LIST_OUTBOUND_EMAILS' => 'Outbound Email Accounts',
    'LNK_LIST_SCHEDULER' => '任务计划',
    'LNK_SEED_QUEUES' => '团队的记录队列',
    'LBL_GROUPFOLDER_ID' => '群组文件夹ID',

    'LBL_ALLOW_OUTBOUND_GROUP_USAGE' => '发送邮件时，允许用户使用 "发件人" 的姓名和地址作为回复地址',
    'LBL_ALLOW_OUTBOUND_GROUP_USAGE_DESC' => '当选择此项，群组邮件帐户的用户在撰写电子邮件时，将使用对应用户的 "发件人名称" 和 "邮件地址" 将作为的 "发件人" 的字段。',
    'LBL_STATUS_ACTIVE' => '启用',
    'LBL_STATUS_INACTIVE' => '停用',
    'LBL_IS_PERSONAL' => '个人',
    'LBL_IS_GROUP' => '群组',
    'LBL_ENABLE_AUTO_IMPORT' => '自动导入邮件',
    'LBL_WARNING_CHANGING_AUTO_IMPORT' => '警告：您修改了自动导入设置，可能会导致数据丢失。',
    'LBL_WARNING_CHANGING_AUTO_IMPORT_WITH_CREATE_CASE' => '警告：如果要自动创建客户反馈，必须启用自动导入邮件。',
    'LBL_LIST_TITLE_MY_DRAFTS' => '草稿箱',
    'LBL_LIST_TITLE_MY_INBOX' => '收件箱',
    'LBL_LIST_TITLE_MY_SENT' => '发送邮件',
    'LBL_LIST_TITLE_MY_ARCHIVES' => '已存档',
    'LNK_MY_DRAFTS' => '草稿箱',
    'LNK_MY_INBOX' => 'Email',
    'LNK_VIEW_MY_INBOX' => '查看收件箱',
    'LNK_QUICK_REPLY' => '快速回复',
    'LNK_SENT_EMAIL_LIST' => '已发送',
    'LBL_EDIT_LAYOUT' => '编辑布局' /*for 508 compliance fix*/,
    'LBL_TYPE_DIFFERENT' => 'External OAuth Connection type must be the SAME as the Inbound Email Account type',

    'LBL_MODIFIED_BY' => '修改人',
    'LBL_SERVICE' => 'Service',
    'LBL_STORED_OPTIONS' => '存储的选项',
    'LBL_GROUP_ID' => '组 ID',

    'LBL_OUTBOUND_CONFIGURATION' => '出站配置',
    'LBL_CONNECTION_CONFIGURATION' => '服务器配置',
    'LBL_AUTO_REPLY_CONFIGURATION' => '自动回复配置',
    'LBL_CASE_CONFIGURATION' => '案例配置',
    'LBL_GROUP_CONFIGURATION' => '群组配置',

    'LBL_SECURITYGROUPS_SUBPANEL_TITLE' => '用户组',


    'LBL_OUTBOUND_EMAIL_ACCOUNT' => '邮件发送账户',
    'LBL_OUTBOUND_EMAIL_ACCOUNT_ID' => '邮件发送账户 ID',
    'LBL_OUTBOUND_EMAIL_ACCOUNT_NAME' => '邮件发送账户',

    'LBL_AUTOREPLY_EMAIL_TEMPLATE' => '自动回复模板',
    'LBL_AUTOREPLY_EMAIL_TEMPLATE_ID' => '自动回复模板 ID',
    'LBL_AUTOREPLY_EMAIL_TEMPLATE_NAME' => '自动回复模板',

    'LBL_CASE_EMAIL_TEMPLATE' => '案例邮件模板',
    'LBL_CASE_EMAIL_TEMPLATE_ID' => '案例邮件模板 ID',
    'LBL_CASE_EMAIL_TEMPLATE_NAME' => '案例邮件模板',

    'LBL_PROTOCOL' => '协议',
    'LBL_CONNECTION_STRING' => '连接字符串',
    'LBL_DISTRIB_METHOD' => 'Distribution Method',
    'LBL_DISTRIB_OPTIONS' => '分发选项',

    'LBL_DISTRIBUTION_USER' => '分发用户',
    'LBL_DISTRIBUTION_USER_ID' => '分发用户 ID',
    'LBL_DISTRIBUTION_USER_NAME' => '分发用户',

    'LBL_EXTERNAL_OAUTH_CONNECTION' => '外部 OAuth 连接',
    'LBL_EXTERNAL_OAUTH_CONNECTION_ID' => '外部 OAuth 连接 ID',
    'LBL_EXTERNAL_OAUTH_CONNECTION_NAME' => '外部 OAuth 连接',
    'LNK_EXTERNAL_OAUTH_CONNECTIONS' => '外部 OAuth 连接',

    'LBL_TYPE' => '类型',
    'LBL_AUTH_TYPE' => '认证类型',
    'LBL_IS_DEFAULT' => '默认',
    'LBL_SIGNATURE' => 'Signature',

    'LBL_OWNER_NAME' => '负责人',

    'LBL_SET_AS_DEFAULT_BUTTON' => '设为默认',

    'LBL_MOVE_MESSAGES_TO_TRASH_AFTER_IMPORT' => '导入后移动信件到回收站？',
    'LBL_LAST_IMPORT_RUN_DATETIME' => 'Last Import Run Date/Time',
    'LBL_MAILBOX_LAST_IMPORTED_DAYS' => 'Last Imported Date Per Mailbox',
    'LBL_EMAIL_IMPORT_PER_RUN_THRESHOLD' => 'Emails to Import Per Run',
    'LBL_EMAIL_IMPORT_TIMEFRAME_START' => 'Import Timeframe Start',
    'LBL_EMAIL_IMPORT_UNREAD_ONLY' => 'Import Unread Emails Only'
);
