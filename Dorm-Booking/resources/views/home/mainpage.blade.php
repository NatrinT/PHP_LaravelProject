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
      <p class="header fs-4 d-flex align-items-center "><i class="fa-solid fa-bullhorn"></i>&nbsp;ประกาศสำหรับผู้เช่าหอพัก
      </p>
      <p style="font-weight: 400;">สำหรับตามข่าวสารเกี่ยวกับหอพักของเรา!!</p>
      {{-- --}}
    </div>
  </div>

  <div id="cardCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

      <!-- Slide 1 -->
      <div class="carousel-item active">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card mb-3">
              <div class="row g-0 h-100">
                <div class="col-md-4">
                  <img src="{{asset('images/announcement/electric.jpg')}}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title">คนไทยเฮ! กกพ.ประกาศลดค่าไฟ เหลือ 3.98 บาท/หน่วย</h5>
                    <p class="card-text" style="font-weight: 400;">และมีมติให้ปรับค่า Ft จากเดิม 36.72 สตางค์ต่อหน่วย เป็น
                      19.72 สตางค์ต่อหน่วย ซึ่งจะทำให้ค่าไฟฟ้าเฉลี่ยลดลงจาก 4.15 บาทต่อหน่วย เป็น 3.98 บาทต่อหน่วย
                      หรือลดลงประมาณ 17 สตางค์ต่อหน่วย </p>
                    <div class="card-text mt-auto d-flex justify-content-between align-items-center">
                      <small class="text-body-secondary">Last updated 3 mins ago</small>
                      <a href="https://www.pptvhd36.com/wealth/economic/247852" target="_blank"
                        class="text-decoration-none">อ่านต่อ</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card mb-3">
              <div class="row g-0 h-100">
                <div class="col-md-4">
                  <img src="{{asset('images/announcement/electric.jpg')}}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title">คนไทยเฮ! กกพ.ประกาศลดค่าไฟ เหลือ 3.98 บาท/หน่วย</h5>
                    <p class="card-text" style="font-weight: 400;">และมีมติให้ปรับค่า Ft จากเดิม 36.72 สตางค์ต่อหน่วย เป็น
                      19.72 สตางค์ต่อหน่วย ซึ่งจะทำให้ค่าไฟฟ้าเฉลี่ยลดลงจาก 4.15 บาทต่อหน่วย เป็น 3.98 บาทต่อหน่วย
                      หรือลดลงประมาณ 17 สตางค์ต่อหน่วย </p>
                    <div class="card-text mt-auto d-flex justify-content-between align-items-center">
                      <small class="text-body-secondary">Last updated 3 mins ago</small>
                      <a href="https://www.pptvhd36.com/wealth/economic/247852" target="_blank"
                        class="text-decoration-none">อ่านต่อ</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="carousel-item">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card mb-3">
              <div class="row g-0 h-100">
                <div class="col-md-4">
                  <img src="{{asset('images/announcement/electric.jpg')}}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title">คนไทยเฮ! กกพ.ประกาศลดค่าไฟ เหลือ 3.98 บาท/หน่วย</h5>
                    <p class="card-text" style="font-weight: 400;">และมีมติให้ปรับค่า Ft จากเดิม 36.72 สตางค์ต่อหน่วย เป็น
                      19.72 สตางค์ต่อหน่วย ซึ่งจะทำให้ค่าไฟฟ้าเฉลี่ยลดลงจาก 4.15 บาทต่อหน่วย เป็น 3.98 บาทต่อหน่วย
                      หรือลดลงประมาณ 17 สตางค์ต่อหน่วย </p>
                    <div class="card-text mt-auto d-flex justify-content-between align-items-center">
                      <small class="text-body-secondary">Last updated 3 mins ago</small>
                      <a href="https://www.pptvhd36.com/wealth/economic/247852" target="_blank"
                        class="text-decoration-none">อ่านต่อ</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card mb-3">
              <div class="row g-0 h-100">
                <div class="col-md-4">
                  <img src="{{asset('images/announcement/electric.jpg')}}" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title">คนไทยเฮ! กกพ.ประกาศลดค่าไฟ เหลือ 3.98 บาท/หน่วย</h5>
                    <p class="card-text" style="font-weight: 400;">และมีมติให้ปรับค่า Ft จากเดิม 36.72 สตางค์ต่อหน่วย เป็น
                      19.72 สตางค์ต่อหน่วย ซึ่งจะทำให้ค่าไฟฟ้าเฉลี่ยลดลงจาก 4.15 บาทต่อหน่วย เป็น 3.98 บาทต่อหน่วย
                      หรือลดลงประมาณ 17 สตางค์ต่อหน่วย </p>
                    <div class="card-text mt-auto d-flex justify-content-between align-items-center">
                      <small class="text-body-secondary">Last updated 3 mins ago</small>
                      <a href="https://www.pptvhd36.com/wealth/economic/247852" target="_blank"
                        class="text-decoration-none">อ่านต่อ</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#cardCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#cardCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

@endsection

@section('js_before')
  <!-- JS เพิ่มเติม -->
@endsection