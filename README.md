# AI Enterprise CRM

> 面向 **AI 企业解决方案销售团队** 的客户管理与销售流程优化平台
> 基于开源 CRM **SuiteCRM** 的二次开发项目

[![SuiteCRM](https://img.shields.io/badge/SuiteCRM-7.15.2-blue)](https://github.com/SuiteCRM/SuiteCRM)
[![PHP](https://img.shields.io/badge/PHP-8.3-777bb4)](https://www.php.net/)
[![MariaDB](https://img.shields.io/badge/MariaDB-10.11-003545)](https://mariadb.org/)
[![License](https://img.shields.io/badge/License-AGPL--3.0-green)](LICENSE.txt)

---

## 一、项目介绍

### 1.1 背景

模拟企业 **"智联AI科技有限公司"** 的销售团队日常业务：向制造业、金融业、软件业、政府机构等企业客户销售四类 AI 解决方案：

| 产品 | 说明 |
|---|---|
| 企业 AI 知识库 | 沉淀企业知识资产，降低客服与培训成本 |
| AI 客服系统 | 7×24 智能应答，降低人工客服成本 |
| AI 办公助手 | 文档处理、会议纪要、流程提效 |
| 数据智能分析平台 | 多源数据接入与经营分析 |

**业务痛点**：B 端 AI 解决方案的销售周期长、决策链复杂、售前与交付协同要求高。通用 CRM 无法承载行业特有的销售流程与客户画像。

### 1.2 项目定位

**不重新开发 CRM**，而是基于成熟开源项目进行 **企业业务场景二次开发**：

- ✅ 复用 SuiteCRM 的企业级能力（权限体系、工作流引擎、报表、REST API）
- ✅ 通过**扩展机制**（字段扩展、模块新增、流程重构、看板增强）改造为 AI 解决方案销售专用系统
- ❌ 不修改 SuiteCRM 核心源码，保证可平滑升级

### 1.3 项目价值

本项目重点体现 **B 端业务理解、产品设计、企业流程优化、客户需求分析、项目推进** 五项能力，适用于产品、售前、实施、客户成功、项目管理等岗位的能力证明。

### 1.4 核心成果速览

| 维度 | 成果 |
|---|---|
| 功能模块 | 2 个原生模块扩展（客户、商机）+ 3 个自定义模块（需求调研、销售看板、项目交接） |
| 字段扩展 | 客户新增 12 个字段；商机新增产品类型/输单原因等；两个自定义模块共 30+ 字段 |
| 业务自动化 | 4 条自动化规则，其中「成交→自动生成交接单+派待办」为完整闭环，含幂等与防重入 |
| 数据可视化 | 6 项核心 KPI + 5 张 ECharts 图表（本地资源，无外网依赖） |
| 本地化 | 全站中文化（语言包扩展，未改核心）；日期 `Y-m-d`、货币 ¥ |
| 质量保障 | 定制项验收 **96/96 通过**；业务自动化验收 **7/7 通过**；HTTP 冒烟 14 页全 200 |
| 工程规范 | 核心源码零改动；应用层定制文件 127 个全部走 `custom/` 扩展路径；Git 分阶段提交 |
| 交付文档 | 9 份文档 + 14 张界面截图 + 323 个入库文件 |

---

## 二、开源项目来源

| 项 | 说明 |
|---|---|
| 开源项目 | **SuiteCRM** |
| 仓库地址 | https://github.com/SuiteCRM/SuiteCRM |
| 使用版本 | **7.15.2**（Release 包） |
| 开源协议 | AGPL-3.0 |
| 选型理由 | 成熟的企业级 CRM，具备销售自动化、工作流、报表、多语言、RBAC 等完整 B 端能力；同时拥有成熟的扩展机制，适合作为二次开发底座 |

> **本仓库不包含 SuiteCRM 上游源码**。作为二次开发作品仓库，这里只收录本项目编写的定制内容，
> 上游源码由部署流程获取（详见 [第九章](#九目录结构) 与 [`docs/仓库结构说明.md`](docs/仓库结构说明.md)）。

### 采用的开源能力（未修改）

- **客户管理 Accounts** —— 客户主数据
- **联系人管理 Contacts** —— 客户联系人
- **线索管理 Leads** —— 线索池与转化
- **商机管理 Opportunities** —— 销售管道
- **活动管理 Calls / Meetings / Tasks** —— 跟进记录
- **工作流引擎 Workflow** —— 自动化规则
- **报表 AOR_Reports / 仪表盘 Dashlets** —— 数据分析
- **用户与权限 Users / Roles（RBAC）** —— 组织与权限
- **REST API（V8）** —— 系统集成

---

## 三、二次开发内容

### 3.1 开发方式说明

所有改造均落在 SuiteCRM 官方支持的扩展路径中，**不触碰核心源码**：

```
扩展分层
├── 配置层  Studio / 管理后台        → 下拉项、页面布局、标签、权限
├── 扩展层  custom/ + vardefs 覆盖   → 字段追加、模块新增、逻辑钩子
├── 增强层  自定义 Dashlet / 报表     → 销售看板、漏斗分析
└── 核心层  SuiteCRM 原生代码        → 【不修改】
```

### 3.2 五大模块改造清单

| # | 模块 | 类型 | 说明 |
|---|---|---|---|
| 1 | **AI 企业客户管理增强** | 扩展 Accounts | 新增企业信息、客户价值、业务需求、负责人共 12 个字段，构建 AI 客户画像 |
| 2 | **AI 解决方案销售流程** | 重构 Opportunities | 产品类型字段 + 7 段式销售阶段 + 成交概率联动 + 输单原因 |
| 3 | **客户需求调研模块** | 新增模块 `CReq_CustomerRequirements` | 售前需求分析工作台，可关联客户与商机 |
| 4 | **销售漏斗分析看板** | 新增模块 `AID_SalesAnalytics` | 6 项核心指标 + 5 张 ECharts 分析图表（自研视图，非报表拼装） |
| 5 | **销售到交付流程** | 新增模块 `Hand_ProjectHandovers` + 逻辑钩子 | 商机成交后**自动**生成项目交接单并派发交接待办，打通销售→售前→交付 |

> 详细设计见 [`docs/功能规划说明书.md`](docs/功能规划说明书.md)

**改动量统计**：323 个入库文件，全部落在 `crm/custom/`、`crm/modules/<新增模块>/`、`crm/config_override.php`、`deploy/`、`docs/`、`scripts/`、`screenshots/` 范围内；SuiteCRM 核心源码零改动。

> 唯一需要写入核心目录的内容是安装期兼容补丁 `modules/UpgradeWizard/uw_utils.php`
> （用于绕开 SuiteCRM 7.15.x 自身的静默安装缺陷），它以
> [`deploy/patches/`](deploy/patches/README.md) 的形式存放，由部署脚本释放，不直接提交进 `crm/modules/`。

---

## 四、系统架构

```
┌──────────────────────────────────────────────────────────────┐
│                      浏览器 (Chrome / Edge)                    │
└───────────────────────────┬──────────────────────────────────┘
                            │ HTTP
┌───────────────────────────▼──────────────────────────────────┐
│  Web 层    Apache 2.4  /  PHP 内置服务器（开发环境）            │
├──────────────────────────────────────────────────────────────┤
│  应用层    SuiteCRM 7.15.2                                    │
│            ├─ 原生模块（扩展）：Accounts · Opportunities       │
│            ├─ 原生模块（复用）：Contacts / Leads / Calls /     │
│            │                    Meetings / Tasks              │
│            ├─ 定制模块：CReq_CustomerRequirements（需求调研）  │
│            │            Hand_ProjectHandovers（项目交接）      │
│            │            AID_SalesAnalytics（销售分析看板）     │
│            ├─ 扩展层：custom/ · vardefs · layoutdefs ·         │
│            │           language ext · logic hooks             │
│            └─ 图表层：本地 ECharts 5.5.1（无外网依赖）         │
├──────────────────────────────────────────────────────────────┤
│  运行时    PHP 8.3.35 (NTS)                                   │
├──────────────────────────────────────────────────────────────┤
│  数据层    MariaDB 10.11.19 (utf8mb4)                         │
└──────────────────────────────────────────────────────────────┘
```

**数据流（模块 5 业务自动化）**

```
商机进入「成交」阶段
        │  after_save 逻辑钩子
        ▼
┌───────────────────┐   ┌────────────────────┐   ┌──────────────────┐
│ 幂等查重           │──▶│ 创建项目交接单      │──▶│ 建立客户/商机关联 │
│ (按 opportunity_id)│   │ 继承客户·产品·金额  │   │ + 派发交接待办    │
└───────────────────┘   └────────────────────┘   └──────────────────┘
```

### 技术栈

| 层 | 组件 | 版本 | 说明 |
|---|---|---|---|
| 应用 | SuiteCRM | 7.15.2 | 开源企业级 CRM |
| 运行时 | PHP | 8.3.35 (NTS) | 官方兼容矩阵支持 8.1–8.4 |
| 数据库 | MariaDB | 10.11.19 LTS | SuiteCRM 官方推荐 |
| Web 服务 | Apache 2.4 / PHP CLI Server | — | 生产 Apache，开发 PHP 内置服务器 |
| 容器 | Docker / Docker Compose | — | 仓库交付的标准化部署方式 |
| 图表 | ECharts | 5.5.1 | **本地部署**，无外网依赖 |
| 自动化测试 | Playwright-core + 系统 Chrome | — | 界面截图自动化 |
| 版本管理 | Git | 2.x | 全过程留痕，分阶段提交 |

---

## 五、功能介绍

### 5.1 客户生命周期管理（扩展 Accounts）

覆盖 **线索 → 客户 → 商机 → 成交** 全链路。在原生客户模块上新增 **12 个业务字段**，
按四个面板分组呈现：

| 面板 | 字段 | 业务含义 |
|---|---|---|
| **企业基础信息** | 公司规模 `company_size_c` | 判断方案承载量级（小型/中型/大型/集团） |
| | 企业类型 `enterprise_type_c` | 民企/国企/外企/政府/事业单位 |
| | 所属行业 `industry` | 复用原生字段，重定义下拉值与中文标签 |
| **客户价值** | 客户等级 `customer_level_c` | A/B/C/D 四级，决定资源投入优先级 |
| | 潜在价值 `potential_value_c` | 预估合同价值，支撑漏斗金额预测 |
| | 客户来源 `customer_source_c` | 渠道效果归因 |
| **业务与需求信息** | 当前痛点 `current_pain_points_c` | 方案匹配依据 |
| | 使用系统 `current_system_c` | 判断替换或集成难度 |
| | 预算范围 `budget_range_c` | 判断方案档位 |
| | 决策周期 `decision_cycle_c` | 预测成交时间 |
| **负责人** | 销售负责人 `sales_owner_c` | 关联用户（relate 字段） |
| | 售前负责人 `presales_owner_c` | 关联用户（relate 字段） |

> **设计要点**：新增字段统一使用 `_c` 后缀，避免与原生字段冲突；`industry` 直接复用
> 原生字段并覆盖下拉选项，比新建字段更规范，也不会破坏报表与搜索。

### 5.2 AI 解决方案销售商机管理（重构 Opportunities）

| 项 | 内容 |
|---|---|
| 产品类型 | `product_type_c`：AI知识库 / AI客服 / AI办公助手 / 数据分析平台 |
| 销售阶段 | 7 段：初步接触 → 需求调研 → 方案设计 → 产品演示 → 商务谈判 → **成交** / **输单** |
| 成交概率 | `probability`：随销售阶段自动联动（阶段变更时逻辑钩子写入对应概率） |
| 输单原因 | `lost_reason_c`：价格 / 功能不匹配 / 竞品 / 预算取消 / 决策延期 等 |
| 下一步计划 | `next_step`：复用原生字段并中文化，避免重复建字段 |
| 关键金额 | `amount`：预计金额（原生），驱动漏斗与预测统计 |

> **设计要点（重要）**：SuiteCRM 内部以英文 Key（`Closed Won` / `Closed Lost`）判定商机关闭
> 状态并驱动漏斗与预测统计，且该 Key 被硬编码在搜索条件、列表视图、Dashlet 数据源等多处。
> 本项目**保留英文 Key 不变，仅将显示标签中文化**，确保中文化的界面不破坏统计逻辑。

### 5.3 客户需求调研模块（新模块 `CReq_CustomerRequirements`）

售前顾问的需求分析工作台，共 **13 个业务字段 + 2 个关联关系**，按面板分组：

| 面板 | 字段 |
|---|---|
| 基本信息 | 需求编号 `req_no_c`、需求状态 `req_status_c`、需求优先级 `priority_c` |
| 客户背景与痛点 | 客户背景 `customer_background_c`、业务痛点 `current_pain_points_c`、现有系统 `current_system_c` |
| 需求描述 | 功能需求 `functional_req_c`、技术需求 `technical_req_c`、期望解决方案 `expected_solution_c`、需求描述 `requirement_desc_c` |
| 商务与决策信息 | 预算金额 `budget_c`、关键决策人 `key_decision_maker_c`、竞争方案 `competitor_c` |
| 风险与责任人 | 风险事项 `risk_factor_c`、期望上线时间 `go_live_date_c` |
| 关联关系 | 关联**客户** `account_id`、关联**商机** `opportunity_id` |

> 售前调研结论由"散落邮件与文档"变为"结构化档案"，可被销售、交付双向复用与统计。

### 5.4 销售漏斗分析看板（自研模块 `AID_SalesAnalytics`）

销售管理者的一页式经营看板，通过 `AID_SalesAnalytics` 模块的自定义视图渲染，
图表使用本地部署的 **ECharts 5.5.1**（无外网依赖）。

**6 项核心指标**

| 指标 | 口径 |
|---|---|
| 客户总数 | `accounts` 有效记录数 |
| 商机总数 | `opportunities` 有效记录数 |
| 预计销售金额 | 未关闭商机的 `amount` 合计 |
| 成交金额 | `sales_stage = Closed Won` 的 `amount` 合计 |
| 整体成交率 | 成交商机数 / 商机总数 |
| 平均成交周期 | 成交商机的 `date_entered` → 关闭日 的天数均值 |

**5 张分析图表**

| 图表 | 类型 | 口径 |
|---|---|---|
| 销售漏斗 | 漏斗图 | **累计口径**：进入该阶段及之后所有阶段的商机数（28→24→18→13→9→6） |
| 产品销售金额 | 柱状图 | 按产品类型汇总金额 |
| 行业客户分布 | 饼图 | 按企业行业统计客户数（占比标签） |
| 输单原因分析 | 柱状图 | 按输单原因统计数量（Tooltip 带出金额） |
| 销售阶段分布 | 柱状图 | 各阶段商机数与金额 |

> **口径说明**：漏斗采用「累计到达口径」而非「当前停留口径」。例如"进入需求调研阶段"=
> 当前处于需求调研阶段及之后所有阶段的商机总和，符合标准销售漏斗语义，也避免演示数据中
> 后期阶段堆积导致漏斗倒挂。

### 5.5 销售到项目交付流程（模块 `Hand_ProjectHandovers` + 业务自动化）

商机成交（`Closed Won`）后，**逻辑钩子自动**完成三件事，无需人工干预：

1. 生成 **项目交接单**（编号 `HT-YYYY-####`），自动继承商机的客户、产品类型、合同金额、币种、负责人；
2. 建立「客户 ↔ 交接单」「商机 ↔ 交接单」关系记录，保证 360° 视图可追溯；
3. 向交接负责人派发「项目交接准备」待办任务。

**交接单字段**（共 15 个）

| 面板 | 字段 |
|---|---|
| 基本信息 | 交接单号 `handover_no_c`、交接状态 `handover_status_c`、交接日期 `handover_date_c`、客户名称 `account_id`、关联商机 `opportunity_id` |
| 合同与计划 | 购买产品 `product_type_c`、合同金额 `contract_amount_c`、合同范围 `contract_scope_c`、实施周期 `implementation_cycle_c`、计划启动日期 `start_date_c` |
| 需求描述 | 项目目标 `project_goal_c`、客户需求 `customer_requirement_c`、承诺功能 `committed_features_c` |
| 风险与责任人 | 风险事项 `risk_items_c`、验收标准 `acceptance_criteria_c`、交付负责人 `delivery_owner` |

> **工程保障**：钩子内置 **幂等**（按 `opportunity_id` 查重，已有交接单则补全不重复创建）与
> **防重入**（运行标志位）双重保护，重复保存商机不会产生脏数据。验收脚本
> `scripts/verify/verify-automation.php` 提供 7 项断言，可重复执行并自动回滚。

### 5.6 业务自动化汇总

| 自动化 | 触发条件 | 动作 | 落地方式 |
|---|---|---|---|
| 成交自动建交接单 | 商机 `sales_stage` 变为 `Closed Won` | 创建交接单 + 建关系 + 派待办 | 逻辑钩子 `after_save` |
| 成交概率联动 | 销售阶段变更 | 自动写入对应成交概率 | 逻辑钩子（模块 2） |
| 客户简称自动生成 | 新建/修改客户名称 | 生成检索友好简称 | 逻辑钩子（模块 1） |
| 中文化显示 | 全站 | 界面全中文（含日期 `Y-m-d`、货币 ¥） | 语言包扩展 + 用户偏好 |

---

## 六、部署方式

项目提供 **双轨部署方案**：仓库交付 Docker 配置（可移植、一键启动），本地开发/演示使用
便携 PHP + MariaDB 栈（无需安装 Docker，Windows 双击即用）。

### 方式一：Docker 部署（推荐 / 可移植）

```bash
cd deploy/docker
cp .env.example .env          # 按需修改数据库/管理员密码
docker compose up -d --build  # 首次启动会自动完成 SuiteCRM 静默安装
```

访问 http://localhost:8080

- **登录地址**：`http://localhost:8080/index.php`
- **默认账号**：`admin` / 见 `.env` 中的 `ADMIN_PASSWORD`

停止与清理：

```bash
docker compose down           # 停止（保留数据）
docker compose down -v        # 停止并删除数据卷
```

### 方式二：本地便携部署（Windows，无需 Docker）

> 完整说明（含常见问题排查）见 [`deploy/native/README.md`](deploy/native/README.md)

**① 准备运行环境**

项目内置便携运行环境，位于 `tools/`（**不入库**，约 552 MB，需自行准备）：

| 组件 | 目录 | 端口 |
|---|---|---|
| PHP 8.3.35 (NTS) | `tools/php/` | 8080 |
| MariaDB 10.11.19 | `tools/mariadb-10.11.19-winx64/` | 3307 |

**② 释放部署资源**

本仓库不含 SuiteCRM 上游源码，需先下载并解压：

```bash
# 下载 SuiteCRM 7.15.2 并解压到 crm/（选择"不覆盖已存在文件"）
#   https://github.com/SuiteCRM/SuiteCRM/releases/tag/v7.15.2

# 释放中文语言包与静默安装兼容补丁
bash deploy/native/apply-overlay.sh
```

**③ 启动数据库**

```bash
tools/mariadb-10.11.19-winx64/bin/mysqld.exe \
  --defaults-file=tools/mariadb-10.11.19-winx64/my.ini
```

**④ 启动 Web 服务**

```bash
tools/php/php.exe -S 127.0.0.1:8080 -t crm
```

> ⚠️ 请使用 `http://localhost:8080/index.php` 访问，不要用 `127.0.0.1`——
> 与 `config.php` 中 `site_url` 不一致会导致登录会话丢失。

**⑤ 静默安装**

```bash
cp crm/config_si.php.example crm/config_si.php   # 按需修改数据库连接信息
# 浏览器访问完成安装：
#   http://localhost:8080/install.php?goto=SilentInstall&cli=true
```

**⑥ 初始化定制内容（按顺序执行一次）**

```bash
tools/php/php.exe scripts/setup/repair.php                    # 重建扩展 + 同步字段到数据库
tools/php/php.exe scripts/setup/register-modules.php          # 注册 ACL 动作 + 导航
tools/php/php.exe scripts/setup/apply-locale-preferences.php  # 统一日期/时间/货币显示偏好
tools/php/php.exe scripts/data/seed-demo-data.php --reset     # 生成模拟数据（可选）
tools/php/php.exe scripts/data/prepare-screenshot-targets.php # 挑选截图用代表性记录（可选）
```

**⑦ 自检与验收（可选）**

```bash
tools/php/php.exe scripts/setup/healthcheck.php               # 部署自检
tools/php/php.exe scripts/verify/verify-customizations.php    # 定制项验收（96 项）
tools/php/php.exe scripts/verify/verify-automation.php        # 业务自动化验收（7 项）
```

> 脚本索引与每个脚本的用途说明见 [`scripts/README.md`](scripts/README.md)。

- **默认账号**：`admin` / `Admin@123456`（演示环境统一密码，生产请立即修改）

### 部署参数说明

| 参数 | 默认值 | 说明 |
|---|---|---|
| 访问端口 | 8080 | Docker 可在 `.env` 中通过 `HTTP_PORT` 修改 |
| 数据库端口 | 3307（本地）/ 3306（Docker） | MariaDB 实例端口，本地用 3307 避开系统 3306 |
| 数据库名 | `suitecrm` | utf8mb4 |
| 数据库账号 | `suitecrm` | 应用连接账号 |
| 管理员账号 | `admin` | 本地演示为 `Admin@123456`，首次登录后请立即修改 |

---

## 六·补、模拟数据规模

`scripts/data/seed-demo-data.php` 生成的演示数据（模拟公司"智联AI科技有限公司"）：

| 数据 | 数量 | 说明 |
|---|---|---|
| 客户 Accounts | 20 | 覆盖制造/金融/软件/政府/医疗/教育等行业 |
| 联系人 Contacts | 12 | 关键决策人 |
| 商机 Opportunities | 30 | 分布在各销售阶段，含成交/输单样本 |
| 需求调研 CReq | 20 | 关联客户与商机 |
| 项目交接单 Hand | 6 | 与 6 个成交商机一一对应（编号 `HT-2026-0001`~`0006`） |
| 跟进记录 Calls/Meetings/Tasks | 50 | 真实销售跟进轨迹 |

> 演示主账号为内置 `admin`（姓名"张浩然"、职务"销售经理"），保证首页 Dashlet
> 「我的商机 / 我的客户」有数据；另有 `lisiyuan`（李思远）、`wangxuefeng`（王雪峰）
> 两个业务用户，密码同上。

---

## 七、项目截图

> 截图存放于 [`screenshots/`](screenshots/) 目录，共 **14 张**，由
> `scripts/tools/capture-screenshots.js`（Playwright + 系统 Chrome）自动生成。

| 序号 | 页面 | 文件 | 展示要点 |
|---|---|---|---|
| 1 | 登录页 | `01-login.png` | 中文化的登录界面 |
| 2 | 首页工作台 | `02-home.png` | 「我的商机 / 我的客户 / 销售漏斗」Dashlet |
| 3 | **销售分析看板** | `03-analytics-dashboard.png` | 6 KPI + 5 图表（模块 4 核心产出） |
| 4 | 客户列表 | `04-accounts-list.png` | 中文化列头 + 客户等级 |
| 5 | 客户详情 | `05-account-detail.png` | AI 客户画像面板 |
| 6 | 客户详情·价值页签 | `06-account-value.png` | 客户价值 / 业务需求面板（页签切换） |
| 7 | 客户编辑页 | `07-account-edit.png` | 新增 12 字段的分组布局 |
| 8 | 商机列表 | `08-opportunities-list.png` | 产品类型 + 销售阶段 + 金额 |
| 9 | 商机详情 | `09-opportunity-detail.png` | 7 段式销售阶段与下一步行动 |
| 10 | 商机编辑页 | `10-opportunity-edit.png` | 产品/阶段/概率联动表单 |
| 11 | **需求调研列表** | `11-requirements-list.png` | 模块 3 工作台 |
| 12 | 需求调研详情 | `12-requirement-detail.png` | 需求分析字段与关联客户 |
| 13 | **项目交接单列表** | `13-handovers-list.png` | 模块 5 自动生成的交接单 |
| 14 | 项目交接单详情 | `14-handover-detail.png` | 交付信息与验收标准 |

---

## 八、项目文档

| 文档 | 路径 | 说明 |
|---|---|---|
| 产品需求文档 | [`docs/产品需求文档.md`](docs/产品需求文档.md) | 业务背景、用户角色、痛点、F1~F5 功能需求、业务价值 |
| 功能规划说明书 | [`docs/功能规划说明书.md`](docs/功能规划说明书.md) | 模块规划、字段清单、ER 图、实施路线图 |
| 系统设计文档 | [`docs/系统设计文档.md`](docs/系统设计文档.md) | 架构、扩展加载链路、数据模型、12 项技术难点与解决记录 |
| 二次开发说明 | [`docs/二次开发说明.md`](docs/二次开发说明.md) | 原生能力复用清单 vs 扩展内容、核心代码零改动声明 |
| 测试报告 | [`docs/测试报告.md`](docs/测试报告.md) | 8 组功能测试用例、HTTP 冒烟、自动化验收、12 项缺陷记录 |
| 简历项目描述 | [`docs/简历项目描述.md`](docs/简历项目描述.md) | 产品岗 / 售前岗 / 实施岗三个岗位版本的表述 |
| **项目全景与技术亮点说明** | [`docs/项目全景与技术亮点说明.md`](docs/项目全景与技术亮点说明.md) | **10 分钟读懂全项目 + 简历素材一键提炼（推荐先读）** |
| 仓库结构说明 | [`docs/仓库结构说明.md`](docs/仓库结构说明.md) | 仓库组织规范、目录职责、入库范围与校验方法 |
| 仓库文件清单 | [`docs/仓库文件清单.md`](docs/仓库文件清单.md) | 全部 323 个入库文件的目录树与完整清单 |
| 贡献指南 | [`CONTRIBUTING.md`](CONTRIBUTING.md) | 开发约定、提交规范、提交前检查清单 |
| 更新日志 | [`CHANGELOG.md`](CHANGELOG.md) | 版本演进与 12 项缺陷修复记录 |

---

## 九、目录结构

> 本仓库**只收录本项目的二次开发成果**，SuiteCRM 上游源码与本地运行环境不入库。
> 完整说明见 [`docs/仓库结构说明.md`](docs/仓库结构说明.md)。

```
ai-enterprise-crm/
├── README.md                     项目说明（本文件）
├── LICENSE                       AGPL-3.0 许可证全文
├── CHANGELOG.md                  版本更新日志
├── CONTRIBUTING.md               贡献指南与开发约定
├── .gitignore                    精确白名单（决定什么进仓库）
├── .gitattributes                换行符规范 + 语言统计标注
├── .editorconfig                 编辑器配置统一
├── .github/                      Issue / PR 模板
│
├── crm/                          ★ 应用层：SuiteCRM 二次开发成果（127 个文件）
│   ├── custom/                   二次开发扩展目录（81 个文件）
│   │   ├── Extension/            扩展【源码】Vardefs / Layoutdefs / Language / LogicHooks
│   │   ├── modules/              视图布局覆盖 + 成交自动交接钩子实现
│   │   └── include/              ECharts 本地库 + 顶部导航配置
│   ├── modules/
│   │   ├── AID_SalesAnalytics/        ← 模块 4：销售分析看板
│   │   ├── CReq_CustomerRequirements/ ← 模块 3：需求调研
│   │   └── Hand_ProjectHandovers/     ← 模块 5：项目交接
│   ├── config_override.php       项目定制配置（语言 / 时区 / 货币 / 日期格式）
│   ├── config_si.php.example     静默安装配置模板（不含凭据）
│   └── .htaccess                 SuiteCRM 安全配置
│
├── deploy/                       ★ 部署层：部署资源与方案（149 个文件）
│   ├── docker/                   Docker Compose 一键部署
│   │   ├── docker-compose.yml / Dockerfile / entrypoint.sh
│   │   ├── apache-vhost.conf / php.ini
│   │   └── .env.example          环境变量模板（凭据已脱敏）
│   ├── native/                   Windows 便携栈本地部署
│   │   ├── README.md             完整部署步骤 + 常见问题
│   │   └── apply-overlay.sh      释放语言包与补丁
│   ├── i18n/                     中文语言包（第三方资源，136 个文件）
│   │   ├── manifest.php
│   │   └── zh_CN/                路径镜像 SuiteCRM 应用根目录
│   └── patches/                  部署期兼容补丁
│       └── modules/UpgradeWizard/uw_utils.php
│
├── docs/                         ★ 文档层（9 份）
│   ├── 产品需求文档.md
│   ├── 功能规划说明书.md
│   ├── 系统设计文档.md
│   ├── 二次开发说明.md
│   ├── 测试报告.md
│   ├── 项目全景与技术亮点说明.md
│   ├── 简历项目描述.md
│   └── 仓库结构说明.md
│
├── screenshots/                  ★ 展示层：界面截图（14 张）
│
├── scripts/                      ★ 工具层：脚本工具链（13 个文件）
│   ├── README.md                 脚本索引与调用说明
│   ├── setup/                    部署与初始化（5 个）
│   │   ├── healthcheck.php           部署自检
│   │   ├── reset-admin-password.php  密码重置
│   │   ├── register-modules.php      ACL 动作与导航注册
│   │   ├── apply-locale-preferences.php 显示偏好统一
│   │   └── repair.php                扩展重建 + 语言缓存清理
│   ├── data/                     演示数据（2 个）
│   │   ├── seed-demo-data.php
│   │   └── prepare-screenshot-targets.php
│   ├── verify/                   验收与自检（2 个）
│   │   ├── verify-customizations.php 定制项验收（96 项）
│   │   └── verify-automation.php     业务自动化验收（7 项）
│   ├── dev/                      二次开发辅助（2 个）
│   │   ├── build-modules.php         模块脚手架生成器
│   │   └── gen-viewdefs.php          视图布局生成器
│   └── tools/                    文档产出自动化（1 个）
│       └── capture-screenshots.js    截图自动化
│
├── tools/                        ⊘ 不入库 · 本地运行环境（PHP + MariaDB 便携栈，约 552 MB）
└── data/                         ⊘ 不入库 · 数据库数据与本地凭据（约 214 MB）
```

### 为什么仓库里没有 SuiteCRM 源码

本仓库定位为**二次开发作品仓库**，遵循开源二次开发的通行做法：
只提交自己编写的定制内容，上游源码由部署流程获取。

这样做的收益：

| 维度 | 效果 |
|---|---|
| 仓库体积 | 197 MB → 约 4 MB |
| 克隆速度 | 显著提升 |
| 代码可读性 | 打开仓库看到的就是本项目产出，不被 9,300 个上游文件淹没 |
| 语言统计 | 真实反映本项目的编写量 |
| 升级能力 | 可随时替换上游版本，不与上游修改冲突 |

复现方式（三步）：

```bash
# 1. 下载 SuiteCRM 7.15.2 解压到 crm/（选择"不覆盖已存在文件"）
#    https://github.com/SuiteCRM/SuiteCRM/releases/tag/v7.15.2
# 2. 释放中文语言包与静默安装补丁
bash deploy/native/apply-overlay.sh
# 3. 按 deploy/native/README.md 完成安装、修复重建与演示数据生成
```

---

## 十、已知问题与处理

### 10.1 SuiteCRM 7.15.x 静默安装缺陷

**现象**：使用 `config_si.php` 方式进行静默安装时，安装流程在最开始即中断：

```
PHP Fatal error: Failed opening required 'modules/UpgradeWizard/uw_utils.php'
```

**原因**：SuiteCRM 7.15.x 发布包中移除了 `modules/UpgradeWizard/uw_utils.php`，但 `install/install_utils.php` 第 938 行仍无条件引用该文件。由于 `handleSugarConfig()` 位于安装流程最前端，静默安装必然失败；网页向导式安装因不存在 `config_si.php` 而不受影响。

**处理**：补充上游 7.14.9 版本中该文件的对应实现（`merge_config_si_settings()`），仅补齐缺失函数，不修改任何既有文件。

该补丁存放在 [`deploy/patches/modules/UpgradeWizard/uw_utils.php`](deploy/patches/modules/UpgradeWizard/uw_utils.php)，
由 `bash deploy/native/apply-overlay.sh` 在安装前释放到 `crm/modules/UpgradeWizard/`。
这是本项目**唯一**需要写入 SuiteCRM 核心目录的内容，详见 [`deploy/patches/README.md`](deploy/patches/README.md)。

### 10.2 开发过程踩坑速览

二次开发过程中定位并修复了 12 项缺陷，其中 2 项为阻断级。以下是刷选出的关键几项
（完整根因分析与解决方案见 [`docs/系统设计文档.md`](docs/系统设计文档.md) 第 12 章）：

| # | 现象 | 根因 | 解决 |
|---|---|---|---|
| 1 | **自定义模块详情页只有标题、内容区全空白** | 视图布局 `tabDefs` 所有面板 `newTab=false`，导致 tab 容器为空、面板被 `display:none` | 改为每个面板 `newTab=true` |
| 2 | **销售看板页面渲染成普通空列表** | `action=index` 被框架重映射为 `listview`，自定义视图类未被加载 | 视图文件与类名由 `ViewIndex` 改为 `ViewList` |
| 3 | **平均成交周期为负数** | 数据脚本用了 `$db->quote()`（只转义不加引号），生成的 SQL 语法错误且被静默忽略 | 改用 `$db->quoted()`，并加执行结果校验 |
| 4 | **首页 Dashlet 全空** | 演示数据挂在业务账号下，与当前登录用户不匹配 | 让内置 `admin` 兼任演示主账号 |
| 5 | **新建业务用户无法登录** | 密码哈希算法与 SuiteCRM 不一致 | 改用 `password_hash(strtolower(md5($plain)), PASSWORD_DEFAULT)` |
| 6 | **界面显示 `LBL_XXX` 原始键名** | 模块语言包被缓存在 `cache/modules/.../language/`，扩展合并后未失效 | 建立缓存清理步骤并固化进修复脚本 |

> **关于升级安全性**：上述所有改动均落在 `crm/custom/`、`crm/modules/<新增模块>/` 与
> `config_override.php` 中；SuiteCRM 核心源码零改动，可平滑升级到后续 7.15.x 版本。

---

## 十一、许可与致谢

- 本项目基于 **SuiteCRM** 二次开发，遵循 **[AGPL-3.0](LICENSE)** 开源协议
- 上游项目：https://github.com/SuiteCRM/SuiteCRM
- 中文语言包来源：SuiteCRM 社区 via [Crowdin](https://crowdin.com/project/suitecrmtrans)（见 [`deploy/i18n/README.md`](deploy/i18n/README.md)）

### 关于演示凭据

README 与部署文档中出现的账号密码为**本地演示环境默认值**，
数据库监听在本机 `127.0.0.1:3307`，不对外暴露。
如需部署到可访问的环境，请务必修改：

- `crm/config_si.php` / `deploy/docker/.env`：数据库与管理员密码
- 首次登录后立即在「管理员 → 用户管理」中修改管理员密码

> 仓库中的 `.env.example` 与 `config_si.php.example` 已替换为占位符 `CHANGE_ME_BEFORE_DEPLOY`。
