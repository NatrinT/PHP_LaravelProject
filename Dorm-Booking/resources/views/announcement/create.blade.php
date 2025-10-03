@extends('home')

@section('title', 'Add Announcement')

@section('css_before')
  <link href="{{ asset('css/addanc.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="ship-wrap mt-5">
  <div class="ship-card">
    <h2 class="ship-title">Add Announcement</h2>

    <form action="{{ url('/announcement') }}" method="post" enctype="multipart/form-data" class="ship-form">
      @csrf

      {{-- Title --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-type"></i></div>
        <div class="ship-field">
          <input type="text" name="title" value="{{ old('title') }}" placeholder="Title" required minlength="1">
          @if(isset($errors) && $errors->has('title'))
            <div class="ship-error">{{ $errors->first('title') }}</div>
          @endif
        </div>
      </div>

      {{-- Body --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-card-text"></i></div>
        <div class="ship-field">
          <textarea name="body" rows="5" placeholder="Body of content">{{ old('body') }}</textarea>
          @if(isset($errors) && $errors->has('body'))
            <div class="ship-error">{{ $errors->first('body') }}</div>
          @endif
        </div>
      </div>

      {{-- Link --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-link-45deg"></i></div>
        <div class="ship-field">
          <input type="text" name="link" value="{{ old('link') }}" placeholder="Link News" required minlength="1">
          @if(isset($errors) && $errors->has('link'))
            <div class="ship-error">{{ $errors->first('link') }}</div>
          @endif
        </div>
      </div>

      {{-- Image / File --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-image"></i></div>
        <div class="ship-field">
          <input type="file" name="image" accept="application/pdf,image/*" class="ship-file">
          @error('image')
            <div class="ship-error">{{ $message }}</div>
          @enderror
        </div>
      </div>

      {{-- Actions --}}
      <div class="ship-actions">
        <a href="{{ url('/announcement') }}" class="btn-ghost">Back to list</a>
        <button type="submit" class="btn-primary-outline">Add</button>
      </div>
    </form>

  </div>
</div>
@endsection
