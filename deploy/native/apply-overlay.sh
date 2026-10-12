#!/usr/bin/env bash
# ============================================================
# apply-overlay.sh —— 释放部署期覆盖层到 SuiteCRM 应用目录
# ------------------------------------------------------------
# 作用：
#   1. 把 deploy/patches/ 下的兼容补丁释放进 crm/
#   2. 把 deploy/i18n/zh_CN/ 下的中文语言包释放进 crm/
#
# 用法：
#   bash deploy/native/apply-overlay.sh
#
# 说明：
#   本脚本是幂等的，可重复执行；已存在的文件会被覆盖为新版本。
#   请勿修改本脚本内的相对路径假设（见下方 ROOT 推导）。
# ============================================================

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
DEPLOY_DIR="$(cd "${SCRIPT_DIR}/.." && pwd)"
ROOT="$(cd "${DEPLOY_DIR}/.." && pwd)"

CRM_DIR="${ROOT}/crm"

echo "============================================================"
echo " 释放部署期覆盖层"
echo "============================================================"
echo " 项目根目录 : ${ROOT}"
echo " 目标应用目录: ${CRM_DIR}"
echo

if [ ! -d "${CRM_DIR}" ]; then
    echo "[错误] 未找到应用目录 ${CRM_DIR}"
    echo "       请先把 SuiteCRM 7.15.2 发布包解压到 crm/"
    exit 1
fi

# ---------- 1. 兼容补丁 ----------
echo "[1/2] 释放兼容补丁 ..."
if [ -d "${DEPLOY_DIR}/patches/modules" ]; then
    cp -r "${DEPLOY_DIR}/patches/modules/." "${CRM_DIR}/modules/"
    echo "      -> modules/UpgradeWizard/uw_utils.php"
else
    echo "      [跳过] 未找到 deploy/patches/modules"
fi

# ---------- 2. 中文语言包 ----------
echo "[2/2] 释放中文语言包 ..."
if [ -d "${DEPLOY_DIR}/i18n/zh_CN" ]; then
    cp -r "${DEPLOY_DIR}/i18n/zh_CN/." "${CRM_DIR}/"
    count=$(find "${DEPLOY_DIR}/i18n/zh_CN" -type f | wc -l)
    echo "      -> 已释放 ${count} 个中文本地化文件"
else
    echo "      [跳过] 未找到 deploy/i18n/zh_CN"
fi

# 语言包安装清单（记录语言包来源与版本）
if [ -f "${DEPLOY_DIR}/i18n/manifest.php" ] && [ ! -f "${CRM_DIR}/manifest.php" ]; then
    cp "${DEPLOY_DIR}/i18n/manifest.php" "${CRM_DIR}/manifest.php"
    echo "      -> manifest.php（语言包版本清单）"
fi

echo
echo "============================================================"
echo " 完成。请继续执行："
echo "   1) 配置 crm/config_si.php 后执行静默安装"
echo "   2) php scripts/setup/register-modules.php"
echo "   3) php scripts/setup/repair.php"
echo "   4) php scripts/data/seed-demo-data.php --reset"
echo "============================================================"
