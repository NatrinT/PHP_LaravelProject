@extends('content.layoutContent')

@section('css_before')
<style>
  /* ===== Hero / Base ===== */
  .help-hero{
    border-radius:18px;
    background:linear-gradient(135deg,#0b5ed7,#134eaf);
    color:#fff;
  }
  .help-hero .lead{ opacity:.92; }

  .help-card{
    border:0;
    border-radius:14px;
    box-shadow:0 10px 28px rgba(3,18,43,.06);
  }

  .help-chip{
    display:inline-block;
    padding:.35rem .75rem;
    border-radius:999px;
    background:#eef4ff;
    color:#0b3b66;
    font-weight:700;
    font-size:.85rem;
    border:1px solid rgba(11,94,215,.12);
  }

  .method-icon{
    width:44px; height:44px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    background:#f4f7ff; font-size:1.15rem; color:#0b5ed7;
  }
  .muted{ color:#6b778c; }

  .step{ display:flex; gap:12px; align-items:flex-start; }
  .step .dot{
    width:28px; height:28px; border-radius:50%; flex:0 0 28px;
    display:flex; align-items:center; justify-content:center;
    background:#0b5ed7; color:#fff; font-weight:800; font-size:.9rem;
    box-shadow:0 6px 18px rgba(13,110,253,.25);
  }
  .step + .step{ margin-top:14px; }

  .search-input{
    height:46px; border-radius:12px; border:0;
    padding-left:44px; background:#f7f9fd;
  }
  .search-icon{
    position:absolute; left:14px; top:50%; transform:translateY(-50%);
    color:#6b778c;
  }

  html{ scroll-behavior:smooth; }
  .anchor-offset{ scroll-margin-top:90px; }

  .accordion-item{
    border:0; box-shadow:0 6px 16px rgba(3,18,43,.06);
    border-radius:12px; overflow:hidden;
  }
  .accordion-item + .accordion-item{ margin-top:10px; }

  /* ===== Responsive polish ===== */
  @media (max-width: 991.98px){
    .help-hero{ border-radius:14px; }
    .help-hero h2{ font-size:1.5rem; }
    .help-hero .lead{ font-size:1rem; }
  }
  @media (max-width: 767.98px){
    .help-hero{ padding:1.25rem !important; }
    .help-chip{ font-size:.8rem; padding:.3rem .6rem; }
    .method-icon{ width:40px; height:40px; font-size:1rem; }
    .step .dot{ width:24px; height:24px; flex-basis:24px; font-size:.8rem; }
    .search-input{ height:42px; border-radius:10px; padding-left:40px; }
    .accordion-button{ padding:.9rem 1rem; }
    .help-card{ border-radius:12px; }
  }
  @media (max-width: 575.98px){
    .help-hero .lead{ margin-bottom:.75rem; }
    .help-chip{ margin-bottom:.25rem; }
    .card .p-4{ padding:1rem !important; }
    .card .p-5{ padding:1.25rem !important; }
  }
</style>
@endsection

@section('navbar')
    <!-- Navbar ของหน้า -->
@endsection

@section('content')
<div class="container py-4">

  {{-- ===== HERO ===== --}}
  <section class="help-hero p-4 p-md-5 mb-4">
    <div class="row align-items-center">
      <div class="col-lg-7">
        <h2 class="fw-bold mb-2">ศูนย์ช่วยเหลือ Dorm Booking</h2>
        <p class="lead mb-3">คำแนะนำการใช้งานเว็บไซต์ ขั้นตอนการจอง และวิธีชำระเงิน — ทุกอย่างอยู่ที่นี่</p>
        <div class="row d-flex gap-2 align-items-center justify-content-center">
          <a href="#how-it-works" class="help-chip text-decoration-none col-12 col-lg">เริ่มต้นใช้งาน</a>
          <a href="#booking-steps" class="help-chip text-decoration-none col-12 col-lg">ขั้นตอนการจอง</a>
          <a href="#payment" class="help-chip text-decoration-none col-12 col-lg">การชำระเงิน</a>
          <a href="#faq" class="help-chip text-decoration-none col-12 col-lg">คำถามพบบ่อย</a>
          <a href="#contact" class="help-chip text-decoration-none col-12 col-lg">ติดต่อเรา</a>
        </div>
      </div>
      <div class="col-lg-5 mt-4 mt-lg-0 text-center">
        <i class="fa-solid fa-circle-question" style="font-size:min(18vw,90px); opacity:.9"></i>
      </div>
    </div>
  </section>

  {{-- ===== HOW IT WORKS ===== --}}
  <section id="how-it-works" class="anchor-offset mb-4">
    <div class="card help-card">
      <div class="card-body p-4 p-md-5">
        <h4 class="fw-bold mb-3">เว็บไซต์ทำงานอย่างไร</h4>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="d-flex gap-3">
              <div class="method-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
              <div>
                <h6 class="mb-1">ค้นหาห้องที่ต้องการ</h6>
                <p class="mb-0 muted">เลือกสาขา (เช่น Asoke, Rama9 ฯลฯ), ประเภทห้อง (Standard / Deluxe / Luxury) และช่วงวันที่ต้องการเข้าพัก</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="d-flex gap-3">
              <div class="method-icon"><i class="fa-regular fa-building"></i></div>
              <div>
                <h6 class="mb-1">ดูรายละเอียดห้อง</h6>
                <p class="mb-0 muted">เปิดการ์ดห้องดูรูป โน้ต ชั้น ราคา และสถานะว่าง/ไม่ว่างแบบเรียลไทม์</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="d-flex gap-3">
              <div class="method-icon"><i class="fa-solid fa-clipboard-check"></i></div>
              <div>
                <h6 class="mb-1">กดจองและชำระเงิน</h6>
                <p class="mb-0 muted">ยืนยันการจอง กรอกข้อมูลผู้เข้าพัก และชำระเงินตามช่องทางที่สะดวก</p>
              </div>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </section>

  {{-- ===== BOOKING STEPS ===== --}}
  <section id="booking-steps" class="anchor-offset mb-4">
    <div class="card help-card">
      <div class="card-body p-4 p-md-5">
        <h4 class="fw-bold mb-3">ขั้นตอนการจองห้อง</h4>
        <div class="step"><div class="dot">1</div><div><b>เลือกสาขา/ประเภท/ช่วงวันที่</b><div class="muted">ระบบจะแสดงห้องที่ว่างตามเงื่อนไข</div></div></div>
        <div class="step"><div class="dot">2</div><div><b>เลือกห้อง</b><div class="muted">ตรวจสอบราคา รายละเอียด และกด <b>จอง</b></div></div></div>
        <div class="step"><div class="dot">3</div><div><b>กรอกข้อมูลผู้เข้าพัก</b><div class="muted">ชื่อ-นามสกุล, เบอร์ติดต่อ, อีเมล</div></div></div>
        <div class="step"><div class="dot">4</div><div><b>ชำระเงิน/วางมัดจำ</b><div class="muted">เลือกช่องทางชำระเงิน (ดูด้านล่าง)</div></div></div>
        <div class="step"><div class="dot">5</div><div><b>รับอีเมลยืนยัน</b><div class="muted">เราจะส่งรายละเอียดการจองและใบเสร็จ</div></div></div>
        <div class="step"><div class="dot">6</div><div><b>เช็คอินตามวันนัดหมาย</b><div class="muted">แสดงเอกสารยืนยัน/บัตรประชาชนที่เคาน์เตอร์</div></div></div>
      </div>
    </div>
  </section>

  {{-- ===== PAYMENT METHODS ===== --}}
  <section id="payment" class="anchor-offset mb-4">
    <div class="card help-card">
      <div class="card-body p-4 p-md-5">
        <h4 class="fw-bold mb-3">ช่องทางการชำระเงิน</h4>
        <div class="row g-3">
          <div class="col-md-6 col-lg-3">
            <div class="p-3 border rounded-3 h-100">
              <div class="d-flex align-items-center gap-3 mb-2">
                <div class="method-icon"><i class="fa-regular fa-credit-card"></i></div>
                <b>บัตรเครดิต/เดบิต</b>
              </div>
              <div class="muted small">Visa / MasterCard / JCB — ปลอดภัยด้วย 3-D Secure</div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="p-3 border rounded-3 h-100">
              <div class="d-flex align-items-center gap-3 mb-2">
                <div class="method-icon"><i class="fa-solid fa-qrcode"></i></div>
                <b>QR พร้อมเพย์</b>
              </div>
              <div class="muted small">สแกนจ่ายผ่าน Mobile Banking ยืนยันอัตโนมัติไม่กี่นาที</div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="p-3 border rounded-3 h-100">
              <div class="d-flex align-items-center gap-3 mb-2">
                <div class="method-icon"><i class="fa-solid fa-mobile-screen"></i></div>
                <b>Mobile Banking</b>
              </div>
              <div class="muted small">โอนผ่านแอปธนาคาร กรอกอ้างอิงการจองให้ถูกต้อง</div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="p-3 border rounded-3 h-100">
              <div class="d-flex align-items-center gap-3 mb-2">
                <div class="method-icon"><i class="fa-solid fa-wallet"></i></div>
                <b>e-Wallet</b>
              </div>
              <div class="muted small">TrueMoney/กระเป๋าเงินดิจิทัลที่รองรับ (ถ้ามีเปิดใช้งาน)</div>
            </div>
          </div>
        </div>

        <div class="alert alert-info mt-3 mb-0 small">
          💡 <b>เคล็ดลับ:</b> เก็บสลิป/หลักฐานการชำระเงินไว้เสมอ หากระบบยังไม่ตัดยอดภายใน 10 นาที กรุณาติดต่อฝ่ายบริการลูกค้า
        </div>
      </div>
    </div>
  </section>

  {{-- ===== FAQ ===== --}}
  <section id="faq" class="anchor-offset mb-4">
    <div class="card help-card">
      <div class="card-body p-4 p-md-5">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3">
          <h4 class="fw-bold mb-3 mb-md-0">คำถามที่พบบ่อย</h4>
          <div class="position-relative" style="min-width:260px; max-width:380px; width:100%;">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <input type="text" id="faqSearch" class="form-control search-input" placeholder="พิมพ์เพื่อค้นหาในคำถาม...">
          </div>
        </div>

        <div class="accordion" id="faqAccordion">
          {{-- 1 --}}
          <div class="accordion-item" data-faq>
            <h2 class="accordion-header" id="q1">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#a1">
                ยกเลิกการจอง/ขอคืนเงินได้อย่างไร?
              </button>
            </h2>
            <div id="a1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                นโยบายการยกเลิกขึ้นอยู่กับสาขา โปรดตรวจสอบในอีเมลยืนยันการจอง
                หากต้องการความช่วยเหลือ ติดต่อฝ่ายบริการลูกค้าที่ส่วน “ติดต่อเรา”
              </div>
            </div>
          </div>
          {{-- 2 --}}
          <div class="accordion-item" data-faq>
            <h2 class="accordion-header" id="q2">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a2">
                ระบบรับชำระเงินปลอดภัยหรือไม่?
              </button>
            </h2>
            <div id="a2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                ระบบชำระเงินเชื่อมต่อผู้ให้บริการที่ได้มาตรฐาน รองรับ 3-D Secure และการเข้ารหัสข้อมูล
              </div>
            </div>
          </div>
          {{-- 3 --}}
          <div class="accordion-item" data-faq>
            <h2 class="accordion-header" id="q3">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a3">
                ต้องวางมัดจำเท่าไร?
              </button>
            </h2>
            <div id="a3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                มัดจำขึ้นอยู่กับสาขา/ประเภทห้อง โดยทั่วไปอยู่ที่ 1–2 เดือนของค่าเช่า โปรดดูรายละเอียดหน้าจอง
              </div>
            </div>
          </div>
          {{-- 4 --}}
          <div class="accordion-item" data-faq>
            <h2 class="accordion-header" id="q4">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a4">
                ขอใบเสร็จหรือใบกำกับภาษีได้ไหม?
              </button>
            </h2>
            <div id="a4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                ได้ สามารถระบุความต้องการนี้ในแบบฟอร์มจอง หรือแจ้งทีมงานผ่านช่องทางติดต่อ
              </div>
            </div>
          </div>
          {{-- 5 --}}
          <div class="accordion-item" data-faq>
            <h2 class="accordion-header" id="q5">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a5">
                เวลาเช็คอิน/เช็คเอาท์เป็นอย่างไร?
              </button>
            </h2>
            <div id="a5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                โดยทั่วไปเช็คอินหลัง 14:00 และเช็คเอาท์ก่อน 12:00 แต่ละสาขาอาจต่างกัน โปรดดูในอีเมลยืนยัน
              </div>
            </div>
          </div>
        </div><!-- /accordion -->
      </div>
    </div>
  </section>

  {{-- ===== CONTACT ===== --}}
  <section id="contact" class="anchor-offset mb-4">
    <div class="card help-card">
      <div class="card-body p-4 p-md-5">
        <h4 class="fw-bold mb-3">ติดต่อเรา</h4>
        <div class="row g-3">
          <div class="col-md-6">
            <div class="p-3 border rounded-3 h-100">
              <h6 class="mb-2"><i class="fa-regular fa-envelope me-2 text-primary"></i>อีเมล</h6>
              <div class="muted">support@dormbooking.com</div>
              <h6 class="mt-3 mb-2"><i class="fa-solid fa-phone me-2 text-primary"></i>โทรศัพท์</h6>
              <div class="muted">081-234-5678 (ทุกวัน 09:00–18:00)</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-3 border rounded-3 h-100">
              <h6 class="mb-2"><i class="fa-brands fa-line me-2 text-success"></i>LINE Official</h6>
              <div class="muted">@DormBooking</div>
              <h6 class="mt-3 mb-2"><i class="fa-solid fa-circle-info me-2 text-primary"></i>ลิงก์ที่เกี่ยวข้อง</h6>
              <ul class="list-unstyled mb-0 small">
                <li><a href="#how-it-works">วิธีใช้งานเว็บไซต์</a></li>
                <li><a href="#booking-steps">ขั้นตอนการจอง</a></li>
                <li><a href="#payment">ชำระเงินอย่างไร</a></li>
                <li><a href="#faq">คำถามพบบ่อย</a></li>
              </ul>
            </div>
          </div>
        </div>        
      </div>
    </div>
  </section>

</div>
@endsection

@section('js_before')
<script>
  // ค้นหาใน FAQ (ซ่อน/แสดง accordion items ตามคำค้นหา)
  (function(){
    const input = document.getElementById('faqSearch');
    if(!input) return;
    input.addEventListener('input', () => {
      const q = input.value.trim().toLowerCase();
      document.querySelectorAll('[data-faq]').forEach(item => {
        const txt = item.innerText.toLowerCase();
        item.style.display = txt.includes(q) ? '' : 'none';
      });
    });
  })();
</script>
@endsection
