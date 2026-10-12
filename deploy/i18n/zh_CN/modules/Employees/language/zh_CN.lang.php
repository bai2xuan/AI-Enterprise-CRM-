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
    'LBL_MODULE_NAME' => '员工',
    'LBL_MODULE_TITLE' => '员工',
    'LBL_SEARCH_FORM_TITLE' => '搜索',
    'LBL_LIST_FORM_TITLE' => '员工',
    'LBL_NEW_FORM_TITLE' => '新建',
    'LBL_LOGIN' => '用户名',
    'LBL_RESET_PREFERENCES' => '重置首选项',
    'LBL_TIME_FORMAT' => 'Time Format:',
    'LBL_DATE_FORMAT' => 'Date Format:',
    'LBL_TIMEZONE' => '时区',
    'LBL_CURRENCY' => 'Currency:',
    'LBL_LIST_NAME' => '追踪器',
    'LBL_LIST_LAST_NAME' => '姓氏',
    'LBL_LIST_EMPLOYEE_NAME' => '员工姓名',
    'LBL_LIST_DEPARTMENT' => 'Department',
    'LBL_LIST_REPORTS_TO_NAME' => 'Reports To',
    'LBL_LIST_EMAIL' => 'Email',
    'LBL_LIST_USER_NAME' => '用户名',
    'LBL_ERROR' => '错误',
    'LBL_PASSWORD' => 'Password:',
    'LBL_USER_NAME' => 'User Name:',
    'LBL_USER_TYPE' => '用户类型',
    'LBL_FIRST_NAME' => 'First Name:',
    'LBL_LAST_NAME' => 'Last Name:',
    'LBL_THEME' => 'Theme:',
    'LBL_LANGUAGE' => 'Language:',
    'LBL_ADMIN' => '管理员',
    'LBL_EMPLOYEE_INFORMATION' => '员工信息',
    'LBL_OFFICE_PHONE' => 'Office Phone:',
    'LBL_REPORTS_TO' => '上级',
    'LBL_REPORTS_TO_NAME' => '上级',
    'LBL_OTHER_PHONE' => 'Other Phone:',
    'LBL_NOTES' => '备忘录',
    'LBL_DEPARTMENT' => 'Department:',
    'LBL_TITLE' => '头衔:',
    'LBL_ANY_ADDRESS' => '任何地址',
    'LBL_ANY_PHONE' => '任何电话',
    'LBL_ANY_EMAIL' => '任何邮箱',
    'LBL_ADDRESS' => '地址',
    'LBL_CITY' => 'City:',
    'LBL_STATE' => '省份',
    'LBL_POSTAL_CODE' => 'Postal Code:',
    'LBL_COUNTRY' => 'Country:',
    'LBL_NAME' => '营销活动名称',
    'LBL_MOBILE_PHONE' => 'Mobile:',
    'LBL_FAX' => 'Fax:',
    'LBL_EMAIL' => 'Email Address:',
    'LBL_EMAIL_LINK_TYPE' => 'Email Client',
    'LBL_EMAIL_LINK_TYPE_HELP' => '<b>SuiteCRM 邮件客户端：</b>使用 SuiteCRM 电子邮件客户端来发送邮件。<br /><b>外部邮件客户端：</b>使用外部电子邮件客户端（如 Microsoft Outlook）来发送邮件。',
    'LBL_HOME_PHONE' => '家庭电话',
    'LBL_WORK_PHONE' => '办公电话',
    'LBL_EMPLOYEE_STATUS' => '员工状态',
    'LBL_PRIMARY_ADDRESS' => '街道',
    'LBL_SAVED_SEARCH' => '已保存的筛选',
    'LBL_MESSENGER_ID' => '即时通讯 ID',
    'LBL_MESSENGER_TYPE' => '即时通讯类型',
    'ERR_LAST_ADMIN_1' => '员工姓名 ',
    'ERR_LAST_ADMIN_2' => ' 是最后一个具有管理员权限的员工。请保证至少有一个员工是管理员。',
    'LNK_NEW_EMPLOYEE' => '创建员工',
    'LNK_EMPLOYEE_LIST' => '查看员工',
    'ERR_DELETE_RECORD' => 'You must specify a record number to delete the account.',
    'LBL_LIST_EMPLOYEE_STATUS' => '状态',

    'LBL_SUITE_LOGIN' => '普通用户',
    'LBL_RECEIVE_NOTIFICATIONS' => '接收通知提醒',
    'LBL_IS_ADMIN' => '管理员',
    'LBL_GROUP' => '组用户',
    'LBL_PHOTO' => 'Photo',
    'LBL_DELETE_USER_CONFIRM' => '员工也是一个用户。删除员工会删除对应的用户记录，并且用户将不能再访问系统。您确定要删除此员工记录？',
    'LBL_DELETE_EMPLOYEE_CONFIRM' => '您确定要删除此员工？',
    'LBL_ONLY_ACTIVE' => '仅活动',
    'LBL_SELECT' => '选择' /*for 508 compliance fix*/,
    'LBL_AUTHENTICATE_ID' => '认证ID',
    'LBL_EXT_AUTHENTICATE' => '外部认证',
    'LBL_GROUP_USER' => 'Group User',
    'LBL_LIST_ACCEPT_STATUS' => '接受状态',
    'LBL_MODIFIED_BY' => '修改人',
    'LBL_MODIFIED_BY_ID' => '修改人ID',
    'LBL_CREATED_BY_NAME' => '创建人', //bug48978
    'LBL_PORTAL_ONLY_USER' => '门户用户',
    'LBL_PSW_MODIFIED' => '密码更改时间',
    'LBL_SHOW_ON_EMPLOYEES' => '在员工模块中显示',
    'LBL_USER_HASH' => '更改密码',
    'LBL_SYSTEM_GENERATED_PASSWORD' => '系统生成的密码',
    'LBL_DESCRIPTION' => '说明',
    'LBL_FAX_PHONE' => 'Fax',
    'LBL_STATUS' => '状态',
    'LBL_ADDRESS_CITY' => '城市',
    'LBL_ADDRESS_COUNTRY' => '国家',
    'LBL_ADDRESS_INFORMATION' => 'Address Information',
    'LBL_ADDRESS_POSTALCODE' => '邮编',
    'LBL_ADDRESS_STATE' => '省份',
    'LBL_ADDRESS_STREET' => '街道',

    'LBL_DATE_MODIFIED' => '修改日期',
    'LBL_DATE_ENTERED' => 'Date Entered',
    'LBL_DELETED' => '已删除',

    'LBL_BUTTON_SELECT' => '选择',
    'LBL_BUTTON_CLEAR' => '清除',

    'LBL_CONTACTS_SYNC' => '联系人同步',
    'LBL_OAUTH_TOKENS' => 'OAuth令牌',
    'LBL_PROJECT_USERS_1_FROM_PROJECT_TITLE' => '项目',
    'LBL_PROJECT_CONTACTS_1_FROM_CONTACTS_TITLE' => '联系人',
    'LBL_ROLES' => '查看角色',
    'LBL_SECURITYGROUPS' => '用户组列表',
    'LBL_PROSPECT_LIST' => '目标群体',

    'LBL_FACTOR_AUTH_INTERFACE' => '双重认证接口：',
    'LBL_EDITOR_TYPE' => '编辑器',
);
