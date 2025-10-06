@extends('home')

@section('topbar')
@endsection

@section('content')
    <div class="container-xl mt-3">

        <div class="d-flex justify-content-end mb-3">
            <form method="GET" action="{{ route('users.search') }}" class="d-flex flex-wrap justify-content-end gap-2"
                style="max-width: 600px;">

                {{-- Radios --}}
                <div class="btn-group btn-group-sm flex-wrap me-2" role="group" aria-label="Search by">
                    @php $by = request('by','all'); @endphp
                    <input type="radio" class="btn-check" name="by" id="by-all" value="all"
                        {{ $by === 'all' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-all">All</label>

                    <input type="radio" class="btn-check" name="by" id="by-name" value="name"
                        {{ $by === 'name' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-name">Name</label>

                    <input type="radio" class="btn-check" name="by" id="by-email" value="email"
                        {{ $by === 'email' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-email">Email</label>

                    <input type="radio" class="btn-check" name="by" id="by-phone" value="phone"
                        {{ $by === 'phone' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-phone">Phone</label>

                    <input type="radio" class="btn-check" name="by" id="by-role" value="role"
                        {{ $by === 'role' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-role">Role</label>

                    <input type="radio" class="btn-check" name="by" id="by-status" value="status"
                        {{ $by === 'status' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-status">Status</label>

                    <input type="radio" class="btn-check" name="by" id="by-id" value="id"
                        {{ $by === 'id' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-id">ID</label>
                </div>

                {{-- Keyword box + button --}}
                <div class="input-group" style="max-width: 300px;">
                    <input type="text" name="keyword" class="form-control" placeholder="Search..."
                        value="{{ request('keyword') }}">
                    <button class="btn" type="submit" style="background-color:#020025; border-color:#020025;">
                        <i class="bi bi-search" style="color:#e8f0ff;"></i>
                    </button>
                </div>
            </form>
        </div>



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
                        <th style="width:140px;">Status</th> {{-- เปลี่ยนหัวข้อคอลัมน์เป็นไทย --}}
                        @if (auth()->user()->role == 'ADMIN' || auth()->user()->role == 'STAFF')
                            <th style="width:160px;" class="text-center">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($UsersList as $i => $row)
                        @php
                            // แผนที่สี Badge ตามสถานะ (จาก enum: ACTIVE | SUSPENDED | DELETED)
                            $statusColorMap = [
                                'ACTIVE' => 'success',
                                'SUSPENDED' => 'danger',
                                'DELETED' => 'secondary',
                            ];

                            // ป้ายภาษาไทยสำหรับสถานะ
                            $statusLabelMap = [
                                'ACTIVE' => 'ใช้งาน',
                                'SUSPENDED' => 'ระงับชั่วคราว',
                                'DELETED' => 'ลบแล้ว',
                            ];

                            $statusKey = strtoupper($row->status ?? '');
                            $color = $statusColorMap[$statusKey] ?? 'secondary';
                            $label = $statusLabelMap[$statusKey] ?? ($row->status ?? '-');
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
                                    {{ $label }}
                                </span>
                            </td>
                            @if (auth()->user()->role == 'ADMIN' || auth()->user()->role == 'STAFF')
                                <td class="text-end">
                                    <a href="/users/{{ $row->id }}" class="icon-action text-secondary me-3"
                                        title="Edit">
                                        <i class="bi bi-gear"></i>
                                    </a>
                                    @if($row->role == 'MEMBER' && auth()->user()->role == 'STAFF')
                                    <a href="/users/reset/{{ $row->id }}" class="icon-action text-info me-3"
                                        title="Reset Password">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </a>
                                    @endif
                                    @if(auth()->user()->role == 'ADMIN')
                                    <button type="button" class="icon-action text-danger me-1"
                                        onclick="deleteConfirm({{ $row->id }})" title="Delete">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                    <form id="delete-form-{{ $row->id }}"
                                        action="/users/remove/{{ $row->id }}" method="POST" style="display:none;">
                                        @csrf @method('delete')
                                    </form>
                                    @endif
                                </td>
                            @endif
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
