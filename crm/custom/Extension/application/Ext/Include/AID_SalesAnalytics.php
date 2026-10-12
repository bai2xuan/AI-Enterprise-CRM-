<?php
/**
 * 智联AI科技有限公司 · AI Enterprise CRM
 * 基于 SuiteCRM 7.15.2 二次开发（AGPL-3.0）
 * 本文件为新增扩展文件，不修改 SuiteCRM 核心代码。
 */

// 模块注册：把自定义模块登记进 SuiteCRM 的 Bean / Module 列表
$beanList['AID_SalesAnalytics'] = 'AID_SalesAnalytics';
$beanFiles['AID_SalesAnalytics'] = 'modules/AID_SalesAnalytics/AID_SalesAnalytics.php';
$moduleList[] = 'AID_SalesAnalytics';
$modules_exempt_from_availability_check['AID_SalesAnalytics'] = 'AID_SalesAnalytics';
$report_include_modules['AID_SalesAnalytics'] = 'AID_SalesAnalytics';
