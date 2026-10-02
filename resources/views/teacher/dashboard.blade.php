@extends('layouts.teacher')

@section('page-title', 'Teacher Dashboard')
@section('page-subtitle', 'Overview of section attendance and real-time campus presence')

@section('content')

@php
    $attendanceTotal = $totalStudents ?? 0;
    $present = $presentToday ?? 0;
    $late = $lateToday ?? 0;
    $absent = $absentToday ?? 0;
    $excused = $excusedToday ?? 0;
    $inside = $insideCampus ?? 0;
    $departed = $departedToday ?? 0;

    $presentRate = $attendanceTotal > 0 ? round(($present / $attendanceTotal) * 100) : 0;
    $lateRate = $attendanceTotal > 0 ? round(($late / $attendanceTotal) * 100) : 0;
    $absentRate = $attendanceTotal > 0 ? round(($absent / $attendanceTotal) * 100) : 0;
@endphp

<div class="space-y-6">

    {{-- =========================================================
         FLASH NOTIFICATIONS
    ========================================================== --}}
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 text-xs font-bold">&times;</button>
        </div>
    @endif


    {{-- =========================================================
         WELCOME HEADER (NO CARD / TRANSPARENT)
    ========================================================== --}}
    <div class="py-1">
        <div class="flex items-center gap-2.5 flex-wrap">
            <h1 class="text-2xl font-bold text-[#155d36]">
                Good day, {{ auth()->user()->teacher ? explode(' ', trim(auth()->user()->teacher->first_name))[0] : explode(' ', trim(auth()->user()->name))[0] }}!
            </h1>
            <span id="live-indicator" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Live Sync
            </span>
        </div>

        <p class="text-xs text-stone-500 mt-1 font-medium">
            Attendance records for <span class="font-bold text-stone-700">{{ \Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}</span>.
        </p>
    </div>


    {{-- =========================================================
         4 CORE METRIC CARDS
    ========================================================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- 1. TOTAL ASSIGNED STUDENTS --}}
        <div class="dashboard-card flex flex-col justify-between font-sans antialiased">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Total Students</p>
                    <p id="kpi-total" class="card-empty text-[#155d36]">{{ $totalStudents }}</p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-[#4d88df]/15 text-[#4d88df] border border-[#4d88df]/30 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-8a4 4 0 11-8 0 4 4 0 018 0zm6 3a3 3 0 10-6 0"/>
                    </svg>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                <span class="text-xs text-slate-500 font-medium">Active roster count</span>
                <span class="text-xs font-semibold text-[#4d88df] bg-[#4d88df]/10 px-2 py-0.5 rounded-full">Roster Active</span>
            </div>
        </div>


        {{-- 2. TODAY'S PRESENT --}}
        <div class="dashboard-card flex flex-col justify-between font-sans antialiased">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Today's Present</p>
                    <p id="kpi-present" class="card-empty text-[#155d36]">{{ $present }}</p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-[#155d36]/15 text-[#155d36] border border-[#155d36]/30 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                <span id="kpi-present-rate" class="text-xs font-semibold text-[#155d36]">{{ $presentRate }}% attendance rate</span>
                <span class="text-xs text-slate-500 font-normal">{{ $inside }} inside / {{ $departed }} left</span>
            </div>
        </div>


        {{-- 3. UNSCANNED / ABSENT --}}
        <div class="dashboard-card flex flex-col justify-between font-sans antialiased">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Unscanned / Absent</p>
                    <p id="kpi-absent" class="card-empty text-[#eb5757]">{{ $absent }}</p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-[#eb5757]/15 text-[#eb5757] border border-[#eb5757]/30 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                <span id="kpi-absent-rate" class="text-xs font-semibold text-[#eb5757]">{{ $absentRate }}% absent rate</span>
                <span class="text-xs text-slate-500 font-medium">SMS Alerts Queued</span>
            </div>
        </div>


        {{-- 4. LATE ARRIVALS --}}
        <div class="dashboard-card flex flex-col justify-between font-sans antialiased">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Late Arrivals</p>
                    <p id="kpi-late" class="card-empty text-amber-700">{{ $late }}</p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-[#f2c94c]/20 text-amber-800 border border-[#f2c94c]/40 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                <span id="kpi-late-rate" class="text-xs font-semibold text-amber-800">{{ $lateRate }}% late rate</span>
                <span class="text-xs text-slate-500 font-medium">Gate Scans</span>
            </div>
        </div>

    </div>


    {{-- =========================================================
         LIVE ATTENDANCE TABLE & MANUAL OVERRIDE SYSTEM
    ========================================================== --}}
    <div class="dashboard-panel font-sans antialiased">

        <div class="panel-header flex flex-col xl:flex-row xl:items-center justify-between gap-4">
            <div>
                <h2 class="panel-title text-[#155d36]">Class Attendance & Presence Roster</h2>
                <p class="text-xs text-slate-500 font-normal mt-0.5">Real-time gate synchronization with parent contact details & manual override options</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <form method="GET" action="{{ route('teacher.dashboard') }}" class="flex flex-wrap items-center gap-2.5">
                    {{-- Class / Section Dropdown --}}
                    <select
                        name="section"
                        onchange="this.form.submit()"
                        class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#155d36]/20 cursor-pointer h-[38px]"
                    >
                        @if(count($sections) > 1 || auth()->user()->role !== 'teacher')
                            <option value="">All Sections</option>
                        @endif
                        @foreach($sections as $sec)
                            <option value="{{ $sec }}" {{ ($selectedSection == $sec) ? 'selected' : '' }}>
                                Section {{ $sec }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Attendance Date Picker --}}
                    <input
                        type="date"
                        id="filter-date"
                        name="date"
                        value="{{ $selectedDate }}"
                        onchange="this.form.submit()"
                        class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#155d36]/20 cursor-pointer h-[38px]"
                    >

                    {{-- Search Student Input --}}
                    <input
                        type="text"
                        id="filter-search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search student or ID..."
                        class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#155d36]/20 w-44 sm:w-52 h-[38px]"
                    >

                    {{-- Apply Filter Button --}}
                    <button type="submit" class="bg-[#155d36] hover:bg-[#0f4628] text-white text-xs font-semibold px-4 py-2 rounded-xl transition shadow-xs h-[38px] whitespace-nowrap">
                        Apply Filter
                    </button>
                </form>

                {{-- Sync Now Button --}}
                <button
                    type="button"
                    onclick="fetchLiveData()"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold transition h-[38px] whitespace-nowrap"
                >
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Sync Now</span>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 py-3 px-4">Student Details</th>
                        <th class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 py-3 px-4">Student ID</th>
                        <th class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 py-3 px-4">Time In</th>
                        <th class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 py-3 px-4">Current Presence Status</th>
                        <th class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 py-3 px-4">Parent Contact Info</th>
                        <th class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 py-3 px-4 text-right">Manual Override</th>
                    </tr>
                </thead>

                <tbody id="student-table-tbody" class="divide-y divide-slate-100">
                    @forelse($students as $st)
                        @php
                            $att = $st->attendance_record;
                            $pStatus = $st->presence_status;
                            $tIn = $att && $att->time_in ? \Carbon\Carbon::parse($att->time_in)->format('h:i A') : '—';
                        @endphp

                        <tr id="student-row-{{ $st->id }}" class="hover:bg-slate-50/70 transition duration-150">

                            {{-- Student Photo & Name --}}
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <img
                                        src="{{ $st->photo_url }}"
                                        alt="{{ $st->first_name }}"
                                        class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-2xs flex-shrink-0"
                                    >
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">
                                            {{ $st->formatted_name }}
                                        </p>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            Grade {{ $st->grade_level }} - Section {{ $st->section }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Student ID --}}
                            <td class="py-3.5 px-4 text-xs font-mono font-medium text-slate-600">
                                <span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-xs font-medium text-slate-600">
                                    {{ $st->student_no }}
                                </span>
                            </td>

                            {{-- Time In --}}
                            <td class="py-3.5 px-4 text-xs font-mono font-medium text-slate-700 whitespace-nowrap student-time-in">
                                {{ $tIn }}
                            </td>

                            {{-- Current Status Badge --}}
                            <td class="py-3.5 px-4 whitespace-nowrap student-status-cell">
                                @if($pStatus === 'Inside Campus')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                        Inside Campus
                                    </span>
                                @elseif($pStatus === 'Departed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        Departed
                                    </span>
                                @elseif($pStatus === 'Present')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        Present
                                    </span>
                                @elseif($pStatus === 'Late')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                        Late
                                    </span>
                                @elseif($pStatus === 'Excused')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                        Excused
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        Absent
                                    </span>
                                @endif
                            </td>

                            {{-- Parent Contact Info --}}
                            <td class="py-3.5 px-4 text-xs text-slate-600 font-normal">
                                <div class="flex items-center gap-1.5 text-slate-700">
                                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $st->parent_contact_info }}</span>
                                </div>
                            </td>

                            {{-- Actions (Manual Override) --}}
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <button
                                    type="button"
                                    onclick="openOverrideModal({{ json_encode([
                                        'id' => $st->id,
                                        'name' => $st->formatted_name,
                                        'student_no' => $st->student_no,
                                        'status' => $att?->status ?: 'Absent',
                                        'remarks' => $att?->remarks ?: ''
                                    ]) }})"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-[#155d36] hover:text-white text-xs font-semibold text-[#155d36] transition duration-150"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>Update Status</span>
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 text-xs font-medium">
                                No student records found for the selected section or search criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>


{{-- =========================================================
     MANUAL OVERRIDE MODAL DIALOG
========================================================== --}}
<div id="override-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-stone-900/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl border border-stone-200 shadow-xl max-w-md w-full p-6 space-y-5 transform transition-all font-sans antialiased">

        <div class="flex items-center justify-between pb-3 border-b border-stone-100">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-[#155d36]/15 text-[#155d36] flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-[#155d36]">Manual Attendance Override</h3>
                    <p class="text-xs text-stone-400">Update attendance status or excuse an absence</p>
                </div>
            </div>

            <button type="button" onclick="closeOverrideModal()" class="text-stone-400 hover:text-stone-700 text-lg font-bold">&times;</button>
        </div>

        <form method="POST" action="{{ route('teacher.attendance.status') }}" class="space-y-4">
            @csrf

            <input type="hidden" name="student_id" id="modal-student-id">
            <input type="hidden" name="attendance_date" value="{{ $selectedDate }}">

            <div>
                <p class="text-[10px] font-bold uppercase tracking-wider text-stone-400">Student</p>
                <p id="modal-student-name" class="text-sm font-bold text-[#155d36] mt-0.5">—</p>
                <p id="modal-student-no" class="text-xs font-mono text-stone-500">—</p>
            </div>

            <div>
                <label for="modal-status" class="block text-xs font-bold text-stone-700 mb-1">Attendance Status</label>
                <select
                    name="status"
                    id="modal-status"
                    class="w-full bg-stone-50 border border-stone-200 rounded-xl px-3 py-2.5 text-xs font-bold text-[#155d36] focus:outline-none focus:ring-2 focus:ring-[#155d36]/20"
                    required
                >
                    <option value="Present">Present (Mark as Checked In)</option>
                    <option value="Late">Late Arrival</option>
                    <option value="Absent">Absent (Triggers Parent SMS Notice)</option>
                    <option value="Excused">Excused Absence</option>
                </select>
            </div>

            <div>
                <label for="modal-remarks" class="block text-xs font-bold text-stone-700 mb-1">Remarks / Medical Excuse Reason (Optional)</label>
                <textarea
                    name="remarks"
                    id="modal-remarks"
                    rows="2"
                    placeholder="e.g. Medical excuse letter submitted / Forgot ID card at home"
                    class="w-full bg-stone-50 border border-stone-200 rounded-xl p-3 text-xs font-medium text-stone-700 focus:outline-none focus:ring-2 focus:ring-[#155d36]/20"
                ></textarea>
            </div>

            <div class="pt-2 flex items-center justify-end gap-3">
                <button
                    type="button"
                    onclick="closeOverrideModal()"
                    class="px-4 py-2 rounded-xl border border-stone-200 text-stone-600 text-xs font-semibold hover:bg-stone-50 transition"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-5 py-2 rounded-xl bg-[#155d36] hover:bg-[#0f4628] text-white text-xs font-bold shadow-xs transition"
                >
                    Save Attendance Override
                </button>
            </div>

        </form>

    </div>
</div>


{{-- =========================================================
     REAL-TIME LIVE SYNCHRONIZATION POLLING SCRIPT
========================================================== --}}
<script>
    function openOverrideModal(data) {
        document.getElementById('modal-student-id').value = data.id;
        document.getElementById('modal-student-name').innerText = data.name;
        document.getElementById('modal-student-no').innerText = 'ID: ' + data.student_no;
        document.getElementById('modal-status').value = data.status || 'Present';
        document.getElementById('modal-remarks').value = data.remarks || '';
        document.getElementById('override-modal').classList.remove('hidden');
    }

    function closeOverrideModal() {
        document.getElementById('override-modal').classList.add('hidden');
    }

    // Auto-polling for real-time gate synchronization (Every 4 seconds)
    function fetchLiveData() {
        const section = "{{ $selectedSection }}";
        const grade = "{{ $selectedGrade }}";
        const date = "{{ $selectedDate }}";
        const search = "{{ $search }}";

        const url = `{{ route('teacher.dashboard.live') }}?section=${encodeURIComponent(section)}&grade_level=${encodeURIComponent(grade)}&date=${encodeURIComponent(date)}&search=${encodeURIComponent(search)}`;

        fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Update KPI Metric counts
                const kpiTotal = document.getElementById('kpi-total');
                const kpiPresent = document.getElementById('kpi-present');
                const kpiAbsent = document.getElementById('kpi-absent');
                const kpiLate = document.getElementById('kpi-late');

                if (kpiTotal) kpiTotal.innerText = data.totalStudents;
                if (kpiPresent) kpiPresent.innerText = data.presentToday;
                if (kpiAbsent) kpiAbsent.innerText = data.absentToday;
                if (kpiLate) kpiLate.innerText = data.lateToday;

                const prRate = document.getElementById('kpi-present-rate');
                const abRate = document.getElementById('kpi-absent-rate');
                const ltRate = document.getElementById('kpi-late-rate');

                if (prRate) prRate.innerText = `${data.presenceRate}% attendance rate`;
                if (abRate) abRate.innerText = `${data.totalStudents > 0 ? Math.round((data.absentToday / data.totalStudents) * 100) : 0}% absent rate`;
                if (ltRate) ltRate.innerText = `${data.totalStudents > 0 ? Math.round((data.lateToday / data.totalStudents) * 100) : 0}% late rate`;

                // Update Table Rows
                data.students.forEach(st => {
                    const row = document.getElementById(`student-row-${st.id}`);
                    if (row) {
                        const timeInCell = row.querySelector('.student-time-in');
                        if (timeInCell) timeInCell.innerText = st.time_in;

                        const statusCell = row.querySelector('.student-status-cell');
                        if (statusCell) {
                            let badgeHtml = '';
                            if (st.presence_status === 'Inside Campus') {
                                badgeHtml = `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/80"><span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>Inside Campus</span>`;
                            } else if (st.presence_status === 'Departed') {
                                badgeHtml = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">Departed</span>`;
                            } else if (st.presence_status === 'Present') {
                                badgeHtml = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">Present</span>`;
                            } else if (st.presence_status === 'Late') {
                                badgeHtml = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">Late</span>`;
                            } else if (st.presence_status === 'Excused') {
                                badgeHtml = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">Excused</span>`;
                            } else {
                                badgeHtml = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">Absent</span>`;
                            }
                            statusCell.innerHTML = badgeHtml;
                        }
                    }
                });
            }
        })
        .catch(err => console.error('Live sync poll error:', err));
    }

    // Start auto polling every 4 seconds
    setInterval(fetchLiveData, 4000);
</script>

@endsection