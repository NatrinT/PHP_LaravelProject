@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h1>Announcement
                    <a href="/announcement/adding" class="btn btn-primary btn-sm mb-2"> + Announcement </a>
                </h1>

                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="table-info">
                            <th width="10%">No.</th>
                            <th width="10%">Image</th>
                            <th width="20%">Title</th>
                            <th width="20%">Body</th>
                            <th width="20%">Created</th>
                            <th width="20%">Last Update</th>
                            <th width="20%">Edit</th>
                            <th width="20%">Delete</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($AnnouncementList as $row)
                            <tr>
                                <td align="center"> {{ $loop->iteration }} </td>
                                <td>
                                    @if ($row->image)
                                        @php
                                            $ext = pathinfo($row->image, PATHINFO_EXTENSION);
                                        @endphp
                                        @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('storage/' . $row->image) }}" width="100">
                                        @elseif(strtolower($ext) === 'pdf')
                                            <a href="{{ asset('storage/' . $row->image) }}" target="_blank"
                                                class="btn btn-sm btn-info">
                                                View PDF
                                            </a>
                                        @else
                                            <a href="{{ asset('storage/' . $row->image) }}"
                                                target="_blank">Download</a>
                                        @endif
                                    @endif
                                </td>
                                <td align="center">{{ $row->title }} </td>
                                <td align="center">{{ $row->body }} </td>
                                <td align="center">{{ $row->created_at->format('d/m/Y') }}</td>
                                <td align="center">{{ $row->updated_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="/announcement/{{ $row->id }}" class="btn btn-warning btn-sm">edit</a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="deleteConfirm({{ $row->id }})">delete</button>
                                    <form id="delete-form-{{ $row->id }}"
                                        action="/announcement/remove/{{ $row->id }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('delete')
                                    </form>


                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

                <div>
                    {{ $AnnouncementList->links() }}
                </div>

            </div>
        </div>
    </div>
    {{-- devbanban.com  --}}
@endsection

@section('footer')
@endsection

@section('js_before')
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
