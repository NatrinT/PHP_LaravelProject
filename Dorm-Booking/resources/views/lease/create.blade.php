@extends('home')
@section('css_before')
@endsection
@section('header')
@endsection
@section('sidebarMenu')
@endsection
@section('content')
    <<h3> :: Form Add Lease :: </h3>

        <form action="/lease" method="post" enctype="multipart/form-data">
            @csrf

            {{-- ผู้เช่า (User) --}}
            <div class="form-group row mb-2">
                <label class="col-sm-2">User</label>
                <div class="col-sm-6">
                    <select name="user_id" class="form-control" required>
                        <option value="">-- Select User --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->full_name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- ห้อง (Room) --}}
            <div class="form-group row mb-2">
                <label class="col-sm-2">Room</label>
                <div class="col-sm-6">
                    <select name="room_id" class="form-control" id="room_id" required>
                        <option value="">-- Select Room --</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                {{ $room->room_no }} ({{ $room->type }})
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- วันเริ่มและสิ้นสุด --}}
            <div class="form-group row mb-2">
                <label class="col-sm-2">Start Date</label>
                <div class="col-sm-4">
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                    @error('start_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <label class="col-sm-2">End Date</label>
                <div class="col-sm-4">
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                    @error('end_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- ค่าเช่า + มัดจำ --}}
            <div class="form-group row mb-2">
                <label class="col-sm-2">Rent Amount</label>
                <div class="col-sm-4">
                    <input type="number" name="rent_amount" min="500" class="form-control"
                        value="{{ old('rent_amount') }}" required>
                    @error('rent_amount')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <label class="col-sm-2">Deposit</label>
                <div class="col-sm-4">
                    <input type="number" name="deposit_amount" min="0" class="form-control"
                        value="{{ old('deposit_amount') }}">
                    @error('deposit_amount')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Upload contract file --}}
            <div class="form-group row mb-2">
                <label class="col-sm-2">Contract File</label>
                <div class="col-sm-6">
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
                    <button type="submit" class="btn btn-primary">Save Lease</button>
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
