<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ $title ?? 'Teacher Dashboard' }} - VIP Campus Presence System
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#faf7f0] text-[#1a3322] antialiased min-h-screen">

    <div class="min-h-screen flex">

        {{-- ================= SIDEBAR ================= --}}
        <aside class="w-64 bg-[#155d36] text-white flex flex-col fixed inset-y-0 left-0 z-40 h-screen shadow-xl">

            {{-- Logo Header --}}
            <div class="h-20 px-6 flex items-center border-b border-white/10 flex-shrink-0">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="VIP Learning Center"
                    class="w-10 h-10 object-contain bg-white rounded-xl p-1 shadow-sm"
                >

                <div class="ml-3">
                    <h1 class="font-bold text-sm leading-tight text-white">
                        VIP Learning
                    </h1>

                    <p class="text-[11px] text-white/70">
                        Center Inc.
                    </p>
                </div>

            </div>


            {{-- Navigation Items --}}
            <nav class="flex-1 px-4 py-5 space-y-4 overflow-y-auto no-scrollbar">

                {{-- MAIN --}}
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-white/40 select-none">
                        MAIN MENU
                    </div>

                    {{-- Dashboard --}}
                    <a
                        href="{{ route('teacher.dashboard') }}"
                        class="sidebar-link
                        {{ request()->routeIs('teacher.dashboard')
                            ? 'bg-white/20 text-white font-semibold shadow-xs'
                            : '' }}"
                    >
                        <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M3 12l9-9 9 9M5 10v10h14V10M9 20v-6h6v6"/>
                        </svg>

                        <span>Dashboard</span>
                    </a>
                </div>


                {{-- ACADEMICS & STUDENTS --}}
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-white/40 select-none">
                        CLASSROOM
                    </div>

                    {{-- My Students --}}
                    <a
                        href="{{ route('teacher.students.index') }}"
                        class="sidebar-link
                        {{ request()->routeIs('teacher.students.*')
                            ? 'bg-white/20 text-white font-semibold shadow-xs'
                            : '' }}"
                    >
                        <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/>
                            <circle cx="9" cy="7" r="4" stroke-width="1.8"/>
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                        </svg>

                        <span>My Students</span>
                    </a>
                </div>


                {{-- ATTENDANCE & REPORTS --}}
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-white/40 select-none">
                        ATTENDANCE
                    </div>

                    {{-- Attendance --}}
                    <a
                        href="{{ route('teacher.attendance.index') }}"
                        class="sidebar-link
                        {{ request()->routeIs('teacher.attendance.*')
                            ? 'bg-white/20 text-white font-semibold shadow-xs'
                            : '' }}"
                    >
                        <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="4" y="5" width="16" height="16" rx="2" stroke-width="1.8"/>
                            <path stroke-linecap="round" stroke-width="1.8" d="M8 3v4M16 3v4M4 10h16"/>
                        </svg>

                        <span>Attendance</span>
                    </a>

                    {{-- Reports --}}
                    <a
                        href="{{ url('/reports') }}"
                        class="sidebar-link
                        {{ request()->is('reports*')
                            ? 'bg-white/20 text-white font-semibold shadow-xs'
                            : '' }}"
                    >
                        <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>
                        </svg>

                        <span>Reports</span>
                    </a>
                </div>


                {{-- COMMUNICATION --}}
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-white/40 select-none">
                        COMMUNICATION
                    </div>

                    {{-- Announcements --}}
                    <a
                        href="{{ url('/announcements') }}"
                        class="sidebar-link
                        {{ request()->is('announcements*')
                            ? 'bg-white/20 text-white font-semibold shadow-xs'
                            : '' }}"
                    >
                        <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M4 12h4l8-5v10l-8-5H4z"/>
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M8 12l1.5 6h2L10 13"/>
                        </svg>

                        <span>Announcements</span>
                    </a>
                </div>


                {{-- ACCOUNT --}}
                <div class="space-y-1">
                    <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-white/40 select-none">
                        ACCOUNT
                    </div>

                    {{-- My Profile --}}
                    <a
                        href="{{ route('profile.edit') }}"
                        class="sidebar-link
                        {{ request()->routeIs('profile.*')
                            ? 'bg-white/20 text-white font-semibold shadow-xs'
                            : '' }}"
                    >
                        <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>

                        <span>My Profile</span>
                    </a>
                </div>

            </nav>


            {{-- Logout Footer --}}
            <div class="p-4 border-t border-white/10 flex-shrink-0">

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="sidebar-link w-full text-left"
                    >

                        <svg class="sidebar-icon"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M10 17l5-5-5-5M15 12H3"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M21 3v18"/>
                        </svg>

                        <span>Logout</span>

                    </button>

                </form>

            </div>

        </aside>


        {{-- ================= MAIN CONTENT AREA ================= --}}
        <div class="ml-64 flex-1 min-h-screen flex flex-col">

            {{-- Top Header --}}
            <header class="h-20 bg-white border-b border-stone-200/80 border-t-4 border-t-[#155d36] flex items-center justify-between px-8 sticky top-0 z-30 shadow-xs">

                <div>
                    <h1 class="text-xl font-bold text-[#155d36] tracking-tight">
                        @yield('page-title', 'Teacher Dashboard')
                    </h1>

                    <p class="text-xs font-medium text-stone-400">
                        @yield('page-subtitle', 'VIP Learning Center Inc.')
                    </p>
                </div>


                <div class="flex items-center gap-5">

                    {{-- Notification --}}
                    <button class="relative p-2 rounded-xl text-stone-500 hover:text-[#155d36] hover:bg-stone-100 transition">

                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M18 8a6 6 0 00-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/>

                        </svg>

                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-[#eb5757] rounded-full"></span>

                    </button>

                    <div class="h-8 w-px bg-stone-200"></div>

                    {{-- Teacher Profile --}}
                    <div class="flex items-center gap-3 cursor-pointer">

                        <div class="w-10 h-10 rounded-full bg-[#155d36] text-white flex items-center justify-center font-bold text-sm shadow-xs">
                            {{ strtoupper(substr(auth()->user()->name ?? 'Teacher', 0, 1)) }}
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-[#155d36] leading-tight">
                                {{ auth()->user()->name ?? 'Teacher' }}
                            </p>

                            <p class="text-xs text-stone-400">
                                Teacher
                            </p>

                        </div>

                        <svg class="w-4 h-4 text-stone-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>

                    </div>

                </div>

            </header>


            {{-- Page Content --}}
            <main class="flex-1 p-6 lg:p-8 max-w-[1600px] w-full mx-auto">

                @yield('content')
                {{ $slot ?? '' }}

            </main>

        </div>

    </div>

</body>
</html>

