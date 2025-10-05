@extends('content.layoutContent')

@section('css_before')
    <style>
        .page-wrap {
            max-width: 1200px;
            margin-inline: auto
        }

        .card-clean {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 10px 28px rgba(3, 18, 43, .06)
        }

        .stat-chip {
            display: flex;
            gap: .6rem;
            align-items: center;
            padding: .8rem 1rem;
            border-radius: 12px;
            background: #f7f9fd;
            border: 1px solid #e8edf5
        }

        .stat-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%
        }

        .dot-paid {
            background: #1db954
        }

        .dot-issued {
            background: #0d6efd
        }

        .dot-overdue {
            background: #ff6b00
        }

        .dot-pending {
            background: #6c757d
        }

        .table thead th {
            font-weight: 800;
            color: #4a5568;
            border-bottom: 1px solid #e9ecf2
        }

        .table td {
            vertical-align: middle
        }

        .filter-chip {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .45rem .75rem;
            border: 1px solid #e6e9f0;
            border-radius: 999px;
            background: #fff
        }

        .filter-chip select,
        .filter-chip input {
            border: 0;
            outline: none
        }

        .badge-soft {
            font-weight: 800;
            border-radius: 999px;
            padding: .35rem .7rem
        }

        .b-paypaid {
            background: #ecfbf2;
            color: #147a52
        }

        .b-paydue {
            background: #eef2ff;
            color: #2b4ae2
        }

        .b-payover {
            background: #fdebdc;
            color: #b04112
        }

        .b-paypend {
            background: #eff1f3;
            color: #5f6b77
        }

        .icon-btn {
            border: 1px solid #e6e9f0;
            border-radius: 10px;
            background: #fff;
            padding: .35rem .55rem
        }

        .icon-btn:hover {
            background: #f6f8fc
        }

        @media (max-width:767.98px) {
            .table-responsive {
                font-size: .95rem
            }
        }
    </style>
@endsection

@section('navbar')
    <!-- Navbar ของหน้า -->
@endsection

@section('content')
    <div class="page-wrap py-4">

        {{-- สรุปสถานะ --}}
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
            <div>
                <h4 class="fw-bold mb-1">ประวัติการชำระเงิน</h4>
                <div class="text-muted">ดูและอัปโหลดหลักฐานการชำระเงินย้อนหลังทั้งหมดของคุณ</div>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <div class="stat-chip"><span class="stat-dot dot-paid"></span> ชำระแล้ว <b
                        class="ms-1">{{ $counts['paid'] ?? 0 }}</b></div>
                <div class="stat-chip"><span class="stat-dot dot-issued"></span> ออกบิลแล้ว <b
                        class="ms-1">{{ $counts['issued'] ?? 0 }}</b></div>
                <div class="stat-chip"><span class="stat-dot dot-overdue"></span> เกินกำหนด <b
                        class="ms-1">{{ $counts['overdue'] ?? 0 }}</b></div>
                <div class="stat-chip"><span class="stat-dot dot-pending"></span> รอตรวจ <b
                        class="ms-1">{{ $counts['pending'] ?? 0 }}</b></div>
            </div>
        </div>

        {{-- ฟิลเตอร์ --}}
        <div class="card card-clean mb-4">
            <div class="card-body">
                <form method="GET" class="d-flex flex-wrap align-items-center gap-2">
                    {{-- ค้นคำ --}}
                    <div class="filter-chip">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="ค้นหา: เลขห้อง / ประเภท / สาขา" class="form-control form-control-sm"
                            style="min-width:220px">
                    </div>

                    {{-- สถานะ --}}
                    <div class="filter-chip">
                        <i class="fa-solid fa-filter text-muted"></i>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">ทุกสถานะ</option>
                            <option value="PAID" {{ request('status') === 'PAID' ? 'selected' : '' }}>ชำระแล้ว</option>
                            <option value="CONFIRMED" {{ request('status') === 'CONFIRMED' ? 'selected' : '' }}>
                                คอนเฟิร์มแล้ว</option>
                            <option value="ISSUED" {{ request('status') === 'ISSUED' ? 'selected' : '' }}>ออกบิลแล้ว
                            </option>
                            <option value="OVERDUE" {{ request('status') === 'OVERDUE' ? 'selected' : '' }}>เกินกำหนด
                            </option>
                            <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>รอตรวจ</option>
                        </select>
                    </div>

                    {{-- งวดเดือน --}}
                    <div class="filter-chip">
                        <i class="fa-regular fa-calendar text-muted"></i>
                        <input type="month" name="period" value="{{ request('period') }}"
                            class="form-control form-control-sm">
                    </div>

                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ url()->current() }}" class="btn btn-light btn-sm">ล้างตัวกรอง</a>
                        <button class="btn btn-primary btn-sm">ค้นหา</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ตาราง --}}
        <div class="card card-clean" style="min-height:60vh">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="min-width:180px">ห้อง</th>
                            <th>สาขา</th>
                            <th>ประเภท</th>
                            <th>งวด/ครบกำหนด</th>
                            <th class="text-end">ยอดรวม (THB)</th>
                            <th>QR Code</th>
                            <th>หลักฐานการชำระ</th>
                            <th>สถานะการชำระ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invoices as $row)
                            @php
                                $lease = $row->lease;
                                $room = $lease?->room;

                                $badge = ['cls' => 'b-paypend', 'txt' => 'รอตรวจ'];
                                $st = strtoupper($row->status ?? '');
                                $pst = strtoupper($row->payment_status ?? '');
                                if ($st === 'PAID' || $pst === 'CONFIRMED') {
                                    $badge = ['cls' => 'b-paypaid', 'txt' => 'ชำระแล้ว'];
                                } elseif ($st === 'OVERDUE') {
                                    $badge = ['cls' => 'b-payover', 'txt' => 'เกินกำหนด'];
                                } elseif ($st === 'ISSUED') {
                                    $badge = ['cls' => 'b-paydue', 'txt' => 'ออกบิลแล้ว'];
                                }
                            @endphp
                            <tr>
                                <td>
                                    <div class="fw-bold">Room {{ $room->room_no ?? '-' }}</div>
                                    <div class="text-muted small">เลขที่บิล #{{ $row->id }}</div>
                                </td>
                                <td>{{ $room ? ucwords(strtolower($room->branch)) : '-' }}</td>
                                <td>{{ $room ? ucwords(strtolower($room->type)) : '-' }}</td>
                                <td>
                                    @if (!empty($row->billing_period))
                                        งวด {{ $row->billing_period }}
                                    @endif
                                    @if (!empty($row->due_date))
                                        <div class="small text-muted">ครบกำหนด:
                                            {{ \Carbon\Carbon::parse($row->due_date)->format('d/m/Y') }}</div>
                                    @endif
                                </td>
                                <td class="text-end">{{ number_format((float) ($row->total_amount ?? 0), 2) }}</td>

                                {{-- QR Code: ปุ่ม “ลูกตา” เปิดรูปในแท็บใหม่ --}}
                                <td class="text-center">
                                    <a href="{{ asset('images/qrCode.jpg') }}" class="icon-btn" target="_blank"
                                        rel="noopener" title="เปิด QR Code">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                </td>

                                {{-- หลักฐานการชำระ: มีไฟล์แล้ว → ดู; ไม่มี → อัปโหลด --}}
                                <td>
                                    @if (!empty($row->receipt_file_url))
                                        <a href="{{ asset('storage/' . $row->receipt_file_url) }}" class="icon-btn"
                                            target="_blank" rel="noopener" title="ดูหลักฐาน">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                    @else
                                        <form action="{{ route('payments.uploadReceipt', ['invoice' => $row->id]) }}"
                                            method="POST" enctype="multipart/form-data"
                                            class="d-flex align-items-center gap-2">
                                            @csrf
                                            <input type="file" name="receipt_file" accept="image/*,application/pdf"
                                                class="form-control form-control-sm" required>
                                            <button class="btn btn-sm btn-outline-primary">อัปโหลด</button>
                                        </form>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge-soft {{ $badge['cls'] }}">{{ $badge['txt'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">ยังไม่มีประวัติการชำระเงิน</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $invoices->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
@endsection

@section('js_before')
    {{-- ใส่สคริปต์เสริมได้ตามต้องการ --}}
@endsection
