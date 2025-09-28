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
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/contentBody.css') }}" rel="stylesheet">

    @yield('css_before')
</head>

<body>
    <div class="bg-img">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12">
                    <nav class="navbar navbar-expand-lg navbar-style">
                        <div class="container-fluid ">
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
                                            href="/">หอพัก</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active text-white animate-text" aria-current="page"
                                            href="/">ข่าวสาร/ประกาศ</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white animate-text"
                                            href="https://devbanban.com/?p=4425">ช่วยเหลือ</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white animate-text"
                                            href="https://devbanban.com/?p=4425">การจองของฉัน</a>
                                    </li>


                                    @if (session('user_role') === 'ADMIN')
                                        <li class="nav-item">
                                            <a class="nav-link text-danger animate-text" href="/dashboard"
                                                target="_blank">จัดการหลังบ้าน</a>
                                        </li>
                                    @endif


                                </ul>
                                @if (!session('user_id'))
                                    <div class="d-flex">
                                        <button type="button"
                                            class="btn btn-outline-light text-white d-flex align-items-center"
                                            data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                                            <ion-icon name="person-outline" class="me-2"></ion-icon> เข้าสู่ระบบ
                                        </button>
                                        <a href="/register" style="text-decoration: none">
                                            <button type="button"
                                                class="btn btn-primary text-white mx-2">ลงทะเบียน</button>
                                        </a>
                                    </div>
                                @endif
                                @if (session('user_id'))
                                    <div><b style="font-size:medium">{{ session('user_name') }}</b></div>
                                    <button type="button" class="btn btn-danger text-white mx-2"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ออกจากระบบ</button>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display:none;">
                                        @csrf
                                    </form>
                                @endif

                                {{-- <form action="/search" method="get" class="d-flex" role="search">
                  <input class="form-control me-2" type="text" name="keyword" placeholder="Search Product Name"
                    aria-label="Search" value="{{ $keyword ?? ''}}">
                  <button class="btn btn-success" type="submit">Search </button>
                </form> --}}
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="container contenthome-wrapper">
                <div>
                    @yield('contenthome')
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div>
            @yield('contentBody')
        </div>
    </div>

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
            function togglePassword() {
                const password = document.getElementById('password');
                const icon = document.getElementById('passwordIcon');
                if (password.type === 'password') {
                    password.type = 'text';
                    icon.name = 'eye-outline'; // เปลี่ยน icon
                } else {
                    password.type = 'password';
                    icon.name = 'eye-off-outline';
                }
            }
        </script>


        <footer class="mt-5 mb-2">
            <p class="text-center">by devbanban.com @2025</p>
        </footer>

        @yield('footer')

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
        </script>

        @yield('js_before')

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
