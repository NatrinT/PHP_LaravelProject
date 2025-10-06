@extends('home')

@section('title', 'Update User')

@section('css_before')
    {{-- ใช้ Bootstrap Icons จาก layout เดิม --}}
    <link href="{{ asset('css/edituser.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="ship-wrap mt-5">
        <div class="ship-card">
            <h2 class="ship-title">Update User</h2>

            <form action="/users/{{ $id }}" method="post" class="ship-form">
                @csrf
                @method('put')

                {{-- Username --}}
                <div class="ship-row">
                    <div class="ship-icon"><i class="bi bi-person"></i></div>
                    <div class="ship-field">
                        <input type="text" name="name" value="{{ $name }}" placeholder="Username" required>
                        @if (isset($errors) && $errors->has('name'))
                            <div class="ship-error">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>

                {{-- Email --}}
                <div class="ship-row">
                    <div class="ship-icon"><i class="bi bi-at"></i></div>
                    <div class="ship-field">
                        <input type="email" name="email" value="{{ $email }}" placeholder="Email" required>
                        @if (isset($errors) && $errors->has('email'))
                            <div class="ship-error">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                </div>

                {{-- Phone + Role (จัดวาง 2 คอลัมน์) --}}
                <div class="ship-row">
                    <div class="ship-icon"><i class="bi bi-telephone"></i></div>
                    <div class="ship-field ship-grid-2">
                        <div>
                            <input type="text" name="phone" value="{{ $phone }}" placeholder="Phone Number"
                                required minlength="3">
                            @if (isset($errors) && $errors->has('phone'))
                                <div class="ship-error">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                        <div class="ship-select-wrap">
                            @if (auth()->user()->role === 'ADMIN')
                                <select name="role" required>
                                    <option value="MEMBER" {{ $role == 'MEMBER' ? 'selected' : '' }}>Member</option>
                                    <option value="STAFF" {{ $role == 'STAFF' ? 'selected' : '' }}>Staff</option>
                                    <option value="ADMIN" {{ $role == 'ADMIN' ? 'selected' : '' }}>Admin</option>
                                </select>
                            @else
                                <input type="text" name="role" value="{{ $role }}" required readonly>
                            @endif
                            <i class="bi bi-caret-down-fill ship-caret"></i>
                            @if (isset($errors) && $errors->has('role'))
                                <div class="ship-error">{{ $errors->first('role') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="ship-row">
                    <div class="ship-icon"><i class="bi bi-toggle-on"></i></div>
                    <div class="ship-field">
                        <div class="ship-select-wrap">
                            <select name="status" required>
                                <option value="ACTIVE" {{ $status == 'ACTIVE' ? 'selected' : '' }}>ใช้งาน</option>
                                <option value="SUSPENDED" {{ $status == 'SUSPENDED' ? 'selected' : '' }}>ระงับชั่วคราว
                                </option>
                                <option value="DELETED" {{ $status == 'DELETED' ? 'selected' : '' }}>ลบแล้ว</option>
                            </select>
                            <i class="bi bi-caret-down-fill ship-caret"></i>
                        </div>
                        @if (isset($errors) && $errors->has('status'))
                            <div class="ship-error">{{ $errors->first('status') }}</div>
                        @endif
                    </div>
                </div>

                {{-- ปุ่ม --}}
                <div class="ship-actions">
                    <a href="{{ url('/users') }}" class="btn-ghost">Back to list</a>
                    @if (session('user_role') === 'STAFF' && $role === 'ADMIN')
                    @else
                        <button type="submit" class="btn-primary-outline">Update</button>
                    @endif
                </div>
            </form>

        </div>
    </div>
@endsection
