@extends('layouts.parent')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    {{-- ============================================== --}}
    {{-- CHILDREN SWITCHER (IF MULTIPLE CHILDREN) --}}
    {{-- ============================================== --}}
    @if($children->count() > 1)
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2">
                <i class="fa-solid fa-children text-blue-600"></i>
                <span>Select Child to Monitor:</span>
            </span>

            <div class="flex flex-wrap gap-2">
                @foreach($children as $child)
                    <a 
                        href="{{ route('parent.dashboard', ['child_id' => $child->id]) }}" 
                        class="inline-flex items-center gap-2.5 px-4 py-2 rounded-xl text-xs font-bold transition shadow-sm {{ $selectedStudent && $selectedStudent->id === $child->id ? 'bg-[#0e2c56] text-white shadow-blue-900/10' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}"
                    >
                        <img src="{{ $child->photo_url }}" class="w-5 h-5 rounded-full object-cover">
                        <span>{{ $child->first_name }} {{ $child->last_name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif


    @if($selectedStudent)

        {{-- ============================================== --}}
        {{-- HERO: REAL-TIME CAMPUS PRESENCE STATUS --}}
        {{-- ============================================== --}}
        <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
            
            {{-- STATUS HEADER BANNER --}}
            @if($presenceStatus === 'Inside Campus')
                <div class="bg-gradient-to-r from-emerald-600 to-teal-700 text-white p-6 sm:p-7 relative overflow-hidden">
                    <div class="absolute -right-6 -bottom-10 opacity-15 pointer-events-none">
                        <i class="fa-solid fa-school-flag text-9xl"></i>
                    </div>
            @elseif($presenceStatus === 'Departed')
                <div class="bg-gradient-to-r from-sky-600 to-blue-700 text-white p-6 sm:p-7 relative overflow-hidden">
                    <div class="absolute -right-6 -bottom-10 opacity-15 pointer-events-none">
                        <i class="fa-solid fa-door-open text-9xl"></i>
                    </div>
            @elseif($presenceStatus === 'Late')
                <div class="bg-gradient-to-r from-amber-600 to-orange-700 text-white p-6 sm:p-7 relative overflow-hidden">
                    <div class="absolute -right-6 -bottom-10 opacity-15 pointer-events-none">
                        <i class="fa-solid fa-clock text-9xl"></i>
                    </div>
            @elseif($presenceStatus === 'Excused')
                <div class="bg-gradient-to-r from-purple-600 to-indigo-700 text-white p-6 sm:p-7 relative overflow-hidden">
                    <div class="absolute -right-6 -bottom-10 opacity-15 pointer-events-none">
                        <i class="fa-solid fa-notes-medical text-9xl"></i>
                    </div>
            @else
                <div class="bg-gradient-to-r from-rose-600 to-red-700 text-white p-6 sm:p-7 relative overflow-hidden">
                    <div class="absolute -right-6 -bottom-10 opacity-15 pointer-events-none">
                        <i class="fa-solid fa-clock-rotate-left text-9xl"></i>
                    </div>
            @endif

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 relative z-10">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-white text-xs font-bold uppercase tracking-wider">
                                @if($presenceStatus === 'Inside Campus')
                                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-ping"></span>
                                @endif
                                <i class="{{ $statusBadge['icon'] }} text-xs"></i>
                                <span>Live Presence Status</span>
                            </span>
                            <span class="text-xs text-white/80">• Today: {{ \Carbon\Carbon::parse($today)->format('F d, Y') }}</span>
                        </div>

                        <h2 class="text-2xl sm:text-3xl font-black tracking-tight">
                            {{ $statusBadge['label'] }}
                        </h2>
                        <p class="text-sm text-white/90 mt-1 max-w-xl">
                            {{ $statusBadge['sub'] }}
                        </p>
                    </div>

                    <div class="text-left sm:text-right shrink-0 bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20">
                        <span class="text-[11px] uppercase font-bold text-white/70 block">Terminal Timestamp</span>
                        <span class="text-xl sm:text-2xl font-black text-white font-mono block">
                            @if($todayAttendance && $todayAttendance->time_out)
                                {{ \Carbon\Carbon::parse($todayAttendance->time_out)->format('h:i:s A') }}
                            @elseif($todayAttendance && $todayAttendance->time_in)
                                {{ \Carbon\Carbon::parse($todayAttendance->time_in)->format('h:i:s A') }}
                            @else
                                {{ \Carbon\Carbon::now('Asia/Manila')->format('h:i A') }}
                            @endif
                        </span>
                        <span class="text-[10px] text-white/80 block mt-0.5">Philippine Standard Time</span>
                    </div>
                </div>

            </div>

            {{-- CHILD PROFILE SUMMARY STRIP --}}
            <div class="p-6 bg-slate-50/70 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
                <div class="flex items-center gap-4">
                    <img 
                        src="{{ $selectedStudent->photo_url }}" 
                        alt="{{ $selectedStudent->first_name }}"
                        class="w-16 h-16 rounded-2xl object-cover border-2 border-white shadow-md ring-2 ring-slate-200"
                    >
                    <div>
                        <h3 class="text-lg font-bold text-[#0e2c56]">
                            {{ $selectedStudent->first_name }}
                            @if($selectedStudent->middle_name)
                                {{ substr($selectedStudent->middle_name, 0, 1) }}.
                            @endif
                            {{ $selectedStudent->last_name }}
                        </h3>
                        <div class="flex flex-wrap items-center gap-2 mt-1">
                            <span class="bg-[#0e2c56] text-white px-2.5 py-0.5 rounded-md font-mono text-xs font-bold">
                                {{ $selectedStudent->student_no }}
                            </span>
                            <span class="text-xs text-slate-500 font-semibold">
                                Grade {{ $selectedStudent->grade_level }} — Section {{ $selectedStudent->section ?: 'General' }}
                            </span>
                            <span class="text-xs text-slate-400">• S.Y. 2026-2027</span>
                        </div>
                    </div>
                </div>

                {{-- GATE ACTIVITY STEPPER --}}
                <div class="flex items-center gap-3">
                    {{-- Time In Step --}}
                    <div class="flex items-center gap-2 bg-white border border-slate-200 px-3.5 py-2 rounded-xl text-xs shadow-sm">
                        <div class="w-7 h-7 rounded-lg {{ $todayAttendance && $todayAttendance->time_in ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center text-xs">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Gate In</span>
                            <span class="font-bold font-mono text-slate-800">
                                {{ $todayAttendance && $todayAttendance->time_in ? \Carbon\Carbon::parse($todayAttendance->time_in)->format('h:i A') : 'Not yet' }}
                            </span>
                        </div>
                    </div>

                    <i class="fa-solid fa-arrow-right text-slate-300 text-xs"></i>

                    {{-- Time Out Step --}}
                    <div class="flex items-center gap-2 bg-white border border-slate-200 px-3.5 py-2 rounded-xl text-xs shadow-sm">
                        <div class="w-7 h-7 rounded-lg {{ $todayAttendance && $todayAttendance->time_out ? 'bg-sky-100 text-sky-700' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center text-xs">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Gate Out</span>
                            <span class="font-bold font-mono text-slate-800">
                                {{ $todayAttendance && $todayAttendance->time_out ? \Carbon\Carbon::parse($todayAttendance->time_out)->format('h:i A') : 'Not yet' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- GATE GUARD VERIFICATION DETAILS --}}
            <div class="px-6 py-3.5 bg-white text-xs text-slate-500 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-blue-600"></i>
                    <span>Security Checkpoint:</span>
                    <span class="font-semibold text-slate-700">Main Campus Automated Gate Kiosk</span>
                    @if($todayAttendance && $todayAttendance->guardProfile)
                        <span>• Verified by Officer {{ $todayAttendance->guardProfile->first_name }} {{ $todayAttendance->guardProfile->last_name }}</span>
                    @endif
                </div>

                <div class="flex items-center gap-2 text-slate-400">
                    <i class="fa-solid fa-camera"></i>
                    <span>Camera & 2D QR Scanner Terminal</span>
                </div>
            </div>

        </div>


        {{-- ============================================== --}}
        {{-- KPI ATTENDANCE PERFORMANCE CARDS --}}
        {{-- ============================================== --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            {{-- ATTENDANCE RATE --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm col-span-2 sm:col-span-1">
                <span class="text-xs font-semibold text-slate-500 block">Attendance Rate</span>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-3xl font-black text-[#0e2c56]">{{ $stats['attendance_rate'] }}%</span>
                    <span class="text-xs font-bold text-emerald-600">Active</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5 mt-3 overflow-hidden">
                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $stats['attendance_rate'] }}%"></div>
                </div>
            </div>

            {{-- TOTAL PRESENT --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 block">Days Present</span>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-3xl font-black text-emerald-600">{{ $stats['total_present'] }}</span>
                    <span class="text-xs text-slate-400">days</span>
                </div>
                <span class="text-[11px] text-emerald-600 font-semibold block mt-3">Gate in verified</span>
            </div>

            {{-- TOTAL LATE --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 block">Tardiness / Late</span>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-3xl font-black text-amber-600">{{ $stats['total_late'] }}</span>
                    <span class="text-xs text-slate-400">times</span>
                </div>
                <span class="text-[11px] text-amber-600 font-semibold block mt-3">Scanned past cutoff</span>
            </div>

            {{-- TOTAL EXCUSED --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 block">Excused Leaves</span>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-3xl font-black text-purple-600">{{ $stats['total_excused'] }}</span>
                    <span class="text-xs text-slate-400">days</span>
                </div>
                <span class="text-[11px] text-purple-600 font-semibold block mt-3">Authorized absence</span>
            </div>

            {{-- TOTAL UNEXCUSED ABSENT --}}
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 block">Unexcused Absences</span>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-3xl font-black text-rose-600">{{ $stats['total_absent'] }}</span>
                    <span class="text-xs text-slate-400">days</span>
                </div>
                <span class="text-[11px] text-rose-600 font-semibold block mt-3">No scan recorded</span>
            </div>
        </div>


        {{-- ============================================== --}}
        {{-- ATTENDANCE HISTORY LOGS & ANNOUNCEMENTS --}}
        {{-- ============================================== --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-7">

            {{-- ATTENDANCE LOGS TABLE (2 COLS) --}}
            <div class="xl:col-span-2 bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-[#0e2c56]">
                            Recent Attendance & Gate History
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Recorded scans for {{ $selectedStudent->first_name }}
                        </p>
                    </div>
                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                        Last {{ $attendanceLogs->count() }} Records
                    </span>
                </div>

                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-[11px] uppercase font-bold text-slate-400 tracking-wider">
                                <th class="py-3.5 px-6">Date</th>
                                <th class="py-3.5 px-4">Arrival (Time In)</th>
                                <th class="py-3.5 px-4">Departure (Time Out)</th>
                                <th class="py-3.5 px-4">Campus Status</th>
                                <th class="py-3.5 px-6">Remarks / Officer</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($attendanceLogs as $log)
                                <tr class="hover:bg-slate-50/70 transition">
                                    {{-- DATE --}}
                                    <td class="py-3.5 px-6">
                                        <span class="font-bold text-[#0e2c56] block">
                                            {{ $log->attendance_date ? $log->attendance_date->format('M d, Y') : '—' }}
                                        </span>
                                        <span class="text-[11px] text-slate-400">
                                            {{ $log->attendance_date ? $log->attendance_date->format('l') : '' }}
                                        </span>
                                    </td>

                                    {{-- TIME IN --}}
                                    <td class="py-3.5 px-4 font-mono">
                                        @if($log->time_in)
                                            <span class="font-semibold text-slate-800">
                                                {{ \Carbon\Carbon::parse($log->time_in)->format('h:i A') }}
                                            </span>
                                        @else
                                            <span class="text-slate-300 font-sans">—</span>
                                        @endif
                                    </td>

                                    {{-- TIME OUT --}}
                                    <td class="py-3.5 px-4 font-mono">
                                        @if($log->time_out)
                                            <span class="font-semibold text-slate-800">
                                                {{ \Carbon\Carbon::parse($log->time_out)->format('h:i A') }}
                                            </span>
                                        @else
                                            <span class="text-slate-300 font-sans">—</span>
                                        @endif
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="py-3.5 px-4">
                                        @if($log->status === 'Present')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <i class="fa-solid fa-check text-[10px]"></i>
                                                Present
                                            </span>
                                        @elseif($log->status === 'Late')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                <i class="fa-solid fa-clock text-[10px]"></i>
                                                Late
                                            </span>
                                        @elseif($log->status === 'Excused')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                                <i class="fa-solid fa-file-signature text-[10px]"></i>
                                                Excused
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                <i class="fa-solid fa-xmark text-[10px]"></i>
                                                Absent
                                            </span>
                                        @endif
                                    </td>

                                    {{-- REMARKS / OFFICER --}}
                                    <td class="py-3.5 px-6 text-slate-500">
                                        @if($log->remarks)
                                            <span class="text-purple-700 font-semibold block text-[11px]">
                                                {{ $log->remarks }}
                                            </span>
                                        @endif
                                        @if($log->guardProfile)
                                            <span class="text-[10px] text-slate-400 block">
                                                Guard: {{ $log->guardProfile->first_name }} {{ $log->guardProfile->last_name }}
                                            </span>
                                        @else
                                            <span class="text-[10px] text-slate-400">Automated Kiosk</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-400">
                                        <i class="fa-regular fa-calendar-xmark text-3xl mb-2 text-slate-300"></i>
                                        <p class="font-semibold text-slate-500">No past attendance logs found</p>
                                        <p class="text-xs text-slate-400">Logs will be generated upon scanning at the gate.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- SIDEBAR: ANNOUNCEMENTS & EMERGENCY INFO (1 COL) --}}
            <div class="space-y-6">

                {{-- EMERGENCY CONTACT REGISTRATION CARD --}}
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="fa-solid fa-mobile-screen-button text-base"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-[#0e2c56]">Parent Contact on File</h3>
                            <p class="text-[11px] text-slate-400">Presence verification contact</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 text-xs space-y-2.5">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 font-medium">Guardian Name:</span>
                            <span class="font-bold text-slate-800">
                                {{ $parent ? ($parent->first_name . ' ' . $parent->last_name) : (auth()->user()->name ?? 'Parent') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 font-medium">Mobile Number:</span>
                            <span class="font-mono font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200">
                                {{ $parent && $parent->phone ? $parent->phone : '0917-000-0000' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 font-medium">Address:</span>
                            <span class="font-semibold text-slate-700 text-right truncate max-w-[150px]" title="{{ $parent ? $parent->address : '' }}">
                                {{ $parent && $parent->address ? $parent->address : 'Sorsogon City' }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 p-3 rounded-xl bg-blue-50/70 border border-blue-100 flex items-start gap-2.5 text-[11px] text-slate-600">
                        <i class="fa-solid fa-comment-sms text-blue-600 mt-0.5"></i>
                        <p>
                            Gate arrival and departure logs are logged in real-time. SMS notifications will be linked directly to this registered number.
                        </p>
                    </div>
                </div>

                {{-- CAMPUS ANNOUNCEMENTS FEED --}}
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-bullhorn text-blue-600 text-sm"></i>
                            <h3 class="text-sm font-bold text-[#0e2c56]">School Announcements</h3>
                        </div>
                    </div>

                    <div class="space-y-3.5">
                        @forelse($announcements as $memo)
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 hover:border-slate-200 transition">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="text-xs font-bold text-[#0e2c56]">{{ $memo->title }}</h4>
                                    <span class="text-[10px] text-slate-400 font-mono">
                                        {{ $memo->created_at ? $memo->created_at->format('M d') : '' }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    {{ \Illuminate\Support\Str::limit($memo->content, 120) }}
                                </p>
                                @if($memo->teacher)
                                    <span class="text-[10px] text-blue-600 font-semibold block mt-1.5">
                                        By Teacher {{ $memo->teacher->first_name }} {{ $memo->teacher->last_name }}
                                    </span>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-6 text-slate-400 text-xs">
                                <i class="fa-regular fa-bell text-2xl mb-2 text-slate-300"></i>
                                <p>No current school announcements.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    @else

        {{-- EMPTY STATE: NO CHILD LINKED --}}
        <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center shadow-sm max-w-lg mx-auto">
            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fa-solid fa-children"></i>
            </div>
            <h3 class="text-lg font-bold text-[#0e2c56]">No Student Linked Yet</h3>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                Your parent account is active, but no student has been attached to your profile yet. Please contact the School Registrar or Administrator with your student's ID number.
            </p>
        </div>

    @endif

</div>

@endsection
