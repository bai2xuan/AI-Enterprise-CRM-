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
    'LBL_MODULE_NAME' => '首页',
    'LBL_NEW_FORM_TITLE' => 'New Contact',
    'LBL_FIRST_NAME' => 'First Name:',
    'LBL_LAST_NAME' => 'Last Name:',
    'LBL_LIST_LAST_NAME' => '姓氏',
    'LBL_PHONE' => 'Phone:',
    'LBL_EMAIL_ADDRESS' => 'Email Address:',
    'LBL_MY_PIPELINE_FORM_TITLE' => '我的管道',
    'LBL_PIPELINE_FORM_TITLE' => '销售阶段的销售数据',
    'LBL_RGraph_PIPELINE_FORM_TITLE' => '销售阶段的销售数据',
    'LNK_NEW_CONTACT' => '创建联系人',
    'LNK_NEW_ACCOUNT' => 'Create Account',
    'LNK_NEW_OPPORTUNITY' => 'Create Opportunity',
    'LNK_NEW_LEAD' => '创建潜在客户',
    'LNK_NEW_CASE' => 'Create Case',
    'LNK_NEW_NOTE' => '创建备忘录',
    'LNK_NEW_CALL' => 'Log Call',
    'LNK_NEW_EMAIL' => 'Archive Email',
    'LNK_NEW_MEETING' => '创建会议',
    'LNK_NEW_TASK' => '创建任务',
    'LNK_NEW_BUG' => 'Report Bug',
    'LNK_NEW_SEND_EMAIL' => '写信',
    'LBL_NO_ACCESS' => '您没有访问权限，请联系管理员。',
    'LBL_NO_RESULTS_IN_MODULE' => '--未找到任何结果--',
    'LBL_NO_RESULTS' => '<h2>未找到任何结果。</h2><br />',
    'LBL_NO_RESULTS_TIPS' => '<h3>搜索提示：</h3><ul><li>请确保您已选择适当的类别。</li><li>扩大您的搜索条件。</li><li>如果您仍未找到任何结果，请尝试使用高级搜索选项。</li></ul>',

    'LBL_ADD_DASHLETS' => '添加 Dashlet',
    'LBL_WEBSITE_TITLE' => 'Website',
    'LBL_RSS_TITLE' => '新闻动态',
    'LBL_CLOSE_DASHLETS' => '截止日期',
    'LBL_OPTIONS' => '邮件选项',
    // dashlet search fields
    'LBL_TODAY' => '查看日历',
    'LBL_YESTERDAY' => '昨天',
    'LBL_TOMORROW' => '明天',
    'LBL_NEXT_WEEK' => '下周',
    'LBL_LAST_7_DAYS' => 'Last 7 Days',
    'LBL_NEXT_7_DAYS' => 'Next 7 Days',
    'LBL_LAST_MONTH' => '上月',
    'LBL_NEXT_MONTH' => '下月',
    'LBL_LAST_YEAR' => '去年',
    'LBL_NEXT_YEAR' => '明年',
    'LBL_LAST_30_DAYS' => 'Last 30 Days',
    'LBL_NEXT_30_DAYS' => 'Next 30 Days',
    'LBL_THIS_MONTH' => '本月',
    'LBL_THIS_YEAR' => '今年',

    'LBL_MODULES' => '模块',
    'LBL_CHARTS' => '图表',
    'LBL_TOOLS' => '工具',
    'LBL_WEB' => '网络',
    'LBL_SEARCH_RESULTS' => '搜索结果',

    // Dashlet Categories
    'dashlet_categories_dom' => array(
        'Module Views' => '模块视图',
        'Portal' => '门户',
        'Charts' => '图表',
        'Tools' => '工具',
        'Miscellaneous' => '杂项'
    ),
    'LBL_ADDING_DASHLET' => '正在添加组件...',
    'LBL_ADDED_DASHLET' => 'Dashlet 已添加',
    'LBL_REMOVE_DASHLET_CONFIRM' => '您确定要移除此 Dashlet ？',
    'LBL_REMOVING_DASHLET' => '正在移除组件...',
    'LBL_REMOVED_DASHLET' => 'Dashlet 已移除',
    'LBL_DASHLET_CONFIGURE_GENERAL' => '常规',
    'LBL_DASHLET_CONFIGURE_FILTERS' => 'Filters',
    'LBL_DASHLET_CONFIGURE_MY_ITEMS_ONLY' => 'Only My Items',
    'LBL_DASHLET_CONFIGURE_TITLE' => '标题',
    'LBL_DASHLET_CONFIGURE_DISPLAY_ROWS' => '显示行数',

    'LBL_DASHLET_DELETE' => '删除',
    'LBL_DASHLET_REFRESH' => '刷新',
    'LBL_DASHLET_EDIT' => '编辑',

    // Default out-of-box names for tabs
    'LBL_HOME_PAGE_1_NAME' => '我的 CRM',
    'LBL_CLOSE_SITEMAP' => '截止日期',

    'LBL_SEARCH' => '搜索',
    'LBL_CLEAR' => '清除',

    'LBL_BASIC_CHARTS' => '基本图表',

    'LBL_DASHLET_SEARCH' => '搜索 Dashlet',

//ABOUT page
    'LBL_VERSION' => '版本',
    'LBL_BUILD' => 'Build',

    'LBL_SOURCE_SUGAR' => 'SugarCRM Inc - SugarCRM 社区版框架提供商',

    'LBL_DASHLET_TITLE' => 'My Sites',
    'LBL_DASHLET_OPT_TITLE' => '标题',
    'LBL_DASHLET_INCORRECT_URL' => '指定的网址错误',
    'LBL_DASHLET_OPT_URL' => '网址',
    'LBL_DASHLET_OPT_HEIGHT' => '高(像素)',
    'LBL_DASHLET_SUITE_NEWS' => 'SuiteCRM 新闻',
    'LBL_DASHLET_DISCOVER_SUITE' => '探索 SuiteCRM',
    'LBL_BASIC_SEARCH' => '快速筛选' /*for 508 compliance fix*/,
    'LBL_ADVANCED_SEARCH' => '高级搜索' /*for 508 compliance fix*/,
    'LBL_TOUR_HOME' => '首页图标',
    'LBL_TOUR_HOME_DESCRIPTION' => '单击即可快速回到首页仪表盘。',
    'LBL_TOUR_MODULES' => '模块',
    'LBL_TOUR_MODULES_DESCRIPTION' => '您所有重要的模块都在这里。',
    'LBL_TOUR_MORE' => '更多模块',
    'LBL_TOUR_MORE_DESCRIPTION' => '其余的模块全都在这里。',
    'LBL_TOUR_SEARCH' => '全文搜索',
    'LBL_TOUR_SEARCH_DESCRIPTION' => '搜索将比以前好用很多。',
    'LBL_TOUR_NOTIFICATIONS' => 'Notifications',
    'LBL_TOUR_NOTIFICATIONS_DESCRIPTION' => '这里显示系统通知提醒。',
    'LBL_TOUR_PROFILE' => 'Profile',
    'LBL_TOUR_PROFILE_DESCRIPTION' => '查看或设置用户配置以及注销。',
    'LBL_TOUR_QUICKCREATE' => '快速创建',
    'LBL_TOUR_QUICKCREATE_DESCRIPTION' => '快速创建记录而不用切换当前页面。',
    'LBL_TOUR_FOOTER' => '可折叠的页脚',
    'LBL_TOUR_FOOTER_DESCRIPTION' => '轻松地展开和折叠页脚。',
    'LBL_TOUR_CUSTOM' => '自定义 App',
    'LBL_TOUR_CUSTOM_DESCRIPTION' => '这里设置自定义应用集成。',
    'LBL_TOUR_BRAND' => '品牌形象',
    'LBL_TOUR_BRAND_DESCRIPTION' => '这里是您的 Logo。您可以将鼠标放在上面查看详细信息。',
    'LBL_TOUR_WELCOME' => '欢迎使用 SuiteCRM',
    'LBL_TOUR_WATCH' => '查看 SuiteCRM 新功能',
    'LBL_TOUR_FEATURES' => '<ul style=""><li class="icon-ok">新的简化导航栏</li><li class="icon-ok">新的可折叠页脚</li><li class="icon-ok">改进搜索</li><li class="icon-ok">更新了动作菜单</li></ul><p>还有更多！</p>',
    'LBL_TOUR_VISIT' => '查看详细信息请访问我们的应用程序',
    'LBL_TOUR_DONE' => '完成',
    'LBL_TOUR_REFERENCE_1' => '您可以在任何时候',
    'LBL_TOUR_REFERENCE_2' => '通过访问我们的 "支持论坛" 获得帮助。',
    'LNK_TOUR_DOCUMENTATION' => '文档',
    'LBL_TOUR_CALENDAR_URL_1' => '您是否需要向第三方应用程序（例如 Microsoft Outlook 或 Exchange ）共享的您的日历？如果共享，将生成一个新的、更安全的 URL，防止发布未授权的日历共享。',
    'LBL_TOUR_CALENDAR_URL_2' => '检索您新共享日历的 URL。',
    'LBL_CONTRIBUTORS' => '贡献者',
    'LBL_ABOUT_SUITE' => '关于 SuiteCRM',
    'LBL_PARTNERS' => '合作伙伴',
    'LBL_EDIT_ALL_RECURRENCES' => '编辑所有周期重复纪录',
    'LBL_REMOVE_ALL_RECURRENCES' => '删除所有周期重复纪录',
    'LBL_CONFIRM_REMOVE' => '您确定要移除此项记录？',
    
    'LBL_MAINTAINER_SUITECRM' => 'SuiteCRM is written and maintained by SuiteCRM Ltd',
    'LBL_CONTRIBUTOR_SUITECRM' => 'SuiteCRM - 献给世界的开源客户管理系统',
    'LBL_CONTRIBUTOR_SECURITY_SUITE' => 'SecuritySuite 由 Jason Eggers 贡献',
    'LBL_CONTRIBUTOR_JJW_GMAPS' => 'JJWDesign Google Maps 由 Jeffrey J. Walters 贡献',
    'LBL_CONTRIBUTOR_CONSCIOUS' => 'SuiteCRM Logo Design contributed by Conscious Solutions',
    'LBL_CONTRIBUTOR_RESPONSETAP' => 'Contribution to SuiteCRM by ResponseTap',
    'LBL_CONTRIBUTOR_GMBH' => 'Workflow Calculated Fields 由 diligent technology & business consulting GmbH 贡献',

    'LBL_LANGUAGE_ABOUT' => '关于 SuiteCRM 翻译',
    'LBL_LANGUAGE_COMMUNITY_ABOUT' => '由 SuiteCRM 社区协作完成所有翻译',
    'LBL_LANGUAGE_COMMUNITY_PACKS' => '所有翻译使用 Crowdin 创建',

    'LBL_ABOUT_SUITE_2' => 'SuiteCRM 基于开源许可证 AGPL v3 发布',
    'LBL_ABOUT_SUITE_4' => '所有 SuiteCRM 项目的管理和开发以开源 AGPL v3 发布',
    'LBL_ABOUT_SUITE_5' => '可通过免费和付费选项获得 SuiteCRM 技术支持',

    'LBL_SUITE_PARTNERS' => '我们有许多乐衷于开源的合作伙伴。要查看全部合作伙伴列表，请访问我们的网站。',

    'LBL_SAVE_BUTTON' => '保存',
    'LBL_DELETE_BUTTON' => '删除',
    'LBL_APPLY_BUTTON' => '应用',
    'LBL_SEND_INVITES' => 'Save & Send Invites',
    'LBL_CANCEL_BUTTON' => '取消',
    'LBL_CLOSE_BUTTON' => '截止日期',

    'LBL_CREATE_NEW_RECORD' => 'Create Activity',
    'LBL_CREATE_CALL' => 'Log Call',
    'LBL_CREATE_MEETING' => '创建会议',

    'LBL_GENERAL_TAB' => '细节',
    'LBL_PARTICIPANTS_TAB' => '受邀者',
    'LBL_REPEAT_TAB' => '周期重复',

    'LBL_REPEAT_TYPE' => '重复',
    'LBL_REPEAT_INTERVAL' => 'Every',
    'LBL_REPEAT_END' => '末页',
    'LBL_REPEAT_END_AFTER' => '之后',
    'LBL_REPEAT_OCCURRENCES' => '循环',
    'LBL_REPEAT_END_BY' => '到',
    'LBL_REPEAT_DOW' => '在',
    'LBL_REPEAT_UNTIL' => '重复直到',
    'LBL_REPEAT_COUNT' => '重复次数',
    'LBL_REPEAT_LIMIT_ERROR' => '您的请求将创建超过 $limit 会议数量限制。',

    //Events
    'LNK_EVENT' => '会展',
    'LNK_EVENT_VIEW' => '查看会展',
    'LBL_DATE' => '日期： ',
    'LBL_DURATION' => '期限: ',
    'LBL_NAME' => '标题',
    'LBL_HOUR_ABBREV' => '小时',
    'LBL_HOURS_ABBREV' => '小时',
    'LBL_MINSS_ABBREV' => 'minutes',
    'LBL_LOCATION' => '地点',
    'LBL_STATUS' => '状态',
    'LBL_DESCRIPTION' => 'Description: ',
    //End Events

    'LBL_ELASTIC_SEARCH_EXCEPTION_SEARCH_INVALID_REQUEST' => '搜索出错。输入的搜索内容格式可能不对。',
    'LBL_ELASTIC_SEARCH_EXCEPTION_SEARCH_ENGINE_NOT_FOUND' => '找不到请求的搜索引擎。请尝试再次进行搜索。',
    'LBL_ELASTIC_SEARCH_EXCEPTION_NO_NODES_AVAILABLE' => '无法连接到Elasticsearch 服务器。',
    'LBL_ELASTIC_SEARCH_EXCEPTION_SEARCH' => '发生了搜索内部错误。',
    'LBL_ELASTIC_SEARCH_EXCEPTION_DEFAULT' => '搜索时发生未知错误。',
    'LBL_ELASTIC_SEARCH_EXCEPTION_END_MESSAGE' => '如果问题仍然存在，请联系管理员。日志中有更多信息。',
    'LBL_ELASTIC_SEARCH_EXCEPTION_MISSING_INDEX' => '找不到一个或多个模块的搜索索引。 请确认已正确配置crontab 并正在运行， 打开Elasticsearch 配置并单击"Schedule full indexing"并在不存在时考虑创建一个Scheduler作业"Elasticsearch Indexer"。',

    'LBL_ELASTIC_SEARCH_DEFAULT' => '没有符合您的搜索条件的结果。尝试扩大搜索范围。',

    'LNK_TASK_VIEW' => 'View Task',
);
