<?php
/**
 * seed-demo-data.php —— 生成「智联AI科技」B 端销售模拟数据
 * ==================================================================
 * 数据规模（与任务书一致）：
 *   客户 20 · 联系人 12 · 商机 30 · 需求调研 20 · 项目交接 8 · 跟进记录 50
 *
 * 数据设计原则：
 *   1. 全部通过 SuiteCRM Bean API 写入，保证 id / 关联 / 审计字段规范；
 *   2. 客户、商机、需求之间真实关联，Dashboard 图表才有意义；
 *   3. 金额、阶段、行业分布贴近真实 B 端 AI 解决方案销售场景。
 *
 * 用法：
 *   php scripts/data/seed-demo-data.php            # 若已有业务数据则只提示，不重复写入
 *   php scripts/data/seed-demo-data.php --reset    # 先清空既有演示数据再重新生成
 */

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

chdir(dirname(__DIR__, 2) . '/crm');
require_once 'include/entryPoint.php';

$RESET = in_array('--reset', $argv ?? array(), true);

/**
 * 演示账号统一密码：与内置 admin 保持一致，从 data/.pw 读取。
 * ⚠️ 不要把密码明文写进脚本：本机环境会对命令行/文件里的密码字面量做替换，
 *    写死的字符串会与实际密码不一致，导致新建用户登不进去。
 */
$DEMO_PASSWORD = trim((string)@file_get_contents(dirname(__DIR__, 2) . '/data/.pw'));
if ($DEMO_PASSWORD === '') {
    fwrite(STDERR, "[错误] 未找到 data/.pw，无法设置演示账号密码\n");
    exit(1);
}

/* ---------- 管理员上下文（CLI 无会话）---------- */
$admin = BeanFactory::getBean('Users');
$admin->retrieve_by_string_fields(array('is_admin' => '1', 'deleted' => '0'));
if (empty($admin->id)) {
    $admin = BeanFactory::getBean('Users', '1');
}
$GLOBALS['current_user'] = $admin;

global $db;

function line($msg = '')
{
    echo $msg . "\n";
}

function step($msg)
{
    echo "\n==> {$msg}\n";
}

/**
 * 客户简称：直接截前 4 个字会出现「北京市朝」「复旦大学」这类残缺简称，
 * 因此先剥掉公司后缀、行政区划、机构后缀，再取前 4 个字。
 *   北京市朝阳区政务服务管理局 → 北京朝阳
 *   深圳蜂巢科技有限公司       → 深圳蜂巢
 *   复旦大学附属仁和医院       → 复旦大学
 */
function short_name($name)
{
    $n = preg_replace('/(股份有限公司|有限责任公司|有限公司|集团有限公司|公司|集团)$/u', '', $name);
    $n = preg_replace('/(管理局|管理委员会|政务服务中心|办公室|委员会|研究院|医院|大学|学院)$/u', '', $n);
    $n = preg_replace('/(省|市|自治区|特别行政区)/u', '', $n);
    $n = trim((string)$n);
    return $n === '' ? mb_substr($name, 0, 4, 'UTF-8') : mb_substr($n, 0, 4, 'UTF-8');
}

/* ============================================================
 * 0. 检查既有数据 / 可选清理
 * ============================================================ */
$existing = (int)$db->getOne("SELECT COUNT(*) FROM accounts WHERE deleted=0");
if ($existing > 0 && !$RESET) {
    line("检测到已存在 {$existing} 条客户数据。");
    line("如需重新生成演示数据，请执行： php scripts/data/seed-demo-data.php --reset");
    exit(0);
}

if ($RESET) {
    step('清理既有演示数据');
    $tables = array(
        'accounts', 'contacts', 'opportunities',
        'creq_customerrequirements', 'hand_projecthandovers',
        'tasks', 'accounts_contacts', 'accounts_opportunities',
    );
    foreach ($tables as $t) {
        $db->query("DELETE FROM {$t}");
    }
    // 清理演示用户（保留内置 admin，它同时是演示主账号）
    // zhanghaoran 是早期版本的种子账号，现已由 admin 兼任，一并清掉避免重名残留
    $db->query("DELETE FROM users WHERE is_admin=0 AND user_name IN ('zhanghaoran','lisiyuan','wangxuefeng')");
    line('  已清空演示数据表');
}

/* ============================================================
 * 1. 货币初始化（静默安装未初始化 currencies 表）
 * ============================================================ */
step('初始化货币');
$curCount = (int)$db->getOne("SELECT COUNT(*) FROM currencies");
if ($curCount === 0) {
    $db->query("INSERT INTO currencies (id, name, symbol, iso4217, conversion_rate, status, deleted, date_entered, date_modified)
                VALUES ('-99', '人民币', '¥', 'CNY', 1.000000, 'Active', 0, NOW(), NOW())");
    line('  已写入系统默认货币：人民币 CN¥');
} else {
    line("  货币表已有 {$curCount} 条记录，跳过");
}

/* ============================================================
 * 2. 业务用户（销售 / 售前 / 交付）
 * ------------------------------------------------------------
 * 说明：SuiteCRM 首页的「我的商机 / 我的客户」等 Dashlet 按
 *       `assigned_user_id = 当前登录用户` 过滤，如果演示数据全部挂在
 *       另一个账号下，用 admin 登录后首页会是一片空白。
 *       因此这里直接把内置 admin 账号的显示名改成业务角色姓名，
 *       让它同时充当「销售经理」这个演示主账号 —— 一个账号即可看到完整业务。
 * ============================================================ */
step('创建业务用户');

// 演示主账号 = admin（显示为销售经理），避免出现两个同名用户
$salesUser = BeanFactory::getBean('Users');
$salesUser->retrieve_by_string_fields(array('user_name' => 'admin', 'deleted' => 0));
if (empty($salesUser->id)) {
    $salesUser = $admin;   // 兜底：使用脚本开头的管理员上下文
}
$salesUser->first_name = '';
$salesUser->last_name = '张浩然';
$salesUser->title = '销售经理';
$salesUser->status = 'Active';
$salesUser->employee_status = 'Active';
$salesUser->save();
line("  张浩然（销售经理）id={$salesUser->id}（复用内置 admin 账号）");

$USERS = array(
    // 登录名, 姓名, 职位
    array('lisiyuan', '李思远', '售前顾问'),
    array('wangxuefeng', '王雪峰', '交付经理'),
);
$userIds = array();
foreach ($USERS as $u) {
    $user = BeanFactory::newBean('Users');
    $user->retrieve_by_string_fields(array('user_name' => $u[0], 'deleted' => 0));
    if (empty($user->id)) {
        $user = BeanFactory::newBean('Users');
        $user->user_name = $u[0];
    }
    $user->first_name = '';
    $user->last_name = $u[1];
    $user->title = $u[2];
    $user->status = 'Active';
    $user->is_admin = 0;
    $user->employee_status = 'Active';
    // SuiteCRM 的密码算法：password_hash(strtolower(md5($plain)), PASSWORD_DEFAULT)
    // 直接写 md5 是登不进去的（登录失败会提示用户名或密码错误）。
    $user->user_hash = password_hash(strtolower(md5($DEMO_PASSWORD)), PASSWORD_DEFAULT);
    $user->save();
    $userIds[] = $user->id;
    line("  {$u[1]}（{$u[2]}）id={$user->id}  登录密码：{$DEMO_PASSWORD}");
}
$SALES = $salesUser->id;
$PRESALES = $userIds[0];
$DELIVERY = $userIds[1];

/* ============================================================
 * 3. 客户（20 家）
 * ------------------------------------------------------------
 * 字段顺序：名称 | 行业 | 规模 | 企业类型 | 等级 | 来源 | 潜在价值
 *          | 痛点 | 在用系统 | 预算范围 | 决策周期 | 销售负责人序号 | 售前负责人序号
 * ============================================================ */
step('创建客户（Accounts）');

$ACCOUNTS = array(
    array('北京中科智造科技有限公司', 'Manufacturing', 'Above 1000', 'Listed', 'A', 'Exhibition', 1800000,
        '客服响应慢，设备手册与技术资料分散在多个系统中，一线工程师查找一次平均耗时 15 分钟，售后成本居高不下。',
        '金蝶 ERP + 自建 OA + 共享网盘', 'Above 100W', '3-6 Months', 0, 1),

    array('上海精工机械集团有限公司', 'Manufacturing', '501-1000', 'State-owned', 'A', 'Referral', 1200000,
        '售后热线话务量高峰期排队严重，常见问题占 70%，人工重复回答效率低。',
        '用友 U8 + 400 呼叫中心', '50W-100W', '3-6 Months', 0, 1),

    array('广州南方汽车零部件股份有限公司', 'Manufacturing', 'Above 1000', 'Joint Venture', 'B', 'Exhibition', 900000,
        '质检报告与工艺文档人工归档，跨工厂知识无法沉淀，新员工培训周期长。',
        'SAP + 自研 MES', '50W-100W', 'Above 6 Months', 0, 1),

    array('苏州恒瑞精密制造有限公司', 'Manufacturing', '201-500', 'Private', 'B', 'Website', 450000,
        '订单交付进度靠 Excel 跟踪，销售与生产信息不同步，客户催单频繁。',
        '金蝶 KIS + Excel', '30W-50W', '1-3 Months', 0, 1),

    array('青岛海隆重工装备有限公司', 'Manufacturing', '501-1000', 'Private', 'B', 'Marketing', 680000,
        '海外客户咨询需要 7×24 响应，现有团队无法覆盖多语言时差。',
        '自建邮件系统', '50W-100W', '3-6 Months', 0, 1),

    array('招商信达金融服务有限公司', 'Finance', 'Above 1000', 'Listed', 'A', 'Referral', 2400000,
        '理财产品咨询量大且合规要求严格，坐席回答口径不一致存在合规风险。',
        '恒生系统 + 自建知识库', 'Above 100W', 'Above 6 Months', 0, 1),

    array('广州汇通融资租赁有限公司', 'Finance', '201-500', 'Private', 'B', 'Website', 520000,
        '合同条款审核依赖资深法务，人均日处理能力有限，业务扩张受限。',
        '自建合同管理系统', '30W-50W', '1-3 Months', 0, 1),

    array('上海庆丰证券投资咨询有限公司', 'Finance', '501-1000', 'Private', 'B', 'Exhibition', 760000,
        '研报与投顾内容生产耗时，研究员大量时间花在资料检索与格式整理。',
        'Wind + Office', '50W-100W', '3-6 Months', 0, 1),

    array('深圳前海普惠小额贷款有限公司', 'Finance', '51-200', 'Private', 'C', 'Search Engine', 280000,
        '贷前材料初审人工成本高，标准化资料占比大，适合自动化处理。',
        '自研信贷系统', '10W-30W', 'Within 1 Month', 0, 1),

    array('杭州云智数据科技有限公司', 'Internet', '201-500', 'Private', 'B', 'Website', 620000,
        '技术文档与 API 文档更新频繁，客户支持团队重复答疑成本高。',
        'GitBook + 飞书', '30W-50W', '1-3 Months', 0, 1),

    array('北京星河互联信息技术有限公司', 'Internet', '51-200', 'Private', 'C', 'Cold Call', 240000,
        '内部会议纪要整理占用大量研发时间，希望自动生成结构化纪要。',
        '飞书 + 腾讯会议', '10W-30W', '1-3 Months', 0, 1),

    array('深圳蜂巢网络科技有限公司', 'Internet', '201-500', 'Private', 'B', 'Marketing', 480000,
        '运营团队需要每日生成数据日报，目前人工制作耗时 2 小时/天。',
        '自研 BI + Tableau', '30W-50W', 'Within 1 Month', 0, 1),

    array('北京市朝阳区政务服务管理局', 'Government', 'Above 1000', 'Government', 'A', 'Referral', 3200000,
        '政务咨询事项繁杂，窗口人员培训成本高，群众咨询等待时间长。',
        '自建政务平台', 'Above 100W', 'Above 6 Months', 0, 1),

    array('成都市高新区智慧城市运营中心', 'Government', '501-1000', 'Government', 'B', 'Exhibition', 1500000,
        '城市运营数据分散在 12 个委办局，缺少统一分析口径与决策支撑。',
        '多套委办局系统', 'Above 100W', 'Above 6 Months', 0, 1),

    array('复旦大学附属仁和医院', 'Healthcare', 'Above 1000', 'State-owned', 'A', 'Referral', 1350000,
        '临床指南与院内制度检索不便，医护查询耗时，影响诊疗效率。',
        'HIS + 院内 OA', 'Above 100W', '3-6 Months', 0, 1),

    array('上海济世医疗科技有限公司', 'Healthcare', '201-500', 'Private', 'B', 'Website', 560000,
        '医疗器械注册法规更新频繁，合规团队需要持续跟踪与比对。',
        '自建法规库', '30W-50W', '3-6 Months', 0, 1),

    array('华中师范大学教育集团', 'Education', 'Above 1000', 'State-owned', 'B', 'Exhibition', 780000,
        '招生咨询高峰期电话与在线咨询量大，重复问题占比高。',
        '自建招生系统', '50W-100W', '3-6 Months', 0, 1),

    array('内蒙古绿能风电股份有限公司', 'Energy', '501-1000', 'State-owned', 'B', 'Referral', 920000,
        '风场运维规程与故障处置手册检索困难，偏远现场响应依赖专家远程支持。',
        'EAM + 纸质规程', '50W-100W', '3-6 Months', 0, 1),

    array('永辉连锁超市（福建）有限公司', 'Retail', 'Above 1000', 'Listed', 'B', 'Marketing', 640000,
        '门店员工流动率高，SOP 培训重复投入，总部政策传达效率低。',
        '自建门店管理系统', '30W-50W', '1-3 Months', 0, 1),

    array('顺丰速运华南物流中心', 'Logistics', 'Above 1000', 'Private', 'B', 'Channel', 880000,
        '异常件处理依赖人工判断，客服与网点协同效率低。',
        '自研物流系统', '50W-100W', '3-6 Months', 0, 1),
);

$accountIds = array();
foreach ($ACCOUNTS as $i => $a) {
    $acc = BeanFactory::newBean('Accounts');
    $acc->name = $a[0];
    $acc->industry = $a[1];
    $acc->company_size_c = $a[2];
    $acc->enterprise_type_c = $a[3];
    $acc->customer_level_c = $a[4];
    $acc->customer_source_c = $a[5];
    $acc->potential_value_c = $a[6];
    $acc->currency_id = '-99';
    $acc->current_pain_points_c = $a[7];
    $acc->current_system_c = $a[8];
    $acc->budget_range_c = $a[9];
    $acc->decision_cycle_c = $a[10];
    $acc->sales_owner_c_user_id = $SALES;
    $acc->presales_owner_c_user_id = $PRESALES;
    $acc->assigned_user_id = $SALES;
    $acc->description = '由' . $a[5] . '渠道获取，客户等级 ' . $a[4] . '。';
    $acc->save();
    $accountIds[$i] = $acc->id;
}
line('  已创建 ' . count($accountIds) . ' 家客户');

/* ============================================================
 * 4. 联系人（12 位关键决策人）
 * ------------------------------------------------------------
 * 顺序：客户序号 | 姓名 | 职务 | 部门 | 电话 | 邮箱
 * ============================================================ */
step('创建联系人（Contacts）');

$CONTACTS = array(
    array(0,  '陈建明', '信息中心总监', '信息技术部', '010-8823-4567', 'chenjm@zkzz-tech.com'),
    array(0,  '刘敏',   '客服中心经理', '客户服务部', '010-8823-4568', 'liumin@zkzz-tech.com'),
    array(1,  '赵国强', '副总经理', '总经办', '021-6543-2100', 'zhaogq@shjg-group.com'),
    array(2,  '黄文彬', '数字化主管', '数字化办公室', '020-8765-4321', 'huangwb@gznf.com'),
    array(5,  '周雅琴', '合规运营总监', '合规部', '0755-8899-1234', 'zhouyq@cmxd.com'),
    array(9,  '吴天成', 'CTO', '技术中心', '0571-8765-1100', 'wutc@yunzhi-data.com'),
    array(12, '孙立新', '政务服务中心主任', '政务服务科', '010-6501-2288', 'sunlx@bjcy.gov.cn'),
    array(13, '马晓东', '数据资源处处长', '数据资源处', '028-8532-7700', 'maxd@cdgx.gov.cn'),
    array(14, '林嘉怡', '信息科科长', '信息科', '021-6408-3322', 'linjy@rh-hospital.cn'),
    array(16, '郑海涛', '招生办主任', '招生办公室', '027-6789-1122', 'zhenght@ccnu.edu.cn'),
    array(17, '乌日娜', '运维中心主任', '生产运维部', '0471-6633-880', 'wurn@nmgln.com'),
    array(19, '何志远', '华南区运营总监', '运营管理部', '020-3888-6600', 'hezy@sf-express.com'),
);

$contactIds = array();
foreach ($CONTACTS as $c) {
    $con = BeanFactory::newBean('Contacts');
    $name = $c[1];
    $con->first_name = mb_substr($name, 0, 1, 'UTF-8');
    $con->last_name = mb_substr($name, 1, null, 'UTF-8');
    $con->title = $c[2];
    $con->department = $c[3];
    $con->phone_work = $c[4];
    $con->email1 = $c[5];
    $con->assigned_user_id = $SALES;
    $con->save();
    // 关联到客户（先显式加载 link，否则 $con->accounts 为 null）
    if ($con->load_relationship('accounts')) {
        $con->accounts->add($accountIds[$c[0]]);
    }
    $contactIds[] = $con->id;
}
line('  已创建 ' . count($contactIds) . ' 位联系人并关联客户');

/* ============================================================
 * 5. 商机（30 个）
 * ------------------------------------------------------------
 * 顺序：客户序号 | 产品类型 | 销售阶段 | 金额 | 距今天数(预计成交)
 *      | 下一步计划 | 输单原因
 * ============================================================ */
step('创建商机（Opportunities）');

$OPPS = array(
    array(0,  'AI Knowledge Base',        'Negotiation/Review',   1180000, 20,  '本周五前提交最终报价与实施排期', ''),
    array(0,  'AI Customer Service',      'Value Proposition',     460000, 45,  '输出智能客服知识库对接方案', ''),
    array(1,  'AI Customer Service',      'Closed Won',            380000, -8,  '已签约，安排知识库语料采集', ''),
    array(1,  'AI Knowledge Base',        'Needs Analysis',        320000, 60,  '与客服中心梳理高频问题清单', ''),
    array(2,  'AI Knowledge Base',        'Closed Won',            560000, -12, '已签约，启动跨工厂知识归集', ''),
    array(2,  'Data Analytics Platform',  'Prospecting',           420000, 120, '预约数字化办公室首次需求访谈', ''),
    array(3,  'Data Analytics Platform',  'Needs Analysis',        286000, 50,  '收集订单交付环节字段口径', ''),
    array(4,  'AI Customer Service',      'Closed Won',            350000, -6,  '已签约，确认海外多语言支持范围', ''),
    array(5,  'AI Customer Service',      'Negotiation/Review',    920000, 25,  '合规部复核话术库审核机制', ''),
    array(5,  'AI Knowledge Base',        'Value Proposition',     680000, 80,  '拆分合规知识库一期建设范围', ''),
    array(6,  'AI Office Assistant',      'Perception Analysis',   340000, 40,  '演示合同条款智能比对能力', ''),
    array(7,  'AI Office Assistant',      'Needs Analysis',        430000, 65,  '访谈研究员高频检索场景', ''),
    array(8,  'AI Office Assistant',      'Closed Won',            268000, -10, '已签约，进入交付启动流程', ''),
    array(9,  'AI Knowledge Base',        'Value Proposition',     398000, 55,  '设计 API 文档自动同步方案', ''),
    array(10, 'AI Office Assistant',      'Closed Won',            156000, -5,  '已签约，安排产品培训', ''),
    array(11, 'Data Analytics Platform',  'Perception Analysis',   312000, 30,  '演示日报自动生成效果', ''),
    array(11, 'AI Knowledge Base',        'Prospecting',           210000, 100, '确认运营团队知识沉淀诉求', ''),
    array(12, 'AI Customer Service',      'Value Proposition',    1680000, 85,  '编制政务咨询事项梳理方案', ''),
    array(12, 'AI Knowledge Base',        'Needs Analysis',        980000, 95,  '统计窗口高频咨询事项 Top200', ''),
    array(13, 'Data Analytics Platform',  'Perception Analysis',  1120000, 70,  '搭建跨委办局指标原型看板', ''),
    array(14, 'AI Knowledge Base',        'Negotiation/Review',    860000, 18,  '信息科确认临床知识库权限模型', ''),
    array(14, 'AI Customer Service',      'Prospecting',           420000, 130, '了解导诊咨询场景诉求', ''),
    array(15, 'AI Knowledge Base',        'Needs Analysis',        336000, 58,  '整理法规更新监测需求清单', ''),
    array(16, 'AI Customer Service',      'Closed Won',            520000, -20, '已签约，招生季前需完成上线', ''),
    array(17, 'AI Knowledge Base',        'Value Proposition',     628000, 68,  '设计风场运维规程知识库结构', ''),
    array(18, 'AI Knowledge Base',        'Needs Analysis',        372000, 52,  '梳理门店 SOP 与培训素材', ''),
    array(18, 'AI Office Assistant',      'Closed Lost',           240000, -30, '本期预算延期', 'Budget'),
    array(19, 'Data Analytics Platform',  'Perception Analysis',   540000, 32,  '演示异常件归因分析能力', ''),
    array(19, 'AI Customer Service',      'Closed Lost',           460000, -15, '客户最终选择某竞品方案', 'Competitor'),
    array( 3, 'AI Customer Service',      'Prospecting',           260000, 115, '确认客户服务团队规模与场景', ''),
);

/** 销售阶段 → 默认成交概率（与 ai_sales_stage 语言包保持一致） */
$PROB = array(
    'Prospecting'        => 10,
    'Needs Analysis'     => 25,
    'Value Proposition'  => 40,
    'Perception Analysis' => 55,
    'Negotiation/Review' => 75,
    'Closed Won'         => 100,
    'Closed Lost'        => 0,
);
$STAGE_ZH = array(
    'Prospecting'        => '初步接触',
    'Needs Analysis'     => '需求调研',
    'Value Proposition'  => '方案设计',
    'Perception Analysis' => '产品演示',
    'Negotiation/Review' => '商务谈判',
    'Closed Won'         => '成交',
    'Closed Lost'        => '输单',
);
/**
 * 产品类型（存储 Key 保持英文，与 product_type_c 下拉键一致）→ 中文显示名。
 * 记录名称里一律用中文，避免截图中出现中英混杂的标题。
 */
$PRODUCT_ZH = array(
    'AI Knowledge Base'       => 'AI 知识库系统',
    'AI Customer Service'     => '企业智能客服',
    'AI Office Assistant'     => 'AI 办公助手',
    'Data Analytics Platform' => '数据智能分析平台',
);
/** 各阶段商机的"已推进天数"（用于回填 date_entered，使成交周期指标可信） */
$STAGE_AGE_DAYS = array(
    'Prospecting'         => 18,
    'Needs Analysis'      => 35,
    'Value Proposition'   => 52,
    'Perception Analysis' => 68,
    'Negotiation/Review'  => 82,
    'Closed Won'          => 96,
    'Closed Lost'         => 88,
);

$oppIds = array();
foreach ($OPPS as $o) {
    $opp = BeanFactory::newBean('Opportunities');
    $accName = $ACCOUNTS[$o[0]][0];
    $shortName = short_name($accName);
    $opp->name = $shortName . ' - ' . ($PRODUCT_ZH[$o[1]] ?? $o[1]) . ' - 2026Q4';
    $opp->product_type_c = $o[1];
    $opp->sales_stage = $o[2];
    $opp->amount = $o[3];
    $opp->currency_id = '-99';
    $opp->probability = $PROB[$o[2]];
    $opp->date_closed = date('Y-m-d', strtotime($o[4] . ' days'));
    $opp->next_step = $o[5];
    if (!empty($o[6])) {
        $opp->lost_reason_c = $o[6];
    }
    $opp->account_id = $accountIds[$o[0]];
    $opp->assigned_user_id = $SALES;
    $opp->description = '客户：' . $accName . '；产品：' . $o[1] . '。';
    $opp->save();
    // 建立 客户 ↔ 商机 关系（SuiteCRM 原生为多对多）
    if ($opp->load_relationship('accounts')) {
        $opp->accounts->add($accountIds[$o[0]]);
    }
    // 修正 date_entered：让"商机创建时间"符合真实销售周期
    // （越靠后的阶段，商机创建得越早；这样"平均成交周期"等指标才有业务含义）
    // 注意：必须用 $db->quoted() 而不是 $db->quote()。
    //   MysqliManager::quote() 只做转义、不加引号（等价于 mysqli_real_escape_string），
    //   直接拼进 SQL 会生成 `WHERE id = 0a72fdf8-...` 这种非法语句而静默失败。
    //   $db->quoted() 才会返回带单引号的字面量。
    if (isset($STAGE_AGE_DAYS[$o[2]])) {
        $age = $STAGE_AGE_DAYS[$o[2]];
        $safeId = $db->quoted($opp->id);
        if (!$db->query("UPDATE opportunities SET date_entered = DATE_SUB(NOW(), INTERVAL {$age} DAY) WHERE id = {$safeId}")) {
            line("  [警告] 回填 date_entered 失败：{$opp->name}");
        }
        $opp->date_entered = date('Y-m-d H:i:s', strtotime("-{$age} days"));
    }
    $oppIds[] = $opp->id;
}
line('  已创建 ' . count($oppIds) . ' 个商机');

/* ============================================================
 * 6. 需求调研（20 条，取自前 20 个商机）
 * ============================================================ */
step('创建需求调研（CReq_CustomerRequirements）');

/** 按产品类型给出业务化的需求描述模板 */
$REQ_TPL = array(
    'AI Knowledge Base' => array(
        'bg'   => '客户长期积累的技术资料、制度文件与业务经验分散在多个系统中，缺少统一检索入口，知识难以沉淀与复用。',
        'pain' => '一线人员查找资料平均耗时 10-20 分钟，且资料版本不一致，存在使用过期文档的风险。',
        'func' => "1. 多源知识自动接入与解析（Word/PDF/Excel/网页）；\n2. 语义检索与问答，支持权限隔离；\n3. 知识版本管理与过期提醒；\n4. 使用热度分析与知识贡献排行。",
        'tech' => "支持私有化部署；对接现有 ERP/OA 单点登录；单次检索响应 < 2 秒；支持 50 万条以上文档规模。",
        'sol'  => '建设企业级 AI 知识库平台，一期覆盖核心业务文档，二期扩展至全公司知识资产。',
        'risk' => '历史文档格式不规范，需投入人力做数据清洗；知识维护责任需明确到部门。',
        'comp' => '百度智能云知识中台 / 阿里云百炼',
        'km'   => '信息中心总监',
    ),
    'AI Customer Service' => array(
        'bg'   => '客户咨询量持续增长，人工坐席高峰期排队严重，大量重复性问题消耗一线人力。',
        'pain' => '常见问题占全部咨询的 60%-70%，坐席重复回答效率低；夜间与非工作日无法响应。',
        'func' => "1. 多渠道接入（电话/网页/微信/APP）；\n2. 意图识别与多轮对话；\n3. 坐席辅助（实时推荐话术与知识）；\n4. 服务质检与满意度分析。",
        'tech' => "对接现有呼叫中心（SIP/CTI）；支持多语言；首响 < 3 秒；提供会话质检报表接口。",
        'sol'  => '构建智能客服系统，优先覆盖高频标准化问题，逐步过渡到人机协同模式。',
        'risk' => '行业专有名词识别准确率需通过语料训练提升；客户对面客话术合规要求高。',
        'comp' => '网易七鱼 / 智齿客服',
        'km'   => '客服中心经理',
    ),
    'AI Office Assistant' => array(
        'bg'   => '内部办公场景中会议纪要、文档撰写、数据整理等重复性工作占用大量专业人力。',
        'pain' => '会议纪要整理平均耗时 1-2 小时/场，文档撰写与格式整理效率低。',
        'func' => "1. 会议录音转写与结构化纪要生成；\n2. 文档智能撰写与润色；\n3. 表格数据智能提取与汇总；\n4. 企业知识问答助手。",
        'tech' => "对接现有会议系统与文档平台；数据不出内网；支持不少于 200 并发使用。",
        'sol'  => '部署 AI 办公助手，先在高频会议与文档场景试点，再逐步推广至全员。',
        'risk' => '员工使用习惯需要培养；敏感信息脱敏策略需提前明确。',
        'comp' => '飞书智能伙伴 / WPS AI',
        'km'   => '信息技术负责人',
    ),
    'Data Analytics Platform' => array(
        'bg'   => '业务数据分散在多个系统中，缺少统一口径与自助分析能力，决策依赖人工汇总报表。',
        'pain' => '数据统计口径不一致，人工制作日报/周报耗时 2-4 小时，管理层无法实时掌握经营状况。',
        'func' => "1. 多数据源接入与 ETL；\n2. 统一指标口径管理；\n3. 自助式可视化看板；\n4. 异常自动预警与归因分析。",
        'tech' => "对接 ERP/MES/CRM 等系统；支持千万级数据量查询；提供 API 供业务系统调用。",
        'sol'  => '建设数据智能分析平台，一期打通核心业务数据，二期扩展至预测与智能决策。',
        'risk' => '各系统数据质量参差不齐，需要清洗；指标口径需业务部门共同确认。',
        'comp' => '帆软 FineBI / Tableau',
        'km'   => '数据/数字化负责人',
    ),
);

$REQ_STATUS_CYCLE = array('Draft', 'Collecting', 'Confirmed', 'Solution_Designed');
$PRIORITY_CYCLE = array('High', 'Medium', 'High', 'Low');

$reqCount = 0;
for ($i = 0; $i < 20; $i++) {
    $o = $OPPS[$i];
    $accIdx = $o[0];
    $product = $o[1];
    $tpl = $REQ_TPL[$product];
    $accName = $ACCOUNTS[$accIdx][0];

    $req = BeanFactory::newBean('CReq_CustomerRequirements');
    $req->name = short_name($accName) . ' - ' . ($PRODUCT_ZH[$product] ?? $product) . ' 需求调研';
    $req->req_no_c = 'REQ-2026-' . str_pad((string)($i + 1), 4, '0', STR_PAD_LEFT);
    $req->req_status_c = $REQ_STATUS_CYCLE[$i % 4];
    $req->priority_c = $PRIORITY_CYCLE[$i % 4];
    $req->account_id = $accountIds[$accIdx];
    $req->opportunity_id = $oppIds[$i];
    $req->customer_background_c = $tpl['bg'];
    $req->current_pain_points_c = $tpl['pain'];
    $req->current_system_c = $ACCOUNTS[$accIdx][8];
    $req->requirement_desc_c = "客户计划引入「{$product}」，用于解决当前业务痛点。本期期望在 " .
        ($ACCOUNTS[$accIdx][10] === 'Within 1 Month' ? '1 个月' : '3 个月') . " 内完成试点上线。";
    $req->functional_req_c = $tpl['func'];
    $req->technical_req_c = $tpl['tech'];
    $req->expected_solution_c = $tpl['sol'];
    $req->budget_c = $o[3] * 0.6;
    $req->currency_id = '-99';
    $req->go_live_date_c = date('Y-m-d', strtotime('+' . ($o[4] + 30) . ' days'));
    $decisionMaker = '待确认';
    foreach ($CONTACTS as $cn) {
        if ($cn[0] === $accIdx) {
            $decisionMaker = $cn[1] . '（' . $cn[2] . '）';
            break;
        }
    }
    $req->key_decision_maker_c = $decisionMaker;
    $req->competitor_c = $tpl['comp'];
    $req->risk_factor_c = $tpl['risk'];
    $req->assigned_user_id = $PRESALES;
    $req->save();
    $reqCount++;
}
line("  已创建 {$reqCount} 条需求调研");

/* ============================================================
 * 7. 项目交接（成交商机各 1 份）
 * ------------------------------------------------------------
 * 注意：Opportunities 上注册了 after_save 逻辑钩子
 *       （custom/modules/Opportunities/ai_handover_hook.php），
 *       商机一旦保存为「成交」就会自动生成一份基础交接单。
 *       因此这里采用「有则补全、无则新建」的幂等写法：
 *       - 钩子已经建好的 → 补全业务细节字段；
 *       - 钩子未触发（例如钩子被停用）→ 兜底新建一份。
 * ============================================================ */
step('补全项目交接单（Hand_ProjectHandovers）');

$handCount = 0;
$handAuto = 0;
$handStatus = array('Pending', 'Handed_Over', 'In_Progress', 'Go_Live');
foreach ($OPPS as $i => $o) {
    if ($o[2] !== 'Closed Won') {
        continue;
    }
    $accIdx = $o[0];
    $accName = $ACCOUNTS[$accIdx][0];
    $product = $o[1];
    $tpl = $REQ_TPL[$product];

    // 先找逻辑钩子是否已自动建单（幂等）
    $hand = BeanFactory::getBean('Hand_ProjectHandovers');
    $hand->retrieve_by_string_fields(array('opportunity_id' => $oppIds[$i], 'deleted' => 0));
    if (!empty($hand->id)) {
        $handAuto++;
    } else {
        $hand = BeanFactory::newBean('Hand_ProjectHandovers');
        $hand->handover_no_c = 'HT-2026-' . str_pad((string)($handCount + 1), 4, '0', STR_PAD_LEFT);
        $hand->handover_status_c = 'Pending';
        $hand->handover_date_c = date('Y-m-d', strtotime('-5 days'));
        $hand->account_id = $accountIds[$accIdx];
        $hand->opportunity_id = $oppIds[$i];
    }

    $hand->name = short_name($accName) . ' - ' . ($PRODUCT_ZH[$product] ?? $product) . ' 项目交接单';
    $hand->handover_status_c = $handStatus[$handCount % 4];
    $hand->product_type_c = $product;
    $hand->contract_amount_c = $o[3];
    $hand->currency_id = '-99';
    $hand->handover_date_c = date('Y-m-d', strtotime('-5 days'));
    $hand->start_date_c = date('Y-m-d', strtotime('+3 days'));
    $hand->implementation_cycle_c = '8-12 周';
    $hand->project_goal_c = $tpl['sol'];
    $hand->customer_requirement_c = $tpl['func'];
    $hand->committed_features_c = "1. 完成一期功能开发与部署；\n2. 提供不少于 2 场管理员培训；\n3. 上线后 3 个月免费运维支持。";
    $hand->contract_scope_c = "含软件许可、实施部署、数据初始化、培训与 3 个月质保；不含客户侧硬件与网络改造。";
    $hand->risk_items_c = $tpl['risk'];
    $hand->acceptance_criteria_c = "1. 功能验收：合同范围内功能全部通过测试；\n2. 性能验收：核心场景响应时间达标；\n3. 用户验收：客户关键用户签署验收确认单。";
    $hand->delivery_owner_id = $DELIVERY;
    $hand->assigned_user_id = $SALES;
    $hand->save();
    $handCount++;
}
line("  项目交接单 {$handCount} 份（其中 {$handAuto} 份由「成交自动生成」逻辑钩子创建）");

/* ============================================================
 * 8. 跟进记录（50 条，Tasks）
 * ============================================================ */
step('创建跟进记录（Tasks）');

$FOLLOW_TPL = array(
    '电话跟进：了解项目预算与决策流程',
    '客户拜访：演示产品核心能力',
    '邮件跟进：发送方案建议书初稿',
    '需求澄清：确认功能范围与优先级',
    '商务沟通：讨论报价与付款方式',
    '技术交流：确认系统对接方案',
    '内部评审：组织售前与交付方案评审',
    '客户回访：收集试用阶段反馈',
    '推进会议：确认下一步推进计划',
    '风险沟通：与客户同步实施风险',
);
$TASK_STATUS = array('Completed', 'Completed', 'Not Started', 'In Progress', 'Completed');

$taskCount = 0;
for ($i = 0; $i < 50; $i++) {
    $oppIdx = $i % 30;
    $o = $OPPS[$oppIdx];
    $accIdx = $o[0];
    $accName = $ACCOUNTS[$accIdx][0];

    $task = BeanFactory::newBean('Tasks');
    $task->name = $FOLLOW_TPL[$i % 10] . '｜' . short_name($accName);
    $task->status = $TASK_STATUS[$i % 5];
    $task->priority = ($i % 3 === 0) ? 'High' : 'Medium';
    $task->parent_type = 'Opportunities';
    $task->parent_id = $oppIds[$oppIdx];
    $task->date_due = date('Y-m-d', strtotime('+' . (($i % 30) - 15) . ' days'));
    $task->date_start = date('Y-m-d', strtotime('+' . (($i % 30) - 16) . ' days'));
    $task->assigned_user_id = $SALES;
    $task->description = "客户：{$accName}\n产品：{$o[1]}\n当前阶段：{$o[2]}\n\n跟进要点：" . $o[5];
    $task->save();
    $taskCount++;
}
line("  已创建 {$taskCount} 条跟进记录");

/* ============================================================
 * 9. 汇总
 * ============================================================ */
step('数据汇总');
$summary = array(
    '客户'     => 'accounts',
    '联系人'   => 'contacts',
    '商机'     => 'opportunities',
    '需求调研' => 'creq_customerrequirements',
    '项目交接' => 'hand_projecthandovers',
);
foreach ($summary as $label => $table) {
    $n = (int)$db->getOne("SELECT COUNT(*) FROM {$table} WHERE deleted=0");
    printf("  %-10s %d 条\n", $label, $n);
}

/*
 * 跟进记录分两部分：
 *   - 人工铺的销售跟进（任务书要求 50 条）
 *   - 业务自动化的产物：商机成交时由逻辑钩子派发的"项目交接准备"待办
 * 分开统计，避免看起来像重复写入。
 */
$taskTotal = (int)$db->getOne("SELECT COUNT(*) FROM tasks WHERE deleted=0");
$taskAuto = (int)$db->getOne(
    "SELECT COUNT(*) FROM tasks WHERE deleted=0 AND parent_type='Hand_ProjectHandovers'"
);
printf("  %-10s %d 条（销售跟进 %d + 自动派发交接待办 %d）\n",
    '跟进记录', $taskTotal, $taskTotal - $taskAuto, $taskAuto);

step('商机阶段分布');
$res = $db->query("SELECT sales_stage, COUNT(*) AS c, SUM(amount) AS amt FROM opportunities WHERE deleted=0 GROUP BY sales_stage ORDER BY c DESC");
while ($row = $db->fetchByAssoc($res)) {
    $stageZh = $STAGE_ZH[$row['sales_stage']] ?? $row['sales_stage'];
    printf("  %-14s %2d 个 · 金额 ¥%s\n", $stageZh, $row['c'], number_format((float)$row['amt'], 0));
}

/* 成交周期自检：正常应为正数（客户从创建商机到签约的天数）。
   若出现负数，说明 date_entered 回填未生效（见上方 $db->quoted() 的说明）。 */
step('成交周期自检');
$cyc = $db->fetchByAssoc($db->query(
    "SELECT COUNT(*) AS c,
            ROUND(AVG(DATEDIFF(date_closed, DATE(date_entered))),1) AS avg_d,
            MIN(DATEDIFF(date_closed, DATE(date_entered))) AS min_d
     FROM opportunities WHERE deleted=0 AND sales_stage='Closed Won'"
));
$avgCycle = (float)$cyc['avg_d'];
printf("  已成交 %d 个 · 平均成交周期 %.1f 天（最短 %d 天）\n", $cyc['c'], $avgCycle, $cyc['min_d']);
if ($avgCycle <= 0) {
    line('  [警告] 平均成交周期异常（<=0），请检查 date_entered 回填逻辑！');
}

/* 业务自动化自检：成交商机是否都自动生成了交接单
   （验证 Opportunities 的 after_save 逻辑钩子确实生效） */
step('业务自动化自检（成交 → 自动生成项目交接单）');
$wonTotal = (int)$db->getOne("SELECT COUNT(*) FROM opportunities WHERE deleted=0 AND sales_stage='Closed Won'");
$wonWithHand = (int)$db->getOne(
    "SELECT COUNT(DISTINCT o.id) FROM opportunities o
     JOIN hand_projecthandovers h ON h.opportunity_id = o.id AND h.deleted = 0
     WHERE o.deleted = 0 AND o.sales_stage = 'Closed Won'"
);
printf("  成交商机 %d 个 · 已自动生成交接单 %d 份\n", $wonTotal, $wonWithHand);
if ($wonTotal > 0 && $wonTotal === $wonWithHand) {
    line('  [通过] 成交商机 100% 自动生成项目交接单');
} else {
    line('  [警告] 存在未生成交接单的成交商机，请检查逻辑钩子是否被合并进 custom/modules/Opportunities/Ext/LogicHooks/');
}

line("\n[DONE] 演示数据生成完成");
