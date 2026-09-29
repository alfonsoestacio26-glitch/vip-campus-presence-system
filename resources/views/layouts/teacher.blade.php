<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Teacher Dashboard' }} - VIP Campus Presence System</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #f3f7fc;
        }

        .teacher-sidebar {
            background: #0e2c56;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 10px;
            color: #cbd5e1;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-link i {
            width: 18px;
            text-align: center;
            font-size: 14px;
        }

        .sidebar-link:hover {
            background: #123b70;
            color: white;
        }

        .sidebar-link.active {
            background: #123b70;
            color: white;
        }
    </style>
</head>

<body>

<div class="min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="teacher-sidebar w-64 min-h-screen fixed left-0 top-0 z-40">

        <!-- Logo -->
        <div class="px-6 py-6 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center">
                    <i class="fa-solid fa-school text-[#0e2c56]"></i>
                </div>

                <div>
                    <h1 class="text-white font-bold text-lg leading-tight">
                        VIP Campus
                    </h1>
                    <p class="text-blue-200 text-xs">
                        Teacher Portal
                    </p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="p-4 space-y-1">

            <p class="text-blue-200/60 uppercase text-[10px] font-semibold px-3 mb-3">
                Main Menu
            </p>

            <a href="{{ route('teacher.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('teacher.students.index') }}"
               class="sidebar-link {{ request()->routeIs('teacher.students.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-graduate"></i>
                <span>Students</span>
            </a>

            <a href="{{ route('teacher.attendance.index') }}"
               class="sidebar-link {{ request()->routeIs('teacher.attendance.*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-user"></i>
                <span>Attendance Logs</span>
            </a>
            <a href="{{ url('/reports') }}"
               class="sidebar-link">
                <i class="fa-solid fa-chart-column"></i>
                <span>Reports</span>
            </a>

            <a href="{{ url('/announcements') }}"
               class="sidebar-link">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Announcements</span>
            </a>

            <p class="text-blue-200/60 uppercase text-[10px] font-semibold px-3 mt-7 mb-3">
                Account
            </p>

            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-user"></i>
                <span>My Profile</span>
            </a>

        </nav>

        <!-- Logout -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/10">

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="sidebar-link w-full text-left">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>

        </div>

    </aside>


    <!-- MAIN CONTENT -->
    <div class="ml-64 flex-1 min-h-screen">

        <!-- TOP BAR -->
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8">

            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    @yield('page-title', 'Teacher Dashboard')
                </h2>

                <p class="text-xs text-gray-500">
                    VIP Learning Center Inc.
                </p>
            </div>

            <div class="flex items-center gap-3">

                <div class="text-right">
                    <p class="text-sm font-semibold text-gray-700">
                        {{ auth()->user()->name ?? 'Teacher' }}
                    </p>

                    <p class="text-xs text-gray-500">
                        Teacher
                    </p>
                </div>

                <div class="w-9 h-9 rounded-full bg-[#123b70] text-white flex items-center justify-center">
                    <i class="fa-solid fa-user text-sm"></i>
                </div>

            </div>

        </header>


        <!-- PAGE CONTENT -->
        <main class="p-8">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>