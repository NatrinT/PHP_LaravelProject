@extends('content.layoutContent')

@section('css_before')
    <style>
        /* -------- Base / Layout -------- */
        .room-section-title {
            font-weight: 800;
            letter-spacing: .2px;
        }

        .room-subhead {
            color: #6b778c;
        }

        .roomimg {
            width: 100%;
            height: 210px;
            object-fit: cover;
            object-position: center;
            display: block;
            border-top-left-radius: .75rem;
            border-top-right-radius: .75rem;
        }

        @media (max-width: 991.98px) {
            .roomimg {
                height: 185px;
            }
        }

        @media (max-width: 575.98px) {
            .roomimg {
                height: 160px;
            }
        }

        .room-card {
            border-radius: .75rem;
            background: #fff;
        }

        .hover-lift {
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(13, 110, 253, .12);
        }

        .room-title {
            font-weight: 700;
        }

        .room-meta {
            display: flex;
            gap: 1rem;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .room-meta li {
            display: flex;
            align-items: center;
        }

        .room-note {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: 2.6em;
            line-height: 1.35;
            font-weight: 400;
        }

        .old-price {
            color: #9aa0a6;
            text-decoration: line-through;
            font-size: .9rem;
        }

        .price {
            color: #F96D01;
            font-weight: 800;
            font-size: 1.05rem;
        }

        /* -------- Badges -------- */
        .badge-type,
        .badge-status {
            position: absolute;
            top: .6rem;
            padding: .4rem .65rem;
            font-weight: 800;
            font-size: .72rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .12);
        }

        .badge-type {
            left: .6rem;
        }

        .badge-status {
            right: .6rem;
        }

        /* -------- Branch filter chips -------- */
        .chip-branch {
            display: inline-block;
            padding: .45rem .9rem;
            border-radius: 999px;
            background: #f1f5ff;
            color: #0b3b66;
            font-weight: 700;
            cursor: pointer;
            user-select: none;
            border: 1px solid rgba(11, 94, 215, .12);
            transition: .15s ease;
        }

        .chip-branch:hover {
            filter: brightness(1.03);
        }

        .chip-branch.active {
            background: #0b5ed7;
            color: #fff;
            border-color: #0b5ed7;
        }

        /* -------- Swiper controls -------- */
        .room-swiper {
            --nav-size: 34px;
            --nav-bg: #fff;
            --nav-color: #0b5ed7;
        }

        .room-swiper .swiper-button-next,
        .room-swiper .swiper-button-prev {
            top: 40%;
            width: var(--nav-size);
            height: var(--nav-size);
            background: var(--nav-bg);
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .12);
        }

        .room-swiper .swiper-button-next::after,
        .room-swiper .swiper-button-prev::after {
            color: var(--nav-color);
            font-size: 18px;
        }
    </style>
@endsection

@section('navbar')
    <!-- Navbar ของหน้า -->
@endsection

@section('content')
    {{-- ========== ตัวกรองสาขา ========== --}}
    <form id="branchFilterForm" method="GET" class=" pt-5 pt-md-4">
        <div class="d-flex flex-wrap gap-2">
            @php $sel = strtoupper($selectedBranch ?? ''); @endphp

            {{-- ทั้งหมด --}}
            <input type="radio" class="d-none branch-radio" id="branch_all" name="branch" value=""
                {{ $sel === '' ? 'checked' : '' }}>
            <label for="branch_all" class="chip-branch {{ $sel === '' ? 'active' : '' }}">ทั้งหมด</label>

            {{-- สาขาที่มีในระบบ (มีห้องว่าง) --}}
            @foreach ($branches as $b)
                @php $checked = ($sel === strtoupper($b)); @endphp
                <input type="radio" class="d-none branch-radio" id="branch_{{ strtolower($b) }}" name="branch"
                    value="{{ $b }}" {{ $checked ? 'checked' : '' }}>
                <label for="branch_{{ strtolower($b) }}" class="chip-branch {{ $checked ? 'active' : '' }}">
                    {{ ucwords(strtolower($b)) }}
                </label>
            @endforeach
        </div>
    </form>

    @php
        /* ✅ นิยาม $branchLoop ให้เรียบร้อย */
        $branchLoop = $sel !== '' ? $branches->filter(fn($b) => strtoupper($b) === $sel)->values() : $branches;
    @endphp

    <div class="row">
        @foreach ($branchLoop as $br)
            <h3 class="mt-4 mb-2 room-section-title">สาขา {{ ucwords(strtolower($br)) }}</h3>
            <p class="room-subhead small mb-3">เลือกห้องที่ใช่สำหรับคุณ</p>

            @foreach ($types as $t)
                @php
                    $list = data_get($byBranchType, $br . '.' . $t, collect());
                    $typeClassOutside = match (strtoupper($t ?? '')) {
                        'STANDARD' => 'bg-success',
                        'DELUXE' => 'bg-primary',
                        'LUXURY' => 'bg-warning text-dark',
                        default => 'bg-secondary',
                    };
                @endphp

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0 {{ $typeClassOutside }} py-1 px-2"
                        style="font-weight: 400px;border-radius: 20px;color:white">
                        {{ ucwords(strtolower($t)) }} Room</h6>
                    <small class="text-muted">{{ $list->count() }} ห้อง</small>
                </div>

                @if ($list->isEmpty())
                    <div class="alert alert-light py-2">ยังไม่มีห้องประเภทนี้</div>
                @else
                    <div class="swiper room-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($list as $room)
                                @php
                                    $img = $room->image ? asset('storage/' . $room->image) : null;
                                    if (!$img) {
                                        $slug = \Illuminate\Support\Str::slug($room->branch, '-');
                                        $cand = 'uploads/branch/' . $slug . '.jpg';
                                        $img = \Illuminate\Support\Facades\Storage::disk('public')->exists($cand)
                                            ? \Illuminate\Support\Facades\Storage::url($cand)
                                            : asset('images/apartment_image/rooms.jpg');
                                    }
                                    $st = strtoupper($room->status ?? '');
                                    $statusClass =
                                        $st === 'AVAILABLE'
                                            ? 'bg-success'
                                            : ($st === 'OCCUPIED'
                                                ? 'bg-secondary'
                                                : 'bg-dark');
                                    $statusLabel =
                                        $st === 'AVAILABLE'
                                            ? 'ว่าง'
                                            : ($st === 'OCCUPIED'
                                                ? 'ไม่ว่าง'
                                                : ucfirst(strtolower($st)));
                                @endphp

                                <div class="swiper-slide">
                                    <div class="card room-card h-100 border-0 shadow-sm hover-lift">
                                        <div class="position-relative">
                                            <img src="{{ $img }}" class="roomimg" alt="Room {{ $room->room_no }}"
                                                loading="lazy">
                                            <span class="badge badge-status {{ $statusClass }} rounded-pill">
                                                {{ $statusLabel }}
                                            </span>
                                        </div>

                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="mb-0 room-title">Room {{ $room->room_no }}</h6>
                                                <small class="text-muted">{{ ucwords(strtolower($room->branch)) }}</small>
                                            </div>

                                            <ul class="room-meta small text-muted mb-2">
                                                <li><i class="fa-solid fa-stairs me-1"></i>ชั้น {{ $room->floor }}</li>
                                                <li><i
                                                        class="fa-regular fa-building me-1"></i>{{ strtoupper($room->type) }}
                                                </li>
                                            </ul>

                                            <p class="card-text room-note mb-3">
                                                {{ \Illuminate\Support\Str::limit($room->note, 90) }}</p>

                                            <div class="mt-auto d-flex align-items-end justify-content-between">
                                                <div>
                                                    <div class="old-price">THB
                                                        {{ number_format($room->monthly_rent * 1.2, 2) }}</div>
                                                    <div class="price">THB {{ number_format($room->monthly_rent, 2) }}
                                                    </div>
                                                </div>
                                                @if ($st === 'AVAILABLE')
                                                    <a href="{{ route('checkout.booking', ['room' => $room->id]) }}"
                                                        class="btn btn-sm btn-primary">
                                                        จอง
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-outline-secondary rounded-3 px-3"
                                                        disabled>ไม่ว่าง</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                @endif
                <hr style="height:2px;border-width:0;color:gray;background-color:gray" class="mt-4">
            @endforeach

            <hr class="my-4">
        @endforeach
    </div>
@endsection

@section('js_before')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Auto-submit เมื่อเลือกสาขา
        document.querySelectorAll('.branch-radio').forEach(function(r) {
            r.addEventListener('change', function() {
                document.getElementById('branchFilterForm').submit();
            });
        });

        // Init ทุก swiper
        document.querySelectorAll('.room-swiper').forEach(function(el) {
            new Swiper(el, {
                slidesPerView: 1,
                spaceBetween: 16,
                slidesPerGroup: 1,
                loop: false,
                speed: 450,
                grabCursor: true,
                threshold: 6,
                navigation: {
                    nextEl: el.querySelector('.swiper-button-next'),
                    prevEl: el.querySelector('.swiper-button-prev'),
                },
                a11y: {
                    enabled: true
                },
                breakpoints: {
                    576: {
                        slidesPerView: 2,
                        spaceBetween: 16
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 16
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 18
                    },
                }
            });
        });
    </script>
@endsection
