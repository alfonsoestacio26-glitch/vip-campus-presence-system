@extends('layouts.teacher')

@section('page-title', 'Attendance')
@section('page-subtitle', 'Monitor student campus attendance records and presence logs')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
         PAGE HEADER & FILTER FORM
    ========================================================== --}}
    <div class="dashboard-panel p-6">
        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5">

            {{-- Title --}}
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#0e2c56] border border-blue-100/50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>

                <div>
                    <h1 class="text-xl font-bold text-[#0e2c56]">
                        Attendance Monitoring
                    </h1>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Monitor student campus attendance records and presence logs.
                    </p>
                </div>
            </div>

            {{-- Filters --}}
            <form
                method="GET"
                action="{{ route('teacher.attendance.index') }}"
                class="flex flex-wrap items-center gap-3"
            >
                {{-- Search --}}
                <div class="relative min-w-[200px] w-full sm:w-auto">
                    <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search student..."
                        class="w-full sm:w-56 pl-9 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-[#0e2c56]/20 focus:border-[#0e2c56] transition"
                    >
                    @if(request('search'))
                        <a href="{{ route('teacher.attendance.index', request()->except('search')) }}" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 transition" title="Clear search">
                            &times;
                        </a>
                    @endif
                </div>

                {{-- Date --}}
                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <input
                        type="date"
                        name="date"
                        value="{{ request('date') }}"
                        class="bg-transparent border-0 p-0 text-xs font-semibold text-slate-700 focus:ring-0 cursor-pointer"
                    >
                </div>

                {{-- Status --}}
                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <select
                        name="status"
                        class="bg-transparent border-0 p-0 text-xs font-semibold text-slate-700 focus:ring-0 cursor-pointer"
                    >
                        <option value="">All Status</option>
                        <option value="Present" {{ request('status') === 'Present' ? 'selected' : '' }}>Present</option>
                        <option value="Late" {{ request('status') === 'Late' ? 'selected' : '' }}>Late</option>
                        <option value="Absent" {{ request('status') === 'Absent' ? 'selected' : '' }}>Absent</option>
                        <option value="Excused" {{ request('status') === 'Excused' ? 'selected' : '' }}>Excused</option>
                    </select>
                </div>

                {{-- Filter Button --}}
                <button
                    type="submit"
                    class="px-4 py-2 rounded-xl bg-[#155d36] hover:bg-[#0f4628] active:bg-[#09321c] text-white text-xs font-semibold shadow-xs transition flex items-center gap-1.5 border border-[#155d36]"
                >
                    Filter
                </button>

                @if(request('search') || request('date') || request('status'))
                    <a
                        href="{{ route('teacher.attendance.index') }}"
                        class="px-3 py-2 text-xs text-rose-600 hover:text-rose-800 font-semibold"
                    >
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>


    {{-- =========================================================
         SUMMARY CARDS
    ========================================================== --}}
    @php
        $currentRecords = $attendances->getCollection();

        $presentCount = $currentRecords
            ->filter(fn($item) => strtolower($item->status ?? '') === 'present')
            ->count();

        $lateCount = $currentRecords
            ->filter(fn($item) => strtolower($item->status ?? '') === 'late')
            ->count();

        $excusedCount = $currentRecords
            ->filter(fn($item) => strtolower($item->status ?? '') === 'excused')
            ->count();

        $absentCount = $currentRecords
            ->filter(fn($item) => strtolower($item->status ?? '') === 'absent')
            ->count();
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

        {{-- Present --}}
        <div class="dashboard-card flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="card-label text-emerald-700">Present</p>
                    <p class="card-empty text-emerald-600">{{ $presentCount }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-slate-400 mt-2">Attendance records</p>
        </div>

        {{-- Late --}}
        <div class="dashboard-card flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="card-label text-amber-700">Late</p>
                    <p class="card-empty text-amber-600">{{ $lateCount }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-slate-400 mt-2">Late arrivals</p>
        </div>

        {{-- Excused --}}
        <div class="dashboard-card flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="card-label text-purple-700">Excused</p>
                    <p class="card-empty text-purple-600">{{ $excusedCount }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 border border-purple-100 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-slate-400 mt-2">With teacher note</p>
        </div>

        {{-- Absent --}}
        <div class="dashboard-card flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="card-label text-rose-700">Absent</p>
                    <p class="card-empty text-rose-600">{{ $absentCount }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 border border-rose-100 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-slate-400 mt-2">Not checked in</p>
        </div>

    </div>


    {{-- =========================================================
         ATTENDANCE RECORDS TABLE
    ========================================================== --}}
    <div class="dashboard-panel">

        <div class="panel-header">
            <div>
                <h2 class="panel-title flex items-center gap-2">
                    <span>Attendance Records</span>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700">
                        {{ $attendances->total() }}
                    </span>
                </h2>
                <p class="panel-subtitle">
                    @if(request('date'))
                        Attendance logs for {{ \Carbon\Carbon::parse(request('date'))->format('F d, Y') }}
                    @else
                        Student campus attendance history
                    @endif
                </p>
            </div>

            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0e2c56] flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>


        @if($attendances->count())

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/50">
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Student</th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Level & Section</th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Date</th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Time In</th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Time Out</th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Campus Presence</th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider text-right">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach($attendances as $attendance)
                            @php
                                $status = strtolower($attendance->status ?? '');
                                $student = $attendance->student;
                            @endphp

                            <tr class="hover:bg-slate-50/60 transition duration-150">
                                {{-- Student --}}
                                <td class="py-3.5 px-5">
                                    <div class="flex items-center gap-3">
                                        @if($student?->photo_url)
                                            <img
                                                src="{{ $student->photo_url }}"
                                                alt="Student"
                                                class="w-9 h-9 rounded-full object-cover border border-slate-200 shadow-2xs shrink-0"
                                            >
                                        @else
                                            <div class="w-9 h-9 rounded-full bg-blue-50 text-[#0e2c56] flex items-center justify-center border border-slate-200">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                        @endif

                                        <div>
                                            <p class="text-xs font-bold text-[#0e2c56] leading-tight">
                                                {{ $student?->formatted_name ?? ($student?->first_name . ' ' . $student?->last_name) }}
                                            </p>
                                            <span class="text-[11px] font-mono text-slate-400">
                                                {{ $student?->student_no ?? '—' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Level & Section --}}
                                <td class="py-3.5 px-5 text-xs text-slate-600">
                                    @if($student)
                                        <span class="font-semibold text-slate-700">Grade {{ $student->grade_level }}</span>
                                        <span class="text-slate-400 block text-[11px]">{{ $student->section ?: 'General' }}</span>
                                    @else
                                        <span class="text-slate-300">—</span>
                                    @endif
                                </td>

                                {{-- Date --}}
                                <td class="py-3.5 px-5 text-xs text-slate-600 font-medium">
                                    {{ $attendance->attendance_date ? \Carbon\Carbon::parse($attendance->attendance_date)->format('M d, Y') : '—' }}
                                </td>

                                {{-- Time In --}}
                                <td class="py-3.5 px-5 text-xs font-mono">
                                    @if($attendance->time_in)
                                        <span class="font-semibold text-slate-800">
                                            {{ \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') }}
                                        </span>
                                        <span class="text-[10px] text-emerald-600 block">Gate In Verified</span>
                                    @else
                                        <span class="text-slate-300 font-sans">—</span>
                                    @endif
                                </td>

                                {{-- Time Out --}}
                                <td class="py-3.5 px-5 text-xs font-mono">
                                    @if($attendance->time_out)
                                        <span class="font-semibold text-slate-800">
                                            {{ \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') }}
                                        </span>
                                        <span class="text-[10px] text-sky-600 block">Gate Out Verified</span>
                                    @elseif($attendance->time_in)
                                        <span class="text-amber-500 font-sans text-[11px] italic">Still inside</span>
                                    @else
                                        <span class="text-slate-300 font-sans">—</span>
                                    @endif
                                </td>

                                {{-- Campus Presence --}}
                                <td class="py-3.5 px-5 text-xs whitespace-nowrap">
                                    @if($attendance->time_in && !$attendance->time_out)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Inside Campus
                                        </span>
                                    @elseif($attendance->time_out)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200/80">
                                            Departed
                                        </span>
                                    @elseif($status === 'excused')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200/80">
                                            Excused
                                        </span>
                                    @else
                                        <span class="text-slate-300">—</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                    @if($status === 'present')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                            Present
                                        </span>
                                    @elseif($status === 'late')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200/80">
                                            Late
                                        </span>
                                    @elseif($status === 'excused')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200/80">
                                            Excused
                                        </span>
                                    @elseif($status === 'absent')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200/80">
                                            Absent
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                            {{ $attendance->status ?? 'Unknown' }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $attendances->links() }}
            </div>

        @else

            {{-- Empty State --}}
            <div class="h-64 flex flex-col items-center justify-center text-center p-6">
                <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100">
                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-500 mt-4">
                    No attendance records found
                </h3>
                <p class="text-xs text-slate-400 mt-1">
                    Try changing your search, date, or status filter.
                </p>
            </div>

        @endif

    </div>

</div>

@endsection