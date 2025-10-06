@extends('home')

@section('title', 'Update Room')

@section('css_before')
    <link href="{{ asset('css/editroom.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="ship-wrap mt-5">
        <div class="ship-card">
            <h2 class="ship-title">Update Room</h2>

            {{-- ต้องใส่ enctype เพื่ออัปโหลดไฟล์ --}}
            <form action="/room/{{ $id }}" method="post" enctype="multipart/form-data" class="ship-form">
                @csrf
                @method('put')

                {{-- Room Number (disabled) --}}
                <div class="ship-row">
                    <div class="ship-icon"><i class="bi bi-hash"></i></div>
                    <div class="ship-field">
                        <input type="text" name="room_no" value="{{ $room_no }}" placeholder="Room Number" disabled>
                        @if (isset($errors) && $errors->has('room_no'))
                            <div class="ship-error">{{ $errors->first('room_no') }}</div>
                        @endif
                    </div>
                </div>

                {{-- Floor + Type (2 คอลัมน์) --}}
                <div class="ship-row">
                    <div class="ship-icon"><i class="bi bi-building"></i></div>
                    <div class="ship-field ship-grid-2">
                        <div>
                            <input type="number" name="floor" value="{{ $floor }}" placeholder="Floor"
                                min="1" required {{ auth()->user()->role == 'STAFF' ? 'readonly' : '' }}>
                            @if (isset($errors) && $errors->has('floor'))
                                <div class="ship-error">{{ $errors->first('floor') }}</div>
                            @endif
                        </div>
                        <div class="ship-select-wrap">
                            @if (auth()->user()->role == 'ADMIN')
                                <select name="type" required>
                                    <option value="STANDARD" {{ $type == 'STANDARD' ? 'selected' : '' }}>Standard</option>
                                    <option value="DELUXE" {{ $type == 'DELUXE' ? 'selected' : '' }}>Deluxe</option>
                                    <option value="LUXURY" {{ $type == 'LUXURY' ? 'selected' : '' }}>Luxury</option>
                                </select>
                            @else
                                <input type="text" name="type" value="{{ $type }}" required readonly>
                            @endif
                            <i class="bi bi-caret-down-fill ship-caret"></i>
                            @if (isset($errors) && $errors->has('type'))
                                <div class="ship-error">{{ $errors->first('type') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Monthly Rent --}}
                <div class="ship-row">
                    <div class="ship-icon"><i class="bi bi-cash-coin"></i></div>
                    <div class="ship-field">
                        <input type="number" name="monthly_rent" value="{{ $monthly_rent }}" placeholder="Monthly Rent"
                            min="500" required {{ auth()->user()->role == 'STAFF' ? 'readonly' : '' }}>
                        @if (isset($errors) && $errors->has('monthly_rent'))
                            <div class="ship-error">{{ $errors->first('monthly_rent') }}</div>
                        @endif
                    </div>
                </div>

                {{-- Status --}}
                <div class="ship-row">
                    <div class="ship-icon"><i class="bi bi-toggle-on"></i></div>
                    <div class="ship-field">
                        <div class="ship-select-wrap">

                            <select name="status" required>
                                <option value="AVAILABLE" {{ $status == 'AVAILABLE' ? 'selected' : '' }}>ว่าง</option>
                                <option value="OCCUPIED" {{ $status == 'OCCUPIED' ? 'selected' : '' }}>มีผู้เช่า
                                </option>
                                <option value="MAINTENANCE" {{ $status == 'MAINTENANCE' ? 'selected' : '' }}>
                                    ปิดปรับปรุง</option>
                            </select>



                            <i class="bi bi-caret-down-fill ship-caret"></i>
                        </div>
                        @if (isset($errors) && $errors->has('status'))
                            <div class="ship-error">{{ $errors->first('status') }}</div>
                        @endif
                    </div>
                </div>

                {{-- Note (textarea) --}}
                <div class="ship-row">
                    <div class="ship-icon"><i class="bi bi-journal-text"></i></div>
                    <div class="ship-field">
                        <textarea name="note" rows="7" placeholder="Note some detail" required
                            {{ auth()->user()->role == 'STAFF' ? 'readonly' : '' }}>{{ $note }}</textarea>
                        @if (isset($errors) && $errors->has('note'))
                            <div class="ship-error">{{ $errors->first('note') }}</div>
                        @endif
                    </div>
                </div>

                {{-- Branch --}}
                <div class="ship-row">
                    <div class="ship-icon"><i class="bi bi-geo-alt"></i></div>
                    <div class="ship-field">
                        {{-- <input type="text" name="branch" value="{{ $branch }}" placeholder="Branch" required> --}}

                        @if (auth()->user()->role == 'ADMIN')
                            <select name="branch" required>
                                <option value="SRINAKARIN" {{ $branch == 'SRINAKARIN' ? 'selected' : '' }}>SRINAKARIN
                                </option>
                                <option value="RAMA9" {{ $branch == 'RAMA9' ? 'selected' : '' }}>RAMA9</option>
                                <option value="ASOKE" {{ $branch == 'ASOKE' ? 'selected' : '' }}>ASOKE</option>
                                <option value="ROMKLAO" {{ $branch == 'ROMKLAO' ? 'selected' : '' }}>ROMKLAO</option>
                            </select>
                        @else
                            <input type="text" name="branch" value="{{ $branch }}" required
                                {{ auth()->user()->role == 'STAFF' ? 'readonly' : '' }}>
                        @endif
                        @if (isset($errors) && $errors->has('branch'))
                            <div class="ship-error">{{ $errors->first('branch') }}</div>
                        @endif
                    </div>
                </div>

                {{-- Photo --}}
                <div class="ship-row">
                    <div class="ship-icon"><i class="bi bi-image"></i></div>
                    <div class="ship-field">
                        @if (!empty($image))
                            <p class="ship-note mb-2">Current photo:
                                <a href="{{ asset('storage/' . $image) }}" target="_blank">View</a>
                            </p>
                        @endif
                        <input type="file" name="image" accept="image/*" class="ship-file" {{ auth()->user()->role == 'STAFF' ? 'disabled' : '' }}>
                        @if (isset($errors) && $errors->has('image'))
                            <div class="ship-error">{{ $errors->first('image') }}</div>
                        @endif
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="ship-actions">
                    <a href="{{ url('/room') }}" class="btn-ghost">Back to list</a>
                    <button type="submit" class="btn-primary-outline">Update</button>
                </div>
            </form>

        </div>
    </div>
@endsection
