@extends('layouts.teacher')

@section('page-title', 'Teacher Presence Dashboard')

@section('content')

<div class="max-w-7xl mx-auto" x-data="{
    excuseModal: false,
    selectedStudent: null,
    selectedStatus: 'Excused',
    selectedRemarks: '',
    openExcuseModal(student, currentStatus, currentRemarks) {
        this.selectedStudent = student;
        this.selectedStatus = currentStatus === 'Absent' ? 'Excused' : currentStatus;
        this.selectedRemarks = currentRemarks || '';
        this.excuseModal = true;
    },
    setQuickRemark(text) {
        this.selectedRemarks = text;
        this.selectedStatus = 'Excused';
    }
}">

    {{-- SUCCESS ALERT --}}
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-2xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    {{-- PAGE HEADER & SECTION FILTER --}}
    <div class="bg-white border border-slate-200 rounded-3xl p-6 mb-7 shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
            <div>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-[#0e2c56] text-white flex items-center justify-center shadow-md shadow-[#0e2c56]/10">
                        <i class="fa-solid fa-chalkboard-user text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-[#0e2c56]">
                            Class Presence & Attendance Terminal
                        </h1>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Real-time gate verification, section monitoring, and absence/excuse management
                        </p>
                    </div>
                </div>
            </div>

            {{-- FILTER FORM --}}
            <form method="GET" action="{{ route('teacher.dashboard') }}" class="flex flex-wrap items-center gap-3">
                {{-- Date Filter --}}
                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                    <i class="fa-regular fa-calendar text-slate-400"></i>
                    <input 
                        type="date" 
                        name="date" 
                        value="{{ $selectedDate }}" 
                        onchange="this.form.submit()"
                        class="bg-transparent border-0 p-0 text-xs font-semibold text-slate-700 focus:ring-0 cursor-pointer"
                    >
                </div>

                {{-- Section Filter --}}
                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                    <i class="fa-solid fa-layer-group text-slate-400"></i>
                    <select 
                        name="section" 
                        onchange="this.form.submit()"
                        class="bg-transparent border-0 p-0 text-xs font-semibold text-slate-700 focus:ring-0 cursor-pointer"
                    >
                        <option value="">All Sections</option>
                        @foreach($sections as $sec)
                            <option value="{{ $sec }}" {{ $selectedSection == $sec ? 'selected' : '' }}>
                                Section {{ $sec }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Grade Filter --}}
                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs">
                    <i class="fa-solid fa-graduation-cap text-slate-400"></i>
                    <select 
                        name="grade_level" 
                        onchange="this.form.submit()"
                        class="bg-transparent border-0 p-0 text-xs font-semibold text-slate-700 focus:ring-0 cursor-pointer"
                    >
                        <option value="">All Grades</option>
                        @foreach($gradeLevels as $gl)
                            <option value="{{ $gl }}" {{ $selectedGrade == $gl ? 'selected' : '' }}>
                                Grade {{ $gl }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if($selectedSection || $selectedGrade || $selectedDate != \Carbon\Carbon::now('Asia/Manila')->toDateString() || $search)
                    <a 
                        href="{{ route('teacher.dashboard') }}" 
                        class="text-xs text-rose-600 hover:text-rose-800 font-semibold px-2 py-2"
                        title="Reset Filters"
                    >
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>


    {{-- ============================================== --}}
    {{-- KPI METRICS CARDS --}}
    {{-- ============================================== --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4 mb-7">

        {{-- TOTAL ENROLLED --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Cohort Enrolled</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-[#0e2c56]">{{ $totalStudents }}</span>
                <span class="text-[11px] text-slate-400 block mt-0.5">Students registered</span>
            </div>
        </div>

        {{-- CURRENTLY INSIDE CAMPUS --}}
        <div class="bg-white border border-emerald-200/80 rounded-2xl p-4 shadow-sm relative overflow-hidden bg-gradient-to-b from-white to-emerald-50/20">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-emerald-700 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    Inside Campus
                </span>
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-school-flag"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-emerald-600">{{ $insideCampus }}</span>
                <span class="text-[11px] text-emerald-600/80 block mt-0.5">On grounds now</span>
            </div>
        </div>

        {{-- DEPARTED --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Departed</span>
                <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-door-open"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-sky-700">{{ $departedToday }}</span>
                <span class="text-[11px] text-slate-400 block mt-0.5">Scanned out</span>
            </div>
        </div>

        {{-- TARDY / LATE --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500">Tardy / Late</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-amber-600">{{ $lateToday }}</span>
                <span class="text-[11px] text-slate-400 block mt-0.5">Past cutoff</span>
            </div>
        </div>

        {{-- EXCUSED --}}
        <div class="bg-white border border-purple-200/80 rounded-2xl p-4 shadow-sm relative overflow-hidden bg-gradient-to-b from-white to-purple-50/20">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-purple-700">Excused</span>
                <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-purple-700">{{ $excusedToday }}</span>
                <span class="text-[11px] text-purple-600/80 block mt-0.5">With teacher note</span>
            </div>
        </div>

        {{-- UNEXCUSED / ABSENT --}}
        <div class="bg-white border border-rose-200/80 rounded-2xl p-4 shadow-sm relative overflow-hidden bg-gradient-to-b from-white to-rose-50/20">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-rose-700">Absent</span>
                <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-user-xmark"></i>
                </div>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-black text-rose-600">{{ $absentToday }}</span>
                <span class="text-[11px] text-rose-600/80 block mt-0.5">Not checked in</span>
            </div>
        </div>

    </div>


    {{-- ============================================== --}}
    {{-- MAIN GRID: STUDENT ROSTER & LIVE FEED --}}
    {{-- ============================================== --}}
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-7 mb-8">

        {{-- STUDENT ATTENDANCE LIST (3 COLS) --}}
        <div class="xl:col-span-3 bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden flex flex-col">
            
            {{-- HEADER & SEARCH --}}
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-base font-bold text-[#0e2c56] flex items-center gap-2">
                        <span>Student Section Presence</span>
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700">
                            {{ $students->count() }} enrolled
                        </span>
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Presence verification logs for {{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}
                    </p>
                </div>

                {{-- Search inside cohort --}}
                <form method="GET" action="{{ route('teacher.dashboard') }}" class="relative w-full sm:w-64">
                    <input type="hidden" name="date" value="{{ $selectedDate }}">
                    <input type="hidden" name="section" value="{{ $selectedSection }}">
                    <input type="hidden" name="grade_level" value="{{ $selectedGrade }}">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search }}" 
                        placeholder="Search student or ID..." 
                        class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-[#0e2c56]/20 focus:border-[#0e2c56]"
                    >
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] uppercase font-bold text-slate-400 tracking-wider">
                            <th class="py-3.5 px-6">Student</th>
                            <th class="py-3.5 px-4">Level & Section</th>
                            <th class="py-3.5 px-4">Time In</th>
                            <th class="py-3.5 px-4">Time Out</th>
                            <th class="py-3.5 px-4">Campus Presence</th>
                            <th class="py-3.5 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($students as $student)
                            @php
                                $att = $student->attendance_record;
                                $status = $student->presence_status;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition group">
                                {{-- Student Profile --}}
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <img 
                                            src="{{ $student->photo_url }}" 
                                            alt="{{ $student->first_name }}"
                                            class="w-10 h-10 rounded-xl object-cover border border-slate-200 shadow-sm shrink-0"
                                        >
                                        <div>
                                            <a href="{{ route('teacher.students.show', $student) }}" class="font-bold text-[#0e2c56] hover:text-blue-600 transition block leading-tight">
                                                {{ $student->first_name }}
                                                @if($student->middle_name)
                                                    {{ substr($student->middle_name, 0, 1) }}.
                                                @endif
                                                {{ $student->last_name }}
                                            </a>
                                            <span class="text-[11px] font-mono text-slate-400">{{ $student->student_no }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Level & Section --}}
                                <td class="py-4 px-4 text-slate-600">
                                    <span class="font-semibold text-slate-700">Grade {{ $student->grade_level }}</span>
                                    <span class="text-slate-400 block text-[11px]">{{ $student->section ?: 'General' }}</span>
                                </td>

                                {{-- Time In --}}
                                <td class="py-4 px-4 font-mono">
                                    @if($att && $att->time_in)
                                        <span class="font-semibold text-slate-800">
                                            {{ \Carbon\Carbon::parse($att->time_in)->format('h:i A') }}
                                        </span>
                                        <span class="text-[10px] text-emerald-600 block">Gate In Verified</span>
                                    @else
                                        <span class="text-slate-300 font-sans">—</span>
                                    @endif
                                </td>

                                {{-- Time Out --}}
                                <td class="py-4 px-4 font-mono">
                                    @if($att && $att->time_out)
                                        <span class="font-semibold text-slate-800">
                                            {{ \Carbon\Carbon::parse($att->time_out)->format('h:i A') }}
                                        </span>
                                        <span class="text-[10px] text-sky-600 block">Gate Out Verified</span>
                                    @elseif($att && $att->time_in)
                                        <span class="text-amber-500 font-sans text-[11px] italic">Still inside</span>
                                    @else
                                        <span class="text-slate-300 font-sans">—</span>
                                    @endif
                                </td>

                                {{-- Status Badge --}}
                                <td class="py-4 px-4">
                                    @if($status === 'Inside Campus')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Inside Campus
                                        </span>
                                    @elseif($status === 'Departed')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                            <i class="fa-solid fa-person-walking-arrow-right text-[10px]"></i>
                                            Departed
                                        </span>
                                    @elseif($status === 'Late')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <i class="fa-solid fa-clock text-[10px]"></i>
                                            Late Arrival
                                        </span>
                                    @elseif($status === 'Excused')
                                        <div class="group/excuse relative inline-block">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-purple-50 text-purple-700 border border-purple-200 cursor-pointer">
                                                <i class="fa-solid fa-notes-medical text-[10px]"></i>
                                                Excused
                                            </span>
                                            @if($att && $att->remarks)
                                                <span class="text-[11px] text-purple-600 block mt-0.5 truncate max-w-[140px]" title="{{ $att->remarks }}">
                                                    {{ $att->remarks }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Absent
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions: Excuse / Update --}}
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button 
                                            type="button"
                                            @click="openExcuseModal({{ json_encode($student) }}, '{{ $att ? $att->status : 'Absent' }}', '{{ $att ? addslashes($att->remarks) : '' }}')"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-[#0e2c56] hover:text-white text-slate-700 rounded-lg text-xs font-semibold transition shadow-sm"
                                            title="Mark Excused or Adjust Attendance"
                                        >
                                            <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                            <span>Excuse / Edit</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center">
                                    <div class="max-w-xs mx-auto text-slate-400">
                                        <i class="fa-solid fa-clipboard-question text-4xl mb-3 text-slate-300"></i>
                                        <p class="font-bold text-slate-600 text-sm">No students found</p>
                                        <p class="text-xs text-slate-400 mt-1">Try adjusting section or grade filters above.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- FOOTER / ATTENDANCE RATE --}}
            <div class="p-5 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-slate-500">
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-slate-700">Section Attendance Rate:</span>
                    <span class="px-2.5 py-0.5 rounded-full font-bold {{ $presenceRate >= 80 ? 'bg-emerald-100 text-emerald-700' : ($presenceRate >= 50 ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                        {{ $presenceRate }}%
                    </span>
                    <span class="text-slate-400">({{ $presentToday }} of {{ $totalStudents }} students present)</span>
                </div>

                <a href="{{ route('teacher.attendance.index') }}" class="font-semibold text-[#0e2c56] hover:underline flex items-center gap-1">
                    <span>View Full Log History</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

        </div>


        {{-- SIDEBAR: GATE SCAN FEED & SUMMARY (1 COL) --}}
        <div class="space-y-6">

            {{-- SECTION SUMMARY RADIAL PROGRESS --}}
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-[#0e2c56] mb-1">Presence Distribution</h3>
                <p class="text-xs text-slate-400 mb-6">Current campus breakdown</p>

                <div class="flex flex-col items-center">
                    <div 
                        class="w-36 h-36 rounded-full flex items-center justify-center p-3.5 shadow-inner"
                        style="background: conic-gradient(
                            #10b981 0% {{ $presenceRate }}%,
                            #cbd5e1 {{ $presenceRate }}% 100%
                        );"
                    >
                        <div class="w-full h-full bg-white rounded-full flex flex-col items-center justify-center shadow-sm">
                            <span class="text-2xl font-black text-[#0e2c56]">{{ $presenceRate }}%</span>
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Present</span>
                        </div>
                    </div>

                    <div class="w-full mt-6 space-y-2.5 text-xs">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                <span class="text-slate-600 font-medium">Inside Campus</span>
                            </div>
                            <span class="font-bold text-slate-800">{{ $insideCampus }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                                <span class="text-slate-600 font-medium">Departed</span>
                            </div>
                            <span class="font-bold text-slate-800">{{ $departedToday }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                                <span class="text-slate-600 font-medium">Excused</span>
                            </div>
                            <span class="font-bold text-slate-800">{{ $excusedToday }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                                <span class="text-slate-600 font-medium">Absent</span>
                            </div>
                            <span class="font-bold text-slate-800">{{ $absentToday }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- LIVE GATE SCANS WIDGET --}}
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-[#0e2c56]">Live Gate Scans</h3>
                        <p class="text-[11px] text-slate-400">Terminal kiosk feed</p>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" title="Live Gateway Feed Active"></span>
                </div>

                <div class="space-y-3">
                    @forelse($recentScans as $scan)
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                            <div class="flex items-center gap-2.5 truncate">
                                <img src="{{ $scan->student->photo_url }}" class="w-8 h-8 rounded-lg object-cover border border-slate-200 shrink-0">
                                <div class="truncate">
                                    <p class="font-bold text-[#0e2c56] truncate">
                                        {{ $scan->student->first_name }} {{ $scan->student->last_name }}
                                    </p>
                                    <p class="text-[10px] text-slate-400 font-mono">
                                        {{ $scan->student->student_no }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                @if($scan->time_out)
                                    <span class="text-[10px] font-bold text-sky-700 bg-sky-100 px-2 py-0.5 rounded-md">OUT</span>
                                    <span class="block text-[10px] font-mono text-slate-500 mt-0.5">
                                        {{ \Carbon\Carbon::parse($scan->time_out)->format('h:i A') }}
                                    </span>
                                @else
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md">IN</span>
                                    <span class="block text-[10px] font-mono text-slate-500 mt-0.5">
                                        {{ \Carbon\Carbon::parse($scan->time_in)->format('h:i A') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 text-xs">
                            <i class="fa-solid fa-qrcode text-2xl mb-2 text-slate-300"></i>
                            <p>No gate scans recorded yet for this date.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>


    {{-- ============================================== --}}
    {{-- MODAL: EXCUSE / UPDATE ATTENDANCE --}}
    {{-- ============================================== --}}
    <div 
        x-show="excuseModal" 
        style="display: none;"
        class="fixed inset-0 z-50 overflow-y-auto"
        role="dialog"
        aria-modal="true"
    >
        {{-- Backdrop --}}
        <div 
            x-show="excuseModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
            @click="excuseModal = false"
        ></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div 
                x-show="excuseModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all w-full max-w-md border border-slate-200"
            >
                <form method="POST" action="{{ route('teacher.attendance.status') }}">
                    @csrf
                    <input type="hidden" name="attendance_date" value="{{ $selectedDate }}">
                    <input type="hidden" name="student_id" :value="selectedStudent ? selectedStudent.id : ''">

                    {{-- MODAL HEADER --}}
                    <div class="bg-gradient-to-r from-[#0e2c56] to-[#123b70] p-6 text-white flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-bold flex items-center gap-2">
                                <i class="fa-solid fa-user-pen text-sm"></i>
                                <span>Excuse / Update Attendance</span>
                            </h3>
                            <p class="text-xs text-blue-200 mt-0.5">
                                Date: {{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}
                            </p>
                        </div>
                        <button type="button" @click="excuseModal = false" class="text-white/70 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    {{-- MODAL BODY --}}
                    <div class="p-6 space-y-4">
                        {{-- Student Summary --}}
                        <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-2xl">
                            <img :src="selectedStudent ? selectedStudent.photo_url : ''" class="w-12 h-12 rounded-xl object-cover border border-slate-300">
                            <div>
                                <h4 class="font-bold text-[#0e2c56] text-sm" x-text="selectedStudent ? (selectedStudent.first_name + ' ' + selectedStudent.last_name) : ''"></h4>
                                <p class="text-xs font-mono text-slate-400" x-text="selectedStudent ? selectedStudent.student_no : ''"></p>
                                <p class="text-[11px] text-slate-500" x-text="selectedStudent ? ('Grade ' + selectedStudent.grade_level + ' - ' + (selectedStudent.section || 'General')) : ''"></p>
                            </div>
                        </div>

                        {{-- Status Selection --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                                Attendance Status
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="cursor-pointer border rounded-xl p-2.5 flex items-center gap-2 text-xs font-semibold transition" :class="selectedStatus === 'Excused' ? 'border-purple-500 bg-purple-50 text-purple-700' : 'border-slate-200 text-slate-600 hover:bg-slate-50'">
                                    <input type="radio" name="status" value="Excused" x-model="selectedStatus" class="text-purple-600 focus:ring-0">
                                    <span>🟣 Excused</span>
                                </label>

                                <label class="cursor-pointer border rounded-xl p-2.5 flex items-center gap-2 text-xs font-semibold transition" :class="selectedStatus === 'Present' ? 'border-emerald-500 bg-emerald-50 text-emerald-700' : 'border-slate-200 text-slate-600 hover:bg-slate-50'">
                                    <input type="radio" name="status" value="Present" x-model="selectedStatus" class="text-emerald-600 focus:ring-0">
                                    <span>🟢 Present</span>
                                </label>

                                <label class="cursor-pointer border rounded-xl p-2.5 flex items-center gap-2 text-xs font-semibold transition" :class="selectedStatus === 'Late' ? 'border-amber-500 bg-amber-50 text-amber-700' : 'border-slate-200 text-slate-600 hover:bg-slate-50'">
                                    <input type="radio" name="status" value="Late" x-model="selectedStatus" class="text-amber-600 focus:ring-0">
                                    <span>🟡 Late</span>
                                </label>

                                <label class="cursor-pointer border rounded-xl p-2.5 flex items-center gap-2 text-xs font-semibold transition" :class="selectedStatus === 'Absent' ? 'border-rose-500 bg-rose-50 text-rose-700' : 'border-slate-200 text-slate-600 hover:bg-slate-50'">
                                    <input type="radio" name="status" value="Absent" x-model="selectedStatus" class="text-rose-600 focus:ring-0">
                                    <span>🔴 Absent</span>
                                </label>
                            </div>
                        </div>

                        {{-- Quick Reason Presets --}}
                        <div>
                            <span class="block text-[11px] font-semibold text-slate-500 mb-1.5">Quick Excuse Reasons:</span>
                            <div class="flex flex-wrap gap-1.5">
                                <button type="button" @click="setQuickRemark('Medical / Sick Leave with doctor notice')" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-purple-100 hover:text-purple-700 text-[11px] font-medium text-slate-600 transition">
                                    + Medical / Sick
                                </button>
                                <button type="button" @click="setQuickRemark('Family emergency - guardian notified')" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-purple-100 hover:text-purple-700 text-[11px] font-medium text-slate-600 transition">
                                    + Family Emergency
                                </button>
                                <button type="button" @click="setQuickRemark('School academic / sports competition delegate')" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-purple-100 hover:text-purple-700 text-[11px] font-medium text-slate-600 transition">
                                    + School Delegation
                                </button>
                                <button type="button" @click="setQuickRemark('Dental appointment with excuse letter')" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-purple-100 hover:text-purple-700 text-[11px] font-medium text-slate-600 transition">
                                    + Dental Appt
                                </button>
                            </div>
                        </div>

                        {{-- Reason / Remarks --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Excuse Reason / Remarks
                            </label>
                            <textarea 
                                name="remarks" 
                                rows="3" 
                                x-model="selectedRemarks"
                                placeholder="State reason for excuse or special note..." 
                                class="w-full text-xs rounded-xl border-slate-200 focus:ring-2 focus:ring-[#0e2c56]/20 focus:border-[#0e2c56]"
                            ></textarea>
                        </div>
                    </div>

                    {{-- MODAL FOOTER --}}
                    <div class="p-5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5 rounded-b-3xl">
                        <button 
                            type="button" 
                            @click="excuseModal = false"
                            class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-200/70 transition"
                        >
                            Cancel
                        </button>
                        <button 
                            type="submit" 
                            class="px-5 py-2 rounded-xl bg-[#0e2c56] hover:bg-[#123b70] text-white text-xs font-semibold transition shadow-sm flex items-center gap-1.5"
                        >
                            <i class="fa-solid fa-check"></i>
                            <span>Save Status</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection