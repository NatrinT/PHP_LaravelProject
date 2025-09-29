<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    {{-- Icons + Sidebar styles --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">

    {{-- Page-level CSS --}}
    @yield('css_before')
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0">

            {{-- ===== Sidebar (ซ้าย) ===== --}}
            <div class="col-auto">
                <aside class="sbv sidebar d-flex flex-column align-items-stretch">
                    {{-- โลโก้ตอน sidebar ย่อ --}}
                    <img src="{{ asset('images/app_logo.png') }}" alt="Dorm Logo" class="logo-mini">
                    {{-- โลโก้เต็มตอน hover --}}
                    <img src="{{ asset('images/app_logo.png') }}" alt="Dorm Booking" class="logo-full ms-2">

                    {{-- Menu --}}
                    <nav class="mt-2 px-2 flex-grow-1">
                        <a href="{{ url('/') }}" class="sbv-link {{ request()->is('/') ? 'active' : '' }}">
                            <i class="bi bi-house fs-4"></i> <span class="fw-bold fs-5">Home</span>
                        </a>

                        <a href="{{ url('/dashboard') }}"
                            class="sbv-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                            <i class="bi bi-bar-chart-line fs-4"></i> <span class="fw-bold fs-5">Dashboard</span>
                        </a>

                        <a href="{{ url('/users') }}" class="sbv-link {{ request()->is('users*') ? 'active' : '' }}">
                            <i class="bi bi-people fs-4"></i> <span class="fw-bold fs-5">Users</span>
                        </a>

                        <a href="{{ url('/room') }}" class="sbv-link {{ request()->is('room*') ? 'active' : '' }}">
                            <i class="bi bi-door-open fs-4"></i> <span class="fw-bold fs-5">Room</span>
                        </a>

                        <a href="{{ url('/lease') }}" class="sbv-link {{ request()->is('lease*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text fs-4"></i> <span class="fw-bold fs-5">Leases</span>
                        </a>

                        <a href="{{ url('/invoice') }}"
                            class="sbv-link {{ request()->is('invoice*') ? 'active' : '' }}">
                            <i class="bi bi-receipt fs-4"></i> <span class="fw-bold fs-5">Invoices</span>
                        </a>

                        <a href="{{ url('/announcement') }}"
                            class="sbv-link {{ request()->is('announcement*') ? 'active' : '' }}">
                            <i class="bi bi-megaphone fs-4"></i> <span class="fw-bold fs-5">Announcement</span>
                        </a>

                        {{-- เพิ่มเมนูพิเศษจากหน้าลูก (ถ้ามี) --}}
                        @yield('sidebarMenu')
                    </nav>

                    {{-- Logout --}}
                    <div class="px-2 pb-3">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                        <a href="#" class="sbv-link danger"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right fs-4" style="color:#FF0000;"></i>
                            <span class="fw-bold fs-5" style="color:#FF0000;">Logout</span>
                        </a>
                    </div>
                </aside>
            </div>

            {{-- ===== Main (ขวา) ===== --}}
            <div class="col d-flex flex-column">
                {{-- Topbar ที่หน้าลูกอยากแทรก --}}
                @yield('topbar')

                {{-- Header ที่หน้าลูกอยากแทรก --}}
                @yield('header')

                {{-- Content หลัก --}}
                <div class="p-3 flex-grow-1">
                    @yield('content')
                </div>

                {{-- Footer เฉพาะหน้า (ถ้ามี) --}}
                @yield('footer')
            </div>

        </div>
    </div>

    {{-- JS libs --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YbCrDk0kJm9x2kN8p1o7rRG0mE0M2mC9i5zK2y/8kC7Z6vJ1m1n3qJZqVfI0iZVJ" crossorigin="anonymous">
    </script>

    {{-- ✅ Page-level JS (สำคัญ: ทำให้ script จากหน้าลูกถูก inject จริง) --}}
    @yield('js_before')
</body>

</html>
