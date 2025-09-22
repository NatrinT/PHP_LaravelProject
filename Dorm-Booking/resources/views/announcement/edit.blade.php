@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')

    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">

                <h3> :: form Update Announcement :: </h3>


                <form action="/announcement/{{ $id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Title </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="title" placeholder="Enter title"
                                value="{{ $title }}">
                            @if (isset($errors))
                                @if ($errors->has('title'))
                                    <div class="text-danger"> {{ $errors->first('title') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Body </label>
                        <div class="col-sm-7">
                            <textarea name="body" class="form-control" rows="7" required placeholder="Note some detail">{{ $body }}</textarea>
                            @if (isset($errors))
                                @if ($errors->has('body'))
                                    <div class="text-danger"> {{ $errors->first('body') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    {{-- Image --}}
                    <div class="form-group row mb-2">
                        <label class="col-sm-2">Image</label>
                        <div class="col-sm-6">
                            @if ($image)
                                <p>Image:
                                    <a href="{{ asset('storage/' . $image) }}" target="_blank">View</a>
                                </p>
                            @endif
                            <input type="file" name="image" class="form-control" accept="application/pdf,image/*">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> </label>
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary"> Update </button>
                            <a href="/announcement" class="btn btn-danger">cancel</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>


@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

@section('js_before')
@endsection
