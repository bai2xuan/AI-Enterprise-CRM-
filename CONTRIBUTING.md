# 贡献指南

感谢关注本项目。本仓库是一个**教学与作品集性质**的 SuiteCRM 二次开发示例，
以下约定用于保证代码的可维护性与可复现性。

---

## 一、最重要的三条约定

### 1. 绝不修改 SuiteCRM 核心源码

所有改动必须落在以下路径之一：

| 允许的路径 | 用途 |
|---|---|
| `crm/custom/Extension/**` | 二次开发**源码**：Vardefs / Layoutdefs / Language / LogicHooks |
| `crm/custom/modules/<模块>/metadata/**` | 视图布局覆盖（完整替换，非合并） |
| `crm/modules/<自研模块>/**` | 本项目新增的独立模块 |
| `crm/config_override.php` | 项目定制配置 |

> 唯一的例外是 `deploy/patches/` 下的部署期兼容补丁，它会写入
> `crm/modules/UpgradeWizard/uw_utils.php`，用于绕开 SuiteCRM 7.15.x
> 自身的静默安装缺陷。该补丁在 README 与文档中均有声明。

提交前请自查：

```bash
git diff --name-only <基线提交> HEAD -- crm/ \
  | grep -vE "^crm/(custom/|modules/(AID_SalesAnalytics|CReq_CustomerRequirements|Hand_ProjectHandovers)/|config_override\.php)"
# 预期输出为空
```

### 2. 不要提交生成物与凭据

以下内容已被 `.gitignore` 排除，请勿强制加入：

- SuiteCRM 运行时时产物：`crm/cache/`、`crm/upload/`、`crm/custom/application/`、
  `crm/custom/modules/*/Ext/`
- 含凭据的配置：`crm/config.php`、`crm/config_si.php`、`data/.pw`
- 本地运行环境：`tools/`（PHP + MariaDB 便携栈）、`data/mysql/`

> 注意区分：`crm/custom/**/Ext/` 是**编译产物**（由 Quick Repair 重新生成），
> 而 `crm/custom/Extension/**` 是**源码**，必须提交。

### 3. 保留英文 Key，只中文化显示标签

SuiteCRM 的销售阶段 Key（`Closed Won` / `Closed Lost` 等）被硬编码在
多处统计逻辑中。新增或调整阶段时：

- ✅ 只改语言包中的**显示标签**
- ❌ 不要改 Key 本身，否则漏斗统计与销售预测会失效

---

## 二、开发流程

```bash
# 1. 拉取代码并准备运行环境（详见 README「部署方式」）
# 2. 修改 crm/custom/ 下的扩展源码
# 3. 让扩展生效（把 custom/Extension 合并进 custom/application 并刷新缓存）
tools/php/php.exe scripts/setup/repair.php

# 4. 回归验收
tools/php/php.exe scripts/verify/verify-customizations.php
tools/php/php.exe scripts/verify/verify-automation.php
```

新增模块的推荐路径：

```bash
# 用脚手架生成模块骨架，而不是手工建表建文件
tools/php/php.exe scripts/dev/build-modules.php
```

---

## 三、提交规范

采用 [Conventional Commits](https://www.conventionalcommits.org/zh-hans/)：

```
<类型>(<范围>): <简述>

<可选正文，说明为什么这么改>
```

| 类型 | 含义 |
|---|---|
| `feat` | 新功能（新模块、新字段、新自动化） |
| `fix` | 缺陷修复 |
| `docs` | 仅文档变更 |
| `refactor` | 重构，不改变外部行为 |
| `chore` | 构建、脚本、依赖、配置 |
| `style` | 格式调整（不影响逻辑） |

示例：

```
feat(module4): 销售看板漏斗改为累计到达口径

原口径为各阶段商机数，不符合销售漏斗语义。
改为自下而上累计：上一阶段 = 本阶段 + 更后阶段之和。
```

---

## 四、新增自定义字段的约定

1. 字段名统一加 `_c` 后缀，避免与 SuiteCRM 原生字段冲突
2. 优先复用原生字段（例如成交环节的 `next_step` 已存在，无需新建）
3. 下拉选项的中英文标签需同时补充 `en_us` 与 `zh_CN` 语言包
4. 金额字段必须配套 `currency_id` 与货币下拉框函数
5. 关联字段需同时定义 `name` / `id` / `link` 三件套

---

## 五、提交前检查清单

- [ ] 改动全部落在允许路径内（核心源码零改动）
- [ ] 未提交任何凭据、生成物或本地环境文件
- [ ] 新增语言标签同时覆盖 `en_us` 与 `zh_CN`
- [ ] `verify-customizations.php` 与 `verify-automation.php` 全部通过
- [ ] 涉及界面的改动，已确认页面正常渲染（无 `LBL_` 原始键名外露）
- [ ] 必要时同步更新 `README.md`、`CHANGELOG.md` 与 `docs/`

---

## 六、许可

贡献的代码将以 [AGPL-3.0](LICENSE) 协议发布。提交 Pull Request
即表示您同意以该协议授权。
