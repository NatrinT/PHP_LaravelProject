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
                <h1>Room data
                    <a href="/room/adding" class="btn btn-primary btn-sm mb-2"> + Room </a>
                </h1>

                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="table-info">
                            <th width="10%">Room No.</th>
                            <th width="10%">Floor</th>
                            <th width="20%">Type</th>
                            <th width="20%">Status</th>
                            <th width="20%">Monthly Rent</th>
                            <th width="20%">Note</th>
                            <th width="20%">Edit</th>
                            <th width="20%">Delete</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($RoomList as $row)
                            <tr>
                                <td align="center"> {{ $row->room_no }} </td>
                                <td>{{ $row->floor }} </td>
                                <td>{{ $row->type }} </td>
                                <td>{{ $row->status }} </td>
                                <td>{{ number_format($row->monthly_rent,2) }} </td>
                                <td>{{ $row->note }} </td>
                                <td>
                                    <a href="/room/{{ $row->id }}" class="btn btn-warning btn-sm">edit</a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="deleteConfirm({{ $row->id }})">delete</button>
                                    <form id="delete-form-{{ $row->id }}" action="/room/remove/{{ $row->id }}"
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
                    {{ $RoomList->links() }}
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
