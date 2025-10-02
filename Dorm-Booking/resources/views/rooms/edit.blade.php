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

                <h3> :: form Update Room :: </h3>

                {{-- ✅ ต้องใส่ enctype เพื่อส่งไฟล์รูป --}}
                <form action="/room/{{ $id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Room Number </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="room_no" placeholder="Room Number"
                                value="{{ $room_no }}" disabled>
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
                                value="{{ $floor }}" min="1">
                            @if (isset($errors))
                                @if ($errors->has('floor'))
                                    <div class="text-danger"> {{ $errors->first('floor') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Room Type </label>
                        <div class="col-sm-6">
                            <select class="form-control" name="type" required>
                                <option value="STANDARD" {{ $type == 'STANDARD' ? 'selected' : '' }}>Standard</option>
                                <option value="DELUXE" {{ $type == 'DELUXE' ? 'selected' : '' }}>Deluxe</option>
                                <option value="OTHER" {{ $type == 'OTHER' ? 'selected' : '' }}>Other</option>
                            </select>
                            @if (isset($errors))
                                @if ($errors->has('type'))
                                    <div class="text-danger"> {{ $errors->first('type') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Monthly Rent </label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="monthly_rent" required
                                placeholder="Monthly Rent" value="{{ $monthly_rent }}" min="500">
                            @if (isset($errors))
                                @if ($errors->has('monthly_rent'))
                                    <div class="text-danger"> {{ $errors->first('monthly_rent') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Status </label>
                        <div class="col-sm-6">
                            <select class="form-control" name="status" required>
                                <option value="AVAILABLE" {{ $status == 'AVAILABLE' ? 'selected' : '' }}>ว่าง</option>
                                <option value="OCCUPIED" {{ $status == 'OCCUPIED' ? 'selected' : '' }}>มีผู้เช่า</option>
                                <option value="MAINTENANCE" {{ $status == 'MAINTENANCE' ? 'selected' : '' }}>ปิดปรับปรุง</option>
                            </select>
                            @if (isset($errors))
                                @if ($errors->has('status'))
                                    <div class="text-danger"> {{ $errors->first('status') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Note </label>
                        <div class="col-sm-7">
                            <textarea name="note" class="form-control" rows="7" required placeholder="Note some detail">{{ $note }}</textarea>
                            @if (isset($errors))
                                @if ($errors->has('note'))
                                    <div class="text-danger"> {{ $errors->first('note') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Branch </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="branch" required placeholder="Branch"
                                value="{{ $branch }}">
                            @if (isset($errors))
                                @if ($errors->has('branch'))
                                    <div class="text-danger"> {{ $errors->first('branch') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    {{-- ✅ รูปภาพห้อง (เหมือนแนว receipt ของ invoice) --}}
                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> Photo </label>
                        <div class="col-sm-6">
                            @if (!empty($image))
                                <p class="mb-2">Current photo:
                                    <a href="{{ asset('storage/' . $image) }}" target="_blank">View</a>
                                </p>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if (isset($errors))
                                @if ($errors->has('image'))
                                    <div class="text-danger"> {{ $errors->first('image') }}</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label class="col-sm-2"> </label>
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary"> Update </button>
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
