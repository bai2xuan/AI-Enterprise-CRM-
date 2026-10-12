#!/bin/bash
# ============================================================
# AI Enterprise CRM —— 容器启动脚本
# 职责：
#   1. 等待数据库就绪
#   2. 首次启动时自动生成 config_si.php 并执行 SuiteCRM 静默安装
#   3. 首次安装后自动初始化：模块注册 / 本地化偏好 / 扩展重建 / 演示数据
#   4. 修正目录权限
#   5. 启动 Apache
#
# 注：第 3 步不可省略 —— 静默安装只会建库建表，
#     自研模块若未写入 config 表的 tab 清单与 acl_actions 表，
#     表现为「能通过 URL 打开，但导航栏里看不到、权限页里不出现」。
# ============================================================

set -e

cd /var/www/html

APP_ROOT=/var/www/html
SCRIPT_ROOT=/opt/aiecrm

echo "============================================================"
echo " AI Enterprise CRM —— 启动中"
echo "============================================================"

DB_HOST="${DB_HOST:-db}"
DB_PORT="${DB_PORT:-3306}"

# ---------- 1. 等待数据库就绪 ----------
echo "[1/5] 等待数据库 ${DB_HOST}:${DB_PORT} ..."
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
FIRST_INSTALL=0
if [ ! -f /var/www/html/config.php ]; then
    FIRST_INSTALL=1
    echo "[2/5] 未检测到 config.php，开始首次自动安装 ..."

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
    echo "[2/5] 检测到 config.php，跳过安装"
fi

# ---------- 3. 初始化自研模块与演示数据（仅首次安装后执行）----------
# 脚本按 <root>/scripts/<组>/x.php 布局、内部以 dirname(__DIR__, 2) 定位应用目录，
# 因此这里把 /opt/aiecrm/crm 软链到真实应用根目录，脚本无需改动即可运行。
if [ "$FIRST_INSTALL" = "1" ] && [ -f "${SCRIPT_ROOT}/scripts/setup/register-modules.php" ]; then
    echo "[3/5] 初始化自研模块与演示数据 ..."
    ln -sfn "${APP_ROOT}" "${SCRIPT_ROOT}/crm"

    # seed-demo-data.php 需要 data/.pw 提供演示账号密码（与 admin 一致）
    mkdir -p "${SCRIPT_ROOT}/data"
    printf '%s' "${ADMIN_PASSWORD}" > "${SCRIPT_ROOT}/data/.pw"

    # 任一步骤失败都不阻断容器启动，仅提示查看日志
    run_step() {
        local desc="$1"; shift
        if "$@" >/tmp/aiecrm-step.log 2>&1; then
            echo "      [OK]   ${desc}"
        else
            echo "      [WARN] ${desc} 失败（不影响启动）"
            tail -n 4 /tmp/aiecrm-step.log | sed 's/^/             /'
        fi
    }

    # 顺序不可颠倒：先 repair（重建扩展 + 建表），再 register（导航 + ACL）
    run_step "重建扩展与数据库表"          php "${SCRIPT_ROOT}/scripts/setup/repair.php"
    run_step "注册模块（导航 + ACL 权限）" php "${SCRIPT_ROOT}/scripts/setup/register-modules.php"
    run_step "统一显示偏好"               php "${SCRIPT_ROOT}/scripts/setup/apply-locale-preferences.php"
    run_step "生成演示数据"               php "${SCRIPT_ROOT}/scripts/data/seed-demo-data.php" --reset

    rm -f "${SCRIPT_ROOT}/data/.pw"
    echo "      初始化完成 —— 演示数据已就绪"
else
    echo "[3/5] 非首次启动，跳过初始化"
fi

# ---------- 4. 目录权限 ----------
echo "[4/5] 修正目录权限 ..."
chown -R www-data:www-data /var/www/html
chmod -R 775 \
    /var/www/html/cache \
    /var/www/html/custom \
    /var/www/html/upload \
    /var/www/html/themes \
    /var/www/html/modules 2>/dev/null || true

# ---------- 5. 启动 Apache ----------
echo "[5/5] 启动 Web 服务"
exec "$@"
