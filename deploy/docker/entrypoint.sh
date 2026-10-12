#!/bin/bash
# ============================================================
# AI Enterprise CRM —— 容器启动脚本
# 职责：
#   1. 等待数据库就绪
#   2. 首次启动时自动生成 config_si.php 并执行 SuiteCRM 静默安装
#   3. 修正目录权限

set -e

cd /var/www/html

echo "============================================================"
echo " AI Enterprise CRM —— 启动中"
echo "============================================================"

DB_HOST="${DB_HOST:-db}"
DB_PORT="${DB_PORT:-3306}"

# ---------- 1. 等待数据库就绪 ----------
echo "[1/4] 等待数据库 ${DB_HOST}:${DB_PORT} ..."
for i in $(seq 1 60); do
    if php -r '
        $c = @mysqli_connect(getenv("DB_HOST"), getenv("DB_ROOT_USER"), getenv("DB_ROOT_PASSWORD"), "", (int)(getenv("DB_PORT") ?: 3306));
        exit($c ? 0 : 1);
    ' 2>/dev/null; then
        echo "      数据库已就绪"
        break
    fi
    sleep 2
done

# ---------- 2. 首次安装 ----------
if [ ! -f /var/www/html/config.php ]; then
    echo "[2/4] 未检测到 config.php，开始首次自动安装 ..."

    # 依据环境变量生成静默安装配置
    cat > /var/www/html/config_si.php <<EOFPHP
<?php
\$sugar_config_si = array(
    'setup_db_type'                       => 'mysql',
    'setup_db_host_name'                  => '${DB_HOST}',
    'setup_db_port_num'                   => '${DB_PORT}',
    'setup_db_database_name'              => '${DB_NAME}',
    'setup_db_sugarsales_user'            => '${DB_USER}',
    'setup_db_sugarsales_password'        => '${DB_PASSWORD}',
    'setup_db_sugarsales_password_retype' => '${DB_PASSWORD}',
    'setup_db_create_database'            => false,
    'setup_db_drop_tables'                => false,
    'setup_db_username_is_privileged'     => true,
    'setup_db_create_sugarsales_user'     => false,
    'dbUSRData'                           => 'same',
    'setup_site_url'                      => '${SITE_URL}',
    'setup_system_name'                   => '${SYSTEM_NAME}',
    'setup_site_sugarbeet'                => false,
    'setup_site_defaults'                 => true,
    'setup_site_sugarbeet_automatic_checks' => false,
    'setup_site_sugarbeet_anonymous_stats'  => false,
    'setup_site_admin_user_name'          => '${ADMIN_USER}',
    'setup_site_admin_password'           => '${ADMIN_PASSWORD}',
    'setup_site_admin_password_retype'    => '${ADMIN_PASSWORD}',
    'site_default_theme'                  => 'SuiteP',
    'default_theme'                       => 'SuiteP',
    'default_language'                    => '${DEFAULT_LANGUAGE}',
    'default_charset'                     => 'UTF-8',
    'default_currency_iso4217'            => 'CNY',
    'default_currency_name'               => '人民币',
    'default_currency_symbol'             => '¥',
    'default_currency_significant_digits' => '2',
    'default_locale_name_format'          => 's f l',
    'default_email_charset'               => 'UTF-8',
    'default_export_charset'              => 'UTF-8',
    'export_delimiter'                    => ',',
    'demoData'                            => 'no',
    'disable_persistent_connections'      => false,
    'setup_site_log_level'                => 'fatal',
    'strict_id_validation'                => false,
);
EOFPHP

    # 启动临时 Web 服务并触发静默安装
    php -S 127.0.0.1:8099 -t /var/www/html >/dev/null 2>&1 &
    TMP_PID=$!
    sleep 3

    curl -s --max-time 600 \
        "http://127.0.0.1:8099/install.php?goto=SilentInstall&cli=true" \
        -o /tmp/install-result.html || true

    kill "$TMP_PID" 2>/dev/null || true
    rm -f /var/www/html/config_si.php

    if [ -f /var/www/html/config.php ]; then
        echo "      安装完成 ✓"
    else
        echo "      !! 安装失败，请检查容器日志：/var/www/html/install.log"
    fi
else
    echo "[2/4] 检测到 config.php，跳过安装"
fi

# ---------- 3. 目录权限 ----------
echo "[3/4] 修正目录权限 ..."
chown -R www-data:www-data /var/www/html
chmod -R 775 \
    /var/www/html/cache \
    /var/www/html/custom \
    /var/www/html/upload \
    /var/www/html/themes \
    /var/www/html/modules 2>/dev/null || true

# ---------- 4. 启动 Apache ----------
echo "[4/4] 启动 Web 服务"
exec "$@"
