<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- ใช้ modal-lg ให้กว้างขึ้น -->
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="d-flex" id="display-res"> <!-- Flex container -->

                    <!-- รูปด้านซ้าย -->
                    <div class="login-img flex-shrink-0"></div>

                    <!-- ฟอร์มด้านขวา -->
                    <div class="p-4 flex-grow-1 bg-white">
                        <div class="modal-header p-0 mb-3">
                            <h5 class="modal-title" id="exampleModalToggleLabel">กรุณาเข้าสู่ระบบ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="/login" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" required
                                    placeholder="id@email.com" minlength="3" value="{{ old('email') }}">
                                @if(isset($errors) && $errors->has('email'))
                                    <div class="text-danger">{{ $errors->first('email') }}</div>
                                @endif
                            </div>

                            <div class="position-relative">
                                <label>Password</label>
                                <input type="password" class="form-control" id="password" name="password" required
                                    placeholder="enter password" value="{{ old('password') }}">

                                <!-- ปุ่ม show/hide -->
                                <button type="button" class="btn btn-sm position-absolute show-pass"
                                    onclick="togglePassword()">
                                    <ion-icon name="eye-off-outline" id="passwordIcon" size="10"></ion-icon>
                                </button>

                                @if(isset($errors) && $errors->has('password'))
                                    <div class="text-danger">{{ $errors->first('password') }}</div>
                                @endif
                            </div>

                            <div class="text-end">
                                <button type="button" class="btn text-danger p-0" style="font-size: 14px"
                                    data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">forgot
                                    password?</button>
                            </div>

                            <div class="text-end mt-5">
                                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">ยกเลิก</button>
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
                        <input type="email" class="form-control" name="email" required placeholder="id@email.com"
                            minlength="3" value="{{ old('email') }}">
                        @if(isset($errors) && $errors->has('email'))
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