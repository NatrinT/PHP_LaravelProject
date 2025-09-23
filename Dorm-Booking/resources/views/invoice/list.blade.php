@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('topbar')
  <div class="topbar mt-3 d-flex justify-content-center">
<div class="input-group" style="max-width: 400px;">
  <input type="text" class="form-control" placeholder="Search...">
  <button class="btn btn-primary" type="button">
    <i class="bi bi-search"></i>
  </button>
</div>
  </div>
@endsection

@section('sidebarMenu')
@endsection

@section('content')
<div class="container-xl"> 
    <h3> :: Invoice Management ::
        <a href="/invoice/adding" class="btn btn-primary btn-sm"> Add Invoice </a>
    </h3>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="table-info">
                <th class="text-center">No.</th>
                <th>Lease ID</th>
                <th>Billing Period</th>
                <th>Due Date</th>
                <th>Amount (Total)</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Receipt</th>
                <th class="text-center">Edit</th>
                <th class="text-center">Delete</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($InvoiceList as $row)
                <tr>
                    <td align="center">{{ $row->id }}.</td>
                    <td>#{{ $row->lease_id }}</td>
                    <td>{{ $row->billing_period }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->due_date)->format('d/m/Y') }}</td>
                    <td>฿{{ number_format($row->total_amount, 2) }}</td>
                    <td>{{ $row->status }}</td>
                    <td>{{ $row->payment_status }}</td>
                    <td align="center">
                        @if ($row->receipt_file_url)
                            <a href="{{ asset('storage/' . $row->receipt_file_url) }}" target="_blank" class="btn btn-info btn-sm">View</a>
                        @else
                            -
                        @endif
                    </td>
                    <td align="center">
                        <a href="/invoice/{{ $row->id }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                    <td align="center">
                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="deleteConfirm({{ $row->id }})">Delete</button>

                        <form id="delete-form-{{ $row->id }}" action="/invoice/remove/{{ $row->id }}"
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
        {{ $InvoiceList->links() }}
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
