<?php
/**
 * build-modules.php —— SuiteCRM 自定义模块脚手架生成器
 * ---------------------------------------------------------------
 * 用途：为「智联AI CRM」生成两个业务模块的全套标准文件
 *   1. CReq_CustomerRequirements  客户需求调研（售前顾问使用）
 *   2. Hand_ProjectHandovers      项目交接单（销售→售前→交付 协同）
 *
 * 生成物（全部为「新增文件」，不覆盖任何 SuiteCRM 核心文件）：
 *   modules/<Module>/<Module>.php            Bean 类
 *   modules/<Module>/<Module>_sugar.php      Bean 基类（PHP 8.2+ 属性声明）
 *   modules/<Module>/vardefs.php             字段 / 关系 / 索引定义
 *   modules/<Module>/Menu.php                模块动作菜单
 *   modules/<Module>/language/{zh_CN,en_us}.lang.php
 *   modules/<Module>/metadata/{editview,detailview,listview,search,quickcreate,subpanel}defs.php
 *   modules/<Module>/metadata/SearchFields.php
 *   modules/<Module>/metadata/subpanels/default.php
 *   custom/Extension/application/Ext/Include/<Module>.php            模块注册
 *   custom/Extension/application/Ext/Language/<lang>.ai_mod_<k>.php  模块显示名
 *   custom/Extension/modules/{Accounts,Opportunities}/Ext/Layoutdefs/  父模块子面板
 *   custom/Extension/modules/{Accounts,Opportunities}/Ext/Language/    子面板标题
 *
 * 用法：php scripts/build-modules.php
 */

$ROOT = rtrim(str_replace('\\', '/', dirname(__DIR__, 2)), '/') . '/crm';
if (!is_dir($ROOT . '/modules')) {
    fwrite(STDERR, "未找到 SuiteCRM 根目录: {$ROOT}\n");
    exit(1);
}
define('CRM_ROOT', $ROOT);

/* ============================================================
 * 工具函数
 * ============================================================ */

function ensure_dir($dir)
{
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

function emit($relPath, $content)
{
    $full = CRM_ROOT . '/' . ltrim($relPath, '/');
    ensure_dir(dirname($full));
    file_put_contents($full, $content);
    printf("  [写入] %-78s %6d B\n", $relPath, strlen($content));
}

/** 生成一个变量赋值形式的 PHP 文件 */
function php_file($assign, $value, $comment = null)
{
    $out = "<?php\n";
    if ($comment) {
        $out .= "/**\n * {$comment}\n */\n";
    }
    $out .= "if (!defined('sugarEntry')) {\n    define('sugarEntry', true);\n}\n\n";
    $out .= $assign . ' = ' . var_export($value, true) . ";\n";
    return $out;
}

function lic()
{
    return "/**\n * 智联AI科技有限公司 · AI Enterprise CRM\n * 基于 SuiteCRM 7.15.2 二次开发（AGPL-3.0）\n * 本文件为新增扩展文件，不修改 SuiteCRM 核心代码。\n */\n";
}

/* ============================================================
 * 字段类型展开器：紧凑写法 -> 完整 vardef
 *   紧凑:  'field_c' => array('varchar', 100, '中文名', 'En Name')
 *          'field_c' => array('enum', 'options_key', '中文名', 'En Name')
 *          'field_c' => array('text'|'date'|'currency'|'int', '中文名', 'En Name')
 * ============================================================ */
function expand_field($name, $spec, &$labelsZh, &$labelsEn)
{
    $type = $spec[0];
    $vname = 'LBL_' . strtoupper($name);
    $base = array(
        'name' => $name,
        'vname' => $vname,
        'audited' => true,
        'reportable' => true,
        'importable' => true,
    );

    switch ($type) {
        case 'varchar':
            $labelsZh[$vname] = $spec[2];
            $labelsEn[$vname] = $spec[3];
            $len = isset($spec[1]) ? (int)$spec[1] : 255;
            return $base + array(
                'type' => 'varchar',
                'len' => $len,
                'unified_search' => true,
                'merge_filter' => 'enabled',
            );

        case 'text':
            $labelsZh[$vname] = $spec[1];
            $labelsEn[$vname] = $spec[2];
            return $base + array('type' => 'text');

        case 'enum':
            $labelsZh[$vname] = $spec[2];
            $labelsEn[$vname] = $spec[3];
            return $base + array(
                'type' => 'enum',
                'options' => $spec[1],
                'len' => 100,
                'unified_search' => true,
            );

        case 'date':
            $labelsZh[$vname] = $spec[1];
            $labelsEn[$vname] = $spec[2];
            return $base + array(
                'type' => 'date',
                'enable_range_search' => true,
                'options' => 'date_range_search_dom',
            );

        case 'currency':
            $labelsZh[$vname] = $spec[1];
            $labelsEn[$vname] = $spec[2];
            return $base + array(
                'type' => 'currency',
                'dbType' => 'double',
                'len' => 26,
                'precision' => 6,
                'default' => 0.00,
                'required' => false,
                'enable_range_search' => true,
                'options' => 'numeric_range_search_dom',
            );

        case 'int':
            $labelsZh[$vname] = $spec[1];
            $labelsEn[$vname] = $spec[2];
            return $base + array('type' => 'int', 'len' => 11);

        default:
            fwrite(STDERR, "未知字段类型: {$type}\n");
            exit(2);
    }
}

/** 生成 relate 字段三件套（name / id / link） */
function relate_fields($name, $module, $relName, $labelZh, $labelEn, &$labelsZh, &$labelsEn)
{
    // relate 字段名形如 account_name / delivery_owner_name，
    // 对应的外键列名要取 account_id / delivery_owner_id
    $idName = preg_replace('/_name$/', '_id', $name);
    $labelsZh['LBL_' . strtoupper($name)] = $labelZh;
    $labelsEn['LBL_' . strtoupper($name)] = $labelEn;

    $rname = ($module === 'Users') ? 'last_name' : 'name';
    $table = ($module === 'Users') ? 'users' : strtolower($module) . 's';
    if ($module === 'Opportunities') {
        $table = 'opportunities';
    }
    $linkName = strtolower($module); // accounts / opportunities / users

    $fields = array();
    $fields[$name] = array(
        'name' => $name,
        'rname' => $rname,
        'id_name' => $idName,
        'vname' => 'LBL_' . strtoupper($name),
        'type' => 'relate',
        'table' => $table,
        'isnull' => 'true',
        'module' => $module,
        'dbType' => 'varchar',
        'link' => $linkName,
        'len' => 255,
        'source' => 'non-db',
        'unified_search' => true,
        'required' => false,
        'reportable' => true,
        'importable' => true,
        'massupdate' => false,
    );
    // 外键列：one-to-many 关系需要在从表落一个真实列，
    // 注意不要写 source=non-db，否则该列不会被建出来。
    $fields[$idName] = array(
        'name' => $idName,
        'vname' => 'LBL_' . strtoupper($idName),
        'type' => 'id',
        'audited' => false,
        'reportable' => false,
        'massupdate' => false,
    );
    $fields[$linkName] = array(
        'name' => $linkName,
        'type' => 'link',
        'relationship' => $relName,
        'source' => 'non-db',
        'vname' => 'LBL_' . strtoupper($linkName),
    );
    return $fields;
}

/** 生成 one-to-many 关系定义（父 -> 本模块） */
function o2m($relName, $parentModule, $parentTable, $childModule, $childTable, $childKey)
{
    return array(
        'lhs_module' => $parentModule,
        'lhs_table' => $parentTable,
        'lhs_key' => 'id',
        'rhs_module' => $childModule,
        'rhs_table' => $childTable,
        'rhs_key' => $childKey,
        'relationship_type' => 'one-to-many',
    );
}

/** 生成 panels 结构：['LBL_X' => [['f1','f2'], ['f3']]] -> viewdefs 需要的形式 */
function panels_to_defs($panels)
{
    $out = array();
    foreach ($panels as $panelLabel => $rows) {
        $rowsOut = array();
        foreach ($rows as $row) {
            $rowOut = array();
            foreach ($row as $f) {
                $rowOut[] = array('name' => $f);
            }
            $rowsOut[] = $rowOut;
        }
        $out[$panelLabel] = $rowsOut;
    }
    return $out;
}

/**
 * 生成 detailviewdefs / editviewdefs 的 tabDefs。
 *
 * ⚠️ 关键约束：每个面板的 newTab 必须是 true。
 *   SuiteCRM 的 DetailView2 会先按 tabDefs 渲染出页签容器（.tab-content），
 *   再把各个面板挂到对应页签下。如果所有面板都是 newTab=false，
 *   页签容器会是空的（`.tab-content` 无内容），而所有面板会被渲染成
 *   `style="display:none"` 且没有任何页签可点击 ——
 *   表现就是「详情页只有标题，内容区一片空白」。
 *   与 Accounts 的中文化配置保持一致：一个面板 = 一个页签。
 */
function tabdefs($panels)
{
    $out = array();
    foreach ($panels as $label => $_) {
        $out[$label] = array('newTab' => true, 'panelDefault' => 'expanded');
    }
    return $out;
}

function template_meta($panels, array $extra = array())
{
    $meta = array(
        'maxColumns' => '2',
        'widths' => array(
            array('label' => '10', 'field' => '30'),
            array('label' => '10', 'field' => '30'),
        ),
        'useTabs' => true,
        'tabDefs' => tabdefs($panels),
    );
    return $meta + $extra;
}

/* ============================================================
 * 模块定义
 * ============================================================ */

$MODULES = array();

/* ---------------- 模块 3：客户需求调研 ---------------- */
$MODULES['CReq_CustomerRequirements'] = array(
    'table' => 'creq_customerrequirements',
    'pre' => 'creq',
    'labels' => array('zh' => '需求调研', 'en' => 'Customer Requirement'),
    'labels_plural' => array('zh' => '需求调研', 'en' => 'Customer Requirements'),
    'comment' => '客户需求调研单：售前顾问记录客户业务/技术需求、竞争与风险分析',

    // 自身数据库字段（紧凑写法）
    'fields' => array(
        'req_no_c' => array('varchar', 60, '需求编号', 'Requirement No.'),
        'req_status_c' => array('enum', 'ai_req_status_list', '需求状态', 'Requirement Status'),
        'priority_c' => array('enum', 'ai_req_priority_list', '需求优先级', 'Priority'),
        'customer_background_c' => array('text', '客户背景', 'Customer Background'),
        'current_pain_points_c' => array('text', '业务痛点', 'Business Pain Points'),
        'current_system_c' => array('varchar', 255, '现有系统', 'Current System'),
        'requirement_desc_c' => array('text', '需求描述', 'Requirement Description'),
        'functional_req_c' => array('text', '功能需求', 'Functional Requirements'),
        'technical_req_c' => array('text', '技术需求', 'Technical Requirements'),
        'expected_solution_c' => array('text', '期望解决方案', 'Expected Solution'),
        'budget_c' => array('currency', '预算金额', 'Budget'),
        'go_live_date_c' => array('date', '期望上线时间', 'Expected Go-Live Date'),
        'key_decision_maker_c' => array('varchar', 255, '关键决策人', 'Key Decision Maker'),
        'competitor_c' => array('varchar', 255, '竞争方案', 'Competing Solution'),
        'risk_factor_c' => array('text', '风险事项', 'Risk Factors'),
    ),

    // relate 字段：字段名 => [目标模块, 关系名, 中文, 英文]
    'relates' => array(
        'account_name' => array('Accounts', 'creq_accounts', '客户名称', 'Account'),
        'opportunity_name' => array('Opportunities', 'creq_opportunities', '关联商机', 'Opportunity'),
    ),

    // 关系名 => [父模块, 父表, 子键]
    'relationships' => array(
        'creq_accounts' => array('Accounts', 'accounts', 'account_id'),
        'creq_opportunities' => array('Opportunities', 'opportunities', 'opportunity_id'),
    ),

    // 索引
    'indices' => array(
        array('name' => 'idx_creq_account', 'type' => 'index', 'fields' => array('account_id')),
        array('name' => 'idx_creq_opportunity', 'type' => 'index', 'fields' => array('opportunity_id')),
        array('name' => 'idx_creq_status', 'type' => 'index', 'fields' => array('req_status_c')),
    ),

    // 编辑/详情视图面板
    'panels' => array(
        'LBL_PANEL_BASIC' => array(
            array('req_no_c', 'req_status_c'),
            array('name', 'priority_c'),
            array('account_name', 'opportunity_name'),
        ),
        'LBL_PANEL_BACKGROUND' => array(
            array('customer_background_c'),
            array('current_pain_points_c'),
            array('current_system_c'),
        ),
        'LBL_PANEL_REQUIREMENT' => array(
            array('requirement_desc_c'),
            array('functional_req_c'),
            array('technical_req_c'),
            array('expected_solution_c'),
        ),
        'LBL_PANEL_COMMERCIAL' => array(
            array('budget_c', 'go_live_date_c'),
            array('key_decision_maker_c', 'competitor_c'),
            array('risk_factor_c'),
        ),
        'LBL_PANEL_ASSIGN' => array(
            array('assigned_user_name', 'date_modified'),
            array('description'),
        ),
    ),

    // 快捷创建面板
    'quick_panels' => array(
        'LBL_PANEL_QUICKCREATE' => array(
            array('name', 'req_status_c'),
            array('account_name', 'opportunity_name'),
            array('priority_c', 'go_live_date_c'),
            array('requirement_desc_c'),
        ),
    ),

    // 列表视图列
    'listview' => array(
        'NAME' => array('label' => 'LBL_NAME', 'width' => '18%'),
        'REQ_NO_C' => array('label' => 'LBL_REQ_NO_C', 'width' => '9%'),
        'ACCOUNT_NAME' => array('label' => 'LBL_ACCOUNT_NAME', 'width' => '14%'),
        'OPPORTUNITY_NAME' => array('label' => 'LBL_OPPORTUNITY_NAME', 'width' => '14%'),
        'REQ_STATUS_C' => array('label' => 'LBL_REQ_STATUS_C', 'width' => '8%'),
        'PRIORITY_C' => array('label' => 'LBL_PRIORITY_C', 'width' => '7%'),
        'BUDGET_C' => array('label' => 'LBL_BUDGET_C', 'width' => '9%'),
        'ASSIGNED_USER_NAME' => array('label' => 'LBL_ASSIGNED_USER_NAME', 'width' => '9%'),
        'GO_LIVE_DATE_C' => array('label' => 'LBL_GO_LIVE_DATE_C', 'width' => '8%'),
        'DATE_MODIFIED' => array('label' => 'LBL_DATE_MODIFIED', 'width' => '8%'),
    ),

    // 搜索
    'basic_search' => array('name', 'account_name', 'req_status_c', 'priority_c'),
    'advanced_search' => array('name', 'req_no_c', 'account_name', 'opportunity_name',
        'req_status_c', 'priority_c', 'assigned_user_name', 'budget_c', 'go_live_date_c'),

    // 父模块子面板
    'subpanels' => array(
        'Accounts' => array('title' => '需求调研', 'title_en' => 'Requirements', 'order' => 95),
        'Opportunities' => array('title' => '需求调研', 'title_en' => 'Requirements', 'order' => 95),
    ),
);

/* ---------------- 模块 5：项目交接单 ---------------- */
$MODULES['Hand_ProjectHandovers'] = array(
    'table' => 'hand_projecthandovers',
    'pre' => 'hand',
    'labels' => array('zh' => '项目交接', 'en' => 'Project Handover'),
    'labels_plural' => array('zh' => '项目交接', 'en' => 'Project Handovers'),
    'comment' => '项目交接单：商机成交后，销售向售前与交付团队移交项目信息',

    'fields' => array(
        'handover_no_c' => array('varchar', 60, '交接单号', 'Handover No.'),
        'handover_status_c' => array('enum', 'ai_handover_status_list', '交接状态', 'Handover Status'),
        'product_type_c' => array('enum', 'ai_product_type_list', '购买产品', 'Product'),
        'contract_amount_c' => array('currency', '合同金额', 'Contract Amount'),
        'handover_date_c' => array('date', '交接日期', 'Handover Date'),
        'start_date_c' => array('date', '计划启动日期', 'Planned Start Date'),
        'implementation_cycle_c' => array('varchar', 100, '实施周期', 'Implementation Cycle'),
        'project_goal_c' => array('text', '项目目标', 'Project Goal'),
        'customer_requirement_c' => array('text', '客户需求', 'Customer Requirements'),
        'committed_features_c' => array('text', '承诺功能', 'Committed Features'),
        'contract_scope_c' => array('text', '合同范围', 'Contract Scope'),
        'risk_items_c' => array('text', '风险事项', 'Risk Items'),
        'acceptance_criteria_c' => array('text', '验收标准', 'Acceptance Criteria'),
    ),

    'relates' => array(
        'account_name' => array('Accounts', 'hand_accounts', '客户名称', 'Account'),
        'opportunity_name' => array('Opportunities', 'hand_opportunities', '关联商机', 'Opportunity'),
        'delivery_owner_name' => array('Users', 'hand_delivery_owner', '交付负责人', 'Delivery Owner'),
    ),

    'relationships' => array(
        'hand_accounts' => array('Accounts', 'accounts', 'account_id'),
        'hand_opportunities' => array('Opportunities', 'opportunities', 'opportunity_id'),
        'hand_delivery_owner' => array('Users', 'users', 'delivery_owner_id'),
    ),

    'indices' => array(
        array('name' => 'idx_hand_account', 'type' => 'index', 'fields' => array('account_id')),
        array('name' => 'idx_hand_opportunity', 'type' => 'index', 'fields' => array('opportunity_id')),
        array('name' => 'idx_hand_status', 'type' => 'index', 'fields' => array('handover_status_c')),
    ),

    'panels' => array(
        'LBL_PANEL_BASIC' => array(
            array('handover_no_c', 'handover_status_c'),
            array('name', 'product_type_c'),
            array('account_name', 'opportunity_name'),
        ),
        'LBL_PANEL_CONTRACT' => array(
            array('contract_amount_c', 'handover_date_c'),
            array('start_date_c', 'implementation_cycle_c'),
            array('contract_scope_c'),
        ),
        'LBL_PANEL_DELIVERY' => array(
            array('project_goal_c'),
            array('customer_requirement_c'),
            array('committed_features_c'),
            array('acceptance_criteria_c'),
        ),
        'LBL_PANEL_RISK' => array(
            array('delivery_owner_name', 'assigned_user_name'),
            array('risk_items_c'),
            array('description'),
        ),
    ),

    'quick_panels' => array(
        'LBL_PANEL_QUICKCREATE' => array(
            array('name', 'handover_status_c'),
            array('account_name', 'opportunity_name'),
            array('product_type_c', 'contract_amount_c'),
            array('delivery_owner_name', 'handover_date_c'),
        ),
    ),

    'listview' => array(
        'NAME' => array('label' => 'LBL_NAME', 'width' => '18%'),
        'HANDOVER_NO_C' => array('label' => 'LBL_HANDOVER_NO_C', 'width' => '9%'),
        'ACCOUNT_NAME' => array('label' => 'LBL_ACCOUNT_NAME', 'width' => '14%'),
        'PRODUCT_TYPE_C' => array('label' => 'LBL_PRODUCT_TYPE_C', 'width' => '11%'),
        'HANDOVER_STATUS_C' => array('label' => 'LBL_HANDOVER_STATUS_C', 'width' => '9%'),
        'CONTRACT_AMOUNT_C' => array('label' => 'LBL_CONTRACT_AMOUNT_C', 'width' => '10%'),
        'DELIVERY_OWNER_NAME' => array('label' => 'LBL_DELIVERY_OWNER_NAME', 'width' => '10%'),
        'HANDOVER_DATE_C' => array('label' => 'LBL_HANDOVER_DATE_C', 'width' => '9%'),
        'DATE_MODIFIED' => array('label' => 'LBL_DATE_MODIFIED', 'width' => '10%'),
    ),

    'basic_search' => array('name', 'account_name', 'handover_status_c', 'product_type_c'),
    'advanced_search' => array('name', 'handover_no_c', 'account_name', 'opportunity_name',
        'handover_status_c', 'product_type_c', 'delivery_owner_name', 'handover_date_c'),

    'subpanels' => array(
        'Accounts' => array('title' => '项目交接', 'title_en' => 'Project Handovers', 'order' => 96),
        'Opportunities' => array('title' => '项目交接', 'title_en' => 'Project Handovers', 'order' => 96),
    ),
);

/* ---------------- 模块 4：销售分析看板（纯展示模块）---------------- */
$MODULES['AID_SalesAnalytics'] = array(
    'table' => 'aid_salesanalytics',
    'pre' => 'aid',
    'labels' => array('zh' => '销售分析', 'en' => 'Sales Analytics'),
    'labels_plural' => array('zh' => '销售分析', 'en' => 'Sales Analytics'),
    'comment' => '销售漏斗与经营分析看板：核心指标 / 阶段漏斗 / 产品与行业分布 / 输单归因',
    'view_only' => true,   // 纯展示模块：菜单只提供看板入口，不提供新建/导入

    // 纯展示模块不需要业务字段，仅保留 basic 模板字段（name / date_entered ...）
    'fields' => array(),
    'relates' => array(),
    'relationships' => array(),
    'indices' => array(),

    'panels' => array(
        'LBL_PANEL_BASIC' => array(array('name')),
    ),
    'quick_panels' => array(
        'LBL_PANEL_QUICKCREATE' => array(array('name')),
    ),

    'listview' => array(
        'NAME' => array('label' => 'LBL_NAME', 'width' => '100%'),
    ),

    'basic_search' => array('name'),
    'advanced_search' => array('name'),

    'subpanels' => array(),
);

/* ============================================================
 * 生成
 * ============================================================ */

echo "==> 开始生成自定义模块\n";

foreach ($MODULES as $mod => $def) {
    echo "\n--- {$mod} ---\n";
    $table = $def['table'];
    $pre = $def['pre'];

    /* ---------- 1. 组装 vardefs ---------- */
    $labelsZh = array();
    $labelsEn = array();
    $fields = array();

    foreach ($def['fields'] as $fname => $spec) {
        $fields[$fname] = expand_field($fname, $spec, $labelsZh, $labelsEn);
    }
    foreach ($def['relates'] as $fname => $r) {
        $relFields = relate_fields($fname, $r[0], $r[1], $r[2], $r[3], $labelsZh, $labelsEn);
        $fields = array_merge($fields, $relFields);
    }

    // currency 字段需要 currency_id（SuiteCRM 渲染依赖）
    $hasCurrency = false;
    foreach ($def['fields'] as $spec) {
        if ($spec[0] === 'currency') {
            $hasCurrency = true;
            break;
        }
    }
    if ($hasCurrency) {
        // 注意：这里的 function 必须是 getCurrencyDropDown（SuiteCRM 内置的货币下拉渲染器）。
        // 若误写成 getCurrencyId（签名是 ($module,$id)），SearchForm 会把 bean 对象当模块名传入，
        // 触发 "Cannot access offset of type <Bean>" 致命错误。
        $fields['currency_id'] = array(
            'name' => 'currency_id',
            'type' => 'id',
            'group' => 'currency_id',
            'vname' => 'LBL_CURRENCY',
            'function' => array('name' => 'getCurrencyDropDown', 'returns' => 'html', 'onListView' => true),
            'required' => false,
            'reportable' => false,
            'comment' => 'Currency used for display purposes',
        );
        $labelsZh['LBL_CURRENCY'] = '货币';
        $labelsEn['LBL_CURRENCY'] = 'Currency';
    }

    $relationships = array();
    foreach ($def['relationships'] as $relName => $r) {
        $relationships[$relName] = o2m($relName, $r[0], $r[1], $mod, $table, $r[2]);
    }

    $vardefs = array(
        'table' => $table,
        'audited' => true,
        'inline_edit' => true,
        'unified_search' => true,
        'full_text_search' => true,
        'unified_search_default_enabled' => true,
        'duplicate_merge' => true,
        'comment' => $def['comment'],
        'fields' => $fields,
        'relationships' => $relationships,
        'indices' => $def['indices'],
        'optimistic_locking' => true,
    );

    $vardefSrc = "<?php\n" . lic() . "\n"
        . "\$dictionary['{$mod}'] = " . var_export($vardefs, true) . ";\n\n"
        . "if (!class_exists('VardefManager')) {\n"
        . "    require_once 'include/SugarObjects/VardefManager.php';\n"
        . "}\n"
        . "VardefManager::createVardef('{$mod}', '{$mod}', array('basic', 'assignable'));\n";
    emit("modules/{$mod}/vardefs.php", $vardefSrc);

    /* ---------- 2. Bean 类 ---------- */
    $commonProps = array(
        'id', 'name', 'date_entered', 'date_modified', 'modified_user_id', 'modified_by_name',
        'created_by', 'created_by_name', 'description', 'deleted', 'created_by_link',
        'modified_user_link', 'assigned_user_id', 'assigned_user_name', 'assigned_user_link',
    );
    $customProps = array_keys($def['fields']);
    $allProps = array_unique(array_merge($commonProps, $customProps));
    // relate 字段的 name / id / link 属性都要声明
    foreach ($def['relates'] as $fname => $r) {
        $allProps[] = $fname;
        $allProps[] = preg_replace('/_name$/', '_id', $fname);
        $allProps[] = strtolower($r[0]);
    }

    $propLines = '';
    foreach ($allProps as $p) {
        $propLines .= "    public \${$p};\n";
    }

    $sugar = "<?php\n" . lic() . "\n"
        . "#[\\AllowDynamicProperties]\n"
        . "class {$mod}_sugar extends Basic\n"
        . "{\n"
        . "    public \$new_schema = true;\n"
        . "    public \$module_dir = '{$mod}';\n"
        . "    public \$object_name = '{$mod}';\n"
        . "    public \$table_name = '{$table}';\n"
        . "    public \$importable = true;\n"
        . "    public \$disable_row_level_security = true;\n"
        . $propLines
        . "\n"
        . "    public function __construct()\n"
        . "    {\n"
        . "        parent::__construct();\n"
        . "    }\n"
        . "\n"
        . "    public function bean_implements(\$interface)\n"
        . "    {\n"
        . "        switch (\$interface) {\n"
        . "            case 'ACL':\n"
        . "                return true;\n"
        . "        }\n"
        . "        return false;\n"
        . "    }\n"
        . "}\n";
    emit("modules/{$mod}/{$mod}_sugar.php", $sugar);

    $bean = "<?php\n" . lic() . "\n"
        . "require_once('modules/{$mod}/{$mod}_sugar.php');\n\n"
        . "class {$mod} extends {$mod}_sugar\n"
        . "{\n"
        . "    public function __construct()\n"
        . "    {\n"
        . "        parent::__construct();\n"
        . "    }\n"
        . "}\n";
    emit("modules/{$mod}/{$mod}.php", $bean);

    /* ---------- 3. 语言文件 ---------- */
    $modLabelsZh = array(
        'LBL_MODULE_NAME' => $def['labels']['zh'],
        'LBL_MODULE_TITLE' => $def['labels']['zh'],
        'LBL_MODULE_NAME_SINGULAR' => $def['labels']['zh'],
        'LBL_LIST_FORM_TITLE' => $def['labels_plural']['zh'] . '列表',
        'LBL_SEARCH_FORM_TITLE' => '搜索' . $def['labels']['zh'],
        'LNK_NEW_RECORD' => '新建' . $def['labels']['zh'],
        'LNK_LIST' => $def['labels_plural']['zh'] . '列表',
        'LNK_IMPORT' => '导入' . $def['labels']['zh'],
        'LBL_NEW_FORM_TITLE' => '新建' . $def['labels']['zh'],
        'LBL_HOMEPAGE_TITLE' => '我的' . $def['labels_plural']['zh'],
        'LBL_DEFAULT_SUBPANEL_TITLE' => $def['labels_plural']['zh'],
        'LBL_CONVERTED_FROM_LEAD' => '由线索转换',
        'LNK_VIEW_DASHBOARD' => '查看' . $def['labels']['zh'] . '看板',
    );
    $modLabelsEn = array(
        'LBL_MODULE_NAME' => $def['labels_plural']['en'],
        'LBL_MODULE_TITLE' => $def['labels_plural']['en'],
        'LBL_MODULE_NAME_SINGULAR' => $def['labels']['en'],
        'LBL_LIST_FORM_TITLE' => $def['labels_plural']['en'] . ' List',
        'LBL_SEARCH_FORM_TITLE' => 'Search ' . $def['labels']['en'],
        'LNK_NEW_RECORD' => 'Create ' . $def['labels']['en'],
        'LNK_LIST' => $def['labels_plural']['en'],
        'LNK_IMPORT' => 'Import ' . $def['labels']['en'],
        'LBL_NEW_FORM_TITLE' => 'New ' . $def['labels']['en'],
        'LBL_HOMEPAGE_TITLE' => 'My ' . $def['labels_plural']['en'],
        'LBL_DEFAULT_SUBPANEL_TITLE' => $def['labels_plural']['en'],
        'LBL_CONVERTED_FROM_LEAD' => 'Converted from Lead',
        'LNK_VIEW_DASHBOARD' => 'View ' . $def['labels']['en'] . ' Dashboard',
    );
    // 面板标签
    $panelZh = array(
        'LBL_PANEL_BASIC' => '基本信息',
        'LBL_PANEL_BACKGROUND' => '客户背景与痛点',
        'LBL_PANEL_REQUIREMENT' => '需求描述',
        'LBL_PANEL_COMMERCIAL' => '商务与决策信息',
        'LBL_PANEL_ASSIGN' => '负责人与备注',
        'LBL_PANEL_CONTRACT' => '合同与计划',
        'LBL_PANEL_DELIVERY' => '交付信息',
        'LBL_PANEL_RISK' => '风险与责任人',
        'LBL_PANEL_QUICKCREATE' => '快速创建',
    );
    $panelEn = array(
        'LBL_PANEL_BASIC' => 'Basic Information',
        'LBL_PANEL_BACKGROUND' => 'Customer Background & Pain Points',
        'LBL_PANEL_REQUIREMENT' => 'Requirement Details',
        'LBL_PANEL_COMMERCIAL' => 'Commercial & Decision Info',
        'LBL_PANEL_ASSIGN' => 'Owner & Notes',
        'LBL_PANEL_CONTRACT' => 'Contract & Schedule',
        'LBL_PANEL_DELIVERY' => 'Delivery Information',
        'LBL_PANEL_RISK' => 'Risk & Responsibility',
        'LBL_PANEL_QUICKCREATE' => 'Quick Create',
    );
    foreach ($panelZh as $k => $v) {
        $modLabelsZh[$k] = $v;
        $modLabelsEn[$k] = $panelEn[$k];
    }
    $modLabelsZh['LBL_ASSIGNED_USER_NAME'] = '负责人';
    $modLabelsEn['LBL_ASSIGNED_USER_NAME'] = 'Assigned To';
    $modLabelsZh['LBL_DATE_MODIFIED'] = '修改时间';
    $modLabelsEn['LBL_DATE_MODIFIED'] = 'Date Modified';
    $modLabelsZh['LBL_DATE_ENTERED'] = '创建时间';
    $modLabelsEn['LBL_DATE_ENTERED'] = 'Date Created';

    $allZh = array_merge($modLabelsZh, $labelsZh);
    $allEn = array_merge($modLabelsEn, $labelsEn);
    ksort($allZh);
    ksort($allEn);

    emit("modules/{$mod}/language/zh_CN.lang.php",
        "<?php\n" . lic() . "\n\$mod_strings = " . var_export($allZh, true) . ";\n");
    emit("modules/{$mod}/language/en_us.lang.php",
        "<?php\n" . lic() . "\n\$mod_strings = " . var_export($allEn, true) . ";\n");

    /* ---------- 4. Menu.php ---------- */
    if (!empty($def['view_only'])) {
        // 纯展示模块：菜单只放看板入口
        $menu = "<?php\n" . lic() . "\n"
            . "if (!defined('sugarEntry') || !sugarEntry) {\n    die('Not A Valid Entry Point');\n}\n\n"
            . "\$module_menu = array();\n"
            . "\$module_menu[] = array('index.php?module={$mod}&action=index', \$mod_strings['LNK_VIEW_DASHBOARD'], 'List');\n";
    } else {
        $menu = "<?php\n" . lic() . "\n"
            . "if (!defined('sugarEntry') || !sugarEntry) {\n    die('Not A Valid Entry Point');\n}\n\n"
            . "\$module_menu = array();\n"
            . "\$module_menu[] = array('index.php?module={$mod}&action=EditView&return_module={$mod}&return_action=DetailView', \$mod_strings['LNK_NEW_RECORD'], 'Create');\n"
            . "\$module_menu[] = array('index.php?module={$mod}&action=index&return_module={$mod}&return_action=DetailView', \$mod_strings['LNK_LIST'], 'List');\n"
            . "\$module_menu[] = array('index.php?module={$mod}&action=Import&return_module={$mod}&return_action=DetailView', \$mod_strings['LNK_IMPORT'], 'Import');\n";
    }
    emit("modules/{$mod}/Menu.php", $menu);

    /* ---------- 5. metadata ---------- */
    $panelDefs = panels_to_defs($def['panels']);
    $quickDefs = panels_to_defs($def['quick_panels']);

    // editviewdefs
    $editDefs = array(
        $mod => array(
            'EditView' => array(
                'templateMeta' => template_meta($def['panels'], array('syncDetailEditViews' => true)),
                'panels' => $panelDefs,
            ),
        ),
    );
    emit("modules/{$mod}/metadata/editviewdefs.php", php_file('$viewdefs', $editDefs));

    // detailviewdefs
    $detailDefs = array(
        $mod => array(
            'DetailView' => array(
                'templateMeta' => template_meta($def['panels'], array(
                    'form' => array('buttons' => array('EDIT', 'DUPLICATE', 'DELETE')),
                )),
                'panels' => $panelDefs,
            ),
        ),
    );
    emit("modules/{$mod}/metadata/detailviewdefs.php", php_file('$viewdefs', $detailDefs));

    // quickcreatedefs
    $quickFull = array(
        $mod => array(
            'QuickCreate' => array(
                'templateMeta' => array(
                    'maxColumns' => '2',
                    'widths' => array(
                        array('label' => '10', 'field' => '30'),
                        array('label' => '10', 'field' => '30'),
                    ),
                    'includes' => array(),
                ),
                'panels' => $quickDefs,
            ),
        ),
    );
    emit("modules/{$mod}/metadata/quickcreatedefs.php", php_file('$viewdefs', $quickFull));

    // listviewdefs
    $lv = array();
    foreach ($def['listview'] as $f => $cfg) {
        $entry = array(
            'width' => $cfg['width'],
            'label' => $cfg['label'],
            'default' => true,
        );
        $lower = strtolower($f);
        if (strpos($lower, '_name') !== false || $lower === 'name') {
            $entry['link'] = true;
        }
        if (substr($lower, -2) === '_c') {
            $entry['type'] = 'varchar';
            $entry['studio'] = 'visible';
        }
        if ($lower === 'assigned_user_name') {
            $entry['type'] = 'relate';
            $entry['id'] = 'ASSIGNED_USER_ID';
            $entry['link'] = false;
        }
        $lv[strtoupper($f)] = $entry;
    }
    emit("modules/{$mod}/metadata/listviewdefs.php",
        php_file("\$listViewDefs['{$mod}']", $lv));

    // searchdefs
    $sd = array(
        $mod => array(
            'templateMeta' => array(
                'maxColumns' => 3,
                'widths' => array(
                    array('label' => '10%', 'field' => '30%'),
                    array('label' => '10%', 'field' => '30%'),
                    array('label' => '10%', 'field' => '30%'),
                ),
            ),
            'layout' => array(
                'basic_search' => $def['basic_search'],
                'advanced_search' => $def['advanced_search'],
            ),
        ),
    );
    emit("modules/{$mod}/metadata/searchdefs.php", php_file('$searchdefs', $sd));

    // SearchFields
    $sf = array();
    foreach ($def['advanced_search'] as $f) {
        $sf[strtoupper($f)] = array('query_type' => 'default');
    }
    $sf['CURRENT_USER_ONLY'] = array('query_type' => 'default', 'db_field' => array('assigned_user_id'));
    emit("modules/{$mod}/metadata/SearchFields.php",
        php_file("\$searchFields['{$mod}']", $sf));

    // subpaneldefs（模块自身详情页的子面板，保持为空）
    emit("modules/{$mod}/metadata/subpaneldefs.php",
        "<?php\n" . lic() . "\n"
        . "if (!defined('sugarEntry') || !sugarEntry) {\n    die('Not A Valid Entry Point');\n}\n\n"
        . "\$modules['{$mod}']['subpanel_setup'] = array();\n");

    // subpanels/default.php（在其他模块子面板中显示时的列定义）
    $subFields = array();
    foreach (array_slice($def['listview'], 0, 6, true) as $f => $cfg) {
        $entry = array(
            'vname' => $cfg['label'],
            'width' => $cfg['width'],
        );
        $lower = strtolower($f);
        if ($lower === 'name') {
            $entry['widget_class'] = 'SubPanelDetailViewLink';
            $entry['width'] = '25%';
        }
        $subFields[$f] = $entry;
    }
    $subFields['EDIT_BUTTON'] = array(
        'widget_class' => 'SubPanelEditButton',
        'module' => $mod,
        'width' => '4%',
        'default' => true,
    );
    $subFields['REMOVE_BUTTON'] = array(
        'widget_class' => 'SubPanelRemoveButton',
        'module' => $mod,
        'width' => '4%',
        'default' => true,
    );
    $subpanelLayout = array(
        'top_buttons' => array(
            array('widget_class' => 'SubPanelTopCreateButton'),
            array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => $mod),
        ),
        'where' => '',
        'list_fields' => $subFields,
    );
    emit("modules/{$mod}/metadata/subpanels/default.php", php_file('$subpanel_layout', $subpanelLayout));

    /* ---------- 6. 模块注册 ---------- */
    $reg = "<?php\n" . lic() . "\n"
        . "// 模块注册：把自定义模块登记进 SuiteCRM 的 Bean / Module 列表\n"
        . "\$beanList['{$mod}'] = '{$mod}';\n"
        . "\$beanFiles['{$mod}'] = 'modules/{$mod}/{$mod}.php';\n"
        . "\$moduleList[] = '{$mod}';\n"
        . "\$modules_exempt_from_availability_check['{$mod}'] = '{$mod}';\n"
        . "\$report_include_modules['{$mod}'] = '{$mod}';\n";
    emit("custom/Extension/application/Ext/Include/{$mod}.php", $reg);

    // 模块显示名（导航 / 下拉）
    $keyZh = "<?php\n" . lic() . "\n"
        . "\$app_list_strings['moduleList']['{$mod}'] = '{$def['labels_plural']['zh']}';\n"
        . "\$app_list_strings['moduleListSingular']['{$mod}'] = '{$def['labels']['zh']}';\n";
    $keyEn = "<?php\n" . lic() . "\n"
        . "\$app_list_strings['moduleList']['{$mod}'] = '{$def['labels_plural']['en']}';\n"
        . "\$app_list_strings['moduleListSingular']['{$mod}'] = '{$def['labels']['en']}';\n";
    emit("custom/Extension/application/Ext/Language/zh_CN.ai_mod_{$mod}.php", $keyZh);
    emit("custom/Extension/application/Ext/Language/en_us.ai_mod_{$mod}.php", $keyEn);

    /* ---------- 7. 父模块子面板注册 ---------- */
    foreach ($def['subpanels'] as $parent => $cfg) {
        // 找到与该父模块对应的关系名
        $relKey = null;
        foreach ($def['relationships'] as $rn => $rr) {
            if ($rr[0] === $parent) {
                $relKey = $rn;
                break;
            }
        }
        $layout = "<?php\n" . lic() . "\n"
            . "\$layout_defs['{$parent}']['subpanel_setup']['{$pre}_" . strtolower($mod) . "'] = " . var_export(array(
                'order' => $cfg['order'],
                'module' => $mod,
                'subpanel_name' => 'default',
                'sort_order' => 'desc',
                'sort_by' => 'date_entered',
                'title_key' => 'LBL_' . strtoupper($pre) . '_SUBPANEL_TITLE',
                'get_subpanel_data' => $relKey,
                'top_buttons' => array(
                    array('widget_class' => 'SubPanelTopCreateButton'),
                    array('widget_class' => 'SubPanelTopSelectButton', 'popup_module' => $mod),
                ),
            ), true) . ";\n";
        emit("custom/Extension/modules/{$parent}/Ext/Layoutdefs/{$pre}_{$parent}_subpanel.php", $layout);

        // 子面板标题语言包
        $titleLbl = 'LBL_' . strtoupper($pre) . '_SUBPANEL_TITLE';
        emit("custom/Extension/modules/{$parent}/Ext/Language/zh_CN.{$pre}_subpanel.php",
            "<?php\n" . lic() . "\n\$mod_strings['{$titleLbl}'] = '{$cfg['title']}';\n");
        emit("custom/Extension/modules/{$parent}/Ext/Language/en_us.{$pre}_subpanel.php",
            "<?php\n" . lic() . "\n\$mod_strings['{$titleLbl}'] = '{$cfg['title_en']}';\n");
    }
}

echo "\n==> 生成完成\n";
