# deploy/ · 部署资源

本目录存放**部署期需要、但不属于二次开发源码**的资源。

```
deploy/
├── docker/     Docker Compose 一键部署
├── native/     Windows 便携栈本地部署
├── i18n/       中文语言包（第三方翻译资源）
└── patches/    部署期兼容补丁
```

---

## 部署方式一览

| 方式 | 入口 | 适用场景 |
|---|---|---|
| Docker | [`docker/`](docker/) | 生产 / 演示环境，一条命令起服务 |
| 本地便携栈 | [`native/`](native/) | Windows 免安装体验，无 Docker 环境 |

---

## 为什么语言包与补丁要单独放这里

本仓库只收录**本项目的二次开发成果**，SuiteCRM 上游源码不入库
（详见 [仓库结构说明](../docs/仓库结构说明.md)）。

但以下两类内容虽非本项目编写，却是**系统跑起来所必需的**：

| 目录 | 内容 | 来源 | 处理方式 |
|---|---|---|---|
| `i18n/` | 中文语言包 136 个文件 | SuiteCRM 社区（Crowdin）翻译项目 | 按 SuiteCRM 相对路径镜像存放，由部署脚本释放进 `crm/` |
| `patches/` | `uw_utils.php` 兼容补丁 | 取自 SuiteCRM 7.14.9 上游实现 | 按相对路径镜像，用于绕开 7.15.x 静默安装缺陷 |

把它们放在 `deploy/` 而不是 `crm/`，是为了让仓库里
**"我们写了什么"与"引入了什么第三方资源"一眼可分**。

两份资源均通过 `.gitattributes` 标记为 `linguist-vendored`，
不会计入本项目的语言统计。

---

## 释放顺序

无论哪种部署方式，进入 SuiteCRM 应用目录的内容都遵循同一顺序：

```
1. SuiteCRM 7.15.2 原始发布包       → crm/          （上游源码，不入库）
2. crm/custom/                      → 已随仓库提供   （二次开发源码）
3. crm/modules/<3 个自研模块>/       → 已随仓库提供   （自研模块）
4. deploy/patches/**                → crm/          （补齐缺失文件）
5. deploy/i18n/zh_CN/**             → crm/          （中文化界面）
6. 静默安装 + 修复重建 + 生成演示数据
```

第 4、5 步可用一条命令完成：

```bash
bash deploy/native/apply-overlay.sh
```

第 6 步的执行方式两种部署不同：

| 方式 | 静默安装与初始化 |
|---|---|
| Docker | `docker/entrypoint.sh` 在容器**首次启动时全自动完成**（安装 → repair → 注册模块 → 生成演示数据） |
| 本地便携栈 | 按 [`native/README.md`](native/README.md) 第五节逐步手工执行 |
