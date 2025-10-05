@extends('home')

@section('title', 'Add Room')

@section('css_before')
  <link href="{{ asset('css/createroom.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="ship-wrap mt-5">
  <div class="ship-card">
    <h2 class="ship-title">Add Branch</h2>

    {{-- ✅ ต้องใส่ enctype เพื่อรองรับการอัปโหลดรูป --}}
    <form action="/branch/" method="post" enctype="multipart/form-data" class="ship-form">
      @csrf
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
