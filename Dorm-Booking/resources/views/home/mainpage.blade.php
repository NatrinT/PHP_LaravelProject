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

    <div class="row mt-5">
        <div class="col-12">
            <p class="header fs-4 d-flex align-items-center ">เช่าห้องกับ Dorm Booking ดีอย่างไร
            </p>
        </div>
    </div>
    <div class="row g-3">
        <div class="col">
            <div class="benefit-card">
                <img src="{{ asset('images/' . '24repair.jpg') }}" alt="">
                <div class="d-flex flex-column justify-content-center ">
                    <h6><b>มีช่างคอยให้บริการ 24 ชั่วโมง</b></h6>
                    <small style="font-weight: 400;">เมื่อมีอุปกรณ์เสียหายเช่น แอร์ พัดลม
                        ชำรุดสามารถเรียกหาช่างได้ตลอดเวลา</small>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="benefit-card">
                <img src="{{ asset('images/' . 'payment.jpg') }}" alt="">
                <div class="d-flex flex-column justify-content-center ">
                    <h6><b>ชำระเงินอย่างปลอดภัยและสะดวกสบาย</b></h6>
                    <small style="font-weight: 400;">สามารถชำระเงินผ่านเว็ปไซต์ได้เลยไม่ต้อง walk in
                        ไปส่วนกลางและเลือกวิธีชำระเงินได้หลายวิธี</small>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="benefit-card">
                <img src="{{ asset('images/' . 'security.jpg') }}" alt="">
                <div class="d-flex flex-column justify-content-center ">
                    <h6><b>ความปลอดภัยของผู้เช่าหอพัก</b></h6>
                    <small style="font-weight: 400;">ทางหอพักมีกล้องวงจรปิดทำงาน 24 ชม. พร้อมมี รปภ
                        คอยให้ความช่วยเหลือ</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 ">
        <div class="col-12">
            <p class="header fs-4 d-flex align-items-center mt-5">⭐หอพักแนะนำในเครือของเรา
            </p>
        </div>
    </div>
    <div class="swiper mySwiper mt-2">
        <div class="swiper-wrapper">
            <!-- ตัวอย่าง slide - แทนที่จะใช้ "..." ให้ใส่ path รูปจริง -->
            @foreach ($RoomList as $room)
                @if ($room->status == 'AVAILABLE')
                    <div class="swiper-slide">
                        <a class="card" href="">
                            <img src="{{ asset('images/apartment_image/rooms.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p class="card-title fs-7">
                                    Dorm Apartment {{ ucwords(strtolower($room->branch)) }}
                                </p>
                                <small class="card-text"
                                    style="font-weight: 400; color: rgb(236, 58, 62);">{{ ucwords(strtolower($room->type)) }}
                                    Room</small>
                                <small class="card-text note-text" style="font-weight: 400;">{{ $room->note }}</small>
                                <small class="card-text fs-7 mt-3 text-end"
                                    style="color: rgb(143, 143, 143);text-decoration-line: line-through;">THB
                                    {{ number_format($room->monthly_rent * 1.3, 2) }}</small>
                                <strong class="card-text fs-7 text-end" style="color: rgb(249, 109, 1)">THB
                                    {{ number_format($room->monthly_rent, 2) }}</strong>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
            <!-- เพิ่ม slide ตามต้องการ -->
        </div>

        <!-- controls -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
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
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="chip">ช่วยเหลือตลอด 24 ชม.</span>
                        <span class="chip">มีที่จอดรถ</span>
                        <span class="chip">WIFI ความเร็วสูง</span>
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
                        slidesPerView: 3
                    },
                    992: {
                        slidesPerView: 4
                    }
                }
            });
        });
    </script>
@endsection
