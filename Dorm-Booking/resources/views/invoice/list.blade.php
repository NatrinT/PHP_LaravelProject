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
<div class="container-xl mt-5">

    {{-- Search --}}
<form method="GET" action="{{ route('invoices.search') }}" 
      class="input-group ms-auto me-3" style="max-width: 300px;">
    <input type="text" name="q" class="form-control" placeholder="Search..."
           value="{{ request('q') }}">
    <button class="btn" type="submit" style="background-color:#020025; border-color:#020025;">
        <i class="bi bi-search" style="color:#e8f0ff;"></i>
    </button>
</form>



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
                    <th style="width:70px;" class="text-center">#</th>
                    <th style="width:100px;" class="text-center">Lease ID</th>
                    <th style="width:160px;">Billing Period</th>
                    <th style="width:160px;">Due Date</th>
                    <th style="width:160px;">Amount (Total)</th>
                    <th style="width:140px;">Invoice Status</th>
                    <th style="width:140px;">Payment Status</th>
                    <th style="width:120px;" class="text-center">Receipt</th>
                    <th style="width:160px;" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($InvoiceList as $i => $row)
                    @php
                        // Invoice Status mapping
                        $statusMap = [
                            'DRAFT'    => 'draft',
                            'ISSUED'   => 'issued',
                            'PAID'     => 'paid',
                            'OVERDUE'  => 'overdue',
                            'CANCELED' => 'canceled',
                        ];
                        $statusKey   = strtoupper($row->status ?? '');
                        $statusClass = $statusMap[$statusKey] ?? 'draft';
                        $statusText  = ucfirst(strtolower($row->status ?? ''));

                        // Payment Status mapping
                        $paymentMap = [
                            'PENDING'   => 'pending',
                            'CONFIRMED' => 'confirmed',
                            'FAILED'    => 'failed',
                        ];
                        $payKey   = strtoupper($row->payment_status ?? '');
                        $payClass = $paymentMap[$payKey] ?? 'pending';
                        $payText  = ucfirst(strtolower($row->payment_status ?? ''));
                    @endphp
                    <tr>
                        <td class="text-muted text-center">{{ $InvoiceList->firstItem() + $i }}</td>
                        <td class="text-center">{{ $row->lease_id }}</td>
                        <td>{{ $row->billing_period }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->due_date)->format('d/m/Y') }}</td>
                        <td>฿{{ number_format($row->total_amount, 2) }}</td>
                        <td>
                            <span class="status status-{{ $statusClass }}">
                                <span class="status-dot"></span>
                                {{ $statusText }}
                            </span>
                        </td>
                        <td>
                            <span class="payment payment-{{ $payClass }}">
                                <span class="status-dot"></span>
                                {{ $payText }}
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
                            <a href="/invoice/{{ $row->id }}" class="icon-action text-secondary me-3" title="Edit">
                                <i class="bi bi-gear"></i>
                            </a>
                            <button type="button" class="icon-action text-danger"
                                    onclick="deleteConfirm({{ $row->id }})" title="Delete">
                                <i class="bi bi-x-circle"></i>
                            </button>
                            <form id="delete-form-{{ $row->id }}" action="/invoice/remove/{{ $row->id }}"
                                method="POST" style="display:none;">
                                @csrf
                                @method('delete')
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
