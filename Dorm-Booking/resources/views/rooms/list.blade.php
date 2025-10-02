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

            {{-- Search: เลือกวิธีค้นหาด้วย radio + คงค่าที่เลือกไว้ด้วย request('by') --}}
            <div class="d-flex justify-content-end mb-3">
                <form method="GET" action="{{ route('rooms.search') }}" class="d-flex flex-wrap justify-content-end gap-2"
                    style="max-width: 720px;">

                    {{-- ปุ่ม radio เลือกว่าจะค้นด้วยอะไร --}}
                    <div class="btn-group btn-group-sm flex-wrap me-2" role="group" aria-label="Search by">
                        @php $by = request('by', 'all'); @endphp

                        <input type="radio" class="btn-check" name="by" id="by-all" value="all"
                            {{ $by === 'all' ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary" for="by-all">All</label>

                        <input type="radio" class="btn-check" name="by" id="by-roomno" value="room_no"
                            {{ $by === 'room_no' ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary" for="by-roomno">Room No.</label>

                        <input type="radio" class="btn-check" name="by" id="by-floor" value="floor"
                            {{ $by === 'floor' ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary" for="by-floor">Floor</label>

                        <input type="radio" class="btn-check" name="by" id="by-type" value="type"
                            {{ $by === 'type' ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary" for="by-type">Type</label>

                        <input type="radio" class="btn-check" name="by" id="by-status" value="status"
                            {{ $by === 'status' ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary" for="by-status">Status</label>

                        <input type="radio" class="btn-check" name="by" id="by-rent" value="rent"
                            {{ $by === 'rent' ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary" for="by-rent">Rent</label>

                        <input type="radio" class="btn-check" name="by" id="by-branch" value="branch"
                            {{ $by === 'branch' ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary" for="by-rent">Branch</label>

                        <input type="radio" class="btn-check" name="by" id="by-id" value="id"
                            {{ $by === 'id' ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary" for="by-id">ID</label>
                    </div>

                    {{-- ช่อง keyword + ปุ่มค้นหา --}}
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
                <h3 class="mb-0 fw-bold ms-3" style="color: #e8f0ff">Room Management</h3>

                <a href="/room/adding"
                    class=" btn-add-user d-inline-flex align-items-center text-white text-decoration-none me-4">
                    <i class="bi bi-plus-lg fw-bold" style="color:#020025;"></i>
                    <span class="btn-text ms-1 fw-bold " style="color:#020025;">Add Room</span>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:70px;" class="text-center">#</th>
                            <th style="width:100px;">Room No.</th>
                            <th style="width:100px;">Floor</th>
                            <th style="width:120px;">Type</th>
                            <th style="width:100px;">Status</th> {{-- เปลี่ยนหัวคอลัมน์เป็นไทย --}}
                            <th style="width:160px;">Monthly Rent</th>
                            <th class="text-center td-note">Note</th>
                            <th class="text-center">Branch</th>
                            <th class="text-center">Image</th>
                            <th style="width:160px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($RoomList as $i => $row)
                            @php
                                // สี dot ตามสถานะ
                                $statusColorMap = [
                                    'AVAILABLE' => 'success',
                                    'OCCUPIED' => 'danger',
                                    'MAINTENANCE' => 'warning',
                                    'INACTIVE' => 'secondary',
                                ];
                                // ป้ายภาษาไทย
                                $statusLabelMap = [
                                    'AVAILABLE' => 'ว่าง',
                                    'OCCUPIED' => 'มีผู้เช่า',
                                    'MAINTENANCE' => 'ปิดปรับปรุง',
                                    'INACTIVE' => 'ปิดใช้งาน',
                                ];

                                $key = strtoupper($row->status ?? '');
                                $color = $statusColorMap[$key] ?? 'secondary';
                                $text = $statusLabelMap[$key] ?? ($row->status ?? '-');
                            @endphp
                            <tr>
                                {{-- running index --}}
                                <td class="text-muted text-center">{{ $RoomList->firstItem() + $i }}</td>

                                <td class="text-center fw-semibold">{{ $row->room_no }}</td>
                                <td>{{ $row->floor }}</td>
                                <td>{{ $row->type }}</td>

                                <td>
                                    <span class="status">
                                        <span class="status-dot bg-{{ $color }}"></span>
                                        {{ $text }}
                                    </span>
                                </td>

                                <td>{{ number_format($row->monthly_rent, 2) }}</td>
                                <td class="td-note">{{ $row->note }}</td>
                                <td class="text-muted">{{ $row->branch }}</td>

                                {{-- ✅ Photo column (เหมือนแนว receipt ของ invoice) --}}
                                <td class="text-center">
                                    @if (!empty($row->image))
                                        <a href="{{ asset('storage/' . $row->image) }}" target="_blank"
                                            class="icon-action text-info me-2" title="View Photo">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="/room/{{ $row->id }}" class="icon-action text-secondary me-3"
                                        title="Edit">
                                        <i class="bi bi-gear"></i>
                                    </a>
                                    <button type="button" class="icon-action text-danger"
                                        onclick="deleteConfirm({{ $row->id }})" title="Delete">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                    <form id="delete-form-{{ $row->id }}" action="/room/remove/{{ $row->id }}"
                                        method="POST" style="display:none;">
                                        @csrf @method('delete')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            {{-- ส่วนสรุป/เพจจิเนชันแบบเดียวกับ users --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <span class="text-muted small">
                    Showing {{ $RoomList->count() }} of {{ $RoomList->total() }} entries
                </span>
                {{ $RoomList->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
        </div>
    @endsection



    @section('footer')
    @endsection

    @section('js_before')
    @endsection

    @section('js_before')
    @endsection

    <link href="{{ asset('css/room.css') }}" rel="stylesheet">
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
