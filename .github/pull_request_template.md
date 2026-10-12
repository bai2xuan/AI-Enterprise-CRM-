## 改动说明

<!-- 这个 PR 做了什么、为什么这样做 -->

## 改动类型

- [ ] `feat` 新功能
- [ ] `fix` 缺陷修复
- [ ] `docs` 文档
- [ ] `refactor` 重构
- [ ] `chore` 脚本 / 配置
- [ ] `style` 格式

## 影响范围

| 项 | 内容 |
|---|---|
| 涉及模块 | |
| 新增 / 变更字段 | |
| 是否影响销售阶段 Key | 否 / 是（请说明） |
| 是否需要执行修复重建 | 否 / 是 |

## 自检清单

- [ ] 改动全部落在 `crm/custom/`、自研模块目录或 `config_override.php` 内
- [ ] **未修改任何 SuiteCRM 核心源码**（已执行下方自查命令且输出为空）
- [ ] 未提交凭据、生成物或本地环境文件
- [ ] 新增语言标签同时覆盖 `en_us` 与 `zh_CN`
- [ ] 已执行 `php scripts/setup/repair.php`
- [ ] `php scripts/verify/verify-customizations.php` 全部通过
- [ ] `php scripts/verify/verify-automation.php` 全部通过
- [ ] 涉及界面时，已确认无 `LBL_` 原始键名外露
- [ ] 已同步更新 `README.md` / `CHANGELOG.md` / `docs/`

### 核心代码零改动自查

```bash
git diff --name-only <基线提交> HEAD -- crm/ \
  | grep -vE "^crm/(custom/|modules/(AID_SalesAnalytics|CReq_CustomerRequirements|Hand_ProjectHandovers)/|config_override\.php)"
```

## 截图 / 验证证据

<!-- 界面改动请附前后对比截图；自动化改动请附验收输出 -->
