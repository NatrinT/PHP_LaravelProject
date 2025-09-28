@extends('home')

@section('topbar')
@endsection

@section('content')
    <div class="container-xl mt-5">
        
    <form method="GET" action="{{ route('users.search') }}" 
          class="input-group ms-auto me-3" style="max-width: 300px;">
        <input type="text" name="q" class="form-control" placeholder="Search..."
               value="{{ request('q') }}">
        <button class="btn" type="submit" style="background-color:#020025; border-color:#020025;">
            <i class="bi bi-search" style="color:#e8f0ff;"></i>
        </button>
    </form>

        <div class="d-flex justify-content-between align-items-center mb-0 rounded-top-4"
            style="height:68px; background:#020025;">
            <h3 class="mb-0 fw-bold ms-3" style="color: #e8f0ff">Users Management</h3>

            <a href="/users/adding"
                class=" btn-add-user d-inline-flex align-items-center text-white text-decoration-none me-4">
                <i class="bi bi-plus-lg fw-bold" style="color:#020025;"></i>
                <span class="btn-text ms-1 fw-bold " style="color:#020025;">Add user</span>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-modern align-middle mb-0">
                <thead class="table">
                    <tr>
                        <th style="width:70px;" class="text-center">#</th>
                        <th>Name</th>
                        <th style="width:200px;">Email</th>
                        <th style="width:140px;">Phone</th>
                        <th style="width:120px;">Role</th>
                        <th style="width:140px;">Status</th>
                        <th style="width:160px;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($UsersList as $i => $row)
                        @php
                            $statusMap = ['ACTIVE' => 'success', 'SUSPENDED' => 'danger', 'INACTIVE' => 'secondary'];
                            $color = $statusMap[strtoupper($row->status ?? '')] ?? 'secondary';
                        @endphp
                        <tr>
                            <td class="text-muted text-center">{{ $UsersList->firstItem() + $i }}</td>
                            <td><span class="fw-semibold">{{ $row->full_name }}</span></td>
                            <td class="text-muted">{{ $row->email }}</td>
                            <td>{{ $row->phone }}</td>
                            <td>{{ $row->role }}</td>
                            <td>
                                <span class="status">
                                    <span class="status-dot bg-{{ $color }}"></span>
                                    {{ ucfirst(strtolower($row->status)) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="/users/{{ $row->id }}" class="icon-action text-secondary me-3" title="Edit">
                                    <i class="bi bi-gear"></i>
                                </a>
                                <a href="/users/reset/{{ $row->id }}" class="icon-action text-info me-3"
                                    title="Reset Password">
                                    <i class="bi bi-arrow-repeat"></i>
                                </a>
                                <button type="button" class="icon-action text-danger me-1"
                                    onclick="deleteConfirm({{ $row->id }})" title="Delete">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                                <form id="delete-form-{{ $row->id }}" action="/users/remove/{{ $row->id }}"
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
                Showing {{ $UsersList->count() }} of {{ $UsersList->total() }} entries
            </span>
            {{ $UsersList->withQueryString()->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection



@section('footer')
@endsection

@section('js_before')
@endsection

@section('js_before')
@endsection

<link href="{{ asset('css/user.css') }}" rel="stylesheet">
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
