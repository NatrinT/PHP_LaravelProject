@extends('home')

@section('title', 'Add Room')

@section('css_before')
  <link href="{{ asset('css/createroom.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="ship-wrap mt-5">
  <div class="ship-card">
    <h2 class="ship-title">Add Room</h2>

    {{-- ✅ ต้องใส่ enctype เพื่อรองรับการอัปโหลดรูป --}}
    <form action="/room/" method="post" enctype="multipart/form-data" class="ship-form">
      @csrf

      {{-- Room No. --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-hash"></i></div>
        <div class="ship-field">
          <input type="text" name="room_no" value="{{ old('room_no') }}" placeholder="Room Number" required minlength="3">
          @if(isset($errors) && $errors->has('room_no'))
            <div class="ship-error">{{ $errors->first('room_no') }}</div>
          @endif
        </div>
      </div>

      {{-- Floor + Type (2 คอลัมน์) --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-building"></i></div>
        <div class="ship-field ship-grid-2">
          <div>
            <input type="number" name="floor" value="{{ old('floor') }}" placeholder="Floor" min="1" required>
            @if(isset($errors) && $errors->has('floor'))
              <div class="ship-error">{{ $errors->first('floor') }}</div>
            @endif
          </div>
          <div class="ship-select-wrap">
            <select name="type" required>
              <option value="STANDARD" {{ old('type')=='STANDARD' ? 'selected' : '' }}>Standard</option>
              <option value="DELUXE"   {{ old('type')=='DELUXE'   ? 'selected' : '' }}>Deluxe</option>
              <option value="LUXURY"   {{ old('type')=='LUXURY'   ? 'selected' : '' }}>Luxury</option>
            </select>
            <i class="bi bi-caret-down-fill ship-caret"></i>
            @if(isset($errors) && $errors->has('type'))
              <div class="ship-error">{{ $errors->first('type') }}</div>
            @endif
          </div>
        </div>
      </div>

      {{-- Status --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-toggle-on"></i></div>
        <div class="ship-field">
          <div class="ship-select-wrap">
            <select name="status" required>
              <option value="AVAILABLE"   {{ old('status')=='AVAILABLE'   ? 'selected' : '' }}>ว่าง</option>
              <option value="OCCUPIED"    {{ old('status')=='OCCUPIED'    ? 'selected' : '' }}>มีผู้เช่า</option>
              <option value="MAINTENANCE" {{ old('status')=='MAINTENANCE' ? 'selected' : '' }}>ปิดปรับปรุง</option>
            </select>
            <i class="bi bi-caret-down-fill ship-caret"></i>
          </div>
          @if(isset($errors) && $errors->has('status'))
            <div class="ship-error">{{ $errors->first('status') }}</div>
          @endif
        </div>
      </div>

      {{-- Monthly Rent --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-cash-coin"></i></div>
        <div class="ship-field">
          <input type="number" name="monthly_rent" value="{{ old('monthly_rent') }}" placeholder="Monthly rent min 500 baht" min="500" required>
          @if(isset($errors) && $errors->has('monthly_rent'))
            <div class="ship-error">{{ $errors->first('monthly_rent') }}</div>
          @endif
        </div>
      </div>

      {{-- Note (textarea) --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-journal-text"></i></div>
        <div class="ship-field">
          <textarea name="note" rows="4" placeholder="Note some text for this room">{{ old('note') }}</textarea>
          @if(isset($errors) && $errors->has('note'))
            <div class="ship-error">{{ $errors->first('note') }}</div>
          @endif
        </div>
      </div>

      {{-- Branch --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-geo-alt"></i></div>
        <div class="ship-field">
          <input type="text" name="branch" value="{{ old('branch') }}" placeholder="Branch" required>
          @if(isset($errors) && $errors->has('branch'))
            <div class="ship-error">{{ $errors->first('branch') }}</div>
          @endif
        </div>
      </div>

      {{-- Photo --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-image"></i></div>
        <div class="ship-field">
          <input type="file" name="image" accept="image/*" class="ship-file" required>
          @if(isset($errors) && $errors->has('image'))
            <div class="ship-error">{{ $errors->first('image') }}</div>
          @endif
        </div>
      </div>

      {{-- ปุ่ม --}}
      <div class="ship-actions">
        <a href="{{ url('/room') }}" class="btn-ghost">Back to list</a>
        <button type="submit" class="btn-primary-outline">Add</button>
      </div>
    </form>

  </div>
</div>
@endsection
