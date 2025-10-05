@extends('layouts.frontend')

@section('css_before')
    <link href="{{ asset('css/contentBody.css') }}" rel="stylesheet">
@endsection

@section('navbar')
    <!-- Navbar ของหน้า -->
@endsection

@section('contentBody')
    <div class="row mt-4">
        <div class="col-12">
            <p class="header fs-4 d-flex align-items-center">
                <i class="fa-solid fa-door-open"></i>&nbsp;ห้องพักทั้งหมด
            </p>
            <p style="font-weight: 400;">เลือกห้องที่ถูกใจ แล้วไปต่อขั้นตอนการจองได้เลย</p>
        </div>
    </div>

    <div class="row">
        @forelse($rooms as $room)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card h-100">
                    @php
                        $img = $room->image
                            ? asset('storage/' . $room->image)
                            : asset('storage/uploads/branch/' . $room->branch . '.jpg'); // รูป fallback
                    @endphp

                    <a href="#">
                        <img src="{{ $img }}" class="card-img-top img-size" alt="Room {{ $room->room_no }}">
                    </a>

                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title mb-1">
                            Room {{ $room->room_no }}
                            @php
                                // กำหนดสี badge ตามประเภทห้อง
                                $badgeClass = match (strtoupper($room->type ?? '')) {
                                    'STANDARD' => 'bg-success', // เขียว
                                    'DELUXE' => 'bg-primary', // น้ำเงิน
                                    'LUXURY' => 'bg-warning text-dark', // เหลือง ตัวหนังสือเข้ม
                                    default => 'bg-secondary', // เทา (fallback)
                                };
                            @endphp

                            <span class="badge {{ $badgeClass }} ms-1">
                                {{ ucwords(strtolower($room->type)) }}
                            </span>
                        </h6>
                        <small class="text-muted">
                            ชั้น {{ $room->floor }} • {{ ucwords(strtolower($room->branch)) }}
                        </small>

                        <p class="card-text mt-2" style="min-height: 3rem;">
                            {{ Str::limit($room->note, 80) }}
                        </p>

                        <div class="mt-auto d-flex justify-content-between align-items-end">
                            <div>
                                <small class="text-muted text-decoration-line-through">
                                    THB {{ number_format($room->monthly_rent * 1.2, 2) }}
                                </small>
                                <div class="fw-bold" style="color:#F96D01;">
                                    THB {{ number_format($room->monthly_rent, 2) }}
                                </div>
                            </div>
                            <a href="{{ route('checkout.booking', ['room' => $room->id]) }}"
                                class="btn btn-sm btn-primary">จอง</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">ยังไม่มีห้องว่างให้จองในขณะนี้</div>
            </div>
        @endforelse
    </div>

    <div class="row mt-2 mb-2">
        <div class="col-sm-5 col-md-5"></div>
        <div class="col-sm-3 col-md-3">
            <center>
                {{ $rooms->links('pagination::bootstrap-5') }}
            </center>
        </div>
    </div>
@endsection

@section('footer')
@endsection

@section('js_before')
@endsection
