<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Parent Portal' }} - VIP Campus Presence</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', 'Inter', sans-serif;
            background: #f1f5f9;
            color: #0f172a;
        }

        .portal-header {
            background: linear-gradient(135deg, #0e2c56 0%, #123b70 60%, #172554 100%);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased">

    {{-- TOP NAVBAR --}}
    <header class="portal-header text-white sticky top-0 z-40 shadow-lg shadow-[#0e2c56]/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                {{-- LOGO & TITLE --}}
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center shadow-inner">
                        <i class="fa-solid fa-graduation-cap text-2xl text-blue-200"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-extrabold text-lg sm:text-xl tracking-tight text-white">VIP Campus</span>
                            <span class="bg-blue-500/30 text-blue-200 border border-blue-400/30 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">
                                Parent Portal
                            </span>
                        </div>
                        <p class="text-xs text-blue-200/80 font-medium hidden sm:block">
                            VIP Learning Center Inc. • Campus Presence & Attendance
                        </p>
                    </div>
                </div>

                {{-- USER MENU & ACTIONS --}}
                <div class="flex items-center gap-4">
                    {{-- Emergency Contact Quick Indicator --}}
                    <div class="hidden md:flex items-center gap-2.5 bg-white/10 backdrop-blur-sm border border-white/15 px-3.5 py-1.5 rounded-xl text-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-blue-100 font-medium">Gate Gateway Active</span>
                    </div>

                    {{-- Parent Identity & Logout --}}
                    <div class="flex items-center gap-3 pl-2 border-l border-white/10">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-white leading-tight">
                                {{ auth()->user()->name ?? 'Parent / Guardian' }}
                            </p>
                            <p class="text-[11px] text-blue-200">
                                Family Account
                            </p>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button 
                                type="submit" 
                                class="inline-flex items-center gap-1.5 px-3 py-2 bg-white/10 hover:bg-rose-600/80 border border-white/20 text-white text-xs font-semibold rounded-xl transition shadow-sm"
                                title="Sign out of Parent Portal"
                            >
                                <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                                <span class="hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </header>

    {{-- MAIN PAGE CONTENT --}}
    <main class="flex-1 py-8 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    {{-- PORTAL FOOTER --}}
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p>© {{ date('Y') }} VIP Learning Center Inc. — Automated Campus Presence Verification System.</p>
            <div class="flex items-center gap-4 text-slate-500">
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-halved text-blue-600"></i>
                    <span>Campus Gate Security Terminal</span>
                </span>
                <span>•</span>
                <span>Philippine Standard Time (UTC+8)</span>
            </div>
        </div>
    </footer>

</body>
</html>
