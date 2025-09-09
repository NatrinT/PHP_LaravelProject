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

                <h3> :: form Update User :: </h3>


                <form action="/users/{{ $id }}" method="post">
                    @csrf
                    @method('put')



                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Username </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="name" required placeholder="name"
                                value="{{ $name }}">
                            @if (isset($errors))
                                @if ($errors->has('name'))
                                    <div class="text-danger"> {{ $errors->first('name') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Email </label>
                        <div class="col-sm-6">
                            <input type="email" class="form-control" name="email" required placeholder="email"
                                value="{{ $email }}">
                            @if (isset($errors))
                                @if ($errors->has('email'))
                                    <div class="text-danger"> {{ $errors->first('username') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Phone </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="phone" required placeholder="phone"
                                minlength="3" value="{{ $phone }}">
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
                                <option value="MEMBER" {{ $role == 'MEMBER' ? 'selected' : '' }}>Member</option>
                                <option value="STAFF" {{ $role == 'STAFF' ? 'selected' : '' }}>Staff</option>
                                <option value="ADMIN" {{ $role == 'ADMIN' ? 'selected' : '' }}>Admin</option>
                            </select>

                            @if (isset($errors))
                                @if ($errors->has('role'))
                                    <div class="text-danger"> {{ $errors->first('role') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Status </label>
                        <div class="col-sm-6">
                            {{-- <input type="text" class="form-control" name="role" required placeholder="role"
                                value="{{ old('role') }}"> --}}
                            <select class="form-control" name="status" required>
                                <option value="ACTIVE" {{ $status == 'ACTIVE' ? 'selected' : '' }}>Active</option>
                                <option value="SUSPENDED" {{ $status == 'SUSPENDED' ? 'selected' : '' }}>Suspended</option>
                                <option value="DELETED" {{ $status == 'DELETED' ? 'selected' : '' }}>Delete</option>
                            </select>

                            @if (isset($errors))
                                @if ($errors->has('status'))
                                    <div class="text-danger"> {{ $errors->first('status') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>


                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> </label>
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary"> Update </button>
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
