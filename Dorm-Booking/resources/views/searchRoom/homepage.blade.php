@extends('layouts.frontend')

@section('css_before')
    <link href="{{ asset('css/contentBody.css') }}" rel="stylesheet">
@endsection

@section('navbar')
    <!-- Navbar ของหน้า -->
@endsection

@section('contenthome')
    <div class="row">
        <div class="col-12 text-white fs-2 text-center mt-md-5 mt-4 font-header">
            ราคาถูก วางใจทุกการจองหอพัก ไปกับ DORM Booking
        </div>

        {{-- ฟอร์มหลัก --}}
        <form id="searchForm" method="GET" action="{{ route('searchRoom') }}" class="mt-4 mt-md-5">
            {{-- ================== แถบเลือก “สาขา” (ทำเป็น radio) ================== --}}
            @php $branchVal = strtoupper(request('branch','')); @endphp
            <div class="d-flex">
                <div class="tab-menu active"><i class="fas fa-hotel"></i>&nbsp;จองหอพัก</div>
                <div class="tab-menu"><i class="fa-solid fa-compass"></i>&nbsp;สถานที่ท่องเที่ยว</div>
            </div>
            <hr class="m-1 m-md-3">
            <div class="d-flex gap-2 flex-wrap">
                <input type="radio" name="branch" id="branch_all" value="" class="branch-radio d-none"
                    {{ $branchVal === '' ? 'checked' : '' }}>
                <label for="branch_all" class="type-hotel font-body">
                    <i class="fas fa-hotel"></i>&nbsp;ทุกสาขา
                </label>

                @foreach ($branches as $b)
                    <input type="radio" name="branch" id="branch_{{ strtolower($b) }}" value="{{ $b }}"
                        class="branch-radio d-none" {{ $branchVal === $b ? 'checked' : '' }}>
                    <label for="branch_{{ strtolower($b) }}" class="type-hotel font-body">
                        <i class="fas fa-hotel"></i>&nbsp;หอพักดอร์ม {{ ucwords(strtolower($b)) }}
                    </label>
                @endforeach
            </div>

            {{-- หัวข้อ 3 ช่องหลัก --}}
            <div class="row d-flex flex-row mt-3 mt-md-4 text-white font-body" style="font-weight:400;">
                <div class="col-4">รูปแบบห้อง</div>
                <div class="col-4">ระยะเวลาเช่า</div>
                <div class="col-4">ชื่อ/เลขห้อง</div>
            </div>

            {{-- ================== แถว input ค้นหา ================== --}}
            <div class="row search-row d-flex flex-row mt-2 text-white align-items-stretch"
                style="font-weight:400; justify-content:center; align-items:center;">

                {{-- รูปแบบห้อง (select) --}}
                @php
                    $roomTypes = $types ?? ['STANDARD', 'DELUXE', 'LUXURY'];
                    $typeReq = strtoupper(request('type', ''));
                @endphp
                <div class="col-4 input-data corner-radius1">
                    <ion-icon name="business-outline"></ion-icon>
                    <select name="type" class="form-select p-2 font-body" style="border-radius:0;">
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
                <div class="col-4 input-data">
                    <ion-icon name="calendar-outline"></ion-icon>
                    <input type="text" class="form-control m-0 p-2 font-body" id="dateRangePicker"
                        style="border-radius:0" placeholder="เลือกช่วงวันที่ต้องการเข้าพัก"
                        value="{{ request('start_date') && request('end_date') ? request('start_date') . ' ถึง ' . request('end_date') : '' }}">
                </div>

                {{-- ชื่อ/เลขห้อง (roomNo) --}}
                <div class="col-3 input-data corner-radius2">
                    <ion-icon name="home-outline"></ion-icon>
                    <input type="text" name="roomNo" class="form-control m-0 p-2 font-body"
                        placeholder="เช่น SK101 หรือ 301" value="{{ request('roomNo') }}">
                </div>

                <div class="col-1 p-0 col-btn">
                    <button type="submit"
                        class="search-data btn btn-primary w-100 d-flex justify-content-center align-items-center m-0">
                        <ion-icon name="search-outline" style="font-size:24px;vertical-align:middle"></ion-icon>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('contentBody')
    @include('searchRoom.mainpage')
@endsection

@section('js_before')
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
