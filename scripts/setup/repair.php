<?php
/**
 * AI Enterprise CRM —— Quick Repair and Rebuild（CLI 版）
 * ------------------------------------------------------------------
 * 让 SuiteCRM 重新扫描 custom/Extension 下的扩展文件，合并到 custom/application/Ext，
 * 并把自定义字段同步到数据库表结构。
 *
 * 用法：php scripts/repair.php
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

chdir(dirname(__DIR__, 2) . '/crm');

require_once 'include/entryPoint.php';
require_once 'modules/Administration/QuickRepairAndRebuild.php';

$repair = new RepairAndClear();

// CLI 环境没有登录会话，需显式把当前用户设为管理员，
// 否则 repairDatabase() 会因权限校验失败而退出。
$adminUser = BeanFactory::getBean('Users');
$adminUser->retrieve_by_string_fields(array('is_admin' => '1', 'deleted' => '0'));
if (empty($adminUser->id)) {
    $adminUser = BeanFactory::getBean('Users', '1');
}
$GLOBALS['current_user'] = $adminUser;
echo "==> 以管理员身份执行：" . $adminUser->user_name . " (id={$adminUser->id})\n";

$admin_strings = return_module_language('zh_CN', 'Administration');
$allModules = isset($admin_strings['LBL_ALL_MODULES']) ? $admin_strings['LBL_ALL_MODULES'] : 'All Modules';

echo "==> Quick Repair and Rebuild 开始\n";

$repair->show_output = true;

// 1. 清缓存 + 重建扩展（把 custom/Extension 合并到 custom/application/Ext）
$repair->clearVardefs();
$repair->clearLanguageCache();
$repair->rebuildExtensions();

// 1.5 重新加载"模块注册表"
//     rebuildExtensions() 刚把 custom/Extension/application/Ext/Include/*.php 合并成
//     custom/application/Ext/Include/modules.ext.php，但 entryPoint.php 在脚本启动时
//     已经加载过旧的 modules.ext.php —— 内存里的 $beanList 还不包含新模块。
//     不重新加载，下面的 repairDatabase() 就不会为新模块建表。
//     注意：本文件运行在全局作用域，include 进来的 $beanList/$moduleList 即全局变量。
$extInclude = 'custom/application/Ext/Include/modules.ext.php';
if (file_exists($extInclude)) {
    include $extInclude;
    $newMods = array();
    foreach (array('CReq_CustomerRequirements', 'Hand_ProjectHandovers', 'AID_SalesAnalytics') as $m) {
        if (isset($beanList[$m])) {
            $newMods[] = $m;
        }
    }
    echo "==> 已重新加载模块注册表，识别到的自定义模块：" . ($newMods ? implode(', ', $newMods) : '（无）') . "\n";
}

// 2. 同步字段到数据库（自动执行 SuiteCRM 生成的 ALTER / CREATE TABLE 语句）
//    $repair->execute = true 是关键：否则 repairDatabase() 只会把 SQL 渲染到
//    一个表单里等用户点击，CLI 下不会真正执行。
$repair->execute = true;
$repair->repairDatabase();

// 3. 清理各类缓存
$repair->clearTpls();
$repair->clearThemeCache();
$repair->clearDashlets();
$repair->clearSearchCache();
$repair->clearJsFiles();
$repair->clearJsLangFiles();

// 4. 显式清理"模块语言缓存"
//    SuiteCRM 会把每个模块的语言包缓存到 cache/modules/<Module>/language/<lang>.lang.php，
//    若不清除，新安装的模块语言扩展不会生效（表现为界面显示 LBL_XXX 原始键名）。
$cacheRoot = dirname(__DIR__, 2) . '/crm/cache/modules';
$removed = 0;
if (is_dir($cacheRoot)) {
    foreach (scandir($cacheRoot) as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $langDir = "$cacheRoot/$entry/language";
        if (is_dir($langDir)) {
            foreach (glob("$langDir/*.lang.php") as $f) {
                if (@unlink($f)) {
                    $removed++;
                }
            }
        }
    }
}
echo "==> 已清理模块语言缓存文件：{$removed} 个\n";

echo "\n[DONE] Quick Repair and Rebuild 完成\n";
