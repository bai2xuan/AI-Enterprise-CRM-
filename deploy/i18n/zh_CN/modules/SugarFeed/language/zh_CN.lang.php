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
    'LBL_SAVING' => '正在保存...',
    'LBL_SAVED' => 'Saved',
    'LBL_CREATED_USER' => '创建人',
    'LBL_MODIFIED_USER' => '修改人',
    'LBL_LIST_FORM_TITLE' => '消息列表',
    'LBL_MODULE_NAME' => '活动流',
    'LBL_MODULE_TITLE' => '活动流',
    'LBL_DASHLET_DISABLED' => '警告：Feed 系统已被禁用。在被重新启用之前，将不会发布任何新的 Feed 条目',
    'LBL_RECORDS_DELETED' => '所有先前的 Feed 已被删除，如果 Feed 系统已启用，新的 Feed 条目将自动生成。',
    'LBL_CONFIRM_DELETE_RECORDS' => '您确定要删除？',
    'LBL_FLUSH_RECORDS' => '删除 Feed 条目',
    'LBL_ENABLE_FEED' => '启用我的消息通知中心仪表板',
    'LBL_ENABLE_MODULE_LIST' => '启用 Feed',
    'LBL_HOMEPAGE_TITLE' => '我的消息通知中心',
    'LNK_NEW_RECORD' => '创建 Feed',
    'LNK_LIST' => '查看 Feed',
    'LBL_SEARCH_FORM_TITLE' => '搜索',
    'LBL_HISTORY_SUBPANEL_TITLE' => '历史记录',
    'LBL_ACTIVITIES_SUBPANEL_TITLE' => '活动',
    'LBL_NEW_FORM_TITLE' => '新建',
    'LBL_ALL' => '全部模块',
    'LBL_USER_FEED' => '用户动态',
    'LBL_ENABLE_USER_FEED' => '启用用户 Feed',
    'LBL_TO' => '团队可见',
    'LBL_IS' => '为',
    'LBL_DONE' => 'Done',
    'LBL_TITLE' => '标题',
    'LBL_ROWS' => '行',
    'LBL_CATEGORIES' => '模块',
    'LBL_TIME_LAST_WEEK' => '上周',
    'LBL_TIME_WEEKS' => '周',
    'LBL_TIME_DAYS' => '天数',
    'LBL_TIME_YESTERDAY' => '昨天',
    'LBL_TIME_HOURS' => '小时',
    'LBL_TIME_HOUR' => '小时',
    'LBL_TIME_MINUTES' => '分钟',
    'LBL_TIME_MINUTE' => '分钟',
    'LBL_TIME_SECONDS' => '秒',
    'LBL_TIME_SECOND' => '秒',
    'LBL_TIME_AND' => '和',
    'LBL_TIME_AGO' => '前',
// Activity stream
    'CREATED_CONTACT' => '已创建一个<b>新的</b>{0}',
    'CREATED_OPPORTUNITY' => '创建一个<b>新的</b>{0}',
    'CREATED_CASE' => '创建一个<b>新的</b>{0}',
    'CREATED_LEAD' => '创建一个<b>新的</b>{0}',
    'FOR' => '金额为', // Activity stream for cases
    'FOR_AMOUNT' => '按金额', // Activity stream for cases
    'CLOSED_CASE' => '<b>已关闭</b>一个{0}',
    'CONVERTED_LEAD' => '<b>已转化</b>一个{0}',
    'WON_OPPORTUNITY' => '<b>已赢得</b>一个{0}',
    'WITH' => '关联到',

    'LBL_LINK_TYPE_Link' => '链接',
    'LBL_LINK_TYPE_Image' => '图片',
    'LBL_LINK_TYPE_YouTube' => 'YouTube&#153;',

    'LBL_SELECT' => '选择',
    'LBL_POST' => '提交',
    'LBL_AUTHENTICATE' => '认证',
    'LBL_AUTHENTICATION_PENDING' => '并不是所有选择的外部账户已被认证。点击 "取消" 返回到选项窗口对外部账户进行认证，点击 "确定" 继续而不进行认证。',
    'LBL_ADVANCED_SEARCH' => '高级搜索' /*for 508 compliance fix*/,
    'LBL_SHOW_MORE_OPTIONS' => '显示更多选项',
    'LBL_HIDE_OPTIONS' => '隐藏选项',
    'LBL_VIEW' => '视图',
    'LBL_POST_TITLE' => '提交状态更新用于',
    'LBL_URL_LINK_TITLE' => '要使用的 URL 地址',
);
