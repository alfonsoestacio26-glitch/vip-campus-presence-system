<x-admin-layout>

    <div class="space-y-6">

        {{-- =========================================================
             STATISTICS CARDS
        ========================================================== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

            {{-- Students --}}
            <div class="dashboard-card flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="card-label">Students</p>
                        <p class="card-empty text-[#155d36]">{{ $studentCount ?? 0 }}</p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-[#4d88df]/15 text-[#4d88df] border border-[#4d88df]/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-8a4 4 0 11-8 0 4 4 0 018 0zm6 3a3 3 0 10-6 0"/>
                        </svg>
                    </div>
                </div>

                <a href="{{ route('students.index') }}" class="card-link text-[#155d36] hover:text-[#0f4628]">
                    View all &rarr;
                </a>
            </div>


            {{-- Teachers --}}
            <div class="dashboard-card flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="card-label">Teachers</p>
                        <p class="card-empty text-[#155d36]">{{ $teacherCount ?? 0 }}</p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-[#155d36]/15 text-[#155d36] border border-[#155d36]/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 20a4 4 0 00-8 0m4-8a4 4 0 100-8 4 4 0 000 8zm5 8a4 4 0 00-3-3.87M17 4a3 3 0 010 6"/>
                        </svg>
                    </div>
                </div>

                <a href="{{ route('teachers.index') }}" class="card-link text-[#155d36] hover:text-[#0f4628]">
                    View all &rarr;
                </a>
            </div>


            {{-- Parents --}}
            <div class="dashboard-card flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="card-label">Parents</p>
                        <p class="card-empty text-[#155d36]">{{ $parentCount ?? 0 }}</p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-[#f2c94c]/20 text-amber-800 border border-[#f2c94c]/40 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>

                <a href="{{ route('parents.index') }}" class="card-link text-[#155d36] hover:text-[#0f4628]">
                    View all &rarr;
                </a>
            </div>


            {{-- Today's Present --}}
            <div class="dashboard-card flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="card-label">Today's Present</p>
                        <p class="card-empty text-[#155d36]">{{ $todayPresent ?? 0 }}</p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-[#155d36]/15 text-[#155d36] border border-[#155d36]/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>

                <a href="{{ route('attendance.index') }}" class="card-link text-[#155d36] hover:text-[#0f4628]">
                    View attendance &rarr;
                </a>
            </div>

        </div>


        {{-- =========================================================
             LOWER PANELS (ATTENDANCE OVERVIEW & RECENT SCANS)
        ========================================================== --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

            {{-- Attendance Overview Panel --}}
            <div class="dashboard-panel flex flex-col justify-between">

                <div class="panel-header">
                    <div>
                        <h2 class="panel-title text-[#155d36]">Attendance Overview</h2>
                        <p class="panel-subtitle">Today's attendance summary</p>
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col justify-center">

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-8 py-2">

                        {{-- DONUT CHART --}}
                        <div class="relative w-44 h-44 rounded-full flex items-center justify-center flex-shrink-0 shadow-xs"
                             style="background: conic-gradient(
                                 #155d36 0% {{ $presenceRate ?? 0 }}%,
                                 #e7e5e4 {{ $presenceRate ?? 0 }}% 100%
                             );">
                            <div class="w-32 h-32 bg-white rounded-full flex flex-col items-center justify-center shadow-inner">
                                <span class="text-3xl font-black text-[#155d36]">
                                    {{ $presenceRate ?? 0 }}%
                                </span>
                                <span class="text-[11px] font-medium text-stone-400 mt-0.5">
                                    Presence Rate
                                </span>
                            </div>
                        </div>

                        {{-- LEGEND & STATS --}}
                        <div class="space-y-3.5 min-w-[200px] w-full sm:w-auto">

                            <div class="flex items-center justify-between gap-6 p-2 rounded-xl bg-stone-50/70 border border-stone-100">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3 h-3 rounded-full bg-[#155d36] shadow-xs"></span>
                                    <span class="text-xs font-semibold text-stone-600">Present</span>
                                </div>
                                <span class="font-extrabold text-sm text-[#155d36]">{{ $todayPresent ?? 0 }}</span>
                            </div>

                            <div class="flex items-center justify-between gap-6 p-2 rounded-xl bg-stone-50/70 border border-stone-100">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3 h-3 rounded-full bg-[#4d88df] shadow-xs"></span>
                                    <span class="text-xs font-semibold text-stone-600">Inside Campus</span>
                                </div>
                                <span class="font-extrabold text-sm text-[#155d36]">{{ $insideCampus ?? 0 }}</span>
                            </div>

                            <div class="flex items-center justify-between gap-6 p-2 rounded-xl bg-stone-50/70 border border-stone-100">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3 h-3 rounded-full bg-[#f2c94c] shadow-xs"></span>
                                    <span class="text-xs font-semibold text-stone-600">Departed</span>
                                </div>
                                <span class="font-extrabold text-sm text-[#155d36]">{{ $departedCampus ?? 0 }}</span>
                            </div>

                            <div class="flex items-center justify-between gap-6 p-2 rounded-xl bg-stone-50/70 border border-stone-100">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3 h-3 rounded-full bg-[#eb5757] shadow-xs"></span>
                                    <span class="text-xs font-semibold text-stone-600">Absent / Unscanned</span>
                                </div>
                                <span class="font-extrabold text-sm text-[#155d36]">{{ $absentCount ?? 0 }}</span>
                            </div>

                        </div>

                    </div>

                    {{-- Positive Summary Status --}}
                    <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2 text-[#155d36] font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Gate scanning active and syncing live.</span>
                        </div>

                        <span class="text-stone-400 font-medium">Real-time attendance source</span>
                    </div>

                </div>

            </div>


            {{-- Recent Scans Panel --}}
            <div class="dashboard-panel">

                <div class="panel-header">
                    <div>
                        <h2 class="panel-title text-[#155d36]">Recent Scans</h2>
                        <p class="panel-subtitle">Latest campus presence records</p>
                    </div>

                    <a href="{{ route('attendance.index') }}" class="text-xs font-semibold text-[#155d36] hover:text-[#0f4628] transition">
                        View all &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-left border-collapse">

                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Student
                                </th>

                                <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Time
                                </th>

                                <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Status
                                </th>

                                <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Scanned By
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse ($recentScans ?? [] as $scan)
                                <tr class="hover:bg-slate-50/60 transition duration-150">
                                    <td class="py-3.5 px-5">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $scan->student?->photo_url }}"
                                                 alt="{{ $scan->student?->first_name }}"
                                                 class="w-9 h-9 rounded-full object-cover border border-slate-200 shadow-2xs" />
                                            <div>
                                                <p class="text-xs font-bold text-[#0e2c56]">
                                                    {{ $scan->student?->formatted_name ?? 'Student #' . $scan->student_id }}
                                                </p>
                                                <p class="text-[11px] text-slate-400">
                                                    {{ $scan->student?->student_no }} {{ $scan->student?->section ? '• Section ' . $scan->student?->section : '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-3.5 px-5 text-xs text-slate-600 whitespace-nowrap">
                                        <div>
                                            <span class="font-semibold text-slate-700">In:</span> {{ $scan->time_in ? \Carbon\Carbon::parse($scan->time_in)->format('h:i A') : '—' }}
                                        </div>
                                        @if ($scan->time_out)
                                            <div class="text-[11px] text-slate-400 mt-0.5">
                                                <span class="font-semibold text-slate-500">Out:</span> {{ \Carbon\Carbon::parse($scan->time_out)->format('h:i A') }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="py-3.5 px-5 whitespace-nowrap">
                                        @if ($scan->time_out)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200/80">
                                                Departed
                                            </span>
                                        @elseif ($scan->time_in)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                                Inside Campus
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                                {{ $scan->status ?? 'Present' }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-3.5 px-5 text-xs text-slate-500 whitespace-nowrap">
                                        {{ $scan->guardProfile ? ($scan->guardProfile->first_name . ' ' . $scan->guardProfile->last_name) : 'Gate Guard' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="h-56 flex flex-col items-center justify-center">
                                            <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100">
                                                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm font-semibold text-slate-400 mt-4">
                                                No recent scans today.
                                            </p>
                                            <p class="text-xs text-slate-300 mt-1">
                                                Scanned students will appear here.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-admin-layout>