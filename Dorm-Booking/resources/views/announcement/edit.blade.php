@extends('home')

@section('title', 'Update Announcement')

@section('css_before')
  <link href="{{ asset('css/editanc.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="ship-wrap mt-5">
  <div class="ship-card">
    <h2 class="ship-title">Update Announcement</h2>

    <form action="/announcement/{{ $id }}" method="post" enctype="multipart/form-data" class="ship-form">
      @csrf
      @method('put')

      {{-- Title --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-megaphone"></i></div>
        <div class="ship-field">
          <input type="text" name="title" value="{{ $title }}" placeholder="Enter title" required>
          @if(isset($errors) && $errors->has('title'))
            <div class="ship-error">{{ $errors->first('title') }}</div>
          @endif
        </div>
      </div>

      {{-- Body --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-journal-text"></i></div>
        <div class="ship-field">
          <textarea name="body" rows="7" placeholder="Note some detail" required>{{ $body }}</textarea>
          @if(isset($errors) && $errors->has('body'))
            <div class="ship-error">{{ $errors->first('body') }}</div>
          @endif
        </div>
      </div>

      {{-- Link --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-link-45deg"></i></div>
        <div class="ship-field">
          <input type="text" name="link" value="{{ $link }}" placeholder="Enter Link" required>
          @if(isset($errors) && $errors->has('link'))
            <div class="ship-error">{{ $errors->first('link') }}</div>
          @endif
        </div>
      </div>

      {{-- Image --}}
      <div class="ship-row">
        <div class="ship-icon"><i class="bi bi-image"></i></div>
        <div class="ship-field">
          @if($image)
            <p class="ship-note">Image:
              <a href="{{ asset('storage/' . $image) }}" target="_blank">View</a>
            </p>
          @endif
          <input type="file" name="image" accept="application/pdf,image/*" class="ship-file">
          @error('image') <div class="ship-error">{{ $message }}</div> @enderror
        </div>
      </div>

      {{-- Actions --}}
      <div class="ship-actions">
        <a href="{{ url('/announcement') }}" class="btn-ghost">Back to list</a>
        <button type="submit" class="btn-primary-outline">Update</button>
      </div>
    </form>
  </div>
</div>
@endsection
