<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'VIP Learning Center') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f4f7fb] text-[#0e2c56] antialiased">

    <div class="min-h-screen flex">

        {{-- ================= SIDEBAR ================= --}}
        <aside class="w-64 bg-[#123b70] text-white flex flex-col fixed inset-y-0 left-0 z-40">

            {{-- Logo --}}
            <div class="h-24 px-6 flex items-center border-b border-white/10">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="VIP Learning Center"
                    class="w-12 h-12 object-contain bg-white rounded-xl p-1"
                >

                <div class="ml-3">
                    <h1 class="font-bold text-sm">
                        VIP Learning
                    </h1>

                    <p class="text-[11px] text-white/70">
                        Center Inc.
                    </p>
                </div>

            </div>


            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">

                {{-- Dashboard --}}
                <a
                    href="{{ url('/admin/dashboard') }}"
                    class="sidebar-link
                    {{ request()->is('admin/dashboard')
                        ? 'bg-white/15 text-white'
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


                {{-- Students --}}
                <a
                    href="{{ route('students.index') }}"
                    class="sidebar-link
                    {{ request()->is('students*')
                        ? 'bg-white/15 text-white'
                        : '' }}"
                >
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="4"
                                stroke-width="1.8"/>
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                    </svg>

                    <span>Students</span>
                </a>


                {{-- Parents --}}
                <a
                    href="{{ route('parents.index') }}"
                    class="sidebar-link
                    {{ request()->is('parents*')
                        ? 'bg-white/15 text-white'
                        : '' }}"
                >
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="9" cy="7" r="4"
                                stroke-width="1.8"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M2 21a7 7 0 0114 0"/>

                        <circle cx="17" cy="8" r="3"
                                stroke-width="1.8"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M17 13a5 5 0 015 5"/>
                    </svg>

                    <span>Parents</span>
                </a>


                {{-- Teachers --}}
                <a
                    href="{{ route('teachers.index') }}"
                    class="sidebar-link
                    {{ request()->is('teachers*')
                        ? 'bg-white/15 text-white'
                        : '' }}"
                >
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4"
                                stroke-width="1.8"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M4 21a8 8 0 0116 0"/>
                    </svg>

                    <span>Teachers</span>
                </a>


                {{-- Guards --}}
                <a
                    href="{{ route('guards.index') }}"
                    class="sidebar-link
                    {{ request()->is('guards*')
                        ? 'bg-white/15 text-white'
                        : '' }}"
                >
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M12 3l7 3v5c0 4.5-3 8.5-7 10-4-1.5-7-5.5-7-10V6l7-3z"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M9 12l2 2 4-4"/>

                    </svg>

                    <span>Guards</span>
                </a>


                {{-- Attendance --}}
                <a href="#" class="sidebar-link">

                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <rect x="4" y="5" width="16" height="16"
                              rx="2"
                              stroke-width="1.8"/>

                        <path stroke-linecap="round"
                              stroke-width="1.8"
                              d="M8 3v4M16 3v4M4 10h16"/>

                    </svg>

                    <span>Attendance</span>

                </a>


                {{-- Reports --}}
                <a href="#" class="sidebar-link">

                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>

                    </svg>

                    <span>Reports</span>

                </a>


                {{-- Announcements --}}
                <a href="#" class="sidebar-link">

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


                {{-- SMS Logs --}}
                <a href="#" class="sidebar-link">

                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <rect x="3" y="4" width="18" height="14"
                              rx="2"
                              stroke-width="1.8"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M7 21h10M8 9h8M8 13h5"/>

                    </svg>

                    <span>SMS Logs</span>

                </a>


                {{-- Settings --}}
                <a href="#" class="sidebar-link">

                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <circle cx="12" cy="12" r="3"
                                stroke-width="1.8"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M19.4 15a1.7 1.7 0 00.3 1.9l.1.1-1.8 1.8-.1-.1a1.7 1.7 0 00-1.9-.3 1.7 1.7 0 00-1 1.6v.2h-2.6V20a1.7 1.7 0 00-1-1.6 1.7 1.7 0 00-1.9.3l-.1.1-1.8-1.8.1-.1a1.7 1.7 0 00.3-1.9 1.7 1.7 0 00-1.6-1H5.2v-2.6H5a1.7 1.7 0 001.6-1 1.7 1.7 0 00-.3-1.9l-.1-.1L8 8.5l.1.1a1.7 1.7 0 001.9.3 1.7 1.7 0 001-1.6V7h2.6v.2a1.7 1.7 0 001 1.6 1.7 1.7 0 001.9-.3l.1-.1 1.8 1.8-.1.1a1.7 1.7 0 00-.3 1.9 1.7 1.7 0 001.6 1h.2v2.6h-.2a1.7 1.7 0 00-1.6 1z"/>

                    </svg>

                    <span>Settings</span>

                </a>

            </nav>


            {{-- Logout --}}
            <div class="p-4 border-t border-white/10">

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="sidebar-link w-full"
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


        {{-- ================= MAIN CONTENT ================= --}}
        <div class="ml-64 flex-1 min-h-screen">

            {{-- Top Header --}}
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8">

                <div>

                    <h2 class="text-2xl font-bold text-[#0e2c56]">
                        Admin Dashboard
                    </h2>

                    <p class="text-sm text-slate-400">
                        Campus Management Overview
                    </p>

                </div>


                <div class="flex items-center gap-5">

                    {{-- Notification --}}
                    <button class="relative text-[#0e2c56]">

                        <svg class="w-5 h-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M18 8a6 6 0 00-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/>

                        </svg>

                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>

                    </button>


                    {{-- User --}}
                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-full bg-[#123b70] flex items-center justify-center text-white">

                            <svg class="w-5 h-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <circle cx="12" cy="8" r="4"
                                        stroke-width="1.8"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M4 21a8 8 0 0116 0"/>

                            </svg>

                        </div>

                        <div>

                            <p class="text-sm font-semibold text-[#0e2c56]">
                                {{ auth()->user()->name ?? 'Admin' }}
                            </p>

                            <p class="text-xs text-slate-400">
                                Administrator
                            </p>

                        </div>

                    </div>

                </div>

            </header>


            {{-- Page Content --}}
            <main class="p-8">

                {{ $slot }}

            </main>

        </div>

    </div>

</body>
</html>