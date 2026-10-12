<?php
/**
 * 智联AI科技有限公司 · AI Enterprise CRM
 * 基于 SuiteCRM 7.15.2 二次开发（AGPL-3.0）
 * 需求调研 / 项目交接 模块的业务下拉选项（中文）
 */

/* ---------- 需求状态 ---------- */
$app_list_strings['ai_req_status_list'] = array(
    ''                  => '',
    'Draft'             => '草稿',
    'Collecting'        => '调研中',
    'Confirmed'         => '需求已确认',
    'Solution_Designed' => '方案已输出',
    'Closed'            => '已关闭',
);

/* ---------- 需求优先级 ---------- */
$app_list_strings['ai_req_priority_list'] = array(
    ''       => '',
    'High'   => '高 - 核心诉求',
    'Medium' => '中 - 重要提升',
    'Low'    => '低 - 可选优化',
);

/* ---------- 项目交接状态 ---------- */
$app_list_strings['ai_handover_status_list'] = array(
    ''             => '',
    'Pending'      => '待交接',
    'Handed_Over'  => '已交接',
    'In_Progress'  => '实施中',
    'Go_Live'      => '已上线',
    'Accepted'     => '已验收',
);
