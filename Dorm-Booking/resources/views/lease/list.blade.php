@extends('home')

@section('css_before')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('header')
@endsection

@section('topbar')
@endsection

@section('sidebarMenu')
@endsection

@section('content')
    <div class="container-xl mt-5">
        
        {{-- Search แบบเดียวกับ users (คงค่า q เดิมด้วย request('q')) --}}
        <form method="GET" action="{{ route('leases.search') }}" class="input-group ms-auto me-3" style="max-width: 300px;">
            <input type="text" name="q" class="form-control " placeholder="Search..." value="{{ request('q') }}">
            <button class="btn" type="submit" style="background-color:#020025; border-color:#020025;">
                <i class="bi bi-search" style="color:#e8f0ff;"></i>
            </button>
        </form>

        <div class="d-flex justify-content-between align-items-center mb-0 rounded-top-4"
            style="height:68px; background:#020025;">
            <h3 class="mb-0 fw-bold ms-3" style="color:#e8f0ff">Lease Management</h3>
            <a href="/lease/adding"
                class="btn-add-user d-inline-flex align-items-center text-white text-decoration-none me-4">
                <i class="bi bi-plus-lg fw-bold" style="color:#020025;"></i>
                <span class="btn-text ms-1 fw-bold" style="color:#020025;">Add Lease</span>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-modern align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width:70px;">#</th>
                        <th style="width:12%;">Contract</th>
                        <th style="width:17%;">Username</th>
                        <th class="text-center">Room No</th>
                        <th class="text-center">Start date</th>
                        <th class="text-center">End date</th>
                        <th class="text-center">Rent amount</th>
                        <th class="text-center" style="width:100px;">Deposit</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width:160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($LeasesList as $i => $row)
                        @php
                            // แม็ปสถานะ → สี Bootstrap
                            $statusMap = [
                                'ACTIVE' => 'success', // เขียว
                                'PENDING' => 'warning', // ส้ม
                                'ENDED' => 'secondary', // เทา
                                'CANCELED' => 'danger', // แดง
                            ];
                            $key = strtoupper($row->status ?? '');
                            $color = $statusMap[$key] ?? 'secondary';
                        @endphp

                        <tr>
                            <td class="text-muted text-center">{{ $LeasesList->firstItem() + $i }}</td>
                            <td class="text-start">
                                @if ($row->contract_file_url)
                                    @php $ext = pathinfo($row->contract_file_url, PATHINFO_EXTENSION); @endphp
                                    @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('storage/' . $row->contract_file_url) }}" width="80">
                                    @elseif (strtolower($ext) === 'pdf')
                                        <a href="{{ asset('storage/' . $row->contract_file_url) }}" target="_blank"
                                            class="btn btn-sm btn-info">
                                            View PDF
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $row->contract_file_url) }}"
                                            target="_blank">Download</a>
                                    @endif
                                @endif
                            </td>
                            <td><b>{{ $row->user->full_name }}</b></td>
                            <td class="text-center">{{ $row->room->room_no }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($row->start_date)->format('d/m/Y') }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($row->end_date)->format('d/m/Y') }}</td>
                            <td class="text-center">{{ number_format($row->rent_amount, 2) }}</td>
                            <td class="text-center">{{ number_format($row->deposit_amount, 2) }}</td>
                            <td class="text-start">
                                <span class="status">
                                    <span class="status-dot bg-{{ $color }}"></span>
                                    {{ ucfirst(strtolower($row->status)) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="/lease/{{ $row->id }}" class="icon-action text-secondary me-3"
                                    title="Edit">
                                    <i class="bi bi-gear"></i>
                                </a>
                                <button type="button" class="icon-action text-danger"
                                    onclick="deleteConfirm({{ $row->id }})" title="Delete">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                                <form id="delete-form-{{ $row->id }}" action="/lease/remove/{{ $row->id }}"
                                    method="POST" style="display:none;">
                                    @csrf @method('delete')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="text-muted small">
                Showing {{ $LeasesList->count() }} of {{ $LeasesList->total() }} entries
            </span>
            {{ $LeasesList->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

@section('footer')
@endsection

<link href="{{ asset('css/user.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteConfirm(id) {
        Swal.fire({
            title: 'แน่ใจหรือไม่?',
            text: "คุณต้องการลบข้อมูลนี้จริง ๆ หรือไม่",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#020025',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
