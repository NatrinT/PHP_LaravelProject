@extends('home')

@section('title', 'Update Lease')

@section('css_before')
  <link href="{{ asset('css/editlease.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="ship-wrap mt-5">
  <div class="ship-card">
    <h2 class="ship-title">Update Lease</h2>

    <form action="/lease/{{ $id }}" method="post" enctype="multipart/form-data" class="ship-form">
      @csrf
      @method('put')

      {{-- ผู้เช่า --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-people"></i></div>
        <div class="ship-field">
          <div class="ship-select-wrap">
            <select name="user_id" required>
              @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $user_id == $user->id ? 'selected' : '' }}>
                  {{ $user->full_name }} ({{ $user->email }})
                </option>
              @endforeach
            </select>
            <i class="bi bi-caret-down-fill ship-caret"></i>
          </div>
          @error('user_id')
            <div class="ship-error">{{ $message }}</div>
          @enderror
        </div>
      </div>

      {{-- ห้อง --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-door-open"></i></div>
        <div class="ship-field">
          <div class="ship-select-wrap">
            <select name="room_id" required>
              @foreach($rooms as $room)
                <option value="{{ $room->id }}" {{ $room_id == $room->id ? 'selected' : '' }}>
                  {{ $room->room_no }} ({{ $room->type }})
                </option>
              @endforeach
            </select>
            <i class="bi bi-caret-down-fill ship-caret"></i>
          </div>
          @error('room_id')
            <div class="ship-error">{{ $message }}</div>
          @enderror
        </div>
      </div>

      {{-- วันเริ่ม - สิ้นสุด --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-calendar2-week"></i></div>
        <div class="ship-field ship-grid-2">
          <div>
            <input type="date" name="start_date" value="{{ old('start_date', $start_date) }}" required>
            @error('start_date')
              <div class="ship-error">{{ $message }}</div>
            @enderror
          </div>
          <div>
            <input type="date" name="end_date" value="{{ old('end_date', $end_date) }}" required>
            @error('end_date')
              <div class="ship-error">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      {{-- ค่าเช่า / มัดจำ --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-cash-coin"></i></div>
        <div class="ship-field ship-grid-2">
          <div>
            <input type="number" name="rent_amount" min="500" step="0.01"
                   value="{{ old('rent_amount', $rent_amount) }}" placeholder="Rent Amount" required>
            @error('rent_amount')
              <div class="ship-error">{{ $message }}</div>
            @enderror
          </div>
          <div>
            <input type="number" name="deposit_amount" min="0" step="0.01"
                   value="{{ old('deposit_amount', $deposit_amount) }}" placeholder="Deposit">
            @error('deposit_amount')
              <div class="ship-error">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      {{-- สถานะ --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-toggle-on"></i></div>
        <div class="ship-field">
          <div class="ship-select-wrap">
            <select name="status" required>
              <option value="PENDING"  {{ $status=='PENDING' ? 'selected' : '' }}>รอดำเนินการ</option>
              <option value="ACTIVE"   {{ $status=='ACTIVE'  ? 'selected' : '' }}>กำลังเช่า</option>
              <option value="ENDED"    {{ $status=='ENDED'   ? 'selected' : '' }}>สิ้นสุด</option>
              <option value="CANCELED" {{ $status=='CANCELED'? 'selected' : '' }}>ยกเลิก</option>
            </select>
            <i class="bi bi-caret-down-fill ship-caret"></i>
          </div>
          @error('status')
            <div class="ship-error">{{ $message }}</div>
          @enderror
        </div>
      </div>

      {{-- ไฟล์สัญญา --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-file-earmark-arrow-up"></i></div>
        <div class="ship-field">
          @if($contract_file_url)
            <p class="ship-note">Current file:
              <a href="{{ asset('storage/' . $contract_file_url) }}" target="_blank">View</a>
            </p>
          @endif
          <input type="file" name="contract_file" accept="application/pdf,image/*" class="ship-file">
          @error('contract_file')
            <div class="ship-error">{{ $message }}</div>
          @enderror
        </div>
      </div>

      {{-- ปุ่ม --}}
      <div class="ship-actions">
        <a href="{{ url('/lease') }}" class="btn-ghost">Back to list</a>
        <button type="submit" class="btn-primary-outline">Update</button>
      </div>
    </form>
  </div>
</div>
@endsection
