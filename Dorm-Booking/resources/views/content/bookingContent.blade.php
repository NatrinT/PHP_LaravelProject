@extends('content.layoutContent')

@section('css_before')
    <style>
        /* Layout */
        .checkout-wrap {
            max-width: 1200px;
            margin-inline: auto;
        }

        .card-clean {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 10px 28px rgba(3, 18, 43, .06);
        }

        .sticky-lg {
            position: sticky;
            top: 88px;
        }

        /* Room image */
        .roomimg {
            width: 100%;
            height: 180px;
            object-fit: cover;
            object-position: center;
            border-radius: 12px;
        }

        /* Price */
        .price-old {
            color: #9aa0a6;
            text-decoration: line-through;
            font-size: .9rem;
        }

        .price-now {
            color: #F96D01;
            font-weight: 800;
            font-size: 1.15rem;
        }

        .hr-line {
            margin: .25rem 0 1rem;
        }

        /* Payment chips */
        .pay-chip {
            display: flex;
            align-items: center;
            gap: .5rem;
            border: 1px solid #e5eaf2;
            background: #f7f9fd;
            border-radius: 12px;
            padding: .6rem .75rem;
            cursor: pointer;
            font-weight: 700;
        }

        .pay-chip input {
            display: none;
        }

        .pay-chip.active {
            border-color: #0b5ed7;
            background: #eef4ff;
        }

        .pay-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            color: #0b5ed7;
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .06);
        }

        /* Inputs */
        .form-control,
        .form-select {
            border-radius: 12px;
            border: 1px solid #e6e9f0;
        }

        /* Mobile polish */
        @media (max-width: 991.98px) {
            .sticky-lg {
                position: static;
                top: auto;
            }
        }
    </style>
@endsection


@section('navbar')
    <!-- Navbar ของหน้า -->
@endsection

@section('content')
    @php
        // ----- Expect: $room (App\Models\RoomModel) -----
        // fallback รูปห้อง/สาขา
        $img = $room->image ? asset('storage/' . $room->image) : null;
        if (!$img) {
            $slug = \Illuminate\Support\Str::slug($room->branch, '-');
            $cand = 'uploads/branch/' . $slug . '.jpg';
            $img = \Illuminate\Support\Facades\Storage::disk('public')->exists($cand)
                ? \Illuminate\Support\Facades\Storage::url($cand)
                : asset('images/apartment_image/rooms.jpg');
        }

        // mock ค่าธรรมเนียม/โปรโมชัน (ปรับได้หรือส่งจาก Controller)
        $monthsRent = 1; // จ่ายล่วงหน้า 1 เดือน (หรือ 1 รอบ)
        $rent = (float) $room->monthly_rent;
        $deposit = (float) round($rent * 1); // มัดจำ 1 เดือน
        $cleaning = 500.0; // ค่าทำความสะอาด
        $service = 99.0; // ค่าธรรมเนียมระบบ
        $discount = 0.0; // ส่วนลด (หากมี)
        $subtotal = $rent * $monthsRent;
        $total = max(0, $subtotal + $deposit + $cleaning + $service - $discount);
    @endphp

    <div class="checkout-wrap py-4">
        <div class="row g-4">
            {{-- LEFT: Booking & Payment form --}}
            <div class="col-lg-7">
                <div class="card card-clean">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="fw-bold mb-3">ยืนยันการจอง & ชำระเงิน</h4>
                        <p class="text-muted mb-4">กรอกข้อมูลผู้เข้าพักและเลือกวิธีชำระเงินเพื่อยืนยันการจองห้องของคุณ</p>

                        {{-- Booking info --}}
                        <h6 class="fw-bold">ข้อมูลผู้เข้าพัก</h6>
                        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- ====== ส่งข้อมูลห้องแบบ hidden ====== --}}
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            <input type="hidden" name="branch" value="{{ $room->branch }}">
                            <input type="hidden" name="type" value="{{ $room->type }}">
                            <input type="hidden" name="price"
                                value="{{ number_format((float) $room->monthly_rent, 2, '.', '') }}">

                            {{-- ====== Prefill ผู้ใช้ที่ล็อกอิน ====== --}}
                            @php
                                // รองรับทั้ง auth()->user() และ session('user_id')
                                $currentUser = auth()->user();
                                if (!$currentUser && session('user_id')) {
                                    $currentUser = \App\Models\UsersModel::find(session('user_id'));
                                }

                                // ดึงชื่อเต็มจาก model หรือ session แล้วแยกเป็น ชื่อ / นามสกุล
                                $fullName = $currentUser->name ?? (session('user_name') ?? '');
                                $fullName = trim((string) $fullName);

                                // ถ้ามี fields แยกอยู่แล้วก็ใช้เลย
                                $firstName = $currentUser->first_name ?? '';
                                $lastName = $currentUser->last_name ?? '';

                                if ($firstName === '' && $lastName === '') {
                                    // แตกชื่อเต็มด้วยช่องว่าง: ส่วนแรก = ชื่อ, ที่เหลือ = นามสกุล
                                    $parts = preg_split('/\s+/', $fullName, 2);
                                    $firstName = $parts[0] ?? '';
                                    $lastName = $parts[1] ?? '';
                                }

                                $email = $currentUser->email ?? (session('user_email') ?? '');
                                $phone = $currentUser->phone ?? (session('user_phone') ?? '');
                            @endphp

                            {{-- ====== ข้อมูลผู้เข้าพัก ====== --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">ชื่อ</label>
                                    <input type="text" name="first_name" class="form-control" placeholder="ชิตวร"
                                        value="{{ old('first_name', $firstName) }}" required readonly>
                                    @error('first_name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">นามสกุล</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="โชติช่วง"
                                        value="{{ old('last_name', $lastName) }}" required readonly>
                                    @error('last_name')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">อีเมล</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="example@gmail.com" value="{{ old('email', $email) }}" required
                                        readonly>
                                    @error('email')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">เบอร์โทร</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="093456455"
                                        value="{{ old('phone', $phone) }}" inputmode="tel" required readonly>
                                    @error('phone')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- ====== ระยะเวลาการเช่า ====== --}}
                            @php $monthsRent = $monthsRent ?? 1; @endphp
                            <h6 class="fw-bold mt-2">ระยะเวลาการเช่า</h6>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">วันที่เริ่มเช่า</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ $start_date ?? '' }}" min="{{ now()->toDateString() }}" required>
                                    @error('start_date')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">ระยะเวลาที่เช่า (เดือน)</label>
                                    <input type="number" name="months" id="months" min="1" step="1"
                                        value="{{ $monthsRent }}" class="form-control" required>
                                    @error('months')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">วันที่หมดสัญญาเช่า</label>
                                    {{-- ใช้ readonly (ไม่ใช้ disabled) เพื่อให้ส่งค่าไปกับฟอร์ม --}}
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ $end_date ?? '' }}" readonly required>
                                    @error('end_date')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- ====== วิธีชำระเงิน ====== --}}
                            <h6 class="fw-bold mt-3">เลือกวิธีชำระเงิน</h6>
                            <div class="d-flex flex-wrap gap-2 mb-3" id="payChoices">
                                <label class="pay-chip active">
                                    <input type="radio" name="payment_method" value="card" checked>
                                    <span class="pay-icon"><i class="fa-regular fa-credit-card"></i></span>
                                    บัตรเครดิต/เดบิต
                                </label>
                                <label class="pay-chip">
                                    <input type="radio" name="payment_method" value="qr">
                                    <span class="pay-icon"><i class="fa-solid fa-qrcode"></i></span>
                                    QR พร้อมเพย์
                                </label>
                                <label class="pay-chip">
                                    <input type="radio" name="payment_method" value="mobile">
                                    <span class="pay-icon"><i class="fa-solid fa-mobile-screen"></i></span>
                                    Mobile Banking
                                </label>
                                <label class="pay-chip">
                                    <input type="radio" name="payment_method" value="wallet">
                                    <span class="pay-icon"><i class="fa-solid fa-wallet"></i></span>
                                    e-Wallet
                                </label>
                                <label class="pay-chip">
                                    <input type="radio" name="payment_method" value="cash">
                                    <span class="pay-icon"><i class="fa-solid fa-money-bill"></i></span>
                                    เงินสด (ชำระที่เค้าเตอร์)
                                </label>
                            </div>

                            {{-- ====== ส่วนกรอกตามวิธีชำระเงิน ====== --}}
                            {{-- บัตร --}}
                            <div id="paySectionCard">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label">หมายเลขบัตร</label>
                                        <input type="text" class="form-control" name="card_number"
                                            placeholder="XXXX XXXX XXXX XXXX">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">หมดอายุ</label>
                                        <input type="text" class="form-control" name="card_exp" placeholder="MM/YY">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">CVV</label>
                                        <input type="text" class="form-control" name="card_cvv" placeholder="***"
                                            maxlength="4">
                                    </div>
                                </div>
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" value="1" id="saveCard">
                                    <label class="form-check-label"
                                        for="saveCard">บันทึกบัตรสำหรับการชำระครั้งถัดไป</label>
                                </div>
                            </div>

                            {{-- QR พร้อมเพย์ --}}
                            <div id="paySectionQR" class="d-none">
                                <div class="alert alert-secondary mb-2">
                                    สแกน QR พร้อมเพย์ ด้วยแอปธนาคารของคุณ ระบบจะยืนยันอัตโนมัติภายใน 1–3 นาที
                                </div>
                                <div class="p-3 border rounded-3 text-center mb-3">
                                    <div class="text-muted small mb-2">ตัวอย่าง QR (placeholder)</div>
                                    <img src="{{ asset('images/qrCode.jpg') }}" alt="QR PromptPay"
                                        style="max-width:220px;width:100%;border-radius: 10px">
                                </div>

                                {{-- ต้องแนบสลิปเมื่อเลือกวิธีนี้ --}}
                                <div class="col-12">
                                    <label class="form-label">แนบสลิป (จำเป็นเมื่อเลือก QR พร้อมเพย์)</label>
                                    <input type="file" class="form-control" name="payment_slip" id="payment_slip_qr"
                                        accept="image/*,application/pdf">
                                    @error('payment_slip')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Mobile Banking --}}
                            <div id="paySectionMobile" class="d-none">
                                <div class="alert alert-secondary mb-2">โอนผ่าน Mobile Banking และอัปโหลดสลิปยืนยัน</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">ธนาคารผู้รับ</label>
                                        <select class="form-select" name="mobile_bank">
                                            <option value="">เลือกธนาคาร</option>
                                            <option>SCB</option>
                                            <option>KBANK</option>
                                            <option>BAY</option>
                                            <option>KTB</option>
                                            <option>TMBThanachart</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">หมายเลขอ้างอิงการจอง</label>
                                        <input type="text" class="form-control"
                                            value="DB-{{ now()->format('ymd') }}-{{ $room->id }}" readonly>
                                    </div>

                                    {{-- ไม่บังคับอัปสลิป (แล้วแต่ธุรกิจ); ถ้าจะบังคับ ให้เพิ่ม required ผ่าน JS ได้เหมือน QR --}}
                                    <div class="col-12">
                                        <label class="form-label">แนบสลิป (ไม่บังคับ)</label>
                                        <input type="file" class="form-control" name="mobile_slip"
                                            accept="image/*,application/pdf">
                                        @error('mobile_slip')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- e-Wallet --}}
                            <div id="paySectionWallet" class="d-none">
                                <div class="alert alert-secondary mb-2">เลือก e-Wallet ที่รองรับ แล้วดำเนินการต่อ</div>
                                <div class="row g-2">
                                    <div class="col-6 col-md-4"><button type="button"
                                            class="btn w-100 btn-outline-primary">TrueMoney</button></div>
                                    <div class="col-6 col-md-4"><button type="button"
                                            class="btn w-100 btn-outline-primary">ShopeePay</button></div>
                                    <div class="col-6 col-md-4"><button type="button"
                                            class="btn w-100 btn-outline-primary">AirPay</button></div>
                                </div>
                            </div>

                            {{-- เงินสด --}}
                            <div id="paySectionCash" class="d-none">
                                <div class="alert alert-secondary">ชำระเงินสดที่เคาน์เตอร์ ณ สาขาที่เลือก</div>
                            </div>

                            {{-- ====== เงื่อนไข ====== --}}
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="accept" required>
                                <label class="form-check-label" for="accept">
                                    ยอมรับ <a href="#">เงื่อนไขการจองและนโยบายการยกเลิก</a>
                                </label>
                            </div>

                            {{-- ====== ปุ่มส่งฟอร์ม ====== --}}
                            <div class="d-grid d-md-flex gap-2 justify-content-md-end mt-4">
                                <a href="{{ url()->previous() }}" class="btn btn-light">ย้อนกลับ</a>
                                <button type="submit" class="btn btn-primary px-4 fw-bold">ชำระเงิน &
                                    ยืนยันการจอง</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            {{-- RIGHT: Summary --}}
            <div class="col-lg-5">
                <div class="card card-clean sticky-lg">
                    <div class="card-body p-4 p-md-4">
                        <h5 class="fw-bold mb-3">สรุปรายการ</h5>

                        <img src="{{ $img }}" alt="Room {{ $room->room_no }}" class="roomimg mb-3"
                            loading="lazy">

                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <div class="fw-bold">Room {{ $room->room_no }}</div>
                                <div class="text-muted small">
                                    สาขา {{ ucwords(strtolower($room->branch)) }} • ชั้น {{ $room->floor }}
                                </div>
                                <div class="text-muted small">ประเภทห้อง: {{ ucwords(strtolower($room->type)) }}</div>
                            </div>
                            <div class="text-end">
                                <div class="price-old">THB {{ number_format($rent * 1.2, 2) }}</div>
                                <div class="price-now">THB <span
                                        id="priceNow">{{ number_format($rent, 2) }}</span>/เดือน
                                </div>
                            </div>
                        </div>

                        @if (!empty($room->note))
                            <hr class="hr-line">
                            <div class="small text-muted">{{ \Illuminate\Support\Str::limit($room->note, 140) }}</div>
                        @endif

                        {{-- Dates (optional) --}}
                        @if (!empty($start_date) || !empty($end_date))
                            <div class="mt-3">
                                <div class="small">ช่วงวันที่</div>
                                <div class="fw-semibold">{{ $start_date ?? '-' }} → {{ $end_date ?? '-' }}</div>
                            </div>
                        @endif

                        <hr>

                        {{-- Price breakdown --}}
                        <div class="d-flex justify-content-between small mb-1">
                            <span>ค่าเช่า (ระยะเวลาเช่า) x <span id="monthsLabel">{{ $monthsRent }}</span> เดือน</span>
                            <span>THB <span id="rentSubtotal">{{ number_format($subtotal, 2) }}</span></span>
                        </div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span>ค่าเช่า (ล่วงหน้า) x 1 เดือน</span>
                            <span>THB <span id="rentSubtotal">{{ number_format($subtotal, 2) }}</span></span>
                        </div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span>มัดจำ (คืนเมื่อย้ายออก)</span>
                            <span>THB <span id="depositVal">{{ number_format($deposit, 2) }}</span></span>
                        </div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span>ค่าทำความสะอาด</span>
                            <span>THB <span id="cleaningVal">{{ number_format($cleaning, 2) }}</span></span>
                        </div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span>ค่าธรรมเนียมระบบ</span>
                            <span>THB <span id="serviceVal">{{ number_format($service, 2) }}</span></span>
                        </div>
                        @if ($discount > 0)
                            <div class="d-flex justify-content-between small mb-1 text-success">
                                <span>ส่วนลด</span>
                                <span>- THB <span id="discountVal">{{ number_format($discount, 2) }}</span></span>
                            </div>
                        @endif

                        <hr class="mt-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fw-bold">ยอดชำระทั้งหมด</div>
                            <div class="fs-5 fw-bold text-primary">THB <span
                                    id="grandTotal">{{ number_format($total, 2) }}</span></div>
                        </div>

                        <div class="text-muted small mt-2">
                            * ยอดชำระรวมภาษี/ค่าธรรมเนียมแล้ว (หากมีการเปลี่ยนแปลง จะมีการแจ้งเตือนก่อนชำระจริง)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js_before')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Toggle payment sections + chip active state
        (function() {
            const chips = document.querySelectorAll('#payChoices .pay-chip');
            const secCard = document.getElementById('paySectionCard');
            const secQR = document.getElementById('paySectionQR');
            const secMobile = document.getElementById('paySectionMobile');
            const secWallet = document.getElementById('paySectionWallet');

            function showSection(val) {
                [secCard, secQR, secMobile, secWallet].forEach(s => s.classList.add('d-none'));
                if (val === 'card') secCard.classList.remove('d-none');
                if (val === 'qr') secQR.classList.remove('d-none');
                if (val === 'mobile') secMobile.classList.remove('d-none');
                if (val === 'wallet') secWallet.classList.remove('d-none');
            }

            chips.forEach(c => {
                c.addEventListener('click', () => {
                    chips.forEach(x => x.classList.remove('active'));
                    c.classList.add('active');
                    const radio = c.querySelector('input[type=radio]');
                    if (radio) {
                        radio.checked = true;
                        showSection(radio.value);
                    }
                });
            });
            // init
            const checked = document.querySelector('#payChoices input[type=radio]:checked');
            if (checked) showSection(checked.value);
        })();

        // Recalculate totals when months change
        (function() {
            const monthsSel = document.getElementById('months');
            const monthsLabel = document.getElementById('monthsLabel');
            const rentSubtotal = document.getElementById('rentSubtotal');
            const grandTotal = document.getElementById('grandTotal');

            const priceNowEl = document.getElementById('priceNow');
            const depositEl = document.getElementById('depositVal');
            const cleaningEl = document.getElementById('cleaningVal');
            const serviceEl = document.getElementById('serviceVal');
            const discountEl = document.getElementById('discountVal');

            // ตัวเลขจาก server-side (ฝังแบบ data-attr เพื่อไม่พึ่ง parsing จาก text)
            const base = {
                rent: parseFloat({{ json_encode($rent) }}),
                deposit: parseFloat({{ json_encode($deposit) }}),
                cleaning: parseFloat({{ json_encode($cleaning) }}),
                service: parseFloat({{ json_encode($service) }}),
                discount: parseFloat({{ json_encode($discount) }})
            };

            function fmt(n) {
                return (n || 0).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function recalc() {
                const m = parseInt(monthsSel.value || '1');
                monthsLabel.textContent = m;
                const sub = base.rent * m;
                rentSubtotal.textContent = fmt(sub);
                const total = Math.max(0, sub + base.deposit + base.cleaning + base.service - base.discount);
                grandTotal.textContent = fmt(total);
            }

            monthsSel && monthsSel.addEventListener('change', recalc);
            recalc(); // init
        })();

        (function() {
            // ====== Toggle sections by payment method + required slip for QR ======
            const chips = document.querySelectorAll('#payChoices .pay-chip');
            const sections = {
                card: document.getElementById('paySectionCard'),
                qr: document.getElementById('paySectionQR'),
                mobile: document.getElementById('paySectionMobile'),
                wallet: document.getElementById('paySectionWallet'),
                cash: document.getElementById('paySectionCash'),
            };
            const paymentSlipQR = document.getElementById('payment_slip_qr');

            function showSection(val) {
                Object.values(sections).forEach(s => s && s.classList.add('d-none'));
                if (sections[val]) sections[val].classList.remove('d-none');

                // required เฉพาะ QR พร้อมเพย์
                if (paymentSlipQR) {
                    if (val === 'qr') {
                        paymentSlipQR.setAttribute('required', 'required');
                    } else {
                        paymentSlipQR.removeAttribute('required');
                        paymentSlipQR.value = ''; // เคลียร์ค่าเผื่อผู้ใช้เปลี่ยนใจ
                    }
                }
            }

            chips.forEach(c => {
                c.addEventListener('click', () => {
                    chips.forEach(x => x.classList.remove('active'));
                    c.classList.add('active');
                    const radio = c.querySelector('input[type=radio]');
                    if (radio) {
                        radio.checked = true;
                        showSection(radio.value);
                    }
                });
            });

            // init payment UI on load
            const checked = document.querySelector('#payChoices input[type=radio]:checked');
            if (checked) showSection(checked.value);

            // ====== Recalc end_date when start_date/months change ======
            const startEl = document.getElementById('start_date');
            const monthsEl = document.getElementById('months');
            const endEl = document.getElementById('end_date');

            function toYMD(d) {
                const y = d.getFullYear();
                const m = String(d.getMonth() + 1).padStart(2, '0');
                const day = String(d.getDate()).padStart(2, '0');
                return `${y}-${m}-${day}`;
            }

            function parseYMD(ymd) {
                if (!ymd) return null;
                const [y, m, d] = ymd.split('-').map(Number);
                return new Date(y, m - 1, d);
            }

            function recalcEnd() {
                const s = parseYMD(startEl.value);
                const months = parseInt(monthsEl.value || '1', 10);
                if (!s || isNaN(months) || months < 1) {
                    endEl.value = '';
                    return;
                }
                // end = (start + months months) - 1 day
                const tmp = new Date(s.getFullYear(), s.getMonth() + months, s.getDate());
                tmp.setDate(tmp.getDate() - 1);
                endEl.value = toYMD(tmp);
            }
            startEl && startEl.addEventListener('change', recalcEnd);
            monthsEl && monthsEl.addEventListener('input', recalcEnd);
            monthsEl && monthsEl.addEventListener('change', recalcEnd);
            recalcEnd();

            // ====== Confirm before submit ======
            const form = document.getElementById('checkoutForm');
            form && form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'ยืนยันการชำระเงิน?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'ใช่, ยืนยัน',
                    cancelButtonText: 'ยกเลิก',
                    reverseButtons: true,
                    confirmButtonColor: '#0d6efd'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        })();
    </script>


    (function() {
    const form = document.getElementById('checkoutForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
    e.preventDefault(); // ดักไว้ก่อน
    const totalText = document.getElementById('grandTotal')?.textContent?.trim() || '';
    const html = totalText ?
    `<div style="font-size:14px">ยอดชำระทั้งหมด <b>THB ${totalText}</b></div>` :
    '';

    Swal.fire({
    title: 'ยืนยันการชำระเงิน?',
    html,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'ใช่, ยืนยัน',
    cancelButtonText: 'ยกเลิก',
    reverseButtons: true,
    confirmButtonColor: '#0d6efd'
    }).then((result) => {
    if (result.isConfirmed) form.submit(); // ส่งฟอร์มจริง
    });
    });
    })();
    </script>
@endsection
