<x-guard-layout>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Gate Monitoring • {{ now()->format('l, F j, Y') }}
                </div>

                <h1 class="text-2xl font-bold text-[#0e2c56]">
                    Scan History & Presence Logs
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Real-time automated campus-presence verification and gate access control
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a
                    href="{{ route('guard.dashboard') }}"
                    class="inline-flex items-center gap-2.5 bg-[#155d36] hover:bg-[#0f4628] text-white font-semibold text-sm px-5 py-2.5 rounded-xl shadow-sm hover:shadow transition duration-200"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                    <span>Back to QR Scanner</span>
                </a>
            </div>

        </div>


        {{-- Statistics Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

            {{-- Currently On Campus --}}
            <div class="dashboard-card">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="card-label">
                            Currently On Campus
                        </p>

                        <p class="text-3xl font-bold text-emerald-600 mt-2">
                            {{ $currentlyOnCampus }}
                        </p>

                        <p class="text-xs font-semibold text-emerald-700/80 mt-2 inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Active inside premises
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>

                </div>

            </div>


            {{-- Today's Time In --}}
            <div class="dashboard-card">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="card-label">
                            Today's Time In
                        </p>

                        <p class="text-3xl font-bold text-blue-600 mt-2">
                            {{ $timeInCount }}
                        </p>

                        <p class="text-xs font-semibold text-blue-700/80 mt-2 inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Total entries logged
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 4h4a2 2 0 012 2v12a2 2 0 01-2 2h-4"/>
                        </svg>
                    </div>

                </div>

            </div>


            {{-- Today's Time Out --}}
            <div class="dashboard-card">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="card-label">
                            Today's Time Out
                        </p>

                        <p class="text-3xl font-bold text-amber-500 mt-2">
                            {{ $timeOutCount }}
                        </p>

                        <p class="text-xs font-semibold text-amber-600/80 mt-2 inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Total departures logged
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 4H6a2 2 0 00-2 2v12a2 2 0 002 2h4"/>
                        </svg>
                    </div>

                </div>

            </div>


            {{-- Total Registered Students --}}
            <div class="dashboard-card">

                <div class="flex items-start justify-between">

                    <div>
                        <p class="card-label">
                            Total Students
                        </p>

                        <p class="text-3xl font-bold text-[#0e2c56] mt-2">
                            {{ $totalStudents }}
                        </p>

                        <p class="text-xs font-semibold text-[#2f5995] mt-2 inline-flex items-center gap-1.5">
                            Enrolled in system
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        </svg>
                    </div>

                </div>

            </div>

        </div>



        {{-- Lower Panels --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- Attendance Overview (1/3) --}}
            <div class="dashboard-panel xl:col-span-1">

                <div class="panel-header">
                    <div>
                        <h2 class="panel-title">
                            Campus Presence Flow
                        </h2>
                        <p class="panel-subtitle">
                            Today's presence distribution
                        </p>
                    </div>
                </div>

                <div class="p-6 space-y-6">

                    {{-- Visual Progress Indicators --}}
                    @php
                        $notArrived = max(0, $totalStudents - $timeInCount);
                        $campusPct = $totalStudents > 0 ? round(($currentlyOnCampus / $totalStudents) * 100) : 0;
                        $exitedPct = $totalStudents > 0 ? round(($timeOutCount / $totalStudents) * 100) : 0;
                        $notArrivedPct = $totalStudents > 0 ? round(($notArrived / $totalStudents) * 100) : 0;
                    @endphp

                    {{-- Bar representation --}}
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                            <span>Campus Capacity Ratio</span>
                            <span class="text-[#0e2c56]">{{ $campusPct }}% Inside</span>
                        </div>
                        <div class="h-3 w-full bg-slate-100 rounded-full overflow-hidden flex">
                            <div style="width: {{ $campusPct }}%" class="bg-emerald-500 h-full transition-all duration-500"></div>
                            <div style="width: {{ $exitedPct }}%" class="bg-amber-400 h-full transition-all duration-500"></div>
                        </div>
                    </div>

                    {{-- Metric rows --}}
                    <div class="space-y-3 pt-2">

                        <div class="flex items-center justify-between p-3.5 rounded-xl bg-emerald-50/70 border border-emerald-100">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                <div>
                                    <p class="text-xs font-bold text-emerald-950">Currently Inside</p>
                                    <p class="text-[11px] text-emerald-700">Timed in & not yet left</p>
                                </div>
                            </div>
                            <span class="text-lg font-bold text-emerald-700">{{ $currentlyOnCampus }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3.5 rounded-xl bg-amber-50/70 border border-amber-100">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                                <div>
                                    <p class="text-xs font-bold text-amber-950">Completed (Timed Out)</p>
                                    <p class="text-[11px] text-amber-700">Left campus for the day</p>
                                </div>
                            </div>
                            <span class="text-lg font-bold text-amber-700">{{ $timeOutCount }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full bg-slate-300"></span>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">Not Yet Arrived</p>
                                    <p class="text-[11px] text-slate-400">No scan recorded today</p>
                                </div>
                            </div>
                            <span class="text-lg font-bold text-slate-600">{{ $notArrived }}</span>
                        </div>

                    </div>

                    {{-- Security Status Badge --}}
                    <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                        <span class="inline-flex items-center gap-1.5 font-medium text-slate-600">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Gate Verification Online
                        </span>
                        <span>{{ now()->format('h:i A') }}</span>
                    </div>

                </div>

            </div>


            {{-- Recent Scans Table (2/3) --}}
            <div class="dashboard-panel xl:col-span-2">

                <div class="panel-header">
                    <div>
                        <h2 class="panel-title">
                            Recent Scans
                        </h2>
                        <p class="panel-subtitle">
                            Latest student entry and exit logs today
                        </p>
                    </div>

                    <a
                        href="{{ route('guard.dashboard') }}"
                        class="text-xs font-semibold text-[#123b70] hover:underline flex items-center gap-1"
                    >
                        <span>New Scan</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>

                <div class="overflow-x-auto">

                    @if($recentScans->count() > 0)

                        <table class="w-full">

                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50/50">

                                    <th class="table-heading">
                                        Student
                                    </th>

                                    <th class="table-heading">
                                        Student ID
                                    </th>

                                    <th class="table-heading">
                                        Time In
                                    </th>

                                    <th class="table-heading">
                                        Time Out
                                    </th>

                                    <th class="table-heading text-right">
                                        Status
                                    </th>

                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                @foreach($recentScans as $attendance)

                                    <tr class="hover:bg-slate-50/70 transition">

                                        {{-- Student Info --}}
                                        <td class="px-5 py-3.5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 text-[#123b70] font-bold text-xs flex items-center justify-center flex-shrink-0">
                                                    {{ strtoupper(substr($attendance->student->first_name ?? 'S', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-[#0e2c56]">
                                                        {{ $attendance->student->first_name ?? '' }}
                                                        {{ $attendance->student->last_name ?? '' }}
                                                    </p>
                                                    @if(!empty($attendance->student->grade_level) || !empty($attendance->student->section))
                                                        <p class="text-[11px] text-slate-400">
                                                            Grade {{ $attendance->student->grade_level ?? '—' }} - {{ $attendance->student->section ?? '—' }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Student No --}}
                                        <td class="px-5 py-3.5 text-xs font-mono text-slate-600">
                                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700">
                                                {{ $attendance->student->student_no ?? 'N/A' }}
                                            </span>
                                        </td>

                                        {{-- Time In --}}
                                        <td class="px-5 py-3.5 text-xs font-medium text-slate-600">
                                            @if($attendance->time_in)
                                                <span class="inline-flex items-center gap-1 text-slate-700">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                                    {{ $attendance->time_in->format('h:i A') }}
                                                </span>
                                            @else
                                                <span class="text-slate-300">—</span>
                                            @endif
                                        </td>

                                        {{-- Time Out --}}
                                        <td class="px-5 py-3.5 text-xs font-medium text-slate-600">
                                            @if($attendance->time_out)
                                                <span class="inline-flex items-center gap-1 text-slate-700">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                    {{ $attendance->time_out->format('h:i A') }}
                                                </span>
                                            @else
                                                <span class="text-slate-300">—</span>
                                            @endif
                                        </td>

                                        {{-- Status Badge --}}
                                        <td class="px-5 py-3.5 text-right">
                                            @if($attendance->time_out)
                                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-700">
                                                    Completed
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                    On Campus
                                                </span>
                                            @endif
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    @else

                        {{-- Empty State --}}
                        <div class="h-64 flex flex-col items-center justify-center px-4 text-center">

                            <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                </svg>
                            </div>

                            <p class="text-sm font-semibold text-slate-600">
                                No attendance scans recorded yet today
                            </p>

                            <p class="text-xs text-slate-400 mt-1 max-w-sm">
                                As students present their QR code to the gate camera, verification logs will appear here in real-time.
                            </p>

                            <a
                                href="{{ route('guard.dashboard') }}"
                                class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-[#123b70] hover:text-[#0e2c56] bg-slate-50 hover:bg-slate-100 px-3.5 py-1.5 rounded-lg border border-slate-200 transition"
                            >
                                <span>Start Scanning Now</span>
                                <span>&rarr;</span>
                            </a>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-guard-layout>
