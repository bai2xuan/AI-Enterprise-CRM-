<?php
/**
 * AI Enterprise CRM —— 客户模块原生标签中文化补丁
 * ------------------------------------------------------------------
 * SuiteCRM 官方 zh_CN 语言包对 Accounts 模块存在 40+ 处英文残留
 * （如 "Office Phone:" / "Industry:"），影响界面中文化完整性。
 * 本文件以扩展方式覆盖这些标签，不修改任何核心语言文件。
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/* ---------- 面板 / 区块 ---------- */
$mod_strings['LBL_ACCOUNT_INFORMATION'] = '客户概览';
$mod_strings['LBL_ADDRESS_INFORMATION'] = '地址信息';
$mod_strings['LBL_DESCRIPTION_INFORMATION'] = '说明信息';

/* ---------- 客户基本信息 ---------- */
$mod_strings['LBL_ACCOUNT_NAME'] = '客户名称';
$mod_strings['LBL_TYPE'] = '客户类型';
$mod_strings['LBL_INDUSTRY'] = '所属行业';
$mod_strings['LBL_ANNUAL_REVENUE'] = '年营业额';
$mod_strings['LBL_EMPLOYEES'] = '员工人数';
$mod_strings['LBL_OWNERSHIP'] = '所有权性质';
$mod_strings['LBL_TICKER_SYMBOL'] = '股票代码';
$mod_strings['LBL_MEMBER_OF'] = '上级客户';
$mod_strings['LBL_PARENT_ACCOUNT_ID'] = '上级客户 ID';

/* ---------- 联系方式 ---------- */
$mod_strings['LBL_PHONE'] = '电话';
$mod_strings['LBL_PHONE_OFFICE'] = '办公电话';
$mod_strings['LBL_PHONE_FAX'] = '传真';
$mod_strings['LBL_FAX'] = '传真';
$mod_strings['LBL_PHONE_ALT'] = '备用电话';
$mod_strings['LBL_OTHER_PHONE'] = '其他电话';
$mod_strings['LBL_WEBSITE'] = '网站';
$mod_strings['LBL_EMAIL'] = '电子邮件';
$mod_strings['LBL_EMAIL_ADDRESSES'] = '电子邮件地址';
$mod_strings['LBL_OTHER_EMAIL_ADDRESS'] = '其他邮箱';
$mod_strings['LBL_LIST_PHONE'] = '电话';
$mod_strings['LBL_LIST_EMAIL_ADDRESS'] = '电子邮箱';

/* ---------- 地址 ---------- */
$mod_strings['LBL_BILLING_ADDRESS'] = '账单地址';
$mod_strings['LBL_BILLING_ADDRESS_STREET'] = '账单街道';
$mod_strings['LBL_BILLING_ADDRESS_CITY'] = '账单城市';
$mod_strings['LBL_BILLING_ADDRESS_STATE'] = '账单省份';
$mod_strings['LBL_SHIPPING_ADDRESS'] = '收货地址';
$mod_strings['LBL_SHIPPING_ADDRESS_STREET'] = '收货街道';
$mod_strings['LBL_SHIPPING_ADDRESS_CITY'] = '收货城市';
$mod_strings['LBL_SHIPPING_ADDRESS_STATE'] = '收货省份';
$mod_strings['LBL_SHIPPING_ADDRESS_POSTALCODE'] = '收货邮编';
$mod_strings['LBL_SHIPPING_ADDRESS_COUNTRY'] = '收货国家';
$mod_strings['LBL_CITY'] = '城市';
$mod_strings['LBL_POSTAL_CODE'] = '邮政编码';
$mod_strings['LBL_COUNTRY'] = '国家';

/* ---------- 其他 ---------- */
$mod_strings['LBL_ASSIGNED_TO_ID'] = '负责人';
$mod_strings['LBL_DATE_MODIFIED'] = '修改时间';
$mod_strings['LBL_SAVE_ACCOUNT'] = '保存客户';
$mod_strings['LBL_DUPLICATE'] = '可能存在重复客户';
$mod_strings['LBL_BUGS_SUBPANEL_TITLE'] = '缺陷';
$mod_strings['LBL_AOS_INVOICES'] = '发票';

/* ---------- 快捷菜单 / 侧边栏链接 ---------- */
$mod_strings['LNK_NEW_ACCOUNT'] = '新建客户';
