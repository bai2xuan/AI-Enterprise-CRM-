# 部署期兼容补丁

本目录存放**唯一一处**需要写入 SuiteCRM 核心目录的文件。
之所以采用「补丁 + 部署脚本」的形式，而不是直接把文件提交进 `crm/modules/`，
是为了让仓库中「本项目编写的内容」保持零核心改动。

目录结构镜像 SuiteCRM 应用根目录：

```
deploy/patches/
└── modules/UpgradeWizard/uw_utils.php   →  目标：crm/modules/UpgradeWizard/uw_utils.php
```

---

## 补丁内容：`uw_utils.php`

### 问题背景

SuiteCRM 7.15.x（含 7.15.0 / 7.15.1 / 7.15.2）的官方发布包中，
`modules/UpgradeWizard/uw_utils.php` **被上游移除**，
但安装程序 `install/install_utils.php` 第 938 行仍在**无条件**引用该文件：

```php
if (file_exists('config.php') && file_exists('config_si.php')) {
    require_once('modules/UpgradeWizard/uw_utils.php');   // ← 致命错误
    merge_config_si_settings(false, 'config.php', 'config_si.php');
}
```

而 `handleSugarConfig()` 位于 `install/performSetup.php` 第 156 行，
处于安装流程最前端。因此只要使用**静默安装**（根目录存在 `config_si.php`），
安装会立即中断：

```
PHP Fatal error: Failed opening required 'modules/UpgradeWizard/uw_utils.php'
```

普通的网页向导式安装不受影响——因为没有 `config_si.php`，不会进入该分支。

### 处理方式

补回 SuiteCRM **7.14.9** 版本中该文件的对应实现（核心为
`merge_config_si_settings()` 函数），仅补齐缺失函数，**不修改任何既有文件**。

Docker 部署的 `entrypoint.sh` 会在静默安装前自动应用本补丁；
本地便携栈部署请参考 [`../native/README.md`](../native/README.md)。

### 可否去掉

不可。除非满足以下任一条件：

- SuiteCRM 上游修复该缺陷后升级
- 放弃静默安装，改用网页向导式安装（`deploy/docker/entrypoint.sh` 需同步调整）

---

## 许可

该文件内容取自 SuiteCRM 上游实现，遵循 **AGPL-3.0** 协议。
本项目在 `.gitattributes` 中将其标记为 `linguist-vendored`。
