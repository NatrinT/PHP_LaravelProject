@extends('home')

@section('title', 'Add User')

@section('css_before')
    {{-- ใช้ Bootstrap Icons ที่มีอยู่แล้วใน layout --}}
    <link href="{{ asset('css/createuser.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="ship-wrap mt-5">
  <div class="ship-card">
    <h2 class="ship-title">Add User</h2>

    <form action="/users/" method="post" class="ship-form">
      @csrf

      {{-- Name --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-person"></i></div>
        <div class="ship-field">
          <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Name" required minlength="3">
          @if(isset($errors) && $errors->has('full_name'))
            <div class="ship-error">{{ $errors->first('full_name') }}</div>
          @endif
        </div>
      </div>

      {{-- Phone + Role (วางคู่กันแบบภาพตัวอย่าง Phone + Mobile) --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-telephone"></i></div>
        <div class="ship-field ship-grid-2">
          <div>
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone Number" required minlength="3">
            @if(isset($errors) && $errors->has('phone'))
              <div class="ship-error">{{ $errors->first('phone') }}</div>
            @endif
          </div>
          <div class="ship-select-wrap">
            <select name="role" required>
              <option value="" disabled {{ old('role') ? '' : 'selected' }}>Role</option>
              <option value="MEMBER" {{ old('role')=='MEMBER'?'selected':'' }}>MEMBER</option>
              <option value="STAFF"  {{ old('role')=='STAFF'?'selected':'' }}>STAFF</option>
              <option value="ADMIN"  {{ old('role')=='ADMIN'?'selected':'' }}>ADMIN</option>
            </select>
            <i class="bi bi-caret-down-fill ship-caret"></i>
            @if(isset($errors) && $errors->has('role'))
              <div class="ship-error">{{ $errors->first('role') }}</div>
            @endif
          </div>
        </div>
      </div>

      {{-- Email --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-at"></i></div>
        <div class="ship-field">
          <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required minlength="3">
          @if(isset($errors) && $errors->has('email'))
            <div class="ship-error">{{ $errors->first('email') }}</div>
          @endif
        </div>
      </div>

      {{-- Password --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-lock"></i></div>
        <div class="ship-field">
          <input type="password" name="pass_hash" placeholder="Password" required minlength="3">
          @if(isset($errors) && $errors->has('pass_hash'))
            <div class="ship-error">{{ $errors->first('pass_hash') }}</div>
          @endif
        </div>
      </div>

      {{-- ปุ่ม --}}
      <div class="ship-actions">
        <a href="{{ url('/users') }}" class="btn-ghost">Back to list</a>
        <button type="submit" class="btn-primary-outline">Add</button>
      </div>
    </form>

  </div>
</div>
@endsection
