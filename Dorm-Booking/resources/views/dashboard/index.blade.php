@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h4>Dashboard — Dorm Booking</h4>
            </div>
        </div>
    </div>

    {{-- Cards --}}
    {{-- การ์ดสรุปภาพรวม (ภาษาไทย) --}}
    <div class="container mt-4">
        <div class="row g-3">

            {{-- ผู้ใช้ --}}
            <div class="col-md-3">
                <div class="alert alert-info" role="alert">
                    <h5 class="mb-1">ผู้ใช้ทั้งหมด</h5>
                    <div class="display-6 fw-bold">{{ number_format($totalUsers) }}</div>
                    <div class="small text-muted">สถานะใช้งาน (ACTIVE): {{ number_format($activeUsers) }}</div>
                </div>
            </div>

            {{-- สัญญาเช่า --}}
            <div class="col-md-3">
                <div class="alert alert-success" role="alert">
                    <h5 class="mb-1">สัญญาเช่าทั้งหมด</h5>
                    <div class="display-6 fw-bold">{{ number_format($totalLeases) }}</div>
                    <div class="small mt-1">
                        <span class="badge bg-success">กำลังเช่า {{ number_format($activeLeases) }}</span>
                        <span class="badge bg-secondary">รอดำเนินการ {{ number_format($pendingLeases) }}</span>
                        <span class="badge bg-dark">สิ้นสุด {{ number_format($endedLeases) }}</span>
                        <span class="badge bg-danger">ยกเลิก {{ number_format($canceledLeases) }}</span>
                    </div>
                </div>
            </div>

            {{-- ห้องพัก --}}
            <div class="col-md-3">
                <div class="alert alert-primary" role="alert">
                    <h5 class="mb-1">สถานะห้องพัก</h5>
                    <ul class="list-unstyled mb-0 small">
                        <li>ว่าง (Available): <strong>{{ number_format($roomsAvailable) }}</strong></li>
                        <li>มีผู้เช่า (Occupied): <strong>{{ number_format($roomsOccupied) }}</strong></li>
                        <li>ปิดปรับปรุง (Maintenance): <strong>{{ number_format($roomsMaintenance) }}</strong></li>
                    </ul>
                </div>
            </div>

            {{-- ใบแจ้งหนี้ --}}
            <div class="col-md-3">
                <div class="alert alert-warning" role="alert">
                    <h5 class="mb-1">สถานะใบแจ้งหนี้</h5>
                    <ul class="list-unstyled mb-0 small">
                        <li>ชำระแล้ว: <strong>{{ number_format($invoicePaid) }}</strong></li>
                        <li>ออกบิล/ฉบับร่าง: <strong>{{ number_format($invoiceIssued + $invoiceDraft) }}</strong></li>
                        <li>ค้างชำระ: <strong>{{ number_format($invoiceOverdue) }}</strong></li>
                        <li>ยกเลิก: <strong>{{ number_format($invoiceCanceled) }}</strong></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>


    {{-- Utilities / Rent / Other (6M/12M) --}}
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

    {{-- Donuts --}}
    <div class="container mt-4">
        <div class="row g-4">
            <div class="col-md-6">
                <h5 class="mb-3">สถานะใบแจ้งหนี้</h5>
                <div id="chartInvoiceStatus"></div>
            </div>
            <div class="col-md-6">
                <h5 class="mb-3">สถานะสัญญาเช่า</h5>
                <div id="chartLeaseStatus"></div>
            </div>
        </div>
    </div>

    {{-- Leases Monthly --}}
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h5 class="mb-3">จำนวนสัญญาเช่าเริ่มใหม่รายเดือน (12 เดือนล่าสุด)</h5>
                <div id="chartLeasesMonthly"></div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection

@section('js_before')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            // ====== Utilities / Rent / Other (ตั้งชื่อซีรีส์เป็นไทยที่นี่เลย) ======
            function utilOptions({
                labels,
                util,
                rent,
                other,
                total
            }) {
                return {
                    chart: {
                        type: 'line',
                        height: 360,
                        toolbar: {
                            show: true
                        }
                    },
                    series: [{
                            name: 'ค่าสาธารณูปโภค',
                            type: 'column',
                            data: util
                        },
                        {
                            name: 'ค่าเช่า',
                            type: 'column',
                            data: rent
                        },
                        {
                            name: 'ค่าอื่น ๆ',
                            type: 'column',
                            data: other
                        },
                        {
                            name: 'รวม',
                            type: 'line',
                            data: total
                        }
                    ],
                    xaxis: {
                        categories: labels
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: [0, 0, 0, 3]
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 6,
                            columnWidth: '45%'
                        }
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                        y: {
                            formatter: v => (Number(v) || 0).toLocaleString()
                        }
                    },
                    legend: {
                        position: 'top'
                    },
                    yaxis: {
                        forceNiceScale: true
                    }
                };
            }

            // === Chart: Utilities ===
            const elUtil = document.querySelector('#chartUtilities');
            if (elUtil) {
                let utilChart = new ApexCharts(elUtil, utilOptions({
                    labels: labels6,
                    util: util6,
                    rent: rent6,
                    other: other6,
                    total: total6
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
                        labels: labels6,
                        util: util6,
                        rent: rent6,
                        other: other6,
                        total: total6
                    }));
                });
                btnU12?.addEventListener('click', () => {
                    setBtnActive(btnU12, btnU6);
                    utilChart.updateOptions(utilOptions({
                        labels: labels12,
                        util: util12,
                        rent: rent12,
                        other: other12,
                        total: total12
                    }));
                });
            }

            // === Chart: Invoice Status (Donut) — ตั้ง labels เป็นไทยตรงนี้ ===
            const elInv = document.querySelector('#chartInvoiceStatus');
            if (elInv) {
                new ApexCharts(elInv, {
                    chart: {
                        type: 'donut',
                        height: 320
                    },
                    series: [invoicePaid, invoiceIssued, invoiceDraft, invoiceOverdue, invoiceCanceled],
                    labels: ['ชำระแล้ว', 'ออกบิล', 'ฉบับร่าง', 'ค้างชำระ', 'ยกเลิก'],
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        y: {
                            formatter: v => (Number(v) || 0).toLocaleString()
                        }
                    }
                }).render();
            }

            // === Chart: Lease Status (Donut) — ตั้ง labels เป็นไทยตรงนี้ ===
            const elLease = document.querySelector('#chartLeaseStatus');
            if (elLease) {
                new ApexCharts(elLease, {
                    chart: {
                        type: 'donut',
                        height: 320
                    },
                    series: [activeLeases, pendingLeases, endedLeases, canceledLeases],
                    labels: ['กำลังเช่า', 'รอดำเนินการ', 'สิ้นสุด', 'ยกเลิก'],
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        y: {
                            formatter: v => (Number(v) || 0).toLocaleString()
                        }
                    }
                }).render();
            }

            // === Chart: Leases Monthly (Bar) — ชื่อซีรีส์เป็นไทย ===
            const elLeaseBar = document.querySelector('#chartLeasesMonthly');
            if (elLeaseBar) {
                new ApexCharts(elLeaseBar, {
                    chart: {
                        type: 'bar',
                        height: 320,
                        toolbar: {
                            show: true
                        }
                    },
                    series: [{
                        name: 'เริ่มสัญญาใหม่',
                        data: leasesMonthlyData
                    }],
                    xaxis: {
                        categories: leasesMonthlyLabels
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 6,
                            columnWidth: '55%'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    tooltip: {
                        y: {
                            formatter: v => (Number(v) || 0).toLocaleString()
                        }
                    },
                    legend: {
                        position: 'top'
                    }
                }).render();
            }
        });
    </script>
@endsection
