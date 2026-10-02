@extends('layouts.parent')

@section('page-title', 'Parent Dashboard')
@section('page-subtitle', 'Monitor your child\'s campus presence and attendance')

@section('content')

<div class="space-y-6">

    @if($selectedStudent)

        {{-- =========================================================
             TOP BAR / CHILD SELECTOR HEADER
        ========================================================== --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div>
                <h1 class="text-2xl font-extrabold text-[#155d36]">
                    Parent Dashboard
                </h1>
                <p class="text-xs text-stone-500 mt-1">
                    Real-time campus presence logs for your family account.
                </p>
            </div>

            <div class="flex items-center gap-3">
                @if($children->count() > 1)
                    <div class="relative">
                        <select
                            onchange="if(this.value) window.location.href=this.value"
                            class="appearance-none bg-white border border-stone-200 rounded-xl pl-4 pr-9 py-2.5 text-xs font-bold text-[#155d36] shadow-xs focus:outline-none focus:ring-2 focus:ring-[#155d36]/20 cursor-pointer"
                        >
                            @foreach($children as $child)
                                <option
                                    value="{{ route('parent.dashboard', ['child_id' => $child->id]) }}"
                                    {{ $selectedStudent && $selectedStudent->id === $child->id ? 'selected' : '' }}
                                >
                                    Child: {{ $child->formatted_name }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="w-4 h-4 text-stone-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                @endif

                <div class="flex items-center gap-3 bg-white border border-stone-200 rounded-xl px-3.5 py-2 shadow-xs">
                    <div class="w-8 h-8 rounded-lg bg-[#4d88df]/15 text-[#4d88df] flex items-center justify-center font-bold text-xs">
                        <svg class="w-4 h-4 text-[#155d36]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-[9px] uppercase font-bold tracking-wider text-stone-400">
                            Parent Profile
                        </span>
                        <span class="block text-xs font-bold text-[#155d36]">
                            {{ $parent ? ($parent->first_name . ' ' . $parent->last_name) : (auth()->user()->name ?? 'Parent') }}
                        </span>
                    </div>
                </div>
            </div>

        </div>


        {{-- =========================================================
             CHILD SUMMARY BANNER
        ========================================================== --}}
        <div id="child-information" class="dashboard-panel p-6 border-t-4 border-t-[#155d36]">

            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6">

                {{-- Child Info --}}
                <div class="flex items-center gap-4">
                    <img
                        src="{{ $selectedStudent->photo_url }}"
                        alt="{{ $selectedStudent->formatted_name }}"
                        class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover border-2 border-white shadow-md ring-1 ring-stone-200"
                    >

                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-[10px] uppercase tracking-wider font-bold text-[#4d88df] bg-[#4d88df]/15 px-2 py-0.5 rounded-md border border-[#4d88df]/30">
                                Linked Student
                            </span>

                            <span class="px-2 py-0.5 rounded-md bg-stone-100 text-stone-600 font-mono text-[10px] font-bold">
                                {{ $selectedStudent->student_no }}
                            </span>
                        </div>

                        <h2 class="text-xl sm:text-2xl font-bold text-[#155d36] mt-1">
                            {{ $selectedStudent->formatted_name }}
                        </h2>

                        <p class="text-xs text-stone-500 mt-1">
                            Grade {{ $selectedStudent->grade_level }}
                            <span class="mx-1 text-stone-300">•</span>
                            Section {{ $selectedStudent->section ?: 'General' }}
                            <span class="mx-1 text-stone-300">•</span>
                            S.Y. 2026-2027
                        </p>
                    </div>
                </div>

                {{-- Today's Status Badge --}}
                <div class="xl:w-80">
                    @if($presenceStatus === 'Inside Campus')
                        <div class="rounded-2xl bg-[#155d36]/10 border border-[#155d36]/30 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-[#155d36] text-white flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block text-[9px] uppercase font-bold tracking-wider text-[#155d36]">
                                            Today's Status
                                        </span>
                                        <span class="block text-xs font-black text-[#155d36]">
                                            {{ $statusBadge['label'] }}
                                        </span>
                                    </div>
                                </div>
                                <span class="w-2.5 h-2.5 rounded-full bg-[#155d36] animate-pulse"></span>
                            </div>
                            <p class="text-[10px] text-[#155d36]/90 mt-2">
                                {{ $statusBadge['sub'] }}
                            </p>
                        </div>
                    @elseif($presenceStatus === 'Departed')
                        <div class="rounded-2xl bg-[#4d88df]/15 border border-[#4d88df]/30 p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#4d88df] text-white flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-[9px] uppercase font-bold tracking-wider text-[#4d88df]">
                                        Today's Status
                                    </span>
                                    <span class="block text-xs font-black text-[#1d4ed8]">
                                        {{ $statusBadge['label'] }}
                                    </span>
                                </div>
                            </div>
                            <p class="text-[10px] text-[#4d88df] mt-2 font-medium">
                                {{ $statusBadge['sub'] }}
                            </p>
                        </div>
                    @elseif($presenceStatus === 'Late')
                        <div class="rounded-2xl bg-[#f2c94c]/20 border border-[#f2c94c]/40 p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#f2c94c] text-stone-900 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-[9px] uppercase font-bold tracking-wider text-amber-800">
                                        Today's Status
                                    </span>
                                    <span class="block text-xs font-black text-amber-900">
                                        {{ $statusBadge['label'] }}
                                    </span>
                                </div>
                            </div>
                            <p class="text-[10px] text-amber-800 mt-2 font-medium">
                                {{ $statusBadge['sub'] }}
                            </p>
                        </div>
                    @elseif($presenceStatus === 'Excused')
                        <div class="rounded-2xl bg-purple-50 border border-purple-200/80 p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-[9px] uppercase font-bold tracking-wider text-purple-600">
                                        Today's Status
                                    </span>
                                    <span class="block text-xs font-black text-purple-800">
                                        {{ $statusBadge['label'] }}
                                    </span>
                                </div>
                            </div>
                            <p class="text-[10px] text-purple-700/80 mt-2">
                                {{ $statusBadge['sub'] }}
                            </p>
                        </div>
                    @else
                        <div class="rounded-2xl bg-[#eb5757]/15 border border-[#eb5757]/30 p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#eb5757] text-white flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-[9px] uppercase font-bold tracking-wider text-[#eb5757]">
                                        Today's Status
                                    </span>
                                    <span class="block text-xs font-black text-[#eb5757]">
                                        {{ $statusBadge['label'] }}
                                    </span>
                                </div>
                            </div>
                            <p class="text-[10px] text-[#eb5757] mt-2 font-medium">
                                {{ $statusBadge['sub'] }}
                            </p>
                        </div>
                    @endif
                </div>

            </div>

            {{-- Today's Gate Activity --}}
            <div class="mt-6 pt-4 border-t border-stone-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <span class="block text-[10px] uppercase tracking-wider font-bold text-stone-400">
                        Today's Gate Activity
                    </span>
                    <span class="block text-xs text-stone-500 mt-0.5">
                        {{ \Carbon\Carbon::parse($today)->format('F d, Y') }}
                    </span>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-2 bg-stone-50 border border-stone-200 px-3.5 py-2 rounded-xl shadow-2xs">
                        <div class="w-7 h-7 rounded-lg {{ $todayAttendance && $todayAttendance->time_in ? 'bg-[#155d36]/15 text-[#155d36]' : 'bg-stone-200 text-stone-400' }} flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"/>
                            </svg>
                        </div>
                        <div>
                            <span class="block text-[9px] uppercase font-bold text-stone-400">Gate In</span>
                            <span class="block text-xs font-bold font-mono text-[#155d36]">
                                {{ $todayAttendance && $todayAttendance->time_in ? \Carbon\Carbon::parse($todayAttendance->time_in)->format('h:i A') : 'Not yet' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 bg-stone-50 border border-stone-200 px-3.5 py-2 rounded-xl shadow-2xs">
                        <div class="w-7 h-7 rounded-lg {{ $todayAttendance && $todayAttendance->time_out ? 'bg-[#4d88df]/15 text-[#4d88df]' : 'bg-stone-200 text-stone-400' }} flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l4-4m4 4H7"/>
                            </svg>
                        </div>
                        <div>
                            <span class="block text-[9px] uppercase font-bold text-stone-400">Gate Out</span>
                            <span class="block text-xs font-bold font-mono text-[#155d36]">
                                {{ $todayAttendance && $todayAttendance->time_out ? \Carbon\Carbon::parse($todayAttendance->time_out)->format('h:i A') : 'Not yet' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        {{-- =========================================================
             ATTENDANCE SUMMARY STAT CARDS
        ========================================================== --}}
        <div id="attendance-summary" class="space-y-3">
            <div>
                <h2 class="text-base font-bold text-[#155d36]">
                    Attendance Summary
                </h2>
                <p class="text-xs text-stone-400 mt-0.5">
                    Attendance overview for {{ $selectedStudent->first_name }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5">

                {{-- Attendance Rate --}}
                <div class="dashboard-card flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="card-label">Attendance Rate</p>
                            <p class="card-empty text-[#155d36]">{{ $stats['attendance_rate'] }}%</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-[#4d88df]/15 text-[#4d88df] border border-[#4d88df]/30 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                    </div>
                    <div class="w-full bg-stone-100 rounded-full h-1.5 mt-3">
                        <div
                            class="bg-[#155d36] h-1.5 rounded-full"
                            style="width: {{ min(100, max(0, $stats['attendance_rate'])) }}%"
                        ></div>
                    </div>
                </div>

                {{-- Present --}}
                <div class="dashboard-card flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="card-label text-[#155d36]">Present</p>
                            <p class="card-empty text-[#155d36]">{{ $stats['total_present'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-[#155d36]/15 text-[#155d36] border border-[#155d36]/30 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-stone-400 mt-2">Days logged present</p>
                </div>

                {{-- Late --}}
                <div class="dashboard-card flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="card-label text-amber-700">Late</p>
                            <p class="card-empty text-amber-700">{{ $stats['total_late'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-[#f2c94c]/20 text-amber-800 border border-[#f2c94c]/40 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-stone-400 mt-2">Late arrivals</p>
                </div>

                {{-- Absent --}}
                <div class="dashboard-card flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="card-label text-[#eb5757]">Absent</p>
                            <p class="card-empty text-[#eb5757]">{{ $stats['total_absent'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-[#eb5757]/15 text-[#eb5757] border border-[#eb5757]/30 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-stone-400 mt-2">Days absent</p>
                </div>

                {{-- Excused --}}
                <div class="dashboard-card flex flex-col justify-between">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="card-label text-purple-700">Excused</p>
                            <p class="card-empty text-purple-600">{{ $stats['total_excused'] }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 border border-purple-100 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-stone-400 mt-2">Authorized absence</p>
                </div>

            </div>
        </div>


        {{-- =========================================================
             LOWER SECTION: RECENT ATTENDANCE & ANNOUNCEMENTS
        ========================================================== --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- Recent Attendance Table (2 cols) --}}
            <div class="xl:col-span-2 dashboard-panel">
                <div class="panel-header">
                    <div>
                        <h2 class="panel-title text-[#155d36]">Recent Attendance</h2>
                        <p class="panel-subtitle">Recent gate attendance records for {{ $selectedStudent->first_name }}</p>
                    </div>

                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-[#4d88df]/15 text-[#4d88df] border border-[#4d88df]/30">
                        {{ $attendanceLogs->count() }} Records
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-stone-100 bg-stone-50/50">
                                <th class="py-3 px-5 text-xs font-semibold text-stone-400 uppercase tracking-wider">Date</th>
                                <th class="py-3 px-5 text-xs font-semibold text-stone-400 uppercase tracking-wider">Time In</th>
                                <th class="py-3 px-5 text-xs font-semibold text-stone-400 uppercase tracking-wider">Time Out</th>
                                <th class="py-3 px-5 text-xs font-semibold text-stone-400 uppercase tracking-wider text-right">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-stone-100">
                            @forelse($attendanceLogs as $log)
                                <tr class="hover:bg-stone-50/60 transition duration-150">
                                    <td class="py-3.5 px-5">
                                        <span class="block font-bold text-[#155d36] text-xs">
                                            {{ $log->attendance_date ? $log->attendance_date->format('M d, Y') : '—' }}
                                        </span>
                                        <span class="block text-[10px] text-stone-400">
                                            {{ $log->attendance_date ? $log->attendance_date->format('l') : '' }}
                                        </span>
                                    </td>

                                    <td class="py-3.5 px-5 text-xs font-medium text-stone-600 font-mono">
                                        {{ $log->time_in ? \Carbon\Carbon::parse($log->time_in)->format('h:i A') : '—' }}
                                    </td>

                                    <td class="py-3.5 px-5 text-xs font-medium text-stone-600 font-mono">
                                        {{ $log->time_out ? \Carbon\Carbon::parse($log->time_out)->format('h:i A') : '—' }}
                                    </td>

                                    <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                        @if($log->status === 'Present')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#155d36]/10 text-[#155d36] border border-[#155d36]/30">
                                                Present
                                            </span>
                                        @elseif($log->status === 'Late')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#f2c94c]/20 text-amber-800 border border-[#f2c94c]/40">
                                                Late
                                            </span>
                                        @elseif($log->status === 'Excused')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200/80">
                                                Excused
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#eb5757]/15 text-[#eb5757] border border-[#eb5757]/30">
                                                Absent
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="h-56 flex flex-col items-center justify-center text-center p-6">
                                            <div class="w-12 h-12 rounded-full bg-stone-50 flex items-center justify-center border border-stone-100">
                                                <svg class="w-5 h-5 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm font-semibold text-stone-400 mt-4">
                                                No past attendance logs found
                                            </p>
                                            <p class="text-xs text-stone-300 mt-1">
                                                Logs will be generated upon scanning at the campus gate.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($attendanceLogs->count())
                    <div class="px-6 py-3 bg-stone-50 border-t border-stone-100 flex items-center gap-2 text-xs text-stone-400">
                        <svg class="w-4 h-4 text-[#155d36]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Attendance records are verified through the campus gate terminal system.</span>
                    </div>
                @endif
            </div>

            {{-- Announcements (1 col) --}}
            <div id="announcements" class="dashboard-panel flex flex-col justify-between">
                <div>
                    <div class="panel-header">
                        <div>
                            <h2 class="panel-title text-[#155d36]">Announcements</h2>
                            <p class="panel-subtitle">Latest school updates</p>
                        </div>

                        <div class="w-10 h-10 rounded-xl bg-[#4d88df]/15 text-[#4d88df] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="p-5 space-y-4">
                        @forelse($announcements as $memo)
                            <article class="p-4 rounded-xl bg-stone-50/80 border border-stone-100 space-y-2">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="text-xs font-bold text-[#155d36] leading-snug">
                                        {{ $memo->title }}
                                    </h3>

                                    <span class="text-[10px] text-stone-400 font-mono shrink-0">
                                        {{ $memo->created_at ? $memo->created_at->format('M d') : '' }}
                                    </span>
                                </div>

                                <p class="text-xs text-stone-600 leading-relaxed">
                                    {{ \Illuminate\Support\Str::limit($memo->content, 120) }}
                                </p>

                                @if($memo->teacher)
                                    <span class="block text-[10px] text-[#4d88df] font-semibold mt-1">
                                        By Teacher {{ $memo->teacher->first_name }} {{ $memo->teacher->last_name }}
                                    </span>
                                @endif
                            </article>
                        @empty
                            <div class="text-center py-10">
                                <div class="w-12 h-12 rounded-full bg-stone-50 flex items-center justify-center border border-stone-100 mx-auto mb-3">
                                    <svg class="w-5 h-5 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold text-stone-500">
                                    No current school announcements
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>


        {{-- =========================================================
             BOTTOM SECTION: NOTIFICATIONS & PARENT CONTACT
        ========================================================== --}}
        <div id="notifications" class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Notification info --}}
            <div class="dashboard-panel p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-[#155d36]/15 text-[#155d36] border border-[#155d36]/30 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="panel-title text-[#155d36]">SMS Notifications</h2>
                        <p class="panel-subtitle">Campus presence updates</p>
                    </div>
                </div>

                <div class="rounded-xl bg-[#155d36]/10 border border-[#155d36]/30 p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-[#155d36] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs text-[#155d36] leading-relaxed font-medium">
                            Gate arrival and departure logs are recorded in real-time. Instant SMS notification logs are directly connected to your registered parent mobile number.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Parent profile contact --}}
            <div class="dashboard-panel p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-[#4d88df]/15 text-[#4d88df] border border-[#4d88df]/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#155d36]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="panel-title text-[#155d36]">Parent Contact Information</h2>
                        <p class="panel-subtitle">Registered account profile</p>
                    </div>
                </div>

                <div class="space-y-3 divide-y divide-stone-100">
                    <div class="flex items-center justify-between gap-3 pt-1">
                        <span class="text-xs text-stone-400 font-medium">Guardian Name</span>
                        <span class="text-xs font-bold text-[#155d36]">
                            {{ $parent ? ($parent->first_name . ' ' . $parent->last_name) : (auth()->user()->name ?? 'Parent') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between gap-3 pt-3">
                        <span class="text-xs text-stone-400 font-medium">Mobile Number</span>
                        <span class="text-xs font-mono font-bold text-[#4d88df] bg-[#4d88df]/15 px-2.5 py-1 rounded-lg border border-[#4d88df]/30">
                            {{ $parent && $parent->phone ? $parent->phone : 'Registered Phone' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between gap-3 pt-3">
                        <span class="text-xs text-stone-400 font-medium">Address</span>
                        <span class="text-xs font-semibold text-stone-700 text-right truncate max-w-[200px]">
                            {{ $parent && $parent->address ? $parent->address : 'Sorsogon City' }}
                        </span>
                    </div>
                </div>
            </div>

        </div>

    @else

        {{-- =========================================================
             NO CHILD LINKED STATE
        ========================================================== --}}
        <div class="max-w-xl mx-auto py-16">
            <div class="dashboard-panel p-10 text-center">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4 border border-blue-100">
                    <svg class="w-8 h-8 text-[#123b70]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>

                <h3 class="text-lg font-bold text-[#0e2c56]">
                    No Student Linked Yet
                </h3>

                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Your parent account is active, but no student has been attached to your profile yet.
                    Please contact the School Registrar or Administrator with your student's ID number.
                </p>
            </div>
        </div>

    @endif

</div>

@endsection
