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

                <h3> :: form Add Room :: </h3>


                <form action="/room/" method="post">
                    @csrf


                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Room No. </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="room_no" required placeholder="Room Number"
                                minlength="3" value="{{ old('room_no') }}">
                            @if (isset($errors))
                                @if ($errors->has('room_no'))
                                    <div class="text-danger"> {{ $errors->first('room_no') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Floor </label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="floor" required placeholder="Floor"
                                min="1">
                            @if (isset($errors))
                                @if ($errors->has('floor'))
                                    <div class="text-danger"> {{ $errors->first('floor') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2">Type </label>
                        <div class="col-sm-6">
                            {{-- <input type="text" class="form-control" name="full_name" required placeholder="full_name"
                                minlength="3" value="{{ old('full_name') }}"> --}}
                            <select class="form-control" name="type" required>
                                <option value="STANDARD">Standard</option>
                                <option value="DELUXE">Deluxe</option>
                                <option value="LUXURY">Luxury</option>
                            </select>
                            @if (isset($errors))
                                @if ($errors->has('type'))
                                    <div class="text-danger"> {{ $errors->first('type') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Status </label>
                        <div class="col-sm-6">
                            {{-- <input type="text" class="form-control" name="phone" required placeholder="phone"
                                minlength="3" value="{{ old('phone') }}"> --}}
                            <select class="form-control" name="status" required>
                                <option value="AVAILABLE">ว่าง</option>
                                <option value="OCCUPIED">มีผู้เช่า</option>
                                <option value="MAINTENANCE">ปิดปรับปรุง</option>
                            </select>
                            @if (isset($errors))
                                @if ($errors->has('status'))
                                    <div class="text-danger"> {{ $errors->first('status') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Monthly Rent </label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="monthly_rent" required placeholder="Monthly rent min with 500 baht"
                                value="{{ old('monthly_rent') }}" min="500">
                            @if (isset($errors))
                                @if ($errors->has('monthly_rent'))
                                    <div class="text-danger"> {{ $errors->first('monthly_rent') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Note </label>
                        <div class="col-sm-7">
                            <textarea name="note" class="form-control" rows="4" placeholder="Note some text for this room">{{ old('note') }}</textarea>
                            @if (isset($errors))
                                @if ($errors->has('note'))
                                    <div class="text-danger"> {{ $errors->first('note') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> </label>
                        <div class="col-sm-5">

                            <button type="submit" class="btn btn-primary"> Save </button>
                            <a href="/room" class="btn btn-danger">cancel</a>
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
