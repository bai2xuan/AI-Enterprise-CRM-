# 中文语言包（第三方资源）

本目录存放 SuiteCRM 简体中文语言包，**非本项目产出**。

| 项 | 值 |
|---|---|
| 语言包名称 | Chinese (China) |
| 版本 | `7.15-26.10` |
| 适用版本 | SuiteCRM 7.15.x |
| 发布方 | SuiteCRM 社区 via [Crowdin](https://crowdin.com/project/suitecrmtrans) |
| 文件数 | 136 |
| 体积 | 约 1.4 MB |

---

## 目录结构

目录结构**镜像 SuiteCRM 应用根目录**，因此可以直接整体释放：

```
deploy/i18n/
├── manifest.php                        语言包安装清单（记录版本信息）
└── zh_CN/
    ├── include/language/zh_CN.lang.php
    ├── include/SugarObjects/.../zh_CN.lang.php
    ├── include/SugarFields/Fields/Address/zh_CN.DetailView.tpl
    └── modules/<模块>/language/zh_CN.lang.php      ← 覆盖 130+ 个原生模块
```

释放方式：

```bash
cp -r deploy/i18n/zh_CN/. crm/
```

或使用封装脚本：

```bash
bash deploy/native/apply-overlay.sh
```

---

## 关于语言包质量

SuiteCRM 官方中文语言包存在较多英文残留。本项目**未修改语言包本体**，
而是通过 `custom/Extension/.../Language/zh_CN.ai_*_zhfix.php` 扩展文件
覆盖高频词条，保持升级安全性。

覆盖范围：

| 模块 | 修正条目数 |
|---|---|
| `Accounts`（客户） | 42 |
| `Opportunities`（商机） | 15 |
| `Home`（首页） | 29 |
| `app` 应用级 | 201 |

---

## 许可

语言包遵循 SuiteCRM 同源的 **AGPL-3.0** 协议发布。
本项目在 `.gitattributes` 中将其标记为 `linguist-vendored`，
不计入本项目的代码语言统计。
