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
    <div class="container-xl mt-3 announcement-page">

        <div class="d-flex justify-content-end mb-3">
            <form method="GET" action="{{ route('announcement.search') }}" class="d-flex flex-wrap justify-content-end gap-2"
                style="max-width: 920px;">

                @php $by = request('by','all'); @endphp

                <div class="btn-group btn-group-sm flex-wrap me-2" role="group" aria-label="Search by">
                    <input type="radio" class="btn-check" name="by" id="by-all" value="all"
                        {{ $by === 'all' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-all">All</label>

                    <input type="radio" class="btn-check" name="by" id="by-id" value="id"
                        {{ $by === 'id' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-id">ID</label>

                    <input type="radio" class="btn-check" name="by" id="by-title" value="title"
                        {{ $by === 'title' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-title">Title</label>

                    <input type="radio" class="btn-check" name="by" id="by-body" value="body"
                        {{ $by === 'body' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-body">Body</label>

                    <input type="radio" class="btn-check" name="by" id="by-link" value="link"
                        {{ $by === 'link' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-link">Link</label>

                    <input type="radio" class="btn-check" name="by" id="by-image" value="image"
                        {{ $by === 'image' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-image">Image</label>

                    <input type="radio" class="btn-check" name="by" id="by-created" value="created"
                        {{ $by === 'created' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-created">Created</label>

                    <input type="radio" class="btn-check" name="by" id="by-updated" value="updated"
                        {{ $by === 'updated' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-updated">Updated</label>

                    <input type="radio" class="btn-check" name="by" id="by-date" value="date"
                        {{ $by === 'date' ? 'checked' : '' }}>
                    <label class="btn btn-outline-secondary" for="by-date">Any Date</label>
                </div>

                <div class="input-group" style="max-width: 300px;">
                    <input type="text" name="keyword" class="form-control"
                        placeholder="พิมพ์ข้อความ หรือวันที่แบบ 18/09/2025" value="{{ request('keyword', request('q')) }}">
                    <button class="btn" type="submit" style="background-color:#020025; border-color:#020025;">
                        <i class="bi bi-search" style="color:#e8f0ff;"></i>
                    </button>
                </div>
            </form>
        </div>


        {{-- Header bar --}}
        <div class="d-flex justify-content-between align-items-center rounded-top-4 announcement-header">
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
                        <th class="text-center" style="width:150px;">Image</th>
                        <th style="min-width:200px;">Title</th>
                        <th style="min-width:270px;">Body</th>
                        <th style="max-width:100px;">Link</th>
                        <th class="text-center" style="width:160px;">Created</th>
                        <th class="text-center" style="width:160px;">Updated</th>
                        <th class="text-center" style="width:160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($AnnouncementList as $i => $row)
                        @php
                            $firstNo = method_exists($AnnouncementList, 'firstItem')
                                ? $AnnouncementList->firstItem()
                                : 1;
                            $no = $firstNo + $i;
                            $ext = $row->image ? strtolower(pathinfo($row->image, PATHINFO_EXTENSION)) : null;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $no }}</td>
                            <td class="text-center">
                                @if ($row->image)
                                    @php
                                        $ext = strtolower(pathinfo($row->image, PATHINFO_EXTENSION));
                                    @endphp

                                    @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                        <a href="{{ asset('storage/' . $row->image) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $row->image) }}" class="thumb-ann"
                                                alt="image">
                                        </a>
                                    @elseif ($ext === 'pdf')
                                        <a href="{{ asset('storage/' . $row->image) }}" target="_blank"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-file-earmark-pdf"></i> View PDF
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $row->image) }}" target="_blank"
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
                                <div class="text-title" title="{{ $row->title }}">
                                    {{ $row->title }}
                                </div>
                            </td>

                            {{-- Body --}}
                            <td>
                                <div class="text-body" title="{{ $row->body }}">
                                    {{ $row->body }}
                                </div>
                            </td>

                            {{-- Link --}}
                            <td>
                                <div class="text-link" title="{{ $row->link }}">
                                    {{ $row->link }}
                                </div>
                            </td>

                            <td class="text-center">{{ optional($row->created_at)->format('d/m/Y') }}</td>
                            <td class="text-center">{{ optional($row->updated_at)->format('d/m/Y') }}</td>

                            {{-- Actions --}}
                            <td class="text-center">
                                <a href="/announcement/{{ $row->id }}" class="icon-action text-secondary me-3"
                                    title="Edit">
                                    <i class="bi bi-gear"></i>
                                </a>
                                <button type="button" class="icon-action text-danger"
                                    onclick="deleteConfirm({{ $row->id }})" title="Delete">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                                <form id="delete-form-{{ $row->id }}"
                                    action="/announcement/remove/{{ $row->id }}" method="POST"
                                    style="display:none;">
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
