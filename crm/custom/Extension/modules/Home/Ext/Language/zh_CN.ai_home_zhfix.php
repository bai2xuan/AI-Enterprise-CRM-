<?php
/**
 * AI Enterprise CRM —— 首页模块原生标签中文化补丁
 * ------------------------------------------------------------------
 * 覆盖 SuiteCRM 官方 zh_CN 语言包在 Home 模块中的英文残留（快捷创建表单、Dashlet 等）。
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/* ---------- 快捷创建表单 ---------- */
$mod_strings['LBL_NEW_FORM_TITLE'] = '新建联系人';
$mod_strings['LBL_FIRST_NAME'] = '名字';
$mod_strings['LBL_LAST_NAME'] = '姓氏';
$mod_strings['LBL_PHONE'] = '电话';
$mod_strings['LBL_EMAIL_ADDRESS'] = '电子邮件';
$mod_strings['LBL_WEBSITE_TITLE'] = '网站';
$mod_strings['LBL_DESCRIPTION'] = '说明';

/* ---------- Dashlet 配置 ---------- */
$mod_strings['LBL_DASHLET_CONFIGURE_FILTERS'] = '筛选条件';
$mod_strings['LBL_DASHLET_CONFIGURE_MY_ITEMS_ONLY'] = '仅显示我的记录';
$mod_strings['LBL_DASHLET_TITLE'] = '我的站点';

/* ---------- 顶部导航 / 提示 ---------- */
$mod_strings['LBL_TOUR_NOTIFICATIONS'] = '通知';
$mod_strings['LBL_TOUR_PROFILE'] = '个人资料';
$mod_strings['LBL_BUILD'] = '版本';

/* ---------- 活动与邀请 ---------- */
$mod_strings['LBL_SEND_INVITES'] = '保存并发送邀请';
$mod_strings['LBL_CREATE_NEW_RECORD'] = '新建活动';
$mod_strings['LBL_CREATE_CALL'] = '记录电话';
$mod_strings['LBL_REPEAT_INTERVAL'] = '每';
$mod_strings['LBL_MINSS_ABBREV'] = '分钟';
