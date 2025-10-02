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

        {{-- ฟอร์มหลัก --}}
        <form id="searchForm" method="GET" action="{{ route('searchRoom') }}" class="mt-5">
            {{-- ================== แถบเลือก “สาขา” (ทำเป็น radio) ================== --}}
            @php $branchVal = strtoupper(request('branch','')); @endphp
            <div class="d-flex">
                <div class="tab-menu active"><i class="fas fa-hotel"></i>&nbsp;จองหอพัก</div>
                <div class="tab-menu"><i class="fa-solid fa-compass"></i>&nbsp;สถานที่ท่องเที่ยว</div>
            </div>
            <hr>
            <div class="d-flex gap-2 flex-wrap">
                <input type="radio" name="branch" id="branch_all" value="" class="branch-radio d-none"
                    {{ $branchVal === '' ? 'checked' : '' }}>
                <label for="branch_all" class="type-hotel">
                    <i class="fas fa-hotel"></i>&nbsp;ทุกสาขา
                </label>

                <input type="radio" name="branch" id="branch_srinakarin" value="SRINAKARIN" class="branch-radio d-none"
                    {{ $branchVal === 'SRINAKARIN' ? 'checked' : '' }}>
                <label for="branch_srinakarin" class="type-hotel">
                    <i class="fas fa-hotel"></i>&nbsp;หอพักดอร์มศรีนครินทร์
                </label>

                <input type="radio" name="branch" id="branch_rama9" value="RAMA9" class="branch-radio d-none"
                    {{ $branchVal === 'RAMA9' ? 'checked' : '' }}>
                <label for="branch_rama9" class="type-hotel">
                    <i class="fas fa-hotel"></i>&nbsp;หอพักดอร์มพระราม 9
                </label>

                <input type="radio" name="branch" id="branch_asoke" value="ASOKE" class="branch-radio d-none"
                    {{ $branchVal === 'ASOKE' ? 'checked' : '' }}>
                <label for="branch_asoke" class="type-hotel">
                    <i class="fas fa-hotel"></i>&nbsp;หอพักดอร์มอโศก
                </label>
            </div>

            {{-- หัวข้อ 3 ช่องหลัก --}}
            <div class="row d-flex flex-row mt-4 text-white" style="font-weight:400;">
                <div class="col-4">รูปแบบห้อง</div>
                <div class="col-4">ระยะเวลาเช่า</div>
                <div class="col-4">ชื่อ/เลขห้อง (roomNo)</div>
            </div>

            {{-- ================== แถว input ค้นหา ================== --}}
            <div class="row d-flex flex-row mt-2 text-white"
                style="font-weight:400; justify-content:center; align-items:center;">

                {{-- รูปแบบห้อง (select) --}}
                @php
                    $roomTypes = $types ?? ['STANDARD', 'DELUXE', 'LUXURY'];
                    $typeReq = strtoupper(request('type', ''));
                @endphp
                <div class="col-12 col-md-4 input-data corner-radius1">
                    <ion-icon name="business-outline"></ion-icon>
                    <select name="type" class="form-select p-2" style="border-radius:0;">
                        <option value="" {{ $typeReq === '' ? 'selected' : '' }}>ทั้งหมด</option>
                        @foreach ($roomTypes as $t)
                            @php $val = strtoupper($t); @endphp
                            <option value="{{ $val }}" {{ $typeReq === $val ? 'selected' : '' }}>
                                {{ ucwords(strtolower($val)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ระยะเวลาเช่า (flatpickr range) + hidden start/end --}}
                <input type="hidden" name="start_date" id="start_date" value="{{ request('start_date') }}">
                <input type="hidden" name="end_date" id="end_date" value="{{ request('end_date') }}">
                <div class="col-12 col-md-4 input-data">
                    <ion-icon name="calendar-outline"></ion-icon>
                    <input type="text" class="form-control m-0 p-2" id="dateRangePicker" style="border-radius:0"
                        placeholder="เลือกช่วงวันที่ต้องการเข้าพัก"
                        value="{{ request('start_date') && request('end_date') ? request('start_date') . ' ถึง ' . request('end_date') : '' }}">
                </div>

                {{-- ชื่อ/เลขห้อง (roomNo) --}}
                <div class="col-12 col-md-3 input-data corner-radius2">
                    <ion-icon name="home-outline"></ion-icon>
                    <input type="text" name="roomNo" class="form-control m-0 p-2" placeholder="เช่น SK101 หรือ 301"
                        value="{{ request('roomNo') }}">
                </div>

                <div class="col-12 col-md-1 d-grid">
                    <button type="submit" class="search-data p-2 btn btn-primary">
                        <ion-icon name="search-outline" style="font-size:24px;vertical-align:middle"></ion-icon>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('contentBody')
    @include('home.mainpage') <!-- เรียกใช้ไฟล์แยก -->
@endsection

@section('js_before')
    <!-- JS เพิ่มเติม -->
    <script>
        (function() {
            const form = document.getElementById('searchForm');
            if (!form) return;

            // เมื่อเลือกสาขาใหม่ -> สีขึ้นทันทีด้วย CSS (:checked + label) แล้วค่อย submit เบา ๆ
            document.querySelectorAll('input.branch-radio').forEach(r => {
                r.addEventListener('change', () => {
                    requestAnimationFrame(() => setTimeout(() => form.submit(), 80));
                });
            });

            // เมื่อเปลี่ยนชนิดห้อง -> submit อัตโนมัติ
            const typeSelect = document.querySelector('select[name="type"]');
            if (typeSelect) {
                typeSelect.addEventListener('change', () => {
                    requestAnimationFrame(() => setTimeout(() => form.submit(), 50));
                });
            }

            // flatpickr range -> เติม hidden start/end และ auto-submit เมื่อได้ 2 วัน
            const startHidden = document.getElementById('start_date');
            const endHidden = document.getElementById('end_date');
            const dateInput = document.getElementById('dateRangePicker');

            if (window.flatpickr && dateInput && startHidden && endHidden) {
                const defStart = "{{ request('start_date') }}";
                const defEnd = "{{ request('end_date') }}";
                const defaults = (defStart && defEnd) ? [defStart, defEnd] : [];

                flatpickr('#dateRangePicker', {
                    mode: 'range',
                    dateFormat: 'Y-m-d',
                    defaultDate: defaults,
                    onChange: function(selectedDates) {
                        const toYMD = d => d.toISOString().slice(0, 10);

                        if (selectedDates.length === 2) {
                            startHidden.value = toYMD(selectedDates[0]);
                            endHidden.value = toYMD(selectedDates[1]);
                            requestAnimationFrame(() => setTimeout(() => form.submit(), 80));
                        } else if (selectedDates.length === 1) {
                            startHidden.value = toYMD(selectedDates[0]);
                            endHidden.value = toYMD(selectedDates[0]);
                        } else {
                            startHidden.value = '';
                            endHidden.value = '';
                        }
                    }
                });
            }

            // roomNo: กด Enter เพื่อค้นหา
            const roomNoInput = document.querySelector('input[name="roomNo"]');
            if (roomNoInput) {
                roomNoInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        form.submit();
                    }
                });
            }
        })();
    </script>
@endsection
