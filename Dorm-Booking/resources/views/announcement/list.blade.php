@extends('home')

@section('css_before')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/announcement.css') }}">
@endsection

@section('header')
@endsection

@section('topbar')
@endsection

@section('sidebarMenu')
@endsection

@section('content')
<div class="container-xl mt-5 announcement-page">

    {{-- Search (สไตล์เดียวกับหน้า Lease) --}}
    <form method="GET" action="{{ url('/announcement') }}" class="input-group ms-auto me-3" style="max-width: 300px;">
        <input type="text" name="q" class="form-control" placeholder="Search..." value="{{ request('q') }}">
        <button class="btn" type="submit" style="background-color:#020025; border-color:#020025;">
            <i class="bi bi-search" style="color:#e8f0ff;"></i>
        </button>
    </form>

    {{-- Header bar --}}
    <div class="d-flex justify-content-between align-items-center mb-0 rounded-top-4 announcement-header">
        <h3 class="mb-0 fw-bold ms-3">Announcement Management</h3>
        <a href="/announcement/adding"
           class="btn-add-user d-inline-flex align-items-center text-white text-decoration-none me-4">
            <i class="bi bi-plus-lg fw-bold" style="color:#020025;"></i>
            <span class="btn-text ms-1 fw-bold" style="color:#020025;">Add Announcement</span>
        </a>
    </div>

    <div class="table-responsive table-wrap">
        <table class="table table-modern align-middle mb-0 table-announcement">
            <thead>
                <tr>
                    <th class="text-center" style="width:70px;">#</th>
                    <th class="text-center" style="width:110px;">Image</th>
                    <th style="min-width:220px;">Title</th>
                    <th style="min-width:300px;">Body</th>
                    <th class="text-center" style="width:160px;">Created</th>
                    <th class="text-center" style="width:160px;">Updated</th>
                    <th class="text-center" style="width:160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($AnnouncementList as $i => $row)
                    @php
                        $no  = ($AnnouncementList->firstItem() ?? 1) + $i;
                        $ext = $row->image ? strtolower(pathinfo($row->image, PATHINFO_EXTENSION)) : null;
                    @endphp
                    <tr>
                        <td class="text-muted text-center">{{ $no }}</td>

                        {{-- Image / File --}}
                        <td class="text-center">
                            @if ($row->image)
                                @if (in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                    <a href="{{ asset('storage/'.$row->image) }}" target="_blank" class="d-inline-block">
                                        <img src="{{ asset('storage/'.$row->image) }}" class="thumb-ann" alt="image">
                                    </a>
                                @elseif($ext === 'pdf')
                                    <a href="{{ asset('storage/'.$row->image) }}" target="_blank"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-file-earmark-pdf"></i> View PDF
                                    </a>
                                @else
                                    <a href="{{ asset('storage/'.$row->image) }}" target="_blank"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-paperclip"></i> Download
                                    </a>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        {{-- Title --}}
                        <td>
                            <div class="text-truncate-1" title="{{ $row->title }}">
                                {{ $row->title }}
                            </div>
                        </td>

                        {{-- Body --}}
                        <td>
                            <div class="text-truncate-2" title="{{ $row->body }}">
                                {{ $row->body }}
                            </div>
                        </td>

                        <td class="text-center">{{ optional($row->created_at)->format('d/m/Y') }}</td>
                        <td class="text-center">{{ optional($row->updated_at)->format('d/m/Y') }}</td>

                        {{-- Actions --}}
                        <td class="text-center">
                            <a href="/announcement/{{ $row->id }}" class="icon-action text-secondary me-3" title="Edit">
                                <i class="bi bi-gear"></i>
                            </a>
                            <button type="button" class="icon-action text-danger"
                                    onclick="deleteConfirm({{ $row->id }})" title="Delete">
                                <i class="bi bi-x-circle"></i>
                            </button>
                            <form id="delete-form-{{ $row->id }}"
                                  action="/announcement/remove/{{ $row->id }}" method="POST" style="display:none;">
                                @csrf @method('delete')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Summary + Pagination เหมือนหน้า Lease --}}
    <div class="d-flex justify-content-between align-items-center mt-3">
        <span class="text-muted small">
            Showing {{ $AnnouncementList->count() }} of {{ $AnnouncementList->total() }} entries
        </span>
        {{ $AnnouncementList->withQueryString()->links('pagination::bootstrap-5') }}
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
