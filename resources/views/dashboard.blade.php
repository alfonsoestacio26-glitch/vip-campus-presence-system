<x-app-layout>

    <div class="min-h-screen bg-[#faf7f0]">

        <!-- TOP HEADER -->
        <header class="h-20 bg-white border-b border-stone-200 border-t-4 border-t-[#155d36] flex items-center justify-between px-6 lg:px-8">

            <div class="flex items-center gap-4">

                <button class="lg:hidden p-2 rounded-lg hover:bg-stone-100">
                    ☰
                </button>

                <div>
                    <h1 class="text-xl font-bold text-[#155d36]">
                        Admin Dashboard
                    </h1>

                    <p class="text-xs text-stone-400">
                        Campus Management Overview
                    </p>
                </div>

            </div>

            <div class="flex items-center gap-4">

                <div class="text-right">
                    <p class="text-sm font-semibold text-[#155d36]">
                        Admin
                    </p>

                    <p class="text-xs text-stone-400">
                        Administrator
                    </p>
                </div>

                <div class="w-10 h-10 rounded-full bg-[#155d36]
                            flex items-center justify-center text-white font-bold text-sm shadow-xs">
                    A
                </div>

            </div>

        </header>


        <!-- MAIN AREA -->
        <div class="flex">


            <!-- SIDEBAR -->
            <aside class="hidden lg:flex w-64 min-h-[calc(100vh-80px)]
                           bg-gradient-to-b from-[#155d36] to-[#0f4628]
                           text-white flex-col">

                <!-- LOGO -->
                <div class="px-6 py-6 border-b border-white/10">

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11 rounded-xl bg-white
                                    flex items-center justify-center p-1 shadow-xs">

                            <img
                                src="{{ asset('images/logo.png') }}"
                                class="w-9 h-9 object-contain"
                                alt="VIP Logo"
                            >

                        </div>

                        <div>

                            <p class="font-bold text-sm">
                                VIP Learning
                            </p>

                            <p class="text-xs text-white/60">
                                Center Inc.
                            </p>

                        </div>

                    </div>

                </div>


                <!-- MENU -->
                <nav class="flex-1 px-3 py-5 space-y-4">

                    <!-- MAIN -->
                    <div class="space-y-1">
                        <div class="px-3 text-[10px] font-semibold uppercase tracking-wider text-white/40 select-none">
                            MAIN
                        </div>

                        <a href="{{ route('dashboard') }}"
                           class="sidebar-link bg-white/20 text-white font-semibold shadow-xs">
                            🏠
                            Dashboard
                        </a>
                    </div>

                    <!-- MANAGEMENT -->
                    <div class="space-y-1">
                        <div class="px-3 text-[10px] font-semibold uppercase tracking-wider text-white/40 select-none">
                            MANAGEMENT
                        </div>

                        <a href="#" class="sidebar-link">
                            👨‍🎓
                            Students
                        </a>

                        <a href="#" class="sidebar-link">
                            👨‍👩‍👧
                            Parents
                        </a>

                        <a href="#" class="sidebar-link">
                            👨‍🏫
                            Teachers
                        </a>

                        <a href="#" class="sidebar-link">
                            🛡️
                            Guards
                        </a>
                    </div>

                    <!-- ATTENDANCE -->
                    <div class="space-y-1">
                        <div class="px-3 text-[10px] font-semibold uppercase tracking-wider text-white/40 select-none">
                            ATTENDANCE
                        </div>

                        <a href="#" class="sidebar-link">
                            📅
                            Attendance
                        </a>

                        <a href="#" class="sidebar-link">
                            📊
                            Reports
                        </a>
                    </div>

                    <!-- COMMUNICATION -->
                    <div class="space-y-1">
                        <div class="px-3 text-[10px] font-semibold uppercase tracking-wider text-white/40 select-none">
                            COMMUNICATION
                        </div>

                        <a href="#" class="sidebar-link">
                            📢
                            Announcements
                        </a>

                        <a href="#" class="sidebar-link">
                            💬
                            SMS Logs
                        </a>
                    </div>

                    <!-- SYSTEM -->
                    <div class="space-y-1">
                        <div class="px-3 text-[10px] font-semibold uppercase tracking-wider text-white/40 select-none">
                            SYSTEM
                        </div>

                        <a href="#" class="sidebar-link">
                            ⚙️
                            Settings
                        </a>
                    </div>

                </nav>


                <!-- LOGOUT -->
                <div class="p-3 border-t border-white/10">

                    <form method="POST" action="{{ route('logout') }}">

                        @csrf

                        <button
                            type="submit"
                            class="sidebar-link w-full">

                            🚪
                            Logout

                        </button>

                    </form>

                </div>

            </aside>


            <!-- CONTENT -->
            <main class="flex-1 p-5 sm:p-6 lg:p-8">

                <div class="mb-6">

                    <h2 class="text-2xl font-bold text-[#155d36]">
                        Dashboard
                    </h2>

                    <p class="text-sm text-stone-500 mt-1">
                        Overview of your campus management system
                    </p>

                </div>


                <!-- STAT CARDS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">


                    <!-- STUDENTS -->
                    <div class="dashboard-card">

                        <p class="card-label">
                            Students
                        </p>

                        <p class="card-empty text-[#155d36]">
                            —
                        </p>

                        <span class="card-link text-[#155d36]">
                            View all
                        </span>

                    </div>


                    <!-- TEACHERS -->
                    <div class="dashboard-card">

                        <p class="card-label">
                            Teachers
                        </p>

                        <p class="card-empty text-[#155d36]">
                            —
                        </p>

                        <span class="card-link text-[#155d36]">
                            View all
                        </span>

                    </div>


                    <!-- PARENTS -->
                    <div class="dashboard-card">

                        <p class="card-label">
                            Parents
                        </p>

                        <p class="card-empty text-[#155d36]">
                            —
                        </p>

                        <span class="card-link text-[#155d36]">
                            View all
                        </span>

                    </div>


                    <!-- PRESENT -->
                    <div class="dashboard-card">

                        <p class="card-label">
                            Today's Present
                        </p>

                        <p class="card-empty text-[#155d36]">
                            —
                        </p>

                        <span class="card-link text-[#155d36]">
                            View attendance
                        </span>

                    </div>

                </div>


                <!-- LOWER CARDS -->
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 mt-5">


                    <!-- ATTENDANCE -->
                    <div class="dashboard-panel">

                        <div class="panel-header">

                            <div>

                                <h3 class="panel-title text-[#155d36]">
                                    Attendance Overview
                                </h3>

                                <p class="panel-subtitle">
                                    Today's attendance summary
                                </p>

                            </div>

                        </div>

                        <div class="h-72 flex flex-col
                                    items-center justify-center">

                            <div class="w-44 h-44 rounded-full
                                        border-[24px] border-stone-100
                                        flex items-center justify-center">

                                <div class="text-center">

                                    <p class="text-3xl font-bold
                                              text-stone-300">
                                        —
                                    </p>

                                    <p class="text-xs text-stone-400">
                                        No data yet
                                    </p>

                                </div>

                            </div>

                            <p class="mt-5 text-sm text-stone-400">
                                Attendance data will appear here.
                            </p>

                        </div>

                    </div>


                    <!-- RECENT SCANS -->
                    <div class="dashboard-panel">

                        <div class="panel-header">

                            <div>

                                <h3 class="panel-title text-[#155d36]">
                                    Recent Scans
                                </h3>

                                <p class="panel-subtitle">
                                    Latest campus presence records
                                </p>

                            </div>

                            <span class="text-sm font-semibold
                                         text-[#155d36]">
                                View all
                            </span>

                        </div>

                        <div class="h-72 flex flex-col
                                    items-center justify-center">

                            <div class="w-12 h-12 rounded-full
                                        bg-stone-50 flex items-center
                                        justify-center">

                                📋

                            </div>

                            <p class="mt-3 text-sm font-medium
                                      text-stone-400">

                                No attendance records yet

                            </p>

                            <p class="text-xs text-stone-300 mt-1">

                                Scanned students will appear here.

                            </p>

                        </div>

                    </div>

                </div>

            </main>

        </div>

    </div>

</x-app-layout>