<?php
/**
 * 智联AI科技有限公司 · AI Enterprise CRM
 * 基于 SuiteCRM 7.15.2 二次开发（AGPL-3.0）
 * 本文件为新增扩展文件，不修改 SuiteCRM 核心代码。
 * ------------------------------------------------------------------
 * 逻辑钩子实现：商机成交 → 自动生成《项目交接单》+ 派发交接准备待办
 *
 * 设计要点（面试可讲）
 *   1. 触发时机：after_save，只在 sales_stage == 'Closed Won' 时动作；
 *   2. 幂等保证：先按 opportunity_id 查是否已有交接单，已有则跳过，
 *      因此反复保存 / 反复编辑成交商机都不会产生重复交接单；
 *   3. 防重入：创建交接单过程中会在全局打标记，避免嵌套保存递归触发；
 *   4. 数据继承：客户、产品类型、合同金额、货币、负责人直接由商机带过来，
 *      销售不需要重复录入，避免"销售填一遍、交付问一遍"的信息断层；
 *   5. 不写死业务字典：状态用 handover_status_c 的默认值 Pending（待交接）。
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class AI_OpportunityHandoverHook
{
    /** 递归保护标记 */
    const RUNNING_FLAG = 'ai_handover_hook_running';

    /**
     * @param SugarBean $bean    当前保存的商机
     * @param string    $event   事件名
     * @param array     $arguments
     */
    public function afterSave($bean, $event, $arguments)
    {
        if (empty($bean->id)) {
            return;
        }
        // 只关心"成交"这个节点
        if ($bean->sales_stage !== 'Closed Won') {
            return;
        }
        // 防重入：创建过程中触发的保存直接返回
        if (!empty($GLOBALS[self::RUNNING_FLAG])) {
            return;
        }
        // 已生成过交接单就跳过（幂等）
        if ($this->findExistingHandover($bean->id) !== '') {
            return;
        }

        $GLOBALS[self::RUNNING_FLAG] = true;
        try {
            $handover = $this->createHandover($bean);
            $this->createFollowUpTask($bean, $handover);
        } catch (Throwable $e) {
            $GLOBALS['log']->error('[AI CRM] 自动生成项目交接单失败：' . $e->getMessage());
        }
        unset($GLOBALS[self::RUNNING_FLAG]);
    }

    /**
     * 是否已存在该商机的有效交接单
     * @return string 交接单 id，不存在返回空串
     */
    private function findExistingHandover($opportunityId)
    {
        $handover = BeanFactory::getBean('Hand_ProjectHandovers');
        $handover->retrieve_by_string_fields(array(
            'opportunity_id' => $opportunityId,
            'deleted'        => 0,
        ));
        return empty($handover->id) ? '' : $handover->id;
    }

    /**
     * 依据商机创建项目交接单
     * @return Hand_ProjectHandovers
     */
    private function createHandover($bean)
    {
        $handover = BeanFactory::newBean('Hand_ProjectHandovers');

        $accountName = $this->resolveAccountName($bean);
        $productName = $this->productLabel($bean->product_type_c);

        $handover->name              = $accountName . ' - ' . $productName . ' 项目交接单';
        $handover->handover_no_c     = $this->nextHandoverNo();
        $handover->handover_status_c = 'Pending';                 // 待交接
        $handover->handover_date_c   = date('Y-m-d');             // 交接发起日 = 成交当日
        $handover->start_date_c      = date('Y-m-d', strtotime('+7 days'));
        $handover->product_type_c    = $bean->product_type_c;
        $handover->contract_amount_c = $bean->amount;
        $handover->currency_id       = $bean->currency_id;
        $handover->account_id        = $bean->account_id;
        $handover->opportunity_id    = $bean->id;
        $handover->assigned_user_id  = $bean->assigned_user_id;
        $handover->description       = "由商机《{$bean->name}》成交后自动生成，请交付经理确认实施范围。";
        $handover->project_goal_c    = '按合同约定完成交付，确保客户业务目标达成。';
        $handover->save();

        // 建立 客户 / 商机 的正式关联（SuiteCRM 原生多对多关系）
        if ($handover->load_relationship('accounts')) {
            $handover->accounts->add($bean->account_id);
        }
        if ($handover->load_relationship('opportunities')) {
            $handover->opportunities->add($bean->id);
        }

        return $handover;
    }

    /**
     * 派发一条"项目交接准备"待办给销售负责人，形成销售→交付的动作闭环
     */
    private function createFollowUpTask($bean, $handover)
    {
        $task = BeanFactory::newBean('Tasks');
        $task->name            = '项目交接准备：' . $handover->name;
        $task->status          = 'Not Started';
        $task->priority        = 'High';
        $task->date_due        = date('Y-m-d', strtotime('+3 days'));
        $task->parent_type     = 'Hand_ProjectHandovers';
        $task->parent_id       = $handover->id;
        $task->assigned_user_id = $bean->assigned_user_id;
        $task->description     = "商机《{$bean->name}》已成交（合同金额 {$bean->amount}）。\n"
            . "请在 3 个工作日内完成：\n"
            . "1. 整理需求调研结论与方案承诺项；\n"
            . "2. 指定交付负责人与实施排期；\n"
            . "3. 组织销售→交付交接会议。";
        $task->save();
    }

    /**
     * 客户名：relate 字段在 after_save 时不一定已回填，兜底查一次
     */
    private function resolveAccountName($bean)
    {
        if (!empty($bean->account_name)) {
            return $bean->account_name;
        }
        if (empty($bean->account_id)) {
            return '未关联客户';
        }
        $account = BeanFactory::getBean('Accounts', $bean->account_id);
        return empty($account->name) ? '未关联客户' : $account->name;
    }

    /**
     * 产品类型 Key → 中文名（与 ai_product_type_list 保持一致）
     */
    private function productLabel($key)
    {
        $list = isset($GLOBALS['app_list_strings']['ai_product_type_list'])
            ? $GLOBALS['app_list_strings']['ai_product_type_list']
            : array();
        if (!empty($list[$key])) {
            return $list[$key];
        }
        return empty($key) ? 'AI 解决方案' : $key;
    }

    /**
     * 生成交接单号：HT-YYYY-####（按当年已有单据数递增）
     */
    private function nextHandoverNo()
    {
        $db = DBManagerFactory::getInstance();
        $year = date('Y');
        $n = (int)$db->getOne(
            "SELECT COUNT(*) FROM hand_projecthandovers WHERE deleted=0 AND handover_no_c LIKE 'HT-{$year}-%'"
        );
        return 'HT-' . $year . '-' . str_pad((string)($n + 1), 4, '0', STR_PAD_LEFT);
    }
}
