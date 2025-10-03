@extends('home')

@section('css_before')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
@endsection

@section('header')
@endsection

@section('topbar')
@endsection

@section('sidebarMenu')
@endsection

@section('content')
    <div class="container-xl mt-3">

        {{-- Search --}}
        <div class="d-flex justify-content-end mb-3">
            <form method="GET" action="{{ route('invoices.search') }}" class="d-flex flex-wrap justify-content-end gap-2"
                style="max-width: 860px;">

                {{-- radio เลือก field --}}
                <div class="btn-group btn-group-sm flex-wrap me-2" role="group" aria-label="Search by">
                    @php $by = request('by','all'); @endphp

                    <input type="radio" class="btn-check" name="by" id="by-all" value="all"
                        {{ $by === 'all' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-all">All</label>

                    <input type="radio" class="btn-check" name="by" id="by-id" value="id"
                        {{ $by === 'id' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-id">Invoice ID</label>

                    <input type="radio" class="btn-check" name="by" id="by-lease" value="lease"
                        {{ $by === 'lease' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-lease">Lease ID</label>

                    <input type="radio" class="btn-check" name="by" id="by-user" value="user"
                        {{ $by === 'user' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-user">User</label>

                    <input type="radio" class="btn-check" name="by" id="by-room" value="room"
                        {{ $by === 'room' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-room">Room</label>

                    <input type="radio" class="btn-check" name="by" id="by-status" value="status"
                        {{ $by === 'status' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-status">Invoice Status</label>

                    <input type="radio" class="btn-check" name="by" id="by-payment" value="payment"
                        {{ $by === 'payment' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-payment">Payment Status</label>

                    <input type="radio" class="btn-check" name="by" id="by-period" value="period"
                        {{ $by === 'period' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-period">Billing Period</label>

                    <input type="radio" class="btn-check" name="by" id="by-due" value="due"
                        {{ $by === 'due' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-due">Due Date</label>

                    <input type="radio" class="btn-check" name="by" id="by-amount" value="amount"
                        {{ $by === 'amount' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-amount">Total Amount</label>
                </div>

                {{-- keyword --}}
                <div class="input-group" style="max-width: 300px;">
                    <input type="text" name="keyword" class="form-control"
                        placeholder="Search... (18/09/2025 เมื่อเลือก Due Date)" value="{{ request('keyword') }}">
                    <button class="btn" type="submit" style="background-color:#020025; border-color:#020025;">
                        <i class="bi bi-search" style="color:#e8f0ff;"></i>
                    </button>
                </div>
            </form>
        </div>



        <div class="d-flex justify-content-between align-items-center mb-0 rounded-top-4"
            style="height:68px; background:#020025;">
            <h3 class="mb-0 fw-bold ms-3" style="color: #e8f0ff">Invoice Management</h3>

            <a href="/invoice/adding"
                class="btn-add-user d-inline-flex align-items-center text-white text-decoration-none me-4">
                <i class="bi bi-plus-lg fw-bold" style="color:#020025;"></i>
                <span class="btn-text ms-1 fw-bold" style="color:#020025;">Add Invoice</span>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-modern align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:70px;" class="text-center">ID</th>
                        <th style="width:100px;" class="text-center">Lease ID</th>
                        <th style="width:160px;">Billing Period</th>
                        <th style="width:160px;">Due Date</th>
                        <th style="width:160px;">Amount (Total)</th>
                        <th style="width:140px;">สถานะใบแจ้งหนี้</th> {{-- เดิม: Invoice Status --}}
                        <th style="width:160px;">สถานะการชำระเงิน</th> {{-- เดิม: Payment Status --}}
                        <th style="width:120px;" class="text-center">Receipt</th>
                        <th style="width:160px;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($InvoiceList as $i => $row)
                        @php
                            // ===== Mapping class (คงไว้ตาม CSS เดิม) =====
                            $statusClassMap = [
                                'DRAFT' => 'draft',
                                'ISSUED' => 'issued',
                                'PAID' => 'paid',
                                'OVERDUE' => 'overdue',
                                'CANCELED' => 'canceled',
                            ];
                            $paymentClassMap = [
                                'PENDING' => 'pending',
                                'CONFIRMED' => 'confirmed',
                                'FAILED' => 'failed',
                            ];

                            // ===== ป้ายภาษาไทย =====
                            $statusLabelTH = [
                                'DRAFT' => 'ฉบับร่าง',
                                'ISSUED' => 'ออกบิล',
                                'PAID' => 'ชำระแล้ว',
                                'OVERDUE' => 'ค้างชำระ',
                                'CANCELED' => 'ยกเลิก',
                            ];
                            $paymentLabelTH = [
                                'PENDING' => 'รอดำเนินการ',
                                'CONFIRMED' => 'ยืนยันแล้ว',
                                'FAILED' => 'ล้มเหลว',
                            ];

                            $statusKey = strtoupper($row->status ?? '');
                            $payKey = strtoupper($row->payment_status ?? '');

                            $statusClass = $statusClassMap[$statusKey] ?? 'draft';
                            $payClass = $paymentClassMap[$payKey] ?? 'pending';

                            $statusTextTH = $statusLabelTH[$statusKey] ?? ($row->status ?? '-');
                            $payTextTH = $paymentLabelTH[$payKey] ?? ($row->payment_status ?? '-');
                        @endphp

                        <tr>
                            <td class="text-muted text-center">{{ $row->id }}</td>
                            <td class="text-center">{{ $row->lease_id }}</td>
                            <td>{{ $row->billing_period }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->due_date)->format('d/m/Y') }}</td>
                            <td>฿{{ number_format($row->total_amount, 2) }}</td>

                            {{-- สถานะใบแจ้งหนี้ (ไทย) --}}
                            <td>
                                <span class="status status-{{ $statusClass }}">
                                    <span class="status-dot"></span>
                                    {{ $statusTextTH }}
                                </span>
                            </td>

                            {{-- สถานะการชำระเงิน (ไทย) --}}
                            <td>
                                <span class="payment payment-{{ $payClass }}">
                                    <span class="status-dot"></span>
                                    {{ $payTextTH }}
                                </span>
                            </td>

                            <td class="text-center">
                                @if ($row->receipt_file_url)
                                    <a href="{{ asset('storage/' . $row->receipt_file_url) }}" target="_blank"
                                        class="icon-action text-info me-2" title="View Receipt">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="/invoice/{{ $row->id }}" class="icon-action text-secondary me-3"
                                    title="Edit">
                                    <i class="bi bi-gear"></i>
                                </a>
                                <button type="button" class="icon-action text-danger"
                                    onclick="deleteConfirm({{ $row->id }})" title="Delete">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                                <form id="delete-form-{{ $row->id }}" action="/invoice/remove/{{ $row->id }}"
                                    method="POST" style="display:none;">
                                    @csrf @method('delete')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        {{-- Summary + Pagination --}}
        <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="text-muted small">
                Showing {{ $InvoiceList->count() }} of {{ $InvoiceList->total() }} entries
            </span>
            {{ $InvoiceList->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function deleteConfirm(id) {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "หากลบแล้วจะไม่สามารถกู้คืนได้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
