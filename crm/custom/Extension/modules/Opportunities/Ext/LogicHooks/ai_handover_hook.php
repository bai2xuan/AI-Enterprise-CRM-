<?php
/**
 * 智联AI科技有限公司 · AI Enterprise CRM
 * 基于 SuiteCRM 7.15.2 二次开发（AGPL-3.0）
 * 本文件为新增扩展文件，不修改 SuiteCRM 核心代码。
 * ------------------------------------------------------------------
 * 逻辑钩子注册：商机「成交」后自动打通销售 → 交付
 *
 * 业务背景：
 *   本项目模块 5 的诉求是"销售到交付流程"。原生的做法是销售成交后
 *   手工填写交接单，容易漏、也容易信息缺失。这里用 SuiteCRM 官方的
 *   Logic Hook 扩展点，在商机保存后自动生成《项目交接单》并派发待办，
 *   把"成交"这个关键节点变成自动触发的交付起点。
 *
 *   钩子注册文件放在 custom/Extension 下，Quick Repair and Rebuild 会
 *   合并进 custom/modules/Opportunities/Ext/LogicHooks/logichooks.ext.php，
 *   全程不改核心代码。
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$hook_array['after_save'][] = array(
    60,                                              // 执行顺序，放在 SuiteCRM 自身钩子之后
    '商机成交后自动生成项目交接单',                    // 名称
    'custom/modules/Opportunities/ai_handover_hook.php', // 实现文件
    'AI_OpportunityHandoverHook',                    // 类名
    'afterSave',                                     // 方法名
);
