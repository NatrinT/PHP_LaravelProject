@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')
    <h3> ::Lease Managements ::
        <a href="/lease/adding" class="btn btn-primary btn-sm"> Add Lease </a>
    </h3>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="table-info">
                <th class="text-center">No.</th>
                <th width="15%">Contract</th>
                <th width="20%"> Username </th>
                <th class="text-center">Room No</th>
                <th class="text-center">Start date</th>
                <th class="text-center">End date</th>
                <th class="text-center">Rent amount</th>
                <th class="text-center">Deposit</th>
                <th class="text-center">Status</th>
                <th class="text-center">Edit</th>
                <th class="text-center">Delete</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($LeasesList as $row)
                <tr>
                    <td align="center"> {{ $loop->iteration }}. </td>
                    <td>

                        <img src="{{ asset('storage/' . $row->contract_file_url) }}" width="100">
                    </td>
                    <td>
                        <b>{{ $row->username }}</b>
                    </td>
                    <td align="center">฿{{ $row->room_no }}</td>
                    <td align="center"> {{ $row->start_date }} </td>
                    <td align="center"> {{ $row->end_date }} </td>
                    <td align="center"> {{ $row->rent_amount }} </td>
                    <td align="center"> {{ $row->deposit_amount }} </td>
                    <td align="center"> {{ $row->status }} </td>
                    <td align="center">
                        <a href="/lease/{{ $row->id }}" class="btn btn-warning btn-sm">edit</a>
                    </td>
                    <td align="center">
                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="deleteConfirm({{ $row->id }})">delete</button>

                        <form id="delete-form-{{ $row->id }}" action="/lease/remove/{{ $row->id }}"
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
        {{ $LeasesList->links() }}
    </div>
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
            title: 'แน่ใจหรือไม่?',
            text: "คุณต้องการลบข้อมูลนี้จริง ๆ หรือไม่",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ถ้ากด "ลบเลย" ให้ submit form ที่ซ่อนไว้
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
