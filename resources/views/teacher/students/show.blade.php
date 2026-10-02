@extends('layouts.teacher')

@section('page-title', 'Student Profile')
@section('page-subtitle', 'Detailed profile and attendance record')

@section('content')

<div class="space-y-6">

    {{-- Back Link --}}
    <div>
        <a href="{{ route('teacher.students.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-[#0e2c56] transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Back to Students Roster</span>
        </a>
    </div>

    {{-- Student Profile Card --}}
    <div class="dashboard-panel p-6">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">

            {{-- Photo --}}
            <div class="w-40 h-48 rounded-2xl overflow-hidden bg-slate-50 border border-slate-200/80 shadow-xs flex-shrink-0">
                <img
                    src="{{ $student->photo_url }}"
                    alt="{{ $student->formatted_name }}"
                    class="w-full h-full object-cover"
                >
            </div>

            {{-- Student Info --}}
            <div class="flex-1 w-full">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-[#0e2c56]">
                            {{ $student->formatted_name }}
                        </h1>
                        <p class="text-xs font-mono text-slate-400 mt-1">
                            Student No: {{ $student->student_no }}
                        </p>
                    </div>

                    <div>
                        @if(strtolower($student->status) === 'active')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                {{ $student->status ?? 'Inactive' }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Details Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
                    <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Grade Level</p>
                        <p class="text-xs font-bold text-[#0e2c56] mt-1">{{ $student->grade_level ? 'Grade ' . $student->grade_level : '—' }}</p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Section</p>
                        <p class="text-xs font-bold text-[#0e2c56] mt-1">{{ $student->section ?? '—' }}</p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Gender</p>
                        <p class="text-xs font-bold text-[#0e2c56] mt-1">{{ $student->gender ?? '—' }}</p>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Birthdate</p>
                        <p class="text-xs font-bold text-[#0e2c56] mt-1">
                            {{ $student->birthdate
                                ? \Carbon\Carbon::parse($student->birthdate)->format('M d, Y')
                                : '—' }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>


    {{-- Attendance History --}}
    <div class="dashboard-panel">
        <div class="panel-header">
            <div>
                <h2 class="panel-title">
                    Attendance History
                </h2>
                <p class="panel-subtitle">
                    Student campus presence & attendance records
                </p>
            </div>

            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0e2c56] flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

        @if($student->attendances->count())
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/50">
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Date</th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Time In</th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">Time Out</th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider text-right">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach($student->attendances as $attendance)
                            @php
                                $attendanceStatus = strtolower($attendance->status ?? 'present');
                            @endphp

                            <tr class="hover:bg-slate-50/60 transition duration-150">
                                <td class="py-3.5 px-5 text-xs font-bold text-[#0e2c56]">
                                    {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('M d, Y') }}
                                </td>

                                <td class="py-3.5 px-5 text-xs font-medium text-slate-600 font-mono">
                                    {{ $attendance->time_in
                                        ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A')
                                        : '—' }}
                                </td>

                                <td class="py-3.5 px-5 text-xs font-medium text-slate-600 font-mono">
                                    {{ $attendance->time_out
                                        ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A')
                                        : '—' }}
                                </td>

                                <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                    @if($attendanceStatus === 'present')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                            Present
                                        </span>
                                    @elseif($attendanceStatus === 'absent')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200/80">
                                            Absent
                                        </span>
                                    @elseif($attendanceStatus === 'late')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200/80">
                                            Late
                                        </span>
                                    @elseif($attendanceStatus === 'excused')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200/80">
                                            Excused
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                            {{ $attendance->status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="h-56 flex flex-col items-center justify-center text-center p-6">
                <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100">
                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-slate-400 mt-4">
                    No attendance records found
                </p>
                <p class="text-xs text-slate-300 mt-1">
                    This student does not have any attendance records logged yet.
                </p>
            </div>
        @endif
    </div>

</div>

@endsection
endsection
