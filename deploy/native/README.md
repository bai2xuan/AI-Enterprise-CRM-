# 本地便携栈部署（Windows，无需 Docker）

在 Windows 上使用便携版 PHP + MariaDB 直接运行本项目，**不安装任何系统服务**，
所有运行环境都放在项目目录内，删除目录即彻底卸载。

---

## 一、运行环境规格

| 组件 | 版本 | 目录 |
|---|---|---|
| PHP | 8.3.x NTS | `tools/php/` |
| MariaDB | 10.11.19 | `tools/mariadb-10.11.19-winx64/` |
| 数据库数据 | — | `data/mysql/` |
| 凭据文件 | — | `data/.pw` |

> `tools/`、`data/` 均已被 `.gitignore` 排除，**不会进入仓库**，需要自行准备。

---

## 二、服务端口

| 服务 | 端口 | 说明 |
|---|---|---|
| Web（PHP 内置服务器） | `8080` | 必须用 `localhost` 访问 |
| MariaDB | `3307` | 刻意避开系统默认的 3306 |

> ⚠️ 访问地址请使用 `http://localhost:8080/index.php`，
> **不要改成 `127.0.0.1`**。`site_url` 配置为 `localhost`，
> 用 IP 访问会导致会话 Cookie 与站点不一致，出现"登录后又跳回登录页"。

---

## 三、数据库配置

配置文件：`tools/mariadb-10.11.19-winx64/my.ini`

| 项 | 值 |
|---|---|
| 端口 | `3307` |
| 数据目录 | `data/mysql` |
| 数据库名 | `suitecrm`（utf8mb4） |
| 应用账号 | `suitecrm` |
| 统一密码 | 存放于 `data/.pw` |

> **密码读取约定**：项目所有脚本一律通过 `data/.pw` 读取密码，
> **不在任何文件中硬编码凭据**。请勿把密码明文写进脚本或命令行参数。

---

## 四、启动服务

需要两个终端窗口（或用 `start /B` 后台启动）：

```bash
# 窗口 1：启动数据库
tools/mariadb-10.11.19-winx64/bin/mysqld.exe --defaults-file=tools/mariadb-10.11.19-winx64/my.ini

# 窗口 2：启动 Web 服务
tools/php/php.exe -S 127.0.0.1:8080 -t crm
```

访问 `http://localhost:8080/index.php`。

默认演示账号见项目根目录 [`README.md`](../../README.md)。

---

## 五、首次部署完整流程

```bash
# ── 步骤 0：准备 SuiteCRM 上游源码（本仓库不含） ──────────────
# 下载 SuiteCRM 7.15.2 发布包，解压到 crm/
#   下载地址：https://github.com/SuiteCRM/SuiteCRM/releases/tag/v7.15.2
#   解压时请选择「不覆盖已存在文件」，以免冲掉本项目的定制内容

# ── 步骤 1：释放语言包与兼容补丁 ──────────────────────────────
bash deploy/native/apply-overlay.sh

# ── 步骤 2：配置静默安装 ──────────────────────────────────────
# 复制模板并按需修改数据库连接信息
cp crm/config_si.php.example crm/config_si.php

# ── 步骤 3：执行静默安装 ──────────────────────────────────────
# 浏览器访问（安装完成后即可登录）
#   http://localhost:8080/install.php?goto=SilentInstall&cli=true

# ── 步骤 4：让自研模块生效 ────────────────────────────────────
tools/php/php.exe scripts/setup/register-modules.php
tools/php/php.exe scripts/setup/apply-locale-preferences.php
tools/php/php.exe scripts/setup/repair.php

# ── 步骤 5：生成演示数据 ──────────────────────────────────────
tools/php/php.exe scripts/data/seed-demo-data.php --reset
tools/php/php.exe scripts/data/prepare-screenshot-targets.php

# ── 步骤 6：验收 ──────────────────────────────────────────────
tools/php/php.exe scripts/verify/verify-customizations.php
tools/php/php.exe scripts/verify/verify-automation.php
```

> **步骤 1 不可省略**。SuiteCRM 7.15.x 的静默安装存在上游缺陷，
> 缺少 `modules/UpgradeWizard/uw_utils.php` 会导致安装立即中断，
> 详见 [`../patches/README.md`](../patches/README.md)。

---

## 六、常见问题

| 现象 | 原因 | 处理 |
|---|---|---|
| 登录后又跳回登录页 | 用了 `127.0.0.1` 访问 | 改用 `localhost` |
| 界面显示 `LBL_XXX` 键名 | 模块语言缓存未失效 | 重跑 `scripts/setup/repair.php`（已内置缓存清理） |
| 新模块不出现在导航栏 | 未写入导航可见性配置 | 重跑 `scripts/setup/register-modules.php` |
| 详情页只有标题、内容空白 | 视图布局 `tabDefs` 未设置 `newTab` | 参见 `docs/系统设计文档.md` 技术难点章节 |
| 静默安装报 `Failed opening required` | 未应用兼容补丁 | 执行 `bash deploy/native/apply-overlay.sh` |
| 数据库连不上 | 3306 被占用 / 未启动 | 确认使用 3307 端口，并检查 `my.ini` |
| 想恢复初始演示数据 | 数据被改乱 | `php scripts/data/seed-demo-data.php --reset` |

---

## 七、停止与清理

```bash
# 停止服务：直接关闭对应终端窗口，或结束进程
taskkill /F /IM mysqld.exe
taskkill /F /IM php.exe
```

如需彻底清理，删除 `tools/` 与 `data/` 目录即可——
项目所有运行环境与数据都在其中，不会残留任何系统级痕迹。
