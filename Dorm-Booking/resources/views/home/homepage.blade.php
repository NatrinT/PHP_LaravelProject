@extends('layouts.frontend')

@section('css_before')
@endsection


@section('navbar')
  <!-- Navbar ของหน้า -->
@endsection

@section('contenthome')
  <div class="row">
    <div class="col-12 text-white fs-2 text-center mt-5">
      ราคาถูก วางใจทุกการจองหอพัก ไปกับ DORM Booking
    </div>
    <div class="col-12 mt-5">
      <div class="d-flex">
        <div class="tab-menu active"><i class="fas fa-hotel" color="blue"></i>&nbsp;จองหอพัก</div>
        <div class="tab-menu"><i class="fa-solid fa-compass"></i>&nbsp;สถานที่ท่องเที่ยว</div>
      </div>
      <hr>
      <div class="d-flex">
        <div class="type-hotel active"><i class="fas fa-hotel" color="blue"></i>&nbsp;หอพักดอร์มศรีนครินทร์</div>
        <div class="type-hotel"><i class="fas fa-hotel"></i>&nbsp;หอพักดอร์มพระราม 9</div>
        <div class="type-hotel"><i class="fas fa-hotel"></i>&nbsp;หอพักดอร์มอโศก</div>
      </div>
    </div>
  </div>
  <div class="row d-flex flex-row mt-4 text-white" style="font-weight: 400;">
    <div class="col-4">รูปแบบห้อง</div>
    <div class="col-4">ระยะเวลาเช่า</div>
    <div class="col-4">ห้องพัก</div>
  </div>
  <div class="row d-flex flex-row mt-2 text-white "
    style="font-weight: 400; justify-content: center; align-items: center;">

    <div id="selectTypeRoom" class="input-data corner-radius1 col-4 position-relative">
      <ion-icon name="location-outline"></ion-icon>
      <input id="roomInput" class="form-control p-2" type="text" placeholder="เลือกประเภทห้อง" readonly>

      <div id="dropdownContainer" class="dropdownContainer" style="display:none;">
        <ul class="dropdown-menu show w-100">
          <li><a class="dropdown-item" href="#">Standard</a></li>
          <li><a class="dropdown-item" href="#">Deluxe</a></li>
          <li><a class="dropdown-item" href="#">Luxury</a></li>
        </ul>
      </div>
    </div>
    <div class="col-4 input-data">
      <ion-icon name="calendar-outline"></ion-icon>
      <input type="text" class="form-control m-0 p-2" id="dateRangePicker" style="border-radius:0 "
        placeholder="ระยะเวลาที่ท่านต้องการเช่า">
    </div>

    <div class="col-3 input-data corner-radius2">
      <ion-icon name="people-outline"></ion-icon>
      <input type="text" class="form-control m-0 p-2" placeholder="จำนวนห้องพัก">
    </div>

    <a href="/" style="color: white" class="col-1 search-data p-2">
      <ion-icon name="search-outline" style="font-size: 36px"></ion-icon>
    </a>
  </div>
  <div class="row mt-2 mb-2">
    <div class="col-sm-5 col-md-5"></div>
    <div class="col-sm-3 col-md-3">
      <center>
        {{-- {{ $products->links() }} --}}
      </center>
    </div>
  </div>
@endsection

@section('contentBody')
  @include('home.mainpage') <!-- เรียกใช้ไฟล์แยก -->
@endsection

@section('js_before')
  <!-- JS เพิ่มเติม -->
@endsection