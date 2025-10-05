@extends('content.layoutContent')

@section('css_before')
    <style>
        .page-wrap{max-width:1200px;margin-inline:auto}
        .card-clean{border:0;border-radius:14px;box-shadow:0 10px 28px rgba(3,18,43,.06)}
        .stat-chip{display:flex;gap:.6rem;align-items:center;padding:.8rem 1rem;border-radius:12px;background:#f7f9fd;border:1px solid #e8edf5}
        .stat-dot{width:10px;height:10px;border-radius:50%}
        .dot-active{background:#1db954}.dot-upcoming{background:#0d6efd}.dot-ended{background:#6c757d}.dot-cancel{background:#dc3545}
        .book-card{border-radius:14px;border:0;box-shadow:0 10px 24px rgba(0,0,0,.06)}
        .roomimg{width:100%;height:160px;object-fit:cover;object-position:center;border-top-left-radius:14px;border-top-right-radius:14px}
        .badge-soft{font-weight:800;border-radius:999px;padding:.35rem .7rem}
        .b-active{background:#e8f7ef;color:#0f7a3d}.b-upcoming{background:#eaf2ff;color:#0b5ed7}
        .b-ended{background:#eff1f3;color:#5f6b77}.b-cancel{background:#fdeeee;color:#b00020}
        .b-paypaid{background:#ecfbf2;color:#147a52}.b-paydue{background:#fff3cd;color:#9a6a00}.b-payover{background:#fdebdc;color:#b04112}
        .table thead th{font-weight:800;color:#4a5568;border-bottom:1px solid #e9ecf2}
        .table td{vertical-align:middle}
        .filter-chip{display:inline-flex;align-items:center;gap:.4rem;padding:.45rem .75rem;border:1px solid #e6e9f0;border-radius:999px;background:#fff}
        .filter-chip select,.filter-chip input{border:0;outline:none}
        @media (max-width:767.98px){.roomimg{height:140px}}
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
            <div class="stat-chip"><span class="stat-dot dot-active"></span> กำลังเช่า <b class="ms-1">{{ $stats['active'] ?? 0 }}</b></div>
            <div class="stat-chip"><span class="stat-dot dot-upcoming"></span> รอเข้าอยู่ <b class="ms-1">{{ $stats['upcoming'] ?? 0 }}</b></div>
            <div class="stat-chip"><span class="stat-dot dot-ended"></span> สิ้นสุด <b class="ms-1">{{ $stats['ended'] ?? 0 }}</b></div>
            <div class="stat-chip"><span class="stat-dot dot-cancel"></span> ยกเลิก <b class="ms-1">{{ $stats['cancelled'] ?? 0 }}</b></div>
        </div>
    </div>

    {{-- ฟิลเตอร์ --}}
    <div class="card card-clean mb-4">
        <div class="card-body">
            <form method="GET" class="d-flex flex-wrap align-items-center gap-2">
                {{-- ค้นคำ --}}
                <div class="filter-chip">
                    <i class="fa-solid fa-magnifying-glass text-muted"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="ค้นหา: ชื่อ/เลขห้อง, บันทึก"
                           class="form-control form-control-sm" style="min-width:220px">
                </div>

                {{-- สาขา --}}
                <div class="filter-chip">
                    <i class="fa-solid fa-building text-muted"></i>
                    <select name="branch" class="form-select form-select-sm">
                        <option value="">ทุกสาขา</option>
                        @foreach ($branches as $br)
                            <option value="{{ $br }}" {{ request('branch') === $br ? 'selected' : '' }}>
                                {{ ucwords(strtolower($br)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- สถานะ --}}
                <div class="filter-chip">
                    <i class="fa-solid fa-filter text-muted"></i>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">ทุกสถานะ</option>
                        <option value="ACTIVE"   {{ request('status') === 'ACTIVE' ? 'selected' : '' }}>กำลังเช่า</option>
                        <option value="UPCOMING" {{ request('status') === 'UPCOMING' ? 'selected' : '' }}>รอเข้าอยู่</option>
                        <option value="ENDED"    {{ request('status') === 'ENDED' ? 'selected' : '' }}>สิ้นสุด</option>
                        <option value="CANCELLED"{{ request('status') === 'CANCELLED' ? 'selected' : '' }}>ยกเลิก</option>
                    </select>
                </div>

                <div class="ms-auto d-flex gap-2">
                    <a href="{{ url()->current() }}" class="btn btn-light btn-sm">ล้างตัวกรอง</a>
                    <button class="btn btn-primary btn-sm">ค้นหา</button>
                </div>
            </form>
        </div>
    </div>

    {{-- เดสก์ท็อป/แท็บเล็ต: ตาราง --}}
    <div class="d-none d-md-block">
        <div class="card card-clean" style="min-height:60vh">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="min-width:200px">ห้อง</th>
                            <th>สาขา / ประเภท</th>
                            <th>ช่วงสัญญา</th>
                            <th class="text-end">ค่าเช่า/เดือน</th>
                            <th class="text-end">ยอดล่าสุด</th>
                            <th>สถานะ</th>
                            <th>การชำระ</th>
                            <th class="text-end" style="min-width:160px">การทำรายการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- content --}}
                    </tbody>
                </table>
            </div>

            @if (method_exists($bookings, 'links'))
                <div class="p-3 border-top">
                    {{ $bookings->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@section('js_before')
{{-- เพิ่มสคริปต์เสริมได้ตามต้องการ --}}
@endsection
