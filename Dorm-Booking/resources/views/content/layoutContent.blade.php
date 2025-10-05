<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 12 Basic CRUD by devbanban.com 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 Free -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="{{ asset('css/content.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @yield('css_before')
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-style">
            <div class="container-fluid">
                <a href="/">
                    <p class="app-icon"></p>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active text-white animate-text" aria-current="page"
                                href="{{ route('content.room') }}">หอพัก</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white animate-text" href="{{ route('content.help') }}">ช่วยเหลือ</a>
                        </li>
                        @if (session('user_id'))
                            <li class="nav-item">
                                <a class="nav-link text-white animate-text"
                                    href="{{ route('checkout.myBooking') }}">การจองของฉัน</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white animate-text"
                                    href="{{ route('payments.history') }}">ประวัติการชำระเงิน</a>
                            </li>
                        @endif

                        @if (session('user_role') === 'ADMIN')
                            <li class="nav-item">
                                <a class="nav-link text-danger animate-text" href="/dashboard"
                                    target="_blank">จัดการหลังบ้าน</a>
                            </li>
                        @endif


                    </ul>
                    @if (!session('user_id'))
                        <div class="d-flex">
                            <button type="button" class="btn btn-outline-light text-white d-flex align-items-center"
                                data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                                <ion-icon name="person-outline" class="me-2"></ion-icon> เข้าสู่ระบบ
                            </button>
                            <button type="button" class="btn bg-primary text-white d-flex align-items-center mx-2"
                                data-bs-toggle="modal" data-bs-target="#exampleModalToggle3">
                                <ion-icon name="person-outline" class="me-2"></ion-icon> ลงทะเบียน
                            </button>
                        </div>
                    @endif
                    @if (session('user_id'))
                        <div class="mx-3 d-flex fs-6"
                            style="align-items: center; justify-content: center; color: white;"><ion-icon
                                name="person-circle-outline" class="fs-4"></ion-icon>&nbsp;{{ session('user_name') }}
                        </div>
                        <button type="button" class="btn btn-danger text-white mx-2"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ออกจากระบบ</button>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                    @endif
                </div>
            </div>
        </nav>
    </header>
    <div class="container-fluid p-0">
        <div class="container contenthome-wrapper">
            <div>
                @yield('content')
            </div>
        </div>
    </div>

    <footer class="footer text-light">
        <section class="dorm-hero position-relative overflow-hidden">
            <!-- พื้นหลังภาพ -->
            <div class="dorm-hero__bg"></div>

            <div class="container position-relative">
                <div class="row align-items-center min-vh-50 py-4">
                    <!-- LEFT: phone/illustration -->
                    <div class="col-lg-5 mb-4 mb-lg-0 text-center text-lg-start me-3">
                        <img src="{{ asset('images/notebook-mockup.png') }}" alt="Dorm Booking App"
                            class="img-fluid dorm-hero__phone">
                    </div>

                    <!-- RIGHT: headline + form + badges -->
                    <div class="col-lg-6 text-center text-lg-start text-white">
                        <h1 class="display-8 fw-bolder mb-2">
                            อัปเดตเคล็ดลับเลือกหอพัก โปรฯ ล่าสุด และรีวิวจริงอยู่เสมอ
                        </h1>
                        <p class="lead fw-semibold opacity-90 mb-4">
                            รับข่าวสาร โปรโมชั่น ได้ทันทวงที
                        </p>

                        <!-- Email subscribe -->
                        <form class="dorm-hero__form d-flex gap-2 flex-column flex-sm-row mb-4" action="#"
                            method="post">
                            @csrf
                            <div class="flex-grow-1 position-relative">
                                <input type="email" class="form-control dorm-hero__input"
                                    placeholder="กรอกอีเมลของคุณ" required>
                                <span class="dorm-hero__inputIcon">
                                    <i class="fa-regular fa-envelope"></i>
                                </span>
                            </div>
                            <button type="submit" class="btn dorm-hero__btn">สมัครรับจดหมายข่าว</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <div class="container py-5">
            <div class="row">
                <!-- Logo + Description -->
                <div class="col-md-4 mb-4">
                    <img src="{{ asset('images/app_logo.png') }}" alt="">
                    <p class="small">
                        ห้องพักสะดวกสบาย ราคาย่อมเยา สิ่งอำนวยความสะดวกครบครัน
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="col-md-4 mb-4">
                    <h6 class="fw-bold">เกี่ยวกับ Dorm Booking</h6>
                    <ul class="list-unstyled small">
                        <li><a href="#" class="footer-link">หน้าหลัก</a></li>
                        <li><a href="#" class="footer-link">ห้องพัก</a></li>
                        <li><a href="#" class="footer-link">โปรโมชั่น</a></li>
                        <li><a href="#" class="footer-link">วิธีการจอง</a></li>
                        <li><a href="#" class="footer-link">ติดต่อเรา</a></li>
                    </ul>
                    <h6 class="fw-bold mt-5">ติดต่อเรา</h6>
                    <p class="small mb-1">📍 กรุงเทพฯ, ประเทศไทย</p>
                    <p class="small mb-1">📞 081-234-5678</p>
                    <p class="small mb-3">✉️ info@dormapartment.com</p>

                    <!-- Social icons -->
                    <div class="d-flex gap-3">
                        <a href="#" class="footer-social"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="footer-social"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="footer-social"><i class="bi bi-twitter"></i></a>
                    </div>
                </div>

                <!-- Contact -->
                <div class="col-md-4 mb-4">
                    <h6>รองรับการชำระเงินหลากหลาย</h6>
                    <ul class="list-unstyled small">
                        <li class="payment-card">
                            <img src="{{ asset('images/credit_card.png') }}" class="image-payment">
                            <p class="text-center ms-3">บัตรเครดิต/เดบิต</p>
                        </li>
                        <li class="payment-card"><img src="{{ asset('images/promptpay.png') }}"
                                class="image-payment">
                            <p class="text-center ms-3">QR พร้อมเพย์</p>
                        </li>
                        <li class="payment-card"><img src="{{ asset('images/mobilebanking.png') }}"
                                class="image-payment">
                            <p class="text-center ms-3">Mobile Banking</p>
                        </li>
                        <li class="payment-card"><img src="{{ asset('images/truemoney.png') }}"
                                class="image-payment">
                            <p class="text-center ms-3">Truemoney</p>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="text-center mt-4 small border-top pt-3">
                © 2025 Dorm Apartment. All rights reserved.
            </div>
        </div>
    </footer>


    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- ใช้ modal-lg ให้กว้างขึ้น -->
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="d-flex" id="display-res"> <!-- Flex container -->

                        <!-- รูปด้านซ้าย -->
                        <div class="login-img flex-shrink-0 rounded"></div>

                        <!-- ฟอร์มด้านขวา -->
                        <div class="p-4 flex-grow-1 bg-white rounded">
                            <div class="modal-header p-0 mb-3">
                                <h5 class="modal-title" id="exampleModalToggleLabel">กรุณาเข้าสู่ระบบ</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form action="/login" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required
                                        placeholder="id@email.com" minlength="3" value="{{ old('email') }}">
                                    @if (isset($errors) && $errors->has('email'))
                                        <div class="text-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>

                                <div class="position-relative">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        required placeholder="enter password" value="{{ old('password') }}">

                                    <!-- ปุ่ม show/hide -->
                                    <button type="button" class="btn btn-sm position-absolute show-pass"
                                        onclick="togglePassword()">
                                        <ion-icon name="eye-off-outline" id="passwordIcon" size="10"></ion-icon>
                                    </button>

                                    @if (isset($errors) && $errors->has('password'))
                                        <div class="text-danger">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>

                                <div class="text-end">
                                    <button type="button" class="btn text-danger p-0" style="font-size: 14px"
                                        data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">forgot
                                        password?</button>
                                </div>

                                <div class="text-end mt-5">
                                    <button type="button" class="btn btn-warning"
                                        data-bs-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalToggle3" aria-hidden="true" aria-labelledby="exampleModalToggleLabel3"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="d-flex" id="display-res">
                        <div class="register-img flex-shrink-0 rounded mb-1 mb-lg-0"></div>

                        <div class="p-4 flex-grow-1 bg-white rounded">
                            <div class="modal-header p-0 mb-3">
                                <h5 class="modal-title" id="exampleModalToggleLabel">สมัครสมาชิก</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form id="registerForm" action="/register" method="post" enctype="multipart/form-data"
                                novalidate>
                                @csrf

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label style="display: flex" class="form-label justify-content-between">
                                        <span>Email</span>
                                        <small class="text-danger ms-2" id="err_email">
                                            @error('email')
                                                {{ $message }}
                                            @enderror
                                        </small>
                                    </label>
                                    <input type="email" id="reg_email" name="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="id@email.com" required>
                                </div>

                                {{-- Fullname --}}
                                <div class="mb-3">
                                    <label style="display: flex" class="form-label justify-content-between">
                                        <span>Fullname</span>
                                        <small class="text-danger ms-2" id="err_full_name">
                                            @error('full_name')
                                                {{ $message }}
                                            @enderror
                                        </small>
                                    </label>
                                    <input type="text" id="reg_full_name" name="full_name"
                                        value="{{ old('full_name') }}"
                                        class="form-control @error('full_name') is-invalid @enderror"
                                        placeholder="ชิตวร โชติช่วง" required>
                                </div>

                                {{-- phone --}}
                                <div class="mb-3">
                                    <label style="display: flex" class="form-label justify-content-between">
                                        <span>Phone</span>
                                        <small class="text-danger ms-2" id="err_phone">
                                            @error('phone')
                                                {{ $message }}
                                            @enderror
                                        </small>
                                    </label>
                                    <input type="text" id="reg_phone" name="phone" value="{{ old('phone') }}"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="0981302525" required>
                                </div>

                                {{-- Password --}}
                                <div class="mb-3">
                                    <label style="display: flex" class="form-label justify-content-between">
                                        <span>Password</span>
                                        <small class="text-danger ms-2" id="err_password">
                                            @error('password')
                                                {{ $message }}
                                            @enderror
                                        </small>
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" id="register_password" name="password"
                                            class="form-control pe-5 @error('password') is-invalid @enderror"
                                            placeholder="อย่างน้อย 8 ตัวอักษร" required minlength="8">
                                        <button type="button"
                                            class="btn btn-sm position-absolute end-0 top-50 translate-middle-y"
                                            onclick="toggleRegisterPassword()" aria-label="Toggle password">
                                            <ion-icon name="eye-off-outline" id="registerPasswordIcon"
                                                size="10"></ion-icon>
                                        </button>
                                    </div>
                                </div>

                                {{-- Confirm Password --}}
                                <div class="mb-1">
                                    <label style="display: flex" class="form-label justify-content-between">
                                        <span>Confirm Password</span>
                                        <small class="text-danger ms-2" id="err_password_confirmation">
                                            @error('password_confirmation')
                                                {{ $message }}
                                            @enderror
                                        </small>
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" id="register_confirm_password"
                                            name="password_confirmation"
                                            class="form-control pe-5 @error('password_confirmation') is-invalid @enderror"
                                            placeholder="พิมพ์ซ้ำให้ตรงกัน" required minlength="8">
                                        <button type="button"
                                            class="btn btn-sm position-absolute end-0 top-50 translate-middle-y"
                                            onclick="toggleRegisterConfirm()" aria-label="Toggle confirm password">
                                            <ion-icon name="eye-off-outline" id="registerConfirmIcon"
                                                size="10"></ion-icon>
                                        </button>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="button" class="btn btn-warning"
                                        data-bs-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-primary">สมัครสมาชิก</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">คุณลืมรหัสผ่านใช่ไหม</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="my-1">กรุณากรอกอีเมลของท่าน เพื่อให้เราสามารถยืนยันตัวตน
                        และจัดส่งลิงก์สำหรับกรอกแบบฟอร์มเพื่อรีเซ็ตรหัสผ่านใหม่ให้ท่าน</p>
                    <br>
                    <form action="{{ route('users.checkmail') }}" method="GET">
                        @csrf <!-- CSRF สำหรับ GET ไม่จำเป็น แต่ไม่เป็นไร -->
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required
                                placeholder="id@email.com" minlength="3" value="{{ old('email') }}">
                            @if (isset($errors) && $errors->has('email'))
                                <div class="text-danger">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-target="#exampleModalToggle"
                                data-bs-toggle="modal">กลับไป</button>
                            <button type="submit" class="btn btn-primary">ยืนยัน</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>

        <script>
            // toggle eyes
            function toggleRegisterPassword() {
                const input = document.getElementById('register_password');
                const icon = document.getElementById('registerPasswordIcon');
                if (!input) return;
                input.type = input.type === 'password' ? 'text' : 'password';
                if (icon) icon.name = input.type === 'password' ? 'eye-off-outline' : 'eye-outline';
            }

            function toggleRegisterConfirm() {
                const input = document.getElementById('register_confirm_password');
                const icon = document.getElementById('registerConfirmIcon');
                if (!input) return;
                input.type = input.type === 'password' ? 'text' : 'password';
                if (icon) icon.name = input.type === 'password' ? 'eye-off-outline' : 'eye-outline';
            }

            (function() {
                const form = document.getElementById('registerForm');
                if (!form) return;

                // inputs
                const email = document.getElementById('reg_email');
                const fullname = document.getElementById('reg_full_name');
                const phone = document.getElementById('reg_phone');
                const pwd = document.getElementById('register_password');
                const cfm = document.getElementById('register_confirm_password');

                // error holders (ข้าง label)
                const E = {
                    email: document.getElementById('err_email'),
                    full_name: document.getElementById('err_full_name'),
                    phone: document.getElementById('err_phone'),
                    password: document.getElementById('err_password'),
                    password_confirmation: document.getElementById('err_password_confirmation'),
                };

                const isEmail = v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test((v || '').trim());
                const notBlank = v => (v || '').trim().length > 0;

                function setErr(input, holder, msg) {
                    if (input) input.classList.toggle('is-invalid', !!msg);
                    if (holder) holder.textContent = msg || '';
                }

                function validate() {
                    let ok = true;

                    // email
                    if (!notBlank(email.value)) {
                        setErr(email, E.email, 'กรุณากรอกอีเมล');
                        ok = false;
                    } else if (!isEmail(email.value)) {
                        setErr(email, E.email, 'รูปแบบอีเมลไม่ถูกต้อง');
                        ok = false;
                    } else {
                        setErr(email, E.email, '');
                    }

                    // fullname
                    if (!notBlank(fullname.value)) {
                        setErr(fullname, E.full_name, 'กรุณากรอกชื่อ–นามสกุล');
                        ok = false;
                    } else {
                        setErr(fullname, E.full_name, '');
                    }

                    if (!notBlank(phone.value)) {
                        setErr(phone, E.phone, 'กรุณากรอกเบอร์โทร');
                        ok = false;
                    } else {
                        setErr(phone, E.phone, '');
                    }

                    // password
                    if (!notBlank(pwd.value)) {
                        setErr(pwd, E.password, 'กรุณากรอกรหัสผ่าน');
                        ok = false;
                    } else if (pwd.value.length < 8) {
                        setErr(pwd, E.password, 'อย่างน้อย 8 ตัวอักษร');
                        ok = false;
                    } else {
                        setErr(pwd, E.password, '');
                    }

                    // confirm
                    if (!notBlank(cfm.value)) {
                        setErr(cfm, E.password_confirmation, 'กรุณายืนยันรหัสผ่าน');
                        ok = false;
                    } else if (cfm.value !== pwd.value) {
                        setErr(cfm, E.password_confirmation, 'รหัสผ่านไม่ตรงกัน');
                        ok = false;
                    } else {
                        setErr(cfm, E.password_confirmation, '');
                    }

                    return ok;
                }

                [email, fullname, phone, pwd, cfm].forEach(i => {
                    i.addEventListener('input', validate);
                    i.addEventListener('blur', validate);
                });

                form.addEventListener('submit', function(e) {
                    if (!validate()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                });
            })();
        </script>


        @yield('footer')

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
        </script>

        <!-- โหลด flatpickr ให้พร้อมก่อน -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <!-- (ถ้าอยากได้ภาษาไทย) -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>

        <!-- ตอนนี้ค่อยให้เพจย่อยใส่ JS -->
        @yield('js_before')
        <!-- สคริปต์รวมของโปรเจกต์ (ถ้ามี) -->
        <script src="{{ asset('js/script.js') }}"></script>

        <!-- icons etc. -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

        {{-- >>>>>>> ตรงนี้สำคัญ <<<<<<< --}}
        @include('sweetalert::alert')

</body>

</html>
