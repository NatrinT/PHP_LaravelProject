@extends('layouts.frontend'))

@section('css_before')
  <!-- ใส่ CSS เพิ่มเติมได้ -->
@endsection

@section('navbar')
  <!-- Navbar ของหน้า -->
@endsection

@section('contenthome')
  <div class="row">
    <div class="col-12 text-white fs-2 text-center mt-5">
      ราคาถูก วางใจทุกการจองโรงแรม ไปกับ DORM Booking
    </div>
    <div class="col-12 mt-5">
      <div class="d-flex">
        <div class="tab-menu active"><i class="fas fa-hotel" color="blue"></i>&nbsp;จองโรงแรม</div>
        <div class="tab-menu"><i class="fa-solid fa-compass"></i>&nbsp;สถานที่ท่องเที่ยว</div>
      </div>
      <hr>
      <div class="d-flex">
        <div class="type-hotel active"><i class="fas fa-hotel" color="blue"></i>&nbsp;โรงแรม</div>
        <div class="type-hotel"><i class="fas fa-hotel"></i>&nbsp;วิลล่า</div>
        <div class="type-hotel"><i class="fas fa-hotel"></i>&nbsp;อพาร์ตเมนต์</div>
      </div>
    </div>
  </div>
  <div class="row d-flex flex-row mt-4 text-white" style="font-weight: 400;">
    <div class="col-4">ชื่อสถานที่ รีสอร์ท หรือ โรงแรม</div>
    <div class="col-4">วันเช็คอินและเช็คเอาต์</div>
    <div class="col-4">ห้องพัก</div>
  </div>
  <div class="row d-flex flex-row mt-2 text-white "
    style="font-weight: 400; justify-content: center; align-items: center;">
    <form action="/search" method="get" class="col-4 p-0 m-0">
      <div class="input-data corner-radius1">
        <ion-icon name="location-outline"></ion-icon>
        <input class="form-control p-2" type="text" name="keyword" placeholder="ค้นหาชื่อสถานที่ รีสอร์ท หรือ โรงแรม"
          aria-label="Search" value="{{ $keyword ?? ''}}">
      </div>
    </form>

    <div class="col-4 input-data">
      <ion-icon name="calendar-outline"></ion-icon>
      <input type="text" class="form-control m-0 p-2" id="dateRangePicker" style="border-radius:0 "
        placeholder="วันเช็คอินและเช็คเอาต์">
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

@section('footer')
  <footer class="mt-5 mb-2">
    <p class="text-center">by devbanban.com @2025</p>
  </footer>
@endsection

@section('js_before')
  <!-- JS เพิ่มเติม -->
@endsection