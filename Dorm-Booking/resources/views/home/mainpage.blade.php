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
            <p class="header fs-4 d-flex align-items-center font-content-header m-1 m-md-3"><i
                    class="fa-solid fa-bullhorn "></i>&nbsp;ประกาศสำหรับผู้เช่าหอพัก
            </p>
            <p style="font-weight: 400;" class="font-content-body">สำหรับตามข่าวสารเกี่ยวกับหอพักของเรา!!</p>
            {{-- --}}
        </div>
    </div>

    @if (isset($AnnouncementList) && $AnnouncementList->count())
        {{-- ✅ มือถือ: แสดงทีละ 1 ใบ --}}
        <div class="d-md-none">
            <div id="cardCarouselSm" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($AnnouncementList as $i => $announcement)
                        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                            <div class="card mb-3">
                                <div class="row g-0 h-100">
                                    <div class="col-4">
                                        <img src="{{ asset('storage/' . $announcement->image) }}"
                                            class="img-fluid rounded-start obj-cover" alt="...">
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body d-flex flex-column">
                                            <h6 class="card-title mb-1">{{ $announcement->title }}</h6>
                                            <p class="card-text small mb-2">{{ Str::limit($announcement->body, 120) }}</p>
                                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                                <small class="text-body-secondary">อัปเดต
                                                    {{ $announcement->updated_at->diffForHumans() }}</small>
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

                @if ($AnnouncementList->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#cardCarouselSm"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#cardCarouselSm"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                @endif
            </div>
        </div>

        {{-- ✅ จอ md+: แสดงทีละ 2 ใบ (โค้ดเดิม) --}}
        <div class="d-none d-md-block">
            <div id="cardCarouselMd" class="carousel slide" data-bs-ride="carousel">
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
                                                        class="img-fluid rounded-start obj-cover" alt="...">
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
                                                                อัปเดต {{ $announcement->updated_at->diffForHumans() }}
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

                @if ($AnnouncementList->count() > 2)
                    <button class="carousel-control-prev" type="button" data-bs-target="#cardCarouselMd"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#cardCarouselMd"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                @endif
            </div>
        </div>
    @endif


    <div class="row mt-5">
        <div class="col-12">
            <p class="header fs-4 d-flex align-items-center font-content-header">เช่าห้องกับ Dorm Booking ดีอย่างไร
            </p>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="benefit-card">
                <img src="{{ asset('images/' . '24repair.jpg') }}" alt="">
                <div class="d-flex flex-column justify-content-center ">
                    <h6 class="font-benefit-header"><b>มีช่างคอยให้บริการ 24 ชั่วโมง</b></h6>
                    <small style="font-weight: 400;" class="font-benefit-body">เมื่อมีอุปกรณ์เสียหายเช่น แอร์ พัดลม
                        ชำรุดสามารถเรียกหาช่างได้ตลอดเวลา</small>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="benefit-card">
                <img src="{{ asset('images/' . 'security.jpg') }}" alt="">
                <div class="d-flex flex-column justify-content-center ">
                    <h6 class="font-benefit-header"><b>ความปลอดภัยของผู้เช่าหอพัก</b></h6>
                    <small style="font-weight: 400;" class="font-benefit-body">ทางหอพักมีกล้องวงจรปิดทำงาน 24 ชม. พร้อมมี รปภ
                        คอยให้ความช่วยเหลือ</small>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4">
            <div class="benefit-card">
                <img src="{{ asset('images/' . 'payment.jpg') }}" alt="">
                <div class="d-flex flex-column justify-content-center ">
                    <h6 class="font-benefit-header"><b>ชำระเงินอย่างปลอดภัยและสะดวกสบาย</b></h6>
                    <small style="font-weight: 400;" class="font-benefit-body">สามารถชำระเงินผ่านเว็ปไซต์ได้เลยไม่ต้อง walk in
                        ไปส่วนกลางและเลือกวิธีชำระเงินได้หลายวิธี</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 ">
        <div class="col-12">
            <p class="header fs-4 d-flex align-items-center mt-5 font-content-header">⭐หอพักแนะนำในเครือของเรา
            </p>
        </div>
    </div>
    <div class="swiper mySwiper mt-2">
        <div class="swiper-wrapper">
            <!-- ตัวอย่าง slide - แทนที่จะใช้ "..." ให้ใส่ path รูปจริง -->
            @php $types = ['STANDARD','DELUXE','LUXURY']; @endphp
            @foreach ($branches as $br)
                <div class="swiper-slide">
                    <a class="card" href="/searchRoom?branch={{ $br }}">
                        <img src="{{ asset('storage/uploads/branch/' . $br . '.jpg') }}" class="card-img-top"
                            alt="...">
                        <div class="card-body">
                            <p class="card-title fs-7">
                                Dorm Apartment {{ ucwords(strtolower($br)) }}
                            </p>
                            <div class="row p-2">
                                @foreach ($types as $t)
                                    @php
                                        $cnt = $byBranchType[$br][$t];
                                    @endphp
                                    <div class="col-4 p-0">
                                        <div class="border rounded p-2 h-100">
                                            <div class="small text-muted">{{ ucwords(strtolower($t)) }}</div>
                                            <div class="fs-4 fw-bold">{{ $byBranchType[$br][$t] }}</div>
                                            <div class="small text-secondary">ห้อง</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @php $pb = $priceByBranch[$br]; @endphp
                            @if (!is_null($pb['min']))
                                <strong class="card-text fs-7 text-start mt-3" style="color: rgb(249, 109, 1)">

                                    ราคาเริ่มต้น {{ number_format($pb['min'], 0) }} -
                                    {{ number_format($pb['max'], 0) }}
                                </strong>
                            @endif

                        </div>
                        <strong class="card-text fs-7 text-center mt-1 card-footer" style="color: #0b5ed7">
                            ดูเลย
                        </strong>
                    </a>
                </div>
            @endforeach
            <!-- เพิ่ม slide ตามต้องการ -->
        </div>

        {{-- count rooms --}}


        <!-- controls -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <section class="dorm-cta2 border-0 shadow-sm overflow-hidden" style="margin-top: 80px; margin-bottom: 100px;">
        <div class="row g-0">
            <!-- LEFT -->
            <div class="col-lg-7">
                <div class="dorm-cta2__left">
                    <span class="badge dorm-cta2__badge mb-3">Dorm Booking</span>
                    <h2 class="dorm-cta2__title mb-3">บ้านหลังที่สองของคุณ<br class="d-none d-md-block">หาได้ที่นี่</h2>
                    <p class="dorm-cta2__desc mb-4">ห้องพักสะอาด ปลอดภัย ใกล้มหาวิทยาลัย ราคาเข้าถึงได้
                        จองง่ายพร้อมดูรีวิวจริงจากผู้เข้าพัก</p>
                    <div class="row gap-2 mb-4">
                        <span class="chip col-12 col-md-4">ช่วยเหลือตลอด 24 ชม.</span>
                        <span class="chip col-12 col-md-2">มีที่จอดรถ</span>
                        <span class="chip col-12 col-md-3">WIFI ความเร็วสูง</span>
                    </div>
                    <a href="#" class="btn dorm-cta2__btn">สำรวจห้องว่าง</a>
                </div>
            </div>
            <!-- RIGHT -->
            <div class="col-lg-5">
                <div class="dorm-cta2__right">
                    <!-- ใช้ภาพจริงของคุณที่ /public/images/dorm-illustration.png -->
                    <img class="dorm-cta2__img" src="{{ asset('images/dorm-illustration.png') }}"
                        alt="Dorm illustration (placeholder)">
                </div>
            </div>
        </div>
    </section>



@endsection

@section('js_before')
    <!-- JS เพิ่มเติม -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ตรวจสอบว่ามี element ก่อน init
            if (!document.querySelector('.mySwiper')) return;

            var swiper = new Swiper('.mySwiper', {
                slidesPerView: 4, // แสดงทีละ 4 บนจอใหญ่
                spaceBetween: 20,
                slidesPerGroup: 1, // เลื่อนไปทีละ 1 การ์ด
                loop: false, // เปลี่ยนเป็น true ถ้าต้องการวน
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1
                    },
                    576: {
                        slidesPerView: 2
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 16
                    }, // md ≥ 768px → 2 ใบ
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 16
                    }, // lg ≥ 992px → 3 ใบ (ปรับได้)
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 16
                    }, // xl ≥ 1200px → 4 ใบ (ปรับได้)
                }
            });
        });
    </script>
@endsection
