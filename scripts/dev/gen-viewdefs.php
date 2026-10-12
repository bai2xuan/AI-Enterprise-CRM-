<?php
/**
 * AI Enterprise CRM —— 视图布局生成器
 * ------------------------------------------------------------------
 * 作用：读取 SuiteCRM 核心 viewdefs，按 AI 解决方案销售业务对字段重新分组，
 *       输出到 custom/modules/<Module>/metadata/ 作为视图覆盖文件。
 *       运行后不会修改任何 SuiteCRM 核心文件。
 *
 * 用法：php scripts/dev/gen-viewdefs.php
 */

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);

$ROOT = dirname(__DIR__, 2);
$CRM  = $ROOT . '/crm';

$stat = array('ok' => 0, 'fail' => 0);

/**
 * 对某个视图定义文件执行一组"文本替换"并输出为 custom 覆盖文件
 *
 * @param string $CRM      SuiteCRM 根目录
 * @param string $module   模块名，如 Accounts
 * @param string $viewFile editview | detailview
 * @param string $viewKey  EditView | DetailView
 * @param array  $pairs    [[search, replace], ...]
 */
function patch_view($CRM, $module, $viewFile, $viewKey, array $pairs, array &$stat)
{
    $src    = "$CRM/modules/$module/metadata/{$viewFile}defs.php";
    $dstDir = "$CRM/custom/modules/$module/metadata";
    $dst    = "$dstDir/{$viewFile}defs.php";

    if (!is_dir($dstDir)) {
        mkdir($dstDir, 0777, true);
    }
    if (!file_exists($src)) {
        echo "  [x] 源文件不存在: $src\n";
        $stat['fail']++;
        return;
    }

    $code = file_get_contents($src);

    foreach ($pairs as $idx => $pair) {
        $search  = $pair[0];
        $replace = $pair[1];
        $cnt     = 0;
        $code    = str_replace($search, $replace, $code, $cnt);
        if ($cnt === 0) {
            echo "  [!] 替换未命中 ({$module}/{$viewFile} 第" . ($idx + 1) . "处)\n";
            $stat['fail']++;
            return;
        }
    }

    $banner = "<?php\n"
        . "/**\n"
        . " * AI Enterprise CRM —— {$module} {$viewKey} 视图覆盖\n"
        . " * 由 scripts/dev/gen-viewdefs.php 自动生成，请勿手工修改。\n"
        . " * 说明：在 SuiteCRM 原生布局基础上，按 AI 解决方案销售业务分组重排字段；未改动核心源码。\n"
        . " */";

    $code = preg_replace('/\A<\?php/', $banner, $code, 1);

    file_put_contents($dst, $code);
    echo "  [ok] {$module}/{$viewFile} -> custom/modules/{$module}/metadata/{$viewFile}defs.php\n";
    $stat['ok']++;
}

/* ==================================================================
 * 一、Accounts（客户）新增字段面板
 * ================================================================== */
$accNewPanels = <<<'PANELS'
      'LBL_PANEL_AI_BASIC' =>
      array(
        0 =>
        array(
          0 => 'industry',
          1 => 'company_size_c',
        ),
        1 =>
        array(
          0 => 'enterprise_type_c',
        ),
      ),
      'LBL_PANEL_AI_VALUE' =>
      array(
        0 =>
        array(
          0 => 'customer_level_c',
          1 => 'customer_source_c',
        ),
        1 =>
        array(
          0 => 'potential_value_c',
        ),
      ),
      'LBL_PANEL_AI_BUSINESS' =>
      array(
        0 =>
        array(
          0 => 'current_pain_points_c',
        ),
        1 =>
        array(
          0 => 'current_system_c',
        ),
        2 =>
        array(
          0 => 'budget_range_c',
          1 => 'decision_cycle_c',
        ),
      ),
      'LBL_PANEL_AI_OWNER' =>
      array(
        0 =>
        array(
          0 => 'sales_owner_c',
          1 => 'presales_owner_c',
        ),
      ),
PANELS;

$accNewTabs = <<<'TABS'
        'LBL_PANEL_AI_BASIC' =>
        array(
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_AI_VALUE' =>
        array(
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_AI_BUSINESS' =>
        array(
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_AI_OWNER' =>
        array(
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
TABS;

$accDetailNewTabs = str_replace("'newTab' => false", "'newTab' => true", $accNewTabs);

/* ---------- 1.1 Accounts EditView ---------- */
patch_view($CRM, 'Accounts', 'editview', 'EditView', array(
    array(
        // 在原生 ADVANCED 面板前插入 4 个业务面板，并把 industry 从 ADVANCED 迁移到基础信息面板
        "      'LBL_PANEL_ADVANCED' =>\n" .
        "      array(\n" .
        "        0 =>\n" .
        "        array(\n" .
        "          0 => 'account_type',\n" .
        "          1 => 'industry',\n" .
        "        ),\n",

        $accNewPanels .
        "      'LBL_PANEL_ADVANCED' =>\n" .
        "      array(\n" .
        "        0 =>\n" .
        "        array(\n" .
        "          0 => 'account_type',\n" .
        "        ),\n",
    ),
    array(
        "        'LBL_PANEL_ADVANCED' =>\n" .
        "        array(\n" .
        "          'newTab' => false,\n" .
        "          'panelDefault' => 'expanded',\n" .
        "        ),\n",

        $accNewTabs .
        "        'LBL_PANEL_ADVANCED' =>\n" .
        "        array(\n" .
        "          'newTab' => false,\n" .
        "          'panelDefault' => 'expanded',\n" .
        "        ),\n",
    ),
), $stat);

/* ---------- 1.2 Accounts DetailView ---------- */
patch_view($CRM, 'Accounts', 'detailview', 'DetailView', array(
    array(
        "      'LBL_PANEL_ADVANCED' =>\n" .
        "      array(\n" .
        "        0 =>\n" .
        "        array(\n" .
        "          0 =>\n" .
        "          array(\n" .
        "            'name' => 'account_type',\n" .
        "            'comment' => 'The Company is of this type',\n" .
        "            'label' => 'LBL_TYPE',\n" .
        "          ),\n" .
        "          1 =>\n" .
        "          array(\n" .
        "            'name' => 'industry',\n" .
        "            'comment' => 'The company belongs in this industry',\n" .
        "            'label' => 'LBL_INDUSTRY',\n" .
        "          ),\n" .
        "        ),\n",

        $accNewPanels .
        "      'LBL_PANEL_ADVANCED' =>\n" .
        "      array(\n" .
        "        0 =>\n" .
        "        array(\n" .
        "          0 =>\n" .
        "          array(\n" .
        "            'name' => 'account_type',\n" .
        "            'comment' => 'The Company is of this type',\n" .
        "            'label' => 'LBL_TYPE',\n" .
        "          ),\n" .
        "        ),\n",
    ),
    array(
        "        'LBL_PANEL_ADVANCED' =>\n" .
        "        array(\n" .
        "          'newTab' => true,\n" .
        "          'panelDefault' => 'expanded',\n" .
        "        ),\n",

        $accDetailNewTabs .
        "        'LBL_PANEL_ADVANCED' =>\n" .
        "        array(\n" .
        "          'newTab' => true,\n" .
        "          'panelDefault' => 'expanded',\n" .
        "        ),\n",
    ),
), $stat);

/* ==================================================================
 * 二、Opportunities（商机）—— 插入产品类型 / 输单原因
 * ================================================================== */
$oppNewRows = <<<'ROWS'
    array(
      'product_type_c',
      'lost_reason_c',
    ),
ROWS;

/* ---------- 2.1 Opportunities EditView ---------- */
patch_view($CRM, 'Opportunities', 'editview', 'EditView', array(
    array(
        "    array(\n" .
        "      array('name'=>'name'),\n" .
        "      'account_name',\n" .
        "    ),\n",

        "    array(\n" .
        "      array('name'=>'name'),\n" .
        "      'account_name',\n" .
        "    ),\n" .
        $oppNewRows,
    ),
), $stat);

/* ---------- 2.2 Opportunities DetailView ---------- */
patch_view($CRM, 'Opportunities', 'detailview', 'DetailView', array(
    array(
        "      'default' =>\n" .
        "      array(\n" .
        "        0 =>\n" .
        "        array(\n" .
        "          0 => 'name',\n" .
        "          1 => 'account_name',\n" .
        "        ),\n",

        "      'default' =>\n" .
        "      array(\n" .
        "        0 =>\n" .
        "        array(\n" .
        "          0 => 'name',\n" .
        "          1 => 'account_name',\n" .
        "        ),\n" .
        "        99 =>\n" .
        "        array(\n" .
        "          0 => 'product_type_c',\n" .
        "          1 => 'lost_reason_c',\n" .
        "        ),\n",
    ),
), $stat);

/* ==================================================================
 * 汇总
 * ================================================================== */
echo "\n----------------------------------------\n";
echo "生成完成：成功 {$stat['ok']} 个，失败 {$stat['fail']} 个\n";
exit($stat['fail'] > 0 ? 1 : 0);
