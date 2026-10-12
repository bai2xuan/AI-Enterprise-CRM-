<?php
/**
 * 智联AI科技有限公司 · AI Enterprise CRM
 * 销售分析看板（模块 4）
 * ------------------------------------------------------------------
 * 访问入口：index.php?module=AID_SalesAnalytics&action=index
 *          （SuiteCRM 会把 action=index 重映射为 listview，因此本视图文件名为
 *            views/view.list.php，类名为 AID_SalesAnalyticsViewList，
 *            这样模块的默认入口、顶部导航 Tab、快捷菜单都直接落到本看板。）
 *
 * 展示内容：
 *   ① 核心指标：客户数 / 商机数 / 预计销售金额 / 成交金额 / 成交率 / 平均成交周期
 *   ② 销售漏斗：初步接触 → 需求调研 → 方案设计 → 产品演示 → 商务谈判 → 成交
 *   ③ 四类分析图表：阶段商机分布 / 产品销售金额 / 客户行业分布 / 输单原因归因
 *
 * 实现说明：
 *   - 本视图完全走 SuiteCRM 扩展机制（modules/<Module>/views/），未修改任何核心文件；
 *   - 页面外壳复用 SuiteCRM 的 displayHeader()，图表使用本地 ECharts（无外网依赖）；
 *   - 继承 SugarView 而非 ViewList：本模块不承载列表数据，仅展示只读看板。
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'include/MVC/View/SugarView.php';

class AID_SalesAnalyticsViewList extends SugarView
{
    /** @var DBManager */
    private $db;

    /** 销售阶段顺序（Key 保持英文，与 SuiteCRM 内部一致） */
    private $stageOrder = array(
        'Prospecting', 'Needs Analysis', 'Value Proposition',
        'Perception Analysis', 'Negotiation/Review', 'Closed Won', 'Closed Lost',
    );

    /** 漏斗仅统计正向推进阶段 */
    private $funnelOrder = array(
        'Prospecting', 'Needs Analysis', 'Value Proposition',
        'Perception Analysis', 'Negotiation/Review', 'Closed Won',
    );

    private $stageZh = array(
        'Prospecting'         => '初步接触',
        'Needs Analysis'      => '需求调研',
        'Value Proposition'   => '方案设计',
        'Perception Analysis' => '产品演示',
        'Negotiation/Review'  => '商务谈判',
        'Closed Won'          => '成交',
        'Closed Lost'         => '输单',
    );

    private $productZh = array(
        'AI Knowledge Base'       => 'AI 知识库系统',
        'AI Customer Service'     => '企业智能客服',
        'AI Office Assistant'     => 'AI 办公助手',
        'Data Analytics Platform' => '数据智能分析平台',
    );

    private $industryZh = array(
        'Manufacturing' => '制造业', 'Finance' => '金融', 'Healthcare' => '医疗健康',
        'Internet' => '互联网', 'Education' => '教育', 'Energy' => '能源',
        'Government' => '政府机构', 'Retail' => '零售', 'Logistics' => '物流',
    );

    private $lostZh = array(
        'Price' => '价格竞争力不足', 'Features' => '产品功能不满足', 'Delivery' => '实施与交付周期',
        'Competitor' => '选择竞品', 'Budget' => '预算取消或延期', 'Decision Process' => '决策流程变更',
        'Relationship' => '客户关系因素', 'Other' => '其他',
    );

    /* ============================================================
     * 入口
     * ============================================================ */
    public function display()
    {
        $this->db = DBManagerFactory::getInstance();

        $this->displayHeader();
        echo $this->renderDashboard();
    }

    /* ============================================================
     * 数据：核心指标
     * ============================================================ */
    private function getKpis()
    {
        $q = function ($sql) {
            $v = $this->db->getOne($sql);
            return $v === null ? 0 : $v;
        };

        $accounts     = (int)$q("SELECT COUNT(*) FROM accounts WHERE deleted=0");
        $opps         = (int)$q("SELECT COUNT(*) FROM opportunities WHERE deleted=0");
        $pipeline     = (float)$q("SELECT SUM(amount) FROM opportunities WHERE deleted=0 AND sales_stage NOT IN ('Closed Won','Closed Lost')");
        $wonAmount    = (float)$q("SELECT SUM(amount) FROM opportunities WHERE deleted=0 AND sales_stage='Closed Won'");
        $wonCount     = (int)$q("SELECT COUNT(*) FROM opportunities WHERE deleted=0 AND sales_stage='Closed Won'");
        $lostCount    = (int)$q("SELECT COUNT(*) FROM opportunities WHERE deleted=0 AND sales_stage='Closed Lost'");
        $avgCycle     = (float)$q("SELECT AVG(DATEDIFF(date_closed, DATE(date_entered))) FROM opportunities WHERE deleted=0 AND sales_stage='Closed Won'");

        $closed = $wonCount + $lostCount;
        $winRate = $closed > 0 ? round($wonCount * 100 / $closed, 1) : 0;

        return array(
            array('label' => '客户总数',       'value' => number_format($accounts),      'unit' => '家',       'tone' => 'blue',   'hint' => '在册有效客户'),
            array('label' => '商机总数',       'value' => number_format($opps),          'unit' => '个',       'tone' => 'indigo', 'hint' => '全部销售机会'),
            array('label' => '在途预计金额',   'value' => $this->wan($pipeline),         'unit' => '万元',     'tone' => 'cyan',   'hint' => '未结案商机金额合计'),
            array('label' => '已成交金额',     'value' => $this->wan($wonAmount),        'unit' => '万元',     'tone' => 'green',  'hint' => '已签约合同金额'),
            array('label' => '商机成交率',     'value' => $winRate,                      'unit' => '%',        'tone' => 'amber',  'hint' => '成交 /（成交+输单）'),
            array('label' => '平均成交周期',   'value' => round($avgCycle),              'unit' => '天',       'tone' => 'rose',   'hint' => '从商机创建到签约'),
        );
    }

    /* ============================================================
     * 数据：漏斗（阶段）
     * ============================================================ */
    private function getStageStats()
    {
        $rows = array();
        $res = $this->db->query("SELECT sales_stage, COUNT(*) AS c, SUM(amount) AS amt
                                 FROM opportunities WHERE deleted=0 GROUP BY sales_stage");
        while ($r = $this->db->fetchByAssoc($res)) {
            $rows[$r['sales_stage']] = array('count' => (int)$r['c'], 'amount' => (float)$r['amt']);
        }
        $out = array();
        foreach ($this->stageOrder as $s) {
            $out[$s] = array(
                'key'    => $s,
                'label'  => $this->stageZh[$s],
                'count'  => isset($rows[$s]) ? $rows[$s]['count'] : 0,
                'amount' => isset($rows[$s]) ? $rows[$s]['amount'] : 0,
            );
        }
        return $out;
    }

    /* ============================================================
     * 数据：按产品
     * ============================================================ */
    private function getProductStats()
    {
        $out = array();
        foreach ($this->productZh as $k => $zh) {
            $out[$k] = array('label' => $zh, 'count' => 0, 'amount' => 0);
        }
        $res = $this->db->query("SELECT product_type_c, COUNT(*) AS c, SUM(amount) AS amt
                                 FROM opportunities WHERE deleted=0 AND product_type_c IS NOT NULL AND product_type_c<>''
                                 GROUP BY product_type_c");
        while ($r = $this->db->fetchByAssoc($res)) {
            $k = $r['product_type_c'];
            $label = isset($this->productZh[$k]) ? $this->productZh[$k] : $k;
            if (!isset($out[$k])) {
                $out[$k] = array('label' => $label, 'count' => 0, 'amount' => 0);
            }
            $out[$k]['count']  = (int)$r['c'];
            $out[$k]['amount'] = (float)$r['amt'];
        }
        return array_values($out);
    }

    /* ============================================================
     * 数据：客户行业分布
     * ============================================================ */
    private function getIndustryStats()
    {
        $out = array();
        $res = $this->db->query("SELECT industry, COUNT(*) AS c FROM accounts WHERE deleted=0
                                 AND industry IS NOT NULL AND industry<>'' GROUP BY industry ORDER BY c DESC");
        while ($r = $this->db->fetchByAssoc($res)) {
            $k = $r['industry'];
            $out[] = array(
                'label' => isset($this->industryZh[$k]) ? $this->industryZh[$k] : $k,
                'count' => (int)$r['c'],
            );
        }
        return $out;
    }

    /* ============================================================
     * 数据：输单原因
     * ============================================================ */
    private function getLostStats()
    {
        $out = array();
        $res = $this->db->query("SELECT lost_reason_c, COUNT(*) AS c, SUM(amount) AS amt
                                 FROM opportunities WHERE deleted=0 AND sales_stage='Closed Lost'
                                 AND lost_reason_c IS NOT NULL AND lost_reason_c<>''
                                 GROUP BY lost_reason_c ORDER BY c DESC");
        while ($r = $this->db->fetchByAssoc($res)) {
            $k = $r['lost_reason_c'];
            $out[] = array(
                'label'  => isset($this->lostZh[$k]) ? $this->lostZh[$k] : $k,
                'count'  => (int)$r['c'],
                'amount' => (float)$r['amt'],
            );
        }
        return $out;
    }

    /* ============================================================
     * 工具：金额转万元
     * ============================================================ */
    private function wan($n)
    {
        $n = (float)$n;
        if ($n >= 10000) {
            return number_format($n / 10000, 1);
        }
        return number_format($n, 0);
    }

    /* ============================================================
     * 渲染
     * ============================================================ */
    private function renderDashboard()
    {
        $kpis      = $this->getKpis();
        $stages    = $this->getStageStats();
        $products  = $this->getProductStats();
        $industries = $this->getIndustryStats();
        $lostList  = $this->getLostStats();

        // ---------- 漏斗（累计口径）----------
        // 单看"当前阶段分布"画不出漏斗形状；漏斗的业务含义是
        // "进入该阶段及其后续阶段的商机数"，因此这里做后向累计：
        //   进入初步接触 = 全部在途+成交商机
        //   进入需求调研 = 进入初步接触 − 停留在初步接触的
        //   …… 依次递减，成交数为最后一层。
        // 已输单商机不计入（无法确定它推进到了哪一步）。
        $funnelData = array();
        $funnelBase = 0;
        foreach ($this->funnelOrder as $s) {
            $funnelBase += $stages[$s]['count'];
        }
        $reached = $funnelBase;
        foreach ($this->funnelOrder as $s) {
            $funnelData[] = array(
                'name'    => $this->stageZh[$s],
                'value'   => $reached,
                'reached' => $funnelBase > 0 ? round($reached * 100 / $funnelBase, 1) : 0,
            );
            $reached -= $stages[$s]['count'];
        }

        // 阶段柱状图
        $stageLabels = array();
        $stageCounts = array();
        $stageAmounts = array();
        foreach ($this->stageOrder as $s) {
            $stageLabels[]  = $this->stageZh[$s];
            $stageCounts[]  = $stages[$s]['count'];
            $stageAmounts[] = round($stages[$s]['amount'] / 10000, 1);
        }

        $productLabels = array();
        $productAmounts = array();
        $productCounts = array();
        foreach ($products as $p) {
            $productLabels[]  = $p['label'];
            $productAmounts[] = round($p['amount'] / 10000, 1);
            $productCounts[]  = $p['count'];
        }

        $industryData = array();
        foreach ($industries as $it) {
            $industryData[] = array('name' => $it['label'], 'value' => $it['count']);
        }

        $lostLabels = array();
        $lostCounts = array();
        $lostAmounts = array();
        foreach ($lostList as $l) {
            $lostLabels[]  = $l['label'];
            $lostCounts[]  = $l['count'];
            $lostAmounts[] = round($l['amount'] / 10000, 1);
        }

        $chartPayload = array(
            'funnel'  => $funnelData,
            'stage'   => array('labels' => $stageLabels, 'counts' => $stageCounts, 'amounts' => $stageAmounts),
            'product' => array('labels' => $productLabels, 'amounts' => $productAmounts, 'counts' => $productCounts),
            'industry' => $industryData,
            'lost'    => array('labels' => $lostLabels, 'counts' => $lostCounts, 'amounts' => $lostAmounts),
        );

        $jsonOpts = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
        $chartJson = json_encode($chartPayload, $jsonOpts);

        $generated = date('Y-m-d H:i');
        $assets = 'custom/include/ai_assets/echarts.min.js';

        // ---------- KPI 卡片 ----------
        $kpiHtml = '';
        foreach ($kpis as $k) {
            $kpiHtml .= '<div class="ai-kpi ai-kpi--' . $k['tone'] . '">'
                . '<div class="ai-kpi__label">' . $k['label'] . '</div>'
                . '<div class="ai-kpi__value">' . $k['value'] . '<span class="ai-kpi__unit">' . $k['unit'] . '</span></div>'
                . '<div class="ai-kpi__hint">' . $k['hint'] . '</div>'
                . '</div>';
        }

        ob_start();
        ?>
<style>
.ai-dashboard{padding:18px 22px 40px;background:#f5f7fa;min-height:100%;font-family:-apple-system,"Segoe UI","Microsoft YaHei",sans-serif;color:#1f2937}
.ai-dashboard *{box-sizing:border-box}
.ai-head{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:8px}
.ai-head h1{font-size:22px;font-weight:600;margin:0;color:#111827;letter-spacing:.5px}
.ai-head .ai-sub{font-size:12px;color:#6b7280;margin-top:6px}
.ai-head .ai-stamp{font-size:12px;color:#9ca3af}
.ai-kpis{display:grid;grid-template-columns:repeat(6,1fr);gap:14px;margin-bottom:16px}
.ai-kpi{background:#fff;border:1px solid #e8ecf2;border-radius:10px;padding:14px 16px;position:relative;overflow:hidden;box-shadow:0 1px 2px rgba(16,24,40,.04)}
.ai-kpi::before{content:"";position:absolute;left:0;top:0;bottom:0;width:4px;background:#3b82f6}
.ai-kpi--indigo::before{background:#6366f1}
.ai-kpi--cyan::before{background:#06b6d4}
.ai-kpi--green::before{background:#10b981}
.ai-kpi--amber::before{background:#f59e0b}
.ai-kpi--rose::before{background:#f43f5e}
.ai-kpi__label{font-size:12px;color:#6b7280;margin-bottom:8px}
.ai-kpi__value{font-size:26px;font-weight:700;color:#111827;line-height:1.1}
.ai-kpi__unit{font-size:12px;font-weight:500;color:#9ca3af;margin-left:4px}
.ai-kpi__hint{font-size:11px;color:#b0b7c3;margin-top:8px}
.ai-card{background:#fff;border:1px solid #e8ecf2;border-radius:10px;padding:14px 16px 8px;box-shadow:0 1px 2px rgba(16,24,40,.04);margin-bottom:16px}
.ai-card__title{font-size:14px;font-weight:600;color:#111827;margin-bottom:4px;display:flex;align-items:center;gap:8px}
.ai-card__title::before{content:"";width:3px;height:14px;background:#3b82f6;border-radius:2px;display:inline-block}
.ai-card__sub{font-size:11px;color:#9ca3af;margin-bottom:8px}
.ai-grid-2{display:grid;grid-template-columns:5fr 7fr;gap:16px}
.ai-grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.ai-chart{width:100%;height:320px}
.ai-chart--tall{height:360px}
.ai-funnel-legend{margin-top:8px}
@media (max-width:1400px){.ai-kpis{grid-template-columns:repeat(3,1fr)}}
@media (max-width:1100px){.ai-grid-2,.ai-grid-3{grid-template-columns:1fr}}
</style>

<div class="ai-dashboard">
    <div class="ai-head">
        <div>
            <h1>销售经营分析看板</h1>
            <div class="ai-sub">智联AI科技 · AI 解决方案销售管道 · 数据实时取自 CRM 业务库</div>
        </div>
        <div class="ai-stamp">生成时间：<?php echo $generated; ?></div>
    </div>

    <div class="ai-kpis"><?php echo $kpiHtml; ?></div>

    <div class="ai-grid-2">
        <div class="ai-card">
            <div class="ai-card__title">销售漏斗</div>
            <div class="ai-card__sub">累计口径：进入该阶段及后续阶段的商机数（不含已输单）</div>
            <div id="aiChartFunnel" class="ai-chart ai-chart--tall"></div>
        </div>
        <div class="ai-card">
            <div class="ai-card__title">各阶段商机数量</div>
            <div class="ai-card__sub">柱状：商机数量（个）　折线：金额（万元）</div>
            <div id="aiChartStage" class="ai-chart ai-chart--tall"></div>
        </div>
    </div>

    <div class="ai-grid-3">
        <div class="ai-card">
            <div class="ai-card__title">产品销售金额</div>
            <div class="ai-card__sub">按产品类型汇总（万元）</div>
            <div id="aiChartProduct" class="ai-chart"></div>
        </div>
        <div class="ai-card">
            <div class="ai-card__title">客户行业分布</div>
            <div class="ai-card__sub">按客户所属行业统计（家）</div>
            <div id="aiChartIndustry" class="ai-chart"></div>
        </div>
        <div class="ai-card">
            <div class="ai-card__title">输单原因分析</div>
            <div class="ai-card__sub">按输单商机的原因归类（个）</div>
            <div id="aiChartLost" class="ai-chart"></div>
        </div>
    </div>
</div>

<script src="<?php echo $assets; ?>"></script>
<script>
(function () {
    var DATA = <?php echo $chartJson; ?>;
    if (typeof echarts === 'undefined') { return; }

    var PALETTE = ['#3b82f6', '#6366f1', '#06b6d4', '#10b981', '#f59e0b', '#f43f5e', '#8b5cf6', '#14b8a6', '#64748b'];
    var TXT = '#1f2937', SUB = '#9ca3af', LINE = '#e5e7eb';

    function baseGrid() {
        return { left: 10, right: 20, top: 40, bottom: 10, containLabel: true };
    }

    var charts = [];

    // ---------- 1. 销售漏斗（累计口径） ----------
    var funnel = echarts.init(document.getElementById('aiChartFunnel'));
    funnel.setOption({
        tooltip: {
            trigger: 'item',
            formatter: function (p) {
                return p.name + '<br/>累计商机：' + p.value + ' 个<br/>占管道总量：' + p.data.reached + '%';
            }
        },
        legend: { bottom: 0, textStyle: { color: TXT, fontSize: 12 }, itemWidth: 10, itemHeight: 10 },
        series: [{
            type: 'funnel',
            left: '8%', right: '8%', top: 24, bottom: 40,
            minSize: '34%', maxSize: '100%',
            sort: 'none',            // 保持销售阶段顺序，不做数值排序
            gap: 3,
            label: { show: true, position: 'inside', formatter: '{b}  {c}', color: '#fff', fontSize: 13, fontWeight: 600 },
            itemStyle: { borderColor: '#fff', borderWidth: 2 },
            emphasis: { label: { fontSize: 15 } },
            data: DATA.funnel
        }],
        color: PALETTE
    });
    charts.push(funnel);

    // ---------- 2. 各阶段商机数量 + 金额 ----------
    var stage = echarts.init(document.getElementById('aiChartStage'));
    stage.setOption({
        tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
        legend: { top: 0, textStyle: { color: TXT, fontSize: 12 } },
        grid: baseGrid(),
        xAxis: {
            type: 'category',
            data: DATA.stage.labels,
            axisLine: { lineStyle: { color: LINE } },
            axisLabel: { color: TXT, fontSize: 11, interval: 0 }
        },
        yAxis: [
            { type: 'value', name: '商机数', nameTextStyle: { color: SUB, fontSize: 11 },
              axisLabel: { color: SUB }, splitLine: { lineStyle: { color: '#f1f5f9' } } },
            { type: 'value', name: '金额(万)', nameTextStyle: { color: SUB, fontSize: 11 },
              axisLabel: { color: SUB }, splitLine: { show: false } }
        ],
        series: [
            { name: '商机数量', type: 'bar', data: DATA.stage.counts, barWidth: '42%',
              itemStyle: { color: '#3b82f6', borderRadius: [4, 4, 0, 0] },
              label: { show: true, position: 'top', color: TXT, fontSize: 11 } },
            { name: '金额(万元)', type: 'line', yAxisIndex: 1, data: DATA.stage.amounts, smooth: true,
              symbolSize: 7, lineStyle: { width: 2, color: '#f59e0b' }, itemStyle: { color: '#f59e0b' } }
        ]
    });
    charts.push(stage);

    // ---------- 3. 产品销售金额 ----------
    // 数值标签已经直接标在条形末端，X 轴刻度反而会拥挤，故隐藏轴标签与网格线
    var product = echarts.init(document.getElementById('aiChartProduct'));
    product.setOption({
        tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' }, formatter: '{b}<br/>金额：{c} 万元' },
        grid: { left: 10, right: 56, top: 16, bottom: 8, containLabel: true },
        xAxis: { type: 'value', axisLabel: { show: false }, axisLine: { show: false }, axisTick: { show: false }, splitLine: { show: false } },
        yAxis: {
            type: 'category', data: DATA.product.labels,
            axisLine: { lineStyle: { color: LINE } }, axisTick: { show: false },
            axisLabel: { color: TXT, fontSize: 11 }
        },
        series: [{
            type: 'bar', data: DATA.product.amounts, barWidth: '46%',
            itemStyle: { color: '#10b981', borderRadius: [0, 4, 4, 0] },
            label: { show: true, position: 'right', color: TXT, fontSize: 11, formatter: '{c} 万' }
        }]
    });
    charts.push(product);

    // ---------- 4. 客户行业分布 ----------
    // 行业分类较多（9 类），外圈只标占比、名称交给图例，避免标签互相压盖
    var industry = echarts.init(document.getElementById('aiChartIndustry'));
    industry.setOption({
        tooltip: { trigger: 'item', formatter: '{b}<br/>客户：{c} 家（{d}%）' },
        legend: { type: 'scroll', bottom: 0, textStyle: { color: TXT, fontSize: 11 }, itemWidth: 9, itemHeight: 9, itemGap: 8 },
        series: [{
            type: 'pie', radius: ['46%', '70%'], center: ['50%', '43%'],
            avoidLabelOverlap: true,
            minAngle: 6,
            itemStyle: { borderColor: '#fff', borderWidth: 2 },
            label: { show: true, formatter: '{d}%', color: TXT, fontSize: 11 },
            labelLine: { length: 6, length2: 6 },
            data: DATA.industry
        }],
        color: PALETTE
    });
    charts.push(industry);

    // ---------- 5. 输单原因 ----------
    var lost = echarts.init(document.getElementById('aiChartLost'));
    lost.setOption({
        tooltip: {
            trigger: 'axis', axisPointer: { type: 'shadow' },
            formatter: function (arr) {
                var i = arr[0].dataIndex;
                return arr[0].name + '<br/>输单：' + arr[0].value + ' 个<br/>涉及金额：' + DATA.lost.amounts[i] + ' 万元';
            }
        },
        grid: { left: 10, right: 48, top: 16, bottom: 8, containLabel: true },
        xAxis: {
            type: 'value', minInterval: 1,
            axisLabel: { show: false }, axisLine: { show: false },
            axisTick: { show: false }, splitLine: { show: false }
        },
        yAxis: {
            type: 'category', data: DATA.lost.labels, inverse: true,
            axisLine: { lineStyle: { color: LINE } }, axisTick: { show: false },
            axisLabel: { color: TXT, fontSize: 11 }
        },
        series: [{
            type: 'bar', data: DATA.lost.counts, barWidth: '44%',
            itemStyle: { color: '#f43f5e', borderRadius: [0, 4, 4, 0] },
            label: { show: true, position: 'right', color: TXT, fontSize: 11, formatter: '{c} 个' }
        }]
    });
    charts.push(lost);

    // 自适应
    window.addEventListener('resize', function () {
        charts.forEach(function (c) { c.resize(); });
    });
})();
</script>
        <?php
        return ob_get_clean();
    }
}
