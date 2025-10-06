@extends('home')

@section('css_before')
    {{-- ลิงก์ไฟล์ CSS --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="fw-bold">Dashboard — Dorm Booking</h2>
            </div>
        </div>
    </div>

    {{-- ===== Top Cards (Gradient + Equal Height) ===== --}}
    @php
        $totalRooms = ($roomsAvailable ?? 0) + ($roomsOccupied ?? 0) + ($roomsMaintenance ?? 0);
        $issuedTotalForRate = ($invoicePaid ?? 0)+($invoiceIssued ?? 0)+($invoiceDraft ?? 0)+($invoiceOverdue ?? 0);
        $overduePct = $issuedTotalForRate > 0 ? round((($invoiceOverdue ?? 0)/$issuedTotalForRate)*100, 1) : 0;
        $occupiedPct = $totalRooms > 0 ? round((($roomsOccupied ?? 0)/$totalRooms)*100, 1) : 0;
    @endphp

    <div class="container mt-3">
        <div class="row stat-grid">
            {{-- การ์ด: ผู้ใช้ทั้งหมด --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="stat-card stat-green h-100">
                    <div>
                        <h6 class="title">ผู้ใช้ทั้งหมด</h6>
                        <div class="value">{{ number_format($totalUsers) }}</div>
                    </div>
                    <div class="sub">สถานะใช้งาน (ACTIVE): <b>{{ number_format($activeUsers) }}</b></div>
                </div>
            </div>

            {{-- การ์ด: สัญญาเช่าทั้งหมด --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="stat-card stat-purple h-100">
                    <div>
                        <h6 class="title">สัญญาเช่าทั้งหมด</h6>
                        <div class="value">{{ number_format($totalLeases) }}</div>
                    </div>
                    <div class="chips">
                        <span class="chip">กำลังเช่า <b>{{ number_format($activeLeases) }}</b></span>
                        <span class="chip">รอดำเนินการ <b>{{ number_format($pendingLeases) }}</b></span>
                        <span class="chip">สิ้นสุด <b>{{ number_format($endedLeases) }}</b></span>
                        <span class="chip">ยกเลิก <b>{{ number_format($canceledLeases) }}</b></span>
                    </div>
                </div>
            </div>

            {{-- การ์ด: สถานะห้องพัก --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="stat-card stat-blue h-100">
                    <div>
                        <h6 class="title">สถานะห้องพัก</h6>
                    </div>
                    <ul class="stat-list">
                        <li>ว่าง (Available): <b>{{ number_format($roomsAvailable) }}</b></li>
                        <li>มีผู้เช่า (Occupied): <b>{{ number_format($roomsOccupied) }}</b> — {{ $occupiedPct }}% ของ {{ number_format($totalRooms) }}</li>
                        <li>ปิดปรับปรุง (Maintenance): <b>{{ number_format($roomsMaintenance) }}</b></li>
                    </ul>
                </div>
            </div>

            {{-- การ์ด: สถานะใบแจ้งหนี้ --}}
            <div class="col-12 col-md-6 col-lg-3">
                <div class="stat-card stat-orange h-100">
                    <div>
                        <h6 class="title">สถานะใบแจ้งหนี้</h6>
                    </div>
                    <ul class="stat-list">
                        <li>ชำระแล้ว: <b>{{ number_format($invoicePaid) }}</b></li>
                        <li>ออกบิล/ฉบับร่าง: <b>{{ number_format($invoiceIssued + $invoiceDraft) }}</b></li>
                        <li>ค้างชำระ: <b>{{ number_format($invoiceOverdue) }}</b> — {{ $overduePct }}%</li>
                        <li>ยกเลิก: <b>{{ number_format($invoiceCanceled) }}</b></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Utilities / Rent / Other (Bar + Line) ===== --}}
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 d-flex flex-wrap align-items-center justify-content-between">
                <h4 class="mb-3 mb-md-0">ค่าใช้จ่ายรายเดือน (Utilities / Rent / Other)</h4>
                <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Range">
                    <button class="btn btn-outline-secondary" id="btnU6">6 เดือน</button>
                    <button class="btn btn-outline-secondary" id="btnU12">12 เดือน</button>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div id="chartUtilities"></div>
            </div>
        </div>
    </div>

    {{-- ===== ส่วนกราฟล่าง (โดนัท + บาร์) ===== --}}
    <div class="container mt-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="chart-card">
                    <div class="chart-card__head">
                        <h5 class="chart-card__title">สถานะใบแจ้งหนี้</h5>
                    </div>
                    <div class="chart-card__body">
                        <div id="chartInvoiceStatus"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-card">
                    <div class="chart-card__head">
                        <h5 class="chart-card__title">สถานะสัญญาเช่า</h5>
                    </div>
                    <div class="chart-card__body">
                        <div id="chartLeaseStatus"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="chart-card">
                    <div class="chart-card__head chart-card__head--row">
                        <h5 class="chart-card__title mb-0">จำนวนสัญญาเช่าเริ่มใหม่รายเดือน (12 เดือนล่าสุด)</h5>
                    </div>
                    <div class="chart-card__body">
                        <div id="chartLeasesMonthly"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
@endsection

@section('js_before')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ====== Data from Controller ======
            const labels6 = @json($labels6);
            const util6 = @json($util6);
            const rent6 = @json($rent6);
            const other6 = @json($other6);
            const total6 = @json($total6);

            const labels12 = @json($labels12);
            const util12 = @json($util12);
            const rent12 = @json($rent12);
            const other12 = @json($other12);
            const total12 = @json($total12);

            const invoicePaid = @json($invoicePaid);
            const invoiceIssued = @json($invoiceIssued);
            const invoiceDraft = @json($invoiceDraft);
            const invoiceOverdue = @json($invoiceOverdue);
            const invoiceCanceled = @json($invoiceCanceled);

            const leasesMonthlyLabels = @json($leasesMonthlyLabels);
            const leasesMonthlyData = @json($leasesMonthlyData);

            const activeLeases = @json($activeLeases);
            const pendingLeases = @json($pendingLeases);
            const endedLeases = @json($endedLeases);
            const canceledLeases = @json($canceledLeases);

            // ===== Utilities / Rent / Other (function เดิม ปรับเฉพาะ UI) =====
            function utilOptions({ labels, util, rent, other, total }) {
                return {
                    chart: {
                        height: 380,
                        type: 'line',
                        toolbar: { show: true },
                        dropShadow: { enabled: true, top: 3, left: 0, blur: 4, opacity: 0.1 }
                    },
                    series: [
                        { name: 'ค่าสาธารณูปโภค', type: 'column', data: util },
                        { name: 'ค่าเช่า', type: 'column', data: rent },
                        { name: 'ค่าอื่น ๆ', type: 'column', data: other },
                        { name: 'รวม', type: 'line', data: total }
                    ],
                    stroke: { width: [0,0,0,3], curve: 'smooth' },
                    colors: ['#3b82f6','#22c55e','#f59e0b','#ef4444'],
                    dataLabels: {
                        enabled: true,
                        enabledOnSeries: [3],      // โชว์เฉพาะเส้น "รวม"
                        style: { fontSize: '12px', fontWeight: 600, colors: ['#ef4444'] },
                        background: { enabled: false },
                        formatter: v => (Number(v)||0).toLocaleString()
                    },
                    plotOptions: { bar: { borderRadius: 8, columnWidth: '45%', endingShape: 'rounded' } },
                    xaxis: {
                        categories: labels,
                        labels: { style: { fontSize: '12px', colors: '#475569' } },
                        axisBorder: { show: false }, axisTicks: { show: false }
                    },
                    yaxis: {
                        labels: {
                            formatter: v => (Number(v)||0).toLocaleString(),
                            style: { fontSize: '12px', colors: '#475569' }
                        },
                        title: { text: 'บาท', style: { fontWeight: 500 } }
                    },
                    grid: { borderColor: '#e2e8f0', strokeDashArray: 5 },
                    legend: { position: 'top', fontSize: '13px', itemMargin: { horizontal: 10, vertical: 2 } },
                    tooltip: { shared: true, intersect: false, y: { formatter: v => (Number(v)||0).toLocaleString() } },
                    markers: { size: 5, strokeWidth: 2, strokeColors: '#fff', hover: { size: 7 } },
                    fill: {
                        opacity: [0.9,0.9,0.9,1],
                        gradient: { shade: 'light', type: 'vertical', shadeIntensity: 0.25, opacityFrom: 0.9, opacityTo: 0.8, stops: [0,90,100] }
                    }
                };
            }

            // ===== Render Utilities / Rent / Other + ปุ่ม 6/12 เดือน =====
            const elUtil = document.querySelector('#chartUtilities');
            if (elUtil) {
                let utilChart = new ApexCharts(elUtil, utilOptions({
                    labels: labels6, util: util6, rent: rent6, other: other6, total: total6
                }));
                utilChart.render();

                const btnU6 = document.getElementById('btnU6');
                const btnU12 = document.getElementById('btnU12');

                function setBtnActive(on, off) {
                    if (!on || !off) return;
                    off.classList.remove('btn-secondary', 'text-white');
                    off.classList.add('btn-outline-secondary');
                    on.classList.remove('btn-outline-secondary');
                    on.classList.add('btn-secondary', 'text-white');
                }
                setBtnActive(btnU6, btnU12);

                btnU6?.addEventListener('click', () => {
                    setBtnActive(btnU6, btnU12);
                    utilChart.updateOptions(utilOptions({
                        labels: labels6, util: util6, rent: rent6, other: other6, total: total6
                    }));
                });
                btnU12?.addEventListener('click', () => {
                    setBtnActive(btnU12, btnU6);
                    utilChart.updateOptions(utilOptions({
                        labels: labels12, util: util12, rent: rent12, other: other12, total: total12
                    }));
                });
            }

            // ===== Donut: Invoice =====
            const elInv = document.querySelector('#chartInvoiceStatus');
            if (elInv) {
                new ApexCharts(elInv, {
                    chart: { type: 'donut', height: 320, dropShadow: { enabled: true, top: 2, left: 0, blur: 3, opacity: 0.15 } },
                    series: [invoicePaid, invoiceIssued, invoiceDraft, invoiceOverdue, invoiceCanceled],
                    labels: ['ชำระแล้ว', 'ออกบิล', 'ฉบับร่าง', 'ค้างชำระ', 'ยกเลิก'],
                    legend: { position: 'bottom', fontSize: '13px', itemMargin: { horizontal: 8 } },
                    dataLabels: { enabled: true, style: { fontSize: '12px', fontWeight: 500 } },
                    tooltip: { y: { formatter: v => (Number(v)||0).toLocaleString() } },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '72%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true, label: 'รวม', fontSize: '13px',
                                        formatter: w => w.globals.seriesTotals.reduce((a,b)=>a+b,0).toLocaleString()
                                    }
                                }
                            }
                        }
                    },
                    stroke: { width: 1 },
                    colors: ['#22c55e','#6366f1','#a855f7','#ef4444','#94a3b8']
                }).render();
            }

            // ===== Donut: Lease =====
            const elLease = document.querySelector('#chartLeaseStatus');
            if (elLease) {
                new ApexCharts(elLease, {
                    chart: { type: 'donut', height: 320, dropShadow: { enabled: true, top: 2, left: 0, blur: 3, opacity: 0.15 } },
                    series: [activeLeases, pendingLeases, endedLeases, canceledLeases],
                    labels: ['กำลังเช่า', 'รอดำเนินการ', 'สิ้นสุด', 'ยกเลิก'],
                    legend: { position: 'bottom', fontSize: '13px', itemMargin: { horizontal: 8 } },
                    dataLabels: { enabled: true, style: { fontSize: '12px', fontWeight: 500 } },
                    tooltip: { y: { formatter: v => (Number(v)||0).toLocaleString() } },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '72%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true, label: 'รวม', fontSize: '13px',
                                        formatter: w => w.globals.seriesTotals.reduce((a,b)=>a+b,0).toLocaleString()
                                    }
                                }
                            }
                        }
                    },
                    stroke: { width: 1 },
                    colors: ['#0ea5e9','#f59e0b','#10b981','#ef4444']
                }).render();
            }

            // ===== Bar: Leases Monthly =====
            const elLeaseBar = document.querySelector('#chartLeasesMonthly');
            if (elLeaseBar) {
                new ApexCharts(elLeaseBar, {
                    chart: { type: 'bar', height: 320, toolbar: { show: true }, dropShadow: { enabled: true, top: 2, left: 0, blur: 3, opacity: 0.15 } },
                    series: [{ name: 'เริ่มสัญญาใหม่', data: leasesMonthlyData }],
                    xaxis: { categories: leasesMonthlyLabels, labels: { rotate: -15, style: { fontSize: '12px' } }, axisBorder: { show: false } },
                    yaxis: { forceNiceScale: true, labels: { style: { fontSize: '12px' } } },
                    grid: { borderColor: '#eef2f7', strokeDashArray: 4 },
                    plotOptions: { bar: { borderRadius: 8, columnWidth: '55%', dataLabels: { position: 'top' } } },
                    dataLabels: { enabled: true, offsetY: -14, style: { fontSize: '11px', fontWeight: 500 }, formatter: v => (Number(v)||0).toLocaleString() },
                    tooltip: { y: { formatter: v => (Number(v)||0).toLocaleString() } },
                    fill: { type: 'gradient', gradient: { shadeIntensity: 0.15, opacityFrom: 0.95, opacityTo: 0.85, stops: [0, 90, 100] } },
                    colors: ['#6366f1'],
                    states: { hover: { filter: { type: 'lighten', value: 0.05 } } },
                    legend: { position: 'top', fontSize: '13px' }
                }).render();
            }
        });
    </script>
@endsection
