@extends('home')
@section('js_before')
    @include('sweetalert::alert')
@section('header')
@section('sidebarMenu')
@section('content')

    <h3>:: Form Update Lease ::</h3>

    <form action="/lease/{{ $id }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        {{-- ผู้เช่า --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">User</label>
            <div class="col-sm-7">
                <select name="user_id" class="form-control" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->full_name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- ห้อง --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Room</label>
            <div class="col-sm-7">
                <select name="room_id" class="form-control" required>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ $room_id == $room->id ? 'selected' : '' }}>
                            {{ $room->room_no }} ({{ $room->type }})
                        </option>
                    @endforeach
                </select>
                @error('room_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- วันเริ่ม/สิ้นสุด --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Start Date</label>
            <div class="col-sm-4">
                <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $start_date) }}"
                    required>
                @error('start_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <label class="col-sm-2">End Date</label>
            <div class="col-sm-4">
                <input type="date" class="form-control" name="end_date" value="{{ old('end_date', $end_date) }}"
                    required>
                @error('end_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- ค่าเช่า / มัดจำ --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Rent Amount</label>
            <div class="col-sm-4">
                <input type="number" class="form-control" name="rent_amount" min="500" step="0.01"
                    value="{{ old('rent_amount', $rent_amount) }}" required>
                @error('rent_amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <label class="col-sm-2">Deposit</label>
            <div class="col-sm-4">
                <input type="number" class="form-control" name="deposit_amount" min="0" step="0.01"
                    value="{{ old('deposit_amount', $deposit_amount) }}">
                @error('deposit_amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- สถานะ --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Status</label>
            <div class="col-sm-6">
                <select name="status" class="form-control" required>
                    <option value="PENDING" {{ $status == 'PENDING' ? 'selected' : '' }}>Pending</option>
                    <option value="ACTIVE" {{ $status == 'ACTIVE' ? 'selected' : '' }}>Active</option>
                    <option value="ENDED" {{ $status == 'ENDED' ? 'selected' : '' }}>Ended</option>
                    <option value="CANCELED" {{ $status == 'CANCELED' ? 'selected' : '' }}>Canceled</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- ไฟล์สัญญา --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2">Contract File</label>
            <div class="col-sm-6">
                @if ($contract_file_url)
                    <p>Current file:
                        <a href="{{ asset('storage/' . $contract_file_url) }}" target="_blank">View</a>
                    </p>
                @endif
                <input type="file" name="contract_file" class="form-control" accept="application/pdf,image/*">
                @error('contract_file')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- ปุ่ม --}}
        <div class="form-group row mb-2">
            <label class="col-sm-2"></label>
            <div class="col-sm-5">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/lease" class="btn btn-danger">Cancel</a>
            </div>
        </div>
    </form>


@endsection


@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}
