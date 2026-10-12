<?php
/**
 * ============================================================================
 * 兼容性补丁文件 —— 本文件非 SuiteCRM 官方发布包内容
 * ============================================================================
 *
 * 【问题背景】
 * SuiteCRM 7.15.x（含 7.15.0 / 7.15.1 / 7.15.2）的官方发布包中移除了
 *   modules/UpgradeWizard/uw_utils.php
 * 但是安装程序 install/install_utils.php 第 938 行仍在**无条件**引用该文件：
 *
 *     if (file_exists('config.php') && file_exists('config_si.php')) {
 *         require_once('modules/UpgradeWizard/uw_utils.php');   // ← 致命错误
 *         merge_config_si_settings(false, 'config.php', 'config_si.php');
 *     }
 *
 * 由于 handleSugarConfig() 位于 install/performSetup.php 第 156 行（安装流程最前端），
 * 因此一旦使用「静默安装」（即根目录存在 config_si.php），安装会立即中断：
 *   PHP Fatal error: Failed opening required 'modules/UpgradeWizard/uw_utils.php'
 * 普通网页向导式安装不受影响（因为没有 config_si.php，不会进入该分支）。
 *
 * 【解决方案】
 * 参照 SuiteCRM 7.14.9 中该函数的原始实现，补齐 merge_config_si_settings()，
 * 使静默安装得以正常完成。本文件不修改任何 SuiteCRM 既有文件，
 * 安装完成后可安全删除。
 *
 * 【上游参考】
 *   - 7.14.9 原文件：modules/UpgradeWizard/uw_utils.php
 *   - 相关 issue：SuiteCRM 7.15 silent install fails - uw_utils.php missing
 *
 * @package AI Enterprise CRM (兼容补丁)
 * ============================================================================
 */

if (!function_exists('logThis')) {
    /**
     * 日志占位函数（补丁场景下 write_to_upgrade_log 恒为 false，无需真实落盘）
     */
    function logThis($message, $path = '')
    {
        // 静默模式：不输出，避免污染安装过程的 HTTP 响应
        return true;
    }
}

if (!function_exists('merge_config_si_settings')) {
    /**
     * 将 config_si.php 中的配置项合并进 config.php
     *
     * 合并规则：仅合并「非 setup_ 前缀」且「config.php 中尚不存在」的键，
     * 因此不会覆盖安装器已经写入的正式配置。
     *
     * @param bool   $write_to_upgrade_log 是否写升级日志
     * @param string $config_location      config.php 路径
     * @param string $config_si_location   config_si.php 路径
     * @param string $path                 日志路径前缀
     *
     * @return bool
     */
    function merge_config_si_settings($write_to_upgrade_log = false, $config_location = '', $config_si_location = '', $path = '')
    {
        if (!empty($config_location) && !file_exists($config_location)) {
            if ($write_to_upgrade_log) {
                logThis('config.php file specified in ' . $config_si_location . ' could not be found.  Skip merging', $path);
            }
            return false;
        } elseif (empty($config_location)) {
            global $argv;
            if (isset($argv[3]) && is_dir($argv[3])) {
                $config_location = $argv[3] . DIRECTORY_SEPARATOR . 'config.php';
            }
        }

        if (empty($config_location) || !file_exists($config_location)) {
            if ($write_to_upgrade_log) {
                logThis('config.php file at (' . $config_location . ') could not be found.  Skip merging.', $path);
            }
            return false;
        }

        include($config_location);
        if (empty($sugar_config)) {
            if ($write_to_upgrade_log) {
                logThis('config.php contents are empty.  Skip merging.', $path);
            }
            return false;
        }

        if (!empty($config_si_location) && !file_exists($config_si_location)) {
            if ($write_to_upgrade_log) {
                logThis('config_si.php file specified in ' . $config_si_location . ' could not be found.  Skip merging', $path);
            }
            return false;
        } elseif (empty($config_si_location)) {
            global $argv;
            if (isset($argv[0]) && is_file($argv[0])) {
                $php_file = $argv[0];
                $p_info = pathinfo((string)$php_file);
                $php_dir = (isset($p_info['dirname']) && $p_info['dirname'] != '.') ? $p_info['dirname'] . DIRECTORY_SEPARATOR : '';
                $config_si_location = $php_dir . 'config_si.php';
            }
        }

        if (empty($config_si_location) || !file_exists($config_si_location)) {
            if ($write_to_upgrade_log) {
                logThis('config_si.php file at (' . $config_si_location . ') could not be found.  Skip merging.', $path);
            }
            return false;
        }

        include($config_si_location);
        if (empty($sugar_config_si)) {
            if ($write_to_upgrade_log) {
                logThis('config_si.php contents are empty.  Skip merging.', $path);
            }
            return false;
        }

        // 执行合并：仅补充缺失的非 setup_ 配置项
        $modified = false;
        foreach ($sugar_config_si as $key => $value) {
            if (!preg_match('/^setup_/', (string)$key) && !isset($sugar_config[$key])) {
                $sugar_config[$key] = $value;
                $modified = true;
            }
        }

        if ($modified) {
            if (!write_array_to_file("sugar_config", $sugar_config, $config_location)) {
                if ($write_to_upgrade_log) {
                    logThis('*** ERROR: could not write to config.php', $path);
                }
                return false;
            }
        } else {
            return false;
        }

        return true;
    }
}
