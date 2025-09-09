@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')
    <h3> :: Lease Management ::
        <a href="/lease/adding" class="btn btn-primary btn-sm"> Add Lease </a>
    </h3>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="table-info">
                <th class="text-center">No.</th>
                <th width="15%">Contract</th>
                <th width="20%">Username</th>
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
                    <td align="center">
                        @if ($row->contract_file_url)
                            @php
                                $ext = pathinfo($row->contract_file_url, PATHINFO_EXTENSION);
                            @endphp
                            @if (in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                                <img src="{{ asset('storage/' . $row->contract_file_url) }}" width="100">
                            @elseif(strtolower($ext) === 'pdf')
                                <a href="{{ asset('storage/' . $row->contract_file_url) }}" target="_blank" class="btn btn-sm btn-info">
                                    View PDF
                                </a>
                            @else
                                <a href="{{ asset('storage/' . $row->contract_file_url) }}" target="_blank">Download</a>
                            @endif
                        @endif
                    </td>
                    <td>
                        <b>{{ $row->user->full_name }}</b>
                    </td>
                    <td align="center">{{ $row->room->room_no }}</td>
                    <td align="center">{{ \Carbon\Carbon::parse($row->start_date)->format('d/m/Y') }}</td>
                    <td align="center">{{ \Carbon\Carbon::parse($row->end_date)->format('d/m/Y') }}</td>
                    <td align="center">{{ number_format($row->rent_amount, 2) }}</td>
                    <td align="center">{{ number_format($row->deposit_amount, 2) }}</td>
                    <td align="center">{{ $row->status }}</td>
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
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
