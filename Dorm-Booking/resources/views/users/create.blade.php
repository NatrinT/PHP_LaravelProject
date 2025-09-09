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
            <div class="col-sm-9">

                <h3> :: form Add User :: </h3>


                <form action="/users/" method="post">
                    @csrf


                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Email </label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" name="email" required placeholder="email"
                                minlength="3" value="{{ old('email') }}">
                            @if (isset($errors))
                                @if ($errors->has('email'))
                                    <div class="text-danger"> {{ $errors->first('email') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Password </label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="pass_hash" required placeholder="Password"
                                minlength="3">
                            @if (isset($errors))
                                @if ($errors->has('pass_hash'))
                                    <div class="text-danger"> {{ $errors->first('pass_hash') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2">Name </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="full_name" required placeholder="full_name"
                                minlength="3" value="{{ old('full_name') }}">
                            @if (isset($errors))
                                @if ($errors->has('full_name'))
                                    <div class="text-danger"> {{ $errors->first('full_name') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Phone </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="phone" required placeholder="phone"
                                minlength="3" value="{{ old('phone') }}">
                            @if (isset($errors))
                                @if ($errors->has('phone'))
                                    <div class="text-danger"> {{ $errors->first('phone') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Role </label>
                        <div class="col-sm-6">
                            {{-- <input type="text" class="form-control" name="role" required placeholder="role"
                                value="{{ old('role') }}"> --}}
                            <select class="form-control" name="role" required>
                                <option value="MEMBER">MEMBER</option>
                                <option value="STAFF">STAFF</option>
                                <option value="ADMIN">ADMIN</option>
                            </select>
                            @if (isset($errors))
                                @if ($errors->has('role'))
                                    <div class="text-danger"> {{ $errors->first('role') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> </label>
                        <div class="col-sm-5">

                            <button type="submit" class="btn btn-primary"> Save </button>
                            <a href="/users" class="btn btn-danger">cancel</a>
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
