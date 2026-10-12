# 脚本工具链

本目录按**用途分组**存放项目的部署、数据、验收与开发辅助脚本。
所有脚本均以**项目根目录**为基准定位路径，可在任意位置调用。

```
scripts/
├── setup/     部署与环境初始化（部署时需要）
├── data/      演示数据生成（演示/测试时需要）
├── verify/    验收与自检（提交前必须通过）
├── dev/       二次开发辅助工具（仅开发时使用）
└── tools/     文档产出自动化
```

> 统一调用方式：`tools/php/php.exe scripts/<组>/<脚本>.php`

---

## setup/ · 部署与环境初始化

按部署顺序执行：

| 脚本 | 用途 | 关键说明 |
|---|---|---|
| `reset-admin-password.php` | 重置管理员密码 | 忘记密码或新建演示账号时使用 |
| `register-modules.php` | 让自研模块真正生效 | 注册 ACL 动作、写入导航可见性配置（`MySettings.tab`）、登记报告模块清单 |
| `apply-locale-preferences.php` | 统一本地化显示偏好 | 批量写入日期 `Y-m-d`、时间 `H:i`、货币 `¥` |
| `repair.php` | Quick Repair and Rebuild（CLI 版） | 合并 `custom/Extension` 扩展、重建 vardefs/layoutdefs、**清理模块语言缓存** |
| `healthcheck.php` | 部署自检 | 校验 `config.php`、数据库连通性、admin 账号状态 |

> `repair.php` 内置了自研模块校验清单，若新增模块需同步加入其校验数组。

---

## data/ · 演示数据

| 脚本 | 用途 | 关键说明 |
|---|---|---|
| `seed-demo-data.php` | 生成「智联AI科技」B 端销售模拟数据 | 20 客户 / 30 商机 / 20 需求调研 / 50 跟进记录；`--reset` 先清空再生成 |
| `prepare-screenshot-targets.php` | 挑选代表性记录 | 输出 `data/screenshot-targets.json`，供截图脚本使用 |

```bash
# 重置为原始演示数据
tools/php/php.exe scripts/data/seed-demo-data.php --reset

# 重新挑选截图目标
tools/php/php.exe scripts/data/prepare-screenshot-targets.php
```

> 脚本从 `data/.pw` 读取演示密码，**不硬编码任何凭据**。

---

## verify/ · 验收与自检

| 脚本 | 断言数 | 覆盖范围 |
|---|---|---|
| `verify-customizations.php` | 96 项 | 字段扩展、模块注册、导航与 ACL、中文化完整性、业务自动化注册 |
| `verify-automation.php` | 7 项 | 成交触发、字段继承、状态初值、待办派发、幂等性、自动回滚 |

```bash
tools/php/php.exe scripts/verify/verify-customizations.php
tools/php/php.exe scripts/verify/verify-automation.php
```

- 两者均**可重复执行**，不污染演示数据
- `verify-automation.php` 自带回滚：断言结束后自动清理测试记录
- 提交代码前应确保两组验收全部通过

---

## dev/ · 二次开发辅助

| 脚本 | 用途 | 关键说明 |
|---|---|---|
| `build-modules.php` | 自定义模块脚手架生成器 | 一次性产出模块目录、vardefs、语言包、布局定义与视图 |
| `gen-viewdefs.php` | 视图布局生成器 | 生成 `custom/modules/<模块>/metadata/{editview,detailview}defs.php` |

> `gen-viewdefs.php` 生成的布局文件会被**运行时调用**（如
> `EmailAddress::getSendConfirmOptInEmailActionLinkDefs()`），
> 因此不能用 `var_export` 方式生成，须采用文本拼接。

---

## tools/ · 文档产出自动化

| 脚本 | 用途 | 关键说明 |
|---|---|---|
| `capture-screenshots.js` | 14 张界面截图一键生成 | 基于 playwright-core；需 `data/.pw` 与 `data/screenshot-targets.json` |

```bash
NODE_PATH=<node_modules> node scripts/tools/capture-screenshots.js
```

> SuiteCRM 桌面端页签靠主题 JS 的 `selectTab(index)` 驱动，没有 `href` 锚点，
> 截图脚本通过 `page.evaluate` 模拟点击，详见脚本内注释。
