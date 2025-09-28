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
            <p class="header fs-4 d-flex align-items-center "><i
                    class="fa-solid fa-bullhorn"></i>&nbsp;ประกาศสำหรับผู้เช่าหอพัก
            </p>
            <p style="font-weight: 400;">สำหรับตามข่าวสารเกี่ยวกับหอพักของเรา!!</p>
            {{-- --}}
        </div>
    </div>

    @if (isset($AnnouncementList) && $AnnouncementList->count())
        <div id="cardCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($AnnouncementList->chunk(2) as $chunkIndex => $chunk)
                    <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                        <div class="row justify-content-center">
                            @foreach ($chunk as $announcement)
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="row g-0 h-100">
                                            <div class="col-md-4">
                                                <img src="{{ asset('storage/' . $announcement->image) }}"
                                                    class="img-fluid rounded-start" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body d-flex flex-column">
                                                    <h5 class="card-title">{{ $announcement->title }}</h5>
                                                    <p class="card-text" style="font-weight: 400;">
                                                        {{ Str::limit($announcement->body, 150) }}
                                                    </p>
                                                    <div
                                                        class="card-text mt-4 d-flex justify-content-between align-items-center">
                                                        <small class="text-body-secondary">
                                                            Last updated {{ $announcement->updated_at->diffForHumans() }}
                                                        </small>
                                                        <a href="{{ $announcement->link }}" target="_blank"
                                                            class="text-decoration-none">อ่านต่อ</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#cardCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#cardCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    @endif

    <div class="row mt-4">
        <div class="col-12">
            <p class="header fs-4 d-flex align-items-center mt-5">เช่าห้องกับ Dorm Booking ดีอย่างไร
            </p>
        </div>
    </div>
    <div class="row g-3 mb-5">
        <div class="col">
            <div class="benefit-card">
                <img src="{{ asset('images/' . '24repair.jpg') }}" alt="">
                <div class="d-flex flex-column justify-content-center ">
                  <h6><b>มีช่างคอยให้บริการ 24 ชั่วโมง</b></h6>
                  <small style="font-weight: 400;">เมื่อมีอุปกรณ์เสียหายเช่น แอร์ พัดลม ชำรุดสามารถเรียกหาช่างได้ตลอดเวลา</small>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="benefit-card">
                <img src="{{ asset('images/' . 'payment.jpg') }}" alt="">
                <div class="d-flex flex-column justify-content-center ">
                  <h6><b>ชำระเงินอย่างปลอดภัยและสะดวกสบาย</b></h6>
                  <small style="font-weight: 400;">สามารถชำระเงินผ่านเว็ปไซต์ได้เลยไม่ต้อง walk in ไปส่วนกลางและเลือกวิธีชำระเงินได้หลายวิธี</small>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="benefit-card">
                <img src="{{ asset('images/' . 'security.jpg') }}" alt="">
                <div class="d-flex flex-column justify-content-center ">
                  <h6><b>ความปลอดภัยของผู้เช่าหอพัก</b></h6>
                  <small style="font-weight: 400;">ทางหอพักมีกล้องวงจรปิดทำงาน 24 ชม. พร้อมมี รปภ คอยให้ความช่วยเหลือ</small>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('js_before')
    <!-- JS เพิ่มเติม -->
@endsection
