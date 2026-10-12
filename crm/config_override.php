<?php
/***CONFIGURATOR***/
/***CONFIGURATOR***/

/* ============================================================
 * AI Enterprise CRM —— 项目定制配置
 * 说明：config_override.php 在 config.php 之后加载并覆盖其取值，
 *      适合存放本项目定制项（不受 SuiteCRM 升级影响）。
 * ============================================================ */

/* ---------- 默认语言：简体中文 ---------- */
$sugar_config['default_language'] = 'zh_CN';

/* ---------- 启用语言列表 ---------- */
$sugar_config['languages'] = array(
    'en_us' => 'English (US)',
    'zh_CN' => '简体中文',
);

/* ---------- 默认时区 ---------- */
$sugar_config['default_timezone'] = 'Asia/Shanghai';

/* ---------- 默认货币：人民币 CN¥ ---------- */
/* SuiteCRM 用这三个键描述"系统默认货币"，关系到所有金额字段的显示。 */
$sugar_config['default_currency_name'] = '人民币';
$sugar_config['default_currency_symbol'] = '¥';
$sugar_config['default_currency_iso4217'] = 'CNY';
$sugar_config['default_currency_significant_digits'] = '2';

/* ---------- 千分位与小数分隔符（符合中文习惯）---------- */
$sugar_config['default_number_grouping_seperator'] = ',';
$sugar_config['default_decimal_seperator'] = '.';

/* ---------- 日期显示格式 ---------- */
$sugar_config['default_date_format'] = 'Y-m-d';
$sugar_config['default_time_format'] = 'H:i';
