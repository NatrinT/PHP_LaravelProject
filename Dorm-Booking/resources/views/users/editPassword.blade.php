@extends('home')

@section('title', 'Update Password')

@section('css_before')
  <link href="{{ asset('css/editpassword.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="ship-wrap mt-5">
  <div class="ship-card">
    <h2 class="ship-title">Update Password</h2>

    <form action="/users/reset/{{ $id }}" method="post" class="ship-form">
      @csrf
      @method('put')

      {{-- Username --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-person"></i></div>
        <div class="ship-field">
          <input type="text" name="name" value="{{ $name }}" placeholder="Username" disabled>
        </div>
      </div>

      {{-- Email --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-at"></i></div>
        <div class="ship-field">
          <input type="email" name="email" value="{{ $email }}" placeholder="Email" disabled>
        </div>
      </div>

      {{-- New Password --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-lock"></i></div>
        <div class="ship-field">
          <input type="password" name="password" placeholder="New Password (min 3 characters)" required minlength="3">
          @if(isset($errors) && $errors->has('password'))
            <div class="ship-error">{{ $errors->first('password') }}</div>
          @endif
        </div>
      </div>

      {{-- Confirm Password --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-shield-lock"></i></div>
        <div class="ship-field">
          <input type="password" name="password_confirmation" placeholder="Confirm Password" required minlength="3">
          @if(isset($errors) && $errors->has('password_confirmation'))
            <div class="ship-error">{{ $errors->first('password_confirmation') }}</div>
          @endif
        </div>
      </div>

      {{-- Buttons --}}
      <div class="ship-actions">
        <a href="{{ url('/users') }}" class="btn-ghost">Back to list</a>
        <button type="submit" class="btn-primary-outline">Update</button>
      </div>
    </form>

  </div>
</div>
@endsection
