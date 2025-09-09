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
                <h1>Users data
                    <a href="/users/adding" class="btn btn-primary btn-sm mb-2"> + User </a>
                </h1>

                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="table-info">
                            <th width="5%" class="text-center">No.</th>
                            <th width="20%">Username</th>
                            <th width="20%">Email</th>
                            <th width="20%">Phone</th>
                            <th width="20%">Role</th>
                            <th width="20%">Status</th>
                            <th width="5%">edit</th>
                            <th width="5%">PWD</th>
                            <th width="5%">delete</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($UsersList as $row)
                            <tr>
                                <td align="center"> {{ $loop->iteration }}. </td>
                                <td>{{ $row->full_name }} </td>
                                <td>{{ $row->email }} </td>
                                <td>{{ $row->phone }} </td>
                                <td>{{ $row->role }} </td>
                                <td>{{ $row->status }} </td>
                                <td>
                                    <a href="/users/{{ $row->id }}" class="btn btn-warning btn-sm">edit</a>
                                </td>

                                <td>
                                    <a href="/users/reset/{{ $row->id }}" class="btn btn-info btn-sm">reset</a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="deleteConfirm({{ $row->id }})">delete</button>
                                    <form id="delete-form-{{ $row->id }}" action="/users/remove/{{ $row->id }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        @method('delete')
                                    </form>


                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

                <div>
                    {{ $UsersList->links() }}
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
