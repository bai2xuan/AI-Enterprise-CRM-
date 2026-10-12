<?php
/**
 * 智联AI科技有限公司 · AI Enterprise CRM
 * 基于 SuiteCRM 7.15.2 二次开发（AGPL-3.0）
 * 本文件为新增扩展文件，不修改 SuiteCRM 核心代码。
 */

#[\AllowDynamicProperties]
class CReq_CustomerRequirements_sugar extends Basic
{
    public $new_schema = true;
    public $module_dir = 'CReq_CustomerRequirements';
    public $object_name = 'CReq_CustomerRequirements';
    public $table_name = 'creq_customerrequirements';
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
    public $req_no_c;
    public $req_status_c;
    public $priority_c;
    public $customer_background_c;
    public $current_pain_points_c;
    public $current_system_c;
    public $requirement_desc_c;
    public $functional_req_c;
    public $technical_req_c;
    public $expected_solution_c;
    public $budget_c;
    public $go_live_date_c;
    public $key_decision_maker_c;
    public $competitor_c;
    public $risk_factor_c;
    public $account_name;
    public $account_id;
    public $accounts;
    public $opportunity_name;
    public $opportunity_id;
    public $opportunities;

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
