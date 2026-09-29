<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'VIP Learning Center') }} - Guard Portal
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

                {{-- QR Scanner (Dashboard) --}}
                <a
                    href="{{ route('guard.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('guard.dashboard') || request()->routeIs('guard.scanner') ? 'bg-white/15 text-white font-semibold' : '' }}"
                >
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>

                    <span>QR Scanner</span>
                </a>

                {{-- Scan History & Logs --}}
                <a
                    href="{{ route('guard.history') }}"
                    class="sidebar-link {{ request()->routeIs('guard.history') ? 'bg-white/15 text-white font-semibold' : '' }}"
                >
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>

                    <span>Scan History</span>
                </a>

                {{-- Profile / Account --}}
                <a
                    href="{{ route('profile.edit') }}"
                    class="sidebar-link {{ request()->routeIs('profile.*') ? 'bg-white/15 text-white font-semibold' : '' }}"
                >
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>

                    <span>My Profile</span>
                </a>

            </nav>


            {{-- Logout --}}
            <div class="p-4 border-t border-white/10">

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
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>

                        <span>Logout</span>

                    </button>

                </form>

            </div>

        </aside>


        {{-- ================= MAIN CONTENT ================= --}}
        <div class="ml-64 flex-1 min-h-screen flex flex-col">

            {{-- Top Header --}}
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-30">

                <div>

                    <h2 class="text-2xl font-bold text-[#0e2c56]">
                        Guard Portal
                    </h2>

                    <p class="text-sm text-slate-400">
                        Campus Security & Presence Monitoring
                    </p>

                </div>


                <div class="flex items-center gap-5">

                    {{-- Quick CTA Button --}}
                    @if(request()->routeIs('guard.dashboard') || request()->routeIs('guard.scanner'))
                        <a
                            href="{{ route('guard.history') }}"
                            class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-[#0e2c56] text-xs font-semibold px-4 py-2.5 rounded-xl transition border border-slate-200"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            <span>Scan History & Logs</span>
                        </a>
                    @else
                        <a
                            href="{{ route('guard.dashboard') }}"
                            class="inline-flex items-center gap-2 bg-[#123b70] hover:bg-[#0e2c56] text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-sm"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            <span>Open QR Scanner</span>
                        </a>
                    @endif


                    {{-- User Profile Pill --}}
                    <div class="flex items-center gap-3 pl-4 border-l border-slate-200">

                        <div class="w-10 h-10 rounded-full bg-[#123b70] flex items-center justify-center text-white shadow-sm">

                            <svg class="w-5 h-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>

                            </svg>

                        </div>

                        <div>

                            <p class="text-sm font-semibold text-[#0e2c56]">
                                {{ auth()->user()->name ?? 'Guard' }}
                            </p>

                            <p class="text-xs text-slate-400">
                                Campus Security Guard
                            </p>

                        </div>

                    </div>

                </div>

            </header>


            {{-- Page Content --}}
            <main class="p-8 flex-1">

                {{ $slot }}

            </main>

        </div>

    </div>

</body>
</html>
