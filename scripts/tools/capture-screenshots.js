/**
 * ============================================================
 * AI Enterprise CRM —— 界面截图自动化脚本
 * ------------------------------------------------------------
 * 使用系统已安装的 Chrome（避免下载 Chromium），
 * 登录 SuiteCRM 后按清单逐页截图，输出到 screenshots/
 *
 * 运行：
 *   NODE_PATH=<workspace>/node_modules node scripts/capture-screenshots.js
 * ============================================================
 */

const { chromium } = require('playwright-core');
const fs = require('fs');
const path = require('path');

const CHROME_CANDIDATES = [
  'C:/Program Files/Google/Chrome/Application/chrome.exe',
  'C:/Program Files (x86)/Google/Chrome/Application/chrome.exe',
  'C:/Program Files (x86)/Microsoft/Edge/Application/msedge.exe',
];

const BASE_URL = process.env.CRM_BASE_URL || 'http://localhost:8080';
const ADMIN_USER = process.env.CRM_ADMIN_USER || 'admin';
const PROJECT_ROOT = path.resolve(__dirname, '../..');
const PW_FILE = path.join(PROJECT_ROOT, 'data', '.pw');
const TARGETS_FILE = path.join(PROJECT_ROOT, 'data', 'screenshot-targets.json');
const OUT_DIR = path.join(PROJECT_ROOT, 'screenshots');

const VIEWPORT = { width: 1600, height: 1000 };

/**
 * 读取由 scripts/data/prepare-screenshot-targets.php 生成的「代表性记录 ID」。
 * 每次重新灌演示数据 UUID 都会变，所以详情页 id 不能硬编码。
 */
function loadTargets() {
  if (!fs.existsSync(TARGETS_FILE)) {
    throw new Error(`缺少 ${TARGETS_FILE}，请先运行： php scripts/data/prepare-screenshot-targets.php`);
  }
  return JSON.parse(fs.readFileSync(TARGETS_FILE, 'utf8'));
}

/**
 * 需要截图的页面清单
 *  - clickTab   ：可选，点击详情页的某个面板页签（SuiteCRM 详情页一个面板一个页签）
 *  - scrollTo   ：可选，截图前滚动到目标元素（聚焦二次开发的新增字段区域）
 *  - scrollOffset：可选，滚动后再做一次像素偏移，避免标题被顶出视口
 *  - fullPage   ：可选，整页截图
 */
function buildPages(t) {
  const dv = (m, id) => `index.php?module=${m}&action=DetailView&record=${id}`;
  return [
    { file: '02-home.png',              url: 'index.php?module=Home&action=index',                desc: 'SuiteCRM 首页（改造后）' },
    { file: '03-analytics-dashboard.png', url: 'index.php?module=AID_SalesAnalytics&action=index', desc: '模块4 · 销售经营分析看板（KPI + 5 张图表）', fullPage: true },

    { file: '04-accounts-list.png',     url: 'index.php?module=Accounts&action=index',             desc: '模块1 · 客户列表' },
    { file: '05-account-detail.png',    url: dv('Accounts', t.account.id),                        desc: '模块1 · 客户详情（企业基础信息面板）', clickTab: '企业基础信息' },
    { file: '06-account-value.png',     url: dv('Accounts', t.account.id),                        desc: '模块1 · 客户详情（客户价值面板）', clickTab: '客户价值' },
    { file: '07-account-edit.png',      url: 'index.php?module=Accounts&action=EditView',         desc: '模块1 · 客户新建表单（新增字段）', scrollTo: '#company_size_c', scrollOffset: -230 },

    { file: '08-opportunities-list.png', url: 'index.php?module=Opportunities&action=index',       desc: '模块2 · 商机列表（7 段销售阶段）' },
    { file: '09-opportunity-detail.png', url: dv('Opportunities', t.opportunity_open.id),          desc: '模块2 · 商机详情（在途商机）' },
    { file: '10-opportunity-edit.png',  url: 'index.php?module=Opportunities&action=EditView',     desc: '模块2 · 商机新建（产品类型 / 阶段 / 下一步行动）', scrollTo: '#product_type_c', scrollOffset: -230 },

    { file: '11-requirements-list.png', url: 'index.php?module=CReq_CustomerRequirements&action=index', desc: '模块3 · 需求调研列表（自建模块）' },
    { file: '12-requirement-detail.png', url: dv('CReq_CustomerRequirements', t.requirement.id),   desc: '模块3 · 需求调研详情（需求描述面板）', clickTab: '需求描述' },

    { file: '13-handovers-list.png',    url: 'index.php?module=Hand_ProjectHandovers&action=index', desc: '模块5 · 项目交接列表（自建模块）' },
    { file: '14-handover-detail.png',   url: dv('Hand_ProjectHandovers', t.handover.id),           desc: '模块5 · 项目交接单详情（交付信息面板）', clickTab: '交付信息' },
  ];
}

function findBrowser() {
  for (const p of CHROME_CANDIDATES) {
    if (fs.existsSync(p)) return p;
  }
  throw new Error('未找到 Chrome / Edge，请安装其一或修改 CHROME_CANDIDATES');
}

async function main() {
  if (!fs.existsSync(OUT_DIR)) fs.mkdirSync(OUT_DIR, { recursive: true });

  // 清掉旧截图，避免旧命名残留导致交付物混乱
  for (const f of fs.readdirSync(OUT_DIR)) {
    if (/\.png$/i.test(f)) fs.unlinkSync(path.join(OUT_DIR, f));
  }

  const targets = loadTargets();
  const PAGES = buildPages(targets);
  const password = fs.readFileSync(PW_FILE, 'utf8').trim();
  const executablePath = findBrowser();
  console.log(`[info] 浏览器: ${executablePath}`);
  console.log(`[info] 站点  : ${BASE_URL}`);
  console.log(`[info] 计划截图 ${PAGES.length + 1} 张`);

  const browser = await chromium.launch({ executablePath, headless: true, args: ['--no-sandbox'] });
  const context = await browser.newContext({
    viewport: VIEWPORT,
    locale: 'zh-CN',
    deviceScaleFactor: 1,
  });
  const page = await context.newPage();

  try {
    // ---------- 1. 登录页 ----------
    await page.goto(`${BASE_URL}/index.php`, { waitUntil: 'domcontentloaded' });
    await page.waitForTimeout(1500);
    await page.screenshot({ path: path.join(OUT_DIR, '01-login.png') });
    console.log('[ok] 01-login.png  登录页');

    // ---------- 登录 ----------
    // SuiteCRM 7.15 登录表单：字段 #user_name / #username_password，提交按钮 #bigbutton
    await page.fill('#user_name', ADMIN_USER);
    await page.fill('#username_password', password);
    await Promise.all([
      page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }),
      page.click('#bigbutton'),
    ]);
    await page.waitForTimeout(2500);
    console.log('[ok] 登录成功');

    // ---------- 2. 其余页面 ----------
    for (const item of PAGES) {
      const url = `${BASE_URL}/${item.url}`;
      await page.goto(url, { waitUntil: 'domcontentloaded' });
      await page.waitForTimeout(2800);
      // 关闭可能出现的引导弹窗
      try {
        const closeBtn = page.locator('a.close, .modal .close, button[data-dismiss="modal"]').first();
        if (await closeBtn.isVisible({ timeout: 800 })) await closeBtn.click();
      } catch (_) { /* ignore */ }

      // 必要时切换到指定面板页签
      // SuiteCRM 的详情页页签不是标准 bootstrap tab（桌面端 <a> 没有 href/data-target），
      // 而是靠主题 JS 里的全局函数 selectTab(index) 来切换，因此这里直接调用它。
      if (item.clickTab) {
        const ok = await page.evaluate((text) => {
          const lis = Array.from(document.querySelectorAll('#content .nav-tabs > li'));
          const idx = lis.findIndex((li) => li.textContent.trim() === text);
          if (idx < 0) return false;
          lis.forEach((li) => li.classList.remove('active'));
          lis[idx].classList.add('active');
          if (typeof selectTab === 'function') selectTab(idx);
          return true;
        }, item.clickTab);
        if (!ok) console.warn(`  [warn] 未找到面板页签：${item.clickTab}`);
        await page.waitForTimeout(800);
      }

      // 必要时滚动到目标字段（聚焦二次开发的新字段区域）
      if (item.scrollTo) {
        try {
          await page.locator(item.scrollTo).first().scrollIntoViewIfNeeded({ timeout: 4000 });
          await page.waitForTimeout(600);
        } catch (_) { /* ignore */ }
      }

      // 细微偏移，避免滚动后页面标题被顶出视口
      if (item.scrollOffset) {
        await page.evaluate((dy) => window.scrollBy(0, dy), item.scrollOffset);
        await page.waitForTimeout(600);
      }

      // 看板类页面等 ECharts 动画结束再截，避免图表空白
      await page.waitForTimeout(1200);

      await page.screenshot({ path: path.join(OUT_DIR, item.file), fullPage: !!item.fullPage });
      console.log(`[ok] ${item.file}  ${item.desc}`);
    }
  } finally {
    await browser.close();
  }

  console.log('\n[完成] 截图已输出到 screenshots/');
}

main().catch((err) => {
  console.error('[错误]', err.message);
  process.exit(1);
});
