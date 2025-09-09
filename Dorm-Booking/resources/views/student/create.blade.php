@extends('home')
@section('css_before')
@endsection
@section('header')
@endsection
@section('sidebarMenu')   
@endsection
@section('content')
 


    <h3> :: Form Add Student :: </h3>

    <form action="/student/" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group row mb-2">
            <label class="col-sm-2"> Student Code </label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="std_code" required placeholder="Student code "
                    minlength="3" value="{{ old('std_code') }}">
                @if(isset($errors))
                @if($errors->has('std_code'))
                <div class="text-danger"> {{ $errors->first('std_code') }}</div>
                @endif
                @endif
            </div>
        </div>

        <div class="form-group row mb-2">
            <label class="col-sm-2"> Student Name </label>
            <div class="col-sm-7">
                <textarea name="std_name" class="form-control" required
                    placeholder="Student Name">{{ old('std_name') }}</textarea>
                @if(isset($errors))
                @if($errors->has('std_name'))
                <div class="text-danger"> {{ $errors->first('std_name') }}</div>
                @endif
                @endif
            </div>
        </div>

        <div class="form-group row mb-2">
            <label class="col-sm-2">Phone </label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="std_phone" required placeholder="Student phone"
                     value="{{ old('std_phone') }}">
                @if(isset($errors))
                @if($errors->has('std_phone'))
                <div class="text-danger"> {{ $errors->first('std_phone') }}</div>
                @endif
                @endif
            </div>
        </div>

        <div class="form-group row mb-2">
            <label class="col-sm-2"> Pic </label>
            <div class="col-sm-6">
                <input type="file" name="std_img" required placeholder="std_img" accept="image/*">
                @if(isset($errors))
                @if($errors->has('std_img'))
                <div class="text-danger"> {{ $errors->first('std_img') }}</div>
                @endif
                @endif
            </div>
        </div>

        <div class="form-group row mb-2">
            <label class="col-sm-2"> </label>
            <div class="col-sm-5">

                <button type="submit" class="btn btn-primary"> Insert student </button>
                <a href="/student" class="btn btn-danger">cancel</a>
            </div>
        </div>

    </form>

</div>

    
@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

{{-- devbanban.com --}}