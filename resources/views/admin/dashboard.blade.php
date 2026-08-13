<x-admin-layout>

    <div class="max-w-7xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-[#0e2c56]">
                Dashboard
            </h1>

            <p class="text-sm text-slate-400 mt-1">
                Overview of your campus management system
            </p>
        </div>


        {{-- Statistics --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

            {{-- Students --}}
            <div class="dashboard-card">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="card-label">
                            Students
                        </p>

                        <p class="card-empty">
                            {{ $studentCount ?? 0 }}
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">

                        <svg class="w-6 h-6 text-blue-500"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-8a4 4 0 11-8 0 4 4 0 018 0zm6 3a3 3 0 10-6 0"/>
                        </svg>

                    </div>

                </div>

                <a href="{{ route('students.index') }}"
                   class="card-link">
                    View all
                </a>

            </div>


            {{-- Teachers --}}
            <div class="dashboard-card">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="card-label">
                            Teachers
                        </p>

                        <p class="card-empty">
                            {{ $teacherCount ?? 0 }}
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-cyan-50 flex items-center justify-center">

                        <svg class="w-6 h-6 text-cyan-500"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M15 20a4 4 0 00-8 0m4-8a4 4 0 100-8 4 4 0 000 8zm5 8a4 4 0 00-3-3.87M17 4a3 3 0 010 6"/>
                        </svg>

                    </div>

                </div>

                <a href="#" class="card-link">
                    View all
                </a>

            </div>


            {{-- Parents --}}
            <div class="dashboard-card">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="card-label">
                            Parents
                        </p>

                        <p class="card-empty">
                            {{ $parentCount ?? 0 }}
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">

                        <svg class="w-6 h-6 text-amber-500"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M15 20a4 4 0 00-8 0m4-8a4 4 0 100-8 4 4 0 000 8zm5 8a4 4 0 00-3-3.87M17 4a3 3 0 010 6"/>
                        </svg>

                    </div>

                </div>

                <a href="#" class="card-link">
                    View all
                </a>

            </div>


            {{-- Today's Present --}}
            <div class="dashboard-card">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="card-label">
                            Today's Present
                        </p>

                        <p class="card-empty">
                            {{ $todayPresent ?? 0 }}
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center">

                        <svg class="w-6 h-6 text-emerald-500"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>

                    </div>

                </div>

                <a href="#"
                   class="card-link">
                    View attendance
                </a>

            </div>

        </div>


        {{-- Lower Panels --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">

            {{-- Attendance Overview --}}
            <div class="dashboard-panel">

                <div class="panel-header">

                    <div>
                        <h2 class="panel-title">
                            Attendance Overview
                        </h2>

                        <p class="panel-subtitle">
                            Today's attendance summary
                        </p>
                    </div>

                </div>

                <div class="h-72 flex flex-col items-center justify-center">

                    <div class="w-40 h-40 rounded-full border-[18px] border-slate-100 flex items-center justify-center">

                        <div class="text-center">

                            <div class="text-xl font-bold text-slate-300">
                                —
                            </div>

                            <p class="text-xs text-slate-400 mt-1">
                                No data yet
                            </p>

                        </div>

                    </div>

                    <p class="text-sm text-slate-400 mt-5">
                        Attendance data will appear here.
                    </p>

                </div>

            </div>


            {{-- Recent Scans --}}
            <div class="dashboard-panel">

                <div class="panel-header">

                    <div>
                        <h2 class="panel-title">
                            Recent Scans
                        </h2>

                        <p class="panel-subtitle">
                            Latest campus presence records
                        </p>
                    </div>

                    <a href="#"
                       class="text-sm font-semibold text-[#123b70]">
                        View all
                    </a>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>
                            <tr class="border-b border-slate-100">

                                <th class="table-heading">
                                    Student
                                </th>

                                <th class="table-heading">
                                    Time
                                </th>

                                <th class="table-heading">
                                    Status
                                </th>

                                <th class="table-heading">
                                    Scanned By
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td colspan="4">

                                    <div class="h-56 flex flex-col items-center justify-center">

                                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center">

                                            <svg class="w-5 h-5 text-slate-300"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"/>
                                            </svg>

                                        </div>

                                        <p class="text-sm font-semibold text-slate-400 mt-4">
                                            No attendance records yet
                                        </p>

                                        <p class="text-xs text-slate-300 mt-1">
                                            Scanned students will appear here.
                                        </p>

                                    </div>

                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-admin-layout>