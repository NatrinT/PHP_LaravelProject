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

        .dot-active {
            background: #1db954
        }

        .dot-upcoming {
            background: #0d6efd
        }

        .dot-ended {
            background: #6c757d
        }

        .dot-cancel {
            background: #dc3545
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

        .b-active {
            background: #e8f7ef;
            color: #0f7a3d
        }

        .b-upcoming {
            background: #eaf2ff;
            color: #0b5ed7
        }

        .b-ended {
            background: #eff1f3;
            color: #5f6b77
        }

        .b-cancel {
            background: #fdeeee;
            color: #b00020
        }

        .b-paypaid {
            background: #ecfbf2;
            color: #147a52
        }

        .b-paydue {
            background: #fff3cd;
            color: #9a6a00
        }

        .b-payover {
            background: #fdebdc;
            color: #b04112
        }

        .b-paypend {
            background: #eef2ff;
            color: #2b4ae2
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
                <h4 class="fw-bold mb-1">การจองของฉัน</h4>
                <div class="text-muted">ดูสัญญา/สถานะการเช่าและชำระเงินของคุณทั้งหมด</div>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <div class="stat-chip"><span class="stat-dot dot-active"></span> กำลังเช่า <b
                        class="ms-1">{{ $counts['active'] ?? 0 }}</b></div>
                <div class="stat-chip"><span class="stat-dot dot-upcoming"></span> รอเข้าอยู่ <b
                        class="ms-1">{{ $counts['upcoming'] ?? 0 }}</b></div>
                <div class="stat-chip"><span class="stat-dot dot-ended"></span> สิ้นสุด <b
                        class="ms-1">{{ $counts['ended'] ?? 0 }}</b></div>
                <div class="stat-chip"><span class="stat-dot dot-cancel"></span> ยกเลิก <b
                        class="ms-1">{{ $counts['canceled'] ?? 0 }}</b></div>
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
                            placeholder="ค้นหา: เลขห้อง / ประเภท / โน้ต" class="form-control form-control-sm"
                            style="min-width:220px">
                    </div>

                    {{-- สถานะ --}}
                    <div class="filter-chip">
                        <i class="fa-solid fa-filter text-muted"></i>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">ทุกสถานะ</option>
                            <option value="ACTIVE" {{ request('status') === 'ACTIVE' ? 'selected' : '' }}>กำลังเช่า</option>
                            <option value="UPCOMING" {{ request('status') === 'UPCOMING' ? 'selected' : '' }}>รอเข้าอยู่
                            </option>
                            <option value="ENDED" {{ request('status') === 'ENDED' ? 'selected' : '' }}>สิ้นสุด</option>
                            <option value="CANCELED" {{ request('status') === 'CANCELED' ? 'selected' : '' }}>ยกเลิก
                            </option>
                        </select>
                    </div>

                    <div class="ms-auto d-flex gap-2">
                        <a href="{{ url()->current() }}" class="btn btn-light btn-sm">ล้างตัวกรอง</a>
                        <button class="btn btn-primary btn-sm">ค้นหา</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-clean" style="min-height:60vh">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="min-width:180px">ห้อง</th>
                            <th>สาขา</th>
                            <th>ประเภท</th>
                            <th>ช่วงสัญญา</th>
                            <th>ค่าเช่า/เดือน</th>
                            <th>หลักฐานการชำระ</th>
                            <th>สถานะสัญญา</th>
                            <th>การชำระ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $row)
                            @php
                                $room = $row->room; // มาจาก room_id ของสัญญา
                                $inv = optional($row->invoices)->first(); // ใบแจ้งหนี้ล่าสุด

                                // badge สถานะสัญญา
                                $mapLease = [
                                    'ACTIVE' => ['cls' => 'b-active', 'txt' => 'กำลังเช่า'],
                                    'PENDING' => ['cls' => 'b-upcoming', 'txt' => 'รอเข้าอยู่'],
                                    'ENDED' => ['cls' => 'b-ended', 'txt' => 'สิ้นสุด'],
                                    'CANCELED' => ['cls' => 'b-cancel', 'txt' => 'ยกเลิก'],
                                ];
                                $lk = strtoupper($row->status ?? '');
                                $leaseBadge = $mapLease[$lk] ?? ['cls' => 'b-ended', 'txt' => $row->status ?? '-'];

                                // badge การชำระ
                                $payBadge = ['cls' => 'b-paypend', 'txt' => 'รอตรวจ'];
                                if ($inv) {
                                    $st = strtoupper($inv->status ?? '');
                                    $pst = strtoupper($inv->payment_status ?? '');
                                    if ($st === 'PAID' || $pst === 'CONFIRMED') {
                                        $payBadge = ['cls' => 'b-paypaid', 'txt' => 'ชำระแล้ว'];
                                    } elseif ($st === 'OVERDUE') {
                                        $payBadge = ['cls' => 'b-payover', 'txt' => 'เกินกำหนด'];
                                    } elseif ($st === 'ISSUED') {
                                        $payBadge = ['cls' => 'b-paydue', 'txt' => 'ออกบิลแล้ว'];
                                    }
                                }
                            @endphp

                            <tr>
                                <td>
                                    <div class="fw-bold">Room {{ $room->room_no ?? '-' }}</div>
                                    <div class="text-muted small">เลขที่สัญญา #{{ $row->id }}</div>
                                </td>
                                <td>{{ $room ? ucwords(strtolower($room->branch)) : '-' }}</td>
                                <td>{{ $room ? ucwords(strtolower($room->type)) : '-' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($row->start_date)->format('d/m/Y') }}
                                    –
                                    {{ \Carbon\Carbon::parse($row->end_date)->format('d/m/Y') }}
                                </td>
                                <td>THB {{ number_format((float) ($room->monthly_rent ?? 0), 2) }}</td>

                                {{-- หลักฐานการชำระ: มีไฟล์แล้ว → ไอคอนดู, ไม่มี → ฟอร์มอัปโหลด --}}
                                <td>
                                    @if ($inv && !empty($inv->receipt_file_url))
                                        <a href="{{ asset('storage/' . $inv->receipt_file_url) }}" class="icon-btn"
                                            target="_blank" title="ดูหลักฐาน">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                    @elseif ($inv)
                                        <form action="{{ route('booking.uploadReceipt', ['invoice' => $inv->id]) }}"
                                            method="POST" enctype="multipart/form-data"
                                            class="d-flex align-items-center gap-2">
                                            @csrf
                                            <input type="file" name="receipt_file" accept="image/*,application/pdf"
                                                class="form-control form-control-sm" required>
                                            <button class="btn btn-sm btn-outline-primary">อัปโหลด</button>
                                        </form>
                                    @else
                                        <span class="text-muted small">ยังไม่มีใบแจ้งหนี้</span>
                                    @endif
                                </td>

                                <td><span class="badge-soft {{ $leaseBadge['cls'] }}">{{ $leaseBadge['txt'] }}</span></td>

                                <td>
                                    <span class="badge-soft {{ $payBadge['cls'] }}">{{ $payBadge['txt'] }}</span>
                                    @if ($inv && $inv->due_date)
                                        <div class="small text-muted mt-1">
                                            ครบกำหนด: {{ \Carbon\Carbon::parse($inv->due_date)->format('d/m/Y') }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">ยังไม่มีรายการจอง</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-3">
                {{ $bookings->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
@endsection

@section('js_before')
@endsection
