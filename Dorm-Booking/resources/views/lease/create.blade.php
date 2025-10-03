@extends('home')

@section('title', 'Add Lease')

@section('css_before')
  <link href="{{ asset('css/createlease.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="ship-wrap mt-5">
  <div class="ship-card">
    <h2 class="ship-title">Add Lease</h2>

    <form action="/lease" method="post" enctype="multipart/form-data" class="ship-form">
      @csrf

      {{-- ผู้เช่า (User) --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-people"></i></div>
        <div class="ship-field">
          <div class="ship-select-wrap">
            <select name="user_id" required>
              <option value="">-- Select User --</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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

      {{-- ห้อง (Room) --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-door-open"></i></div>
        <div class="ship-field">
          <div class="ship-select-wrap">
            <select name="room_id" id="room_id" required>
              <option value="">-- Select Room --</option>
              @foreach($rooms as $room)
                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
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

      {{-- วันเริ่ม - สิ้นสุด (2 คอลัมน์) --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-calendar2-week"></i></div>
        <div class="ship-field ship-grid-2">
          <div>
            <input type="date" name="start_date" value="{{ old('start_date') }}" required>
            @error('start_date')
              <div class="ship-error">{{ $message }}</div>
            @enderror
          </div>
          <div>
            <input type="date" name="end_date" value="{{ old('end_date') }}" required>
            @error('end_date')
              <div class="ship-error">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      {{-- ค่าเช่า + มัดจำ (2 คอลัมน์) --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-cash-coin"></i></div>
        <div class="ship-field ship-grid-2">
          <div>
            <input type="number" name="rent_amount" min="500" value="{{ old('rent_amount') }}" placeholder="Rent Amount" required>
            @error('rent_amount')
              <div class="ship-error">{{ $message }}</div>
            @enderror
          </div>
          <div>
            <input type="number" name="deposit_amount" min="0" value="{{ old('deposit_amount') }}" placeholder="Deposit (optional)">
            @error('deposit_amount')
              <div class="ship-error">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      {{-- อัปโหลดสัญญา --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-file-earmark-arrow-up"></i></div>
        <div class="ship-field">
          <input type="file" name="contract_file" accept="application/pdf,image/*" class="ship-file">
          @error('contract_file')
            <div class="ship-error">{{ $message }}</div>
          @enderror
        </div>
      </div>

      {{-- ปุ่ม --}}
      <div class="ship-actions">
        <a href="{{ url('/lease') }}" class="btn-ghost">Back to list</a>
        <button type="submit" class="btn-primary-outline">Save Lease</button>
      </div>
    </form>
  </div>
</div>
@endsection
