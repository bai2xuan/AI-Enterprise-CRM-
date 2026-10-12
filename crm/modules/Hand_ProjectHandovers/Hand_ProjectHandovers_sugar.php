<?php
/**
 * 智联AI科技有限公司 · AI Enterprise CRM
 * 基于 SuiteCRM 7.15.2 二次开发（AGPL-3.0）
 * 本文件为新增扩展文件，不修改 SuiteCRM 核心代码。
 */

#[\AllowDynamicProperties]
class Hand_ProjectHandovers_sugar extends Basic
{
    public $new_schema = true;
    public $module_dir = 'Hand_ProjectHandovers';
    public $object_name = 'Hand_ProjectHandovers';
    public $table_name = 'hand_projecthandovers';
    public $importable = true;
    public $disable_row_level_security = true;
    public $id;
    public $name;
    public $date_entered;
    public $date_modified;
    public $modified_user_id;
    public $modified_by_name;
    public $created_by;
    public $created_by_name;
    public $description;
    public $deleted;
    public $created_by_link;
    public $modified_user_link;
    public $assigned_user_id;
    public $assigned_user_name;
    public $assigned_user_link;
    public $handover_no_c;
    public $handover_status_c;
    public $product_type_c;
    public $contract_amount_c;
    public $handover_date_c;
    public $start_date_c;
    public $implementation_cycle_c;
    public $project_goal_c;
    public $customer_requirement_c;
    public $committed_features_c;
    public $contract_scope_c;
    public $risk_items_c;
    public $acceptance_criteria_c;
    public $account_name;
    public $account_id;
    public $accounts;
    public $opportunity_name;
    public $opportunity_id;
    public $opportunities;
    public $delivery_owner_name;
    public $delivery_owner_id;
    public $users;

    public function __construct()
    {
        parent::__construct();
    }

    public function bean_implements($interface)
    {
        switch ($interface) {
            case 'ACL':
                return true;
        }
        return false;
    }
}
