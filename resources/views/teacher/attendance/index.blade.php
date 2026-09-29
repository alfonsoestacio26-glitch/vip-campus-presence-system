@extends('layouts.teacher')

@section('page-title', 'Attendance')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-[#0e2c56]">
            Attendance
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Monitor student campus attendance records.
        </p>
    </div>


    {{-- Filters --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">

        <form method="GET"
              action="{{ route('teacher.attendance.index') }}"
              class="grid grid-cols-1 md:grid-cols-4 gap-4">

            {{-- Search --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-2">
                    Search Student
                </label>

                <div class="relative">

                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-sm"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Name or student no."
                        class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#0e2c56] focus:border-[#0e2c56]"
                    >

                </div>
            </div>


            {{-- Date --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-2">
                    Date
                </label>

                <input
                    type="date"
                    name="date"
                    value="{{ request('date') }}"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#0e2c56] focus:border-[#0e2c56]"
                >
            </div>


            {{-- Status --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-2">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#0e2c56] focus:border-[#0e2c56]"
                >

                    <option value="">All Status</option>

                    <option value="Present"
                        {{ request('status') === 'Present' ? 'selected' : '' }}>
                        Present
                    </option>

                    <option value="Late"
                        {{ request('status') === 'Late' ? 'selected' : '' }}>
                        Late
                    </option>

                    <option value="Absent"
                        {{ request('status') === 'Absent' ? 'selected' : '' }}>
                        Absent
                    </option>

                </select>
            </div>


            {{-- Buttons --}}
            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-[#0e2c56] text-white text-sm font-semibold hover:bg-[#123b70]"
                >
                    <i class="fa-solid fa-filter mr-1"></i>
                    Filter
                </button>

                <a
                    href="{{ route('teacher.attendance.index') }}"
                    class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 text-sm font-semibold hover:bg-gray-50"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- Attendance Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">

            <div>
                <h2 class="font-bold text-[#0e2c56]">
                    Attendance Records
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    {{ $attendances->total() }} record(s) found
                </p>
            </div>

            <div class="w-10 h-10 rounded-xl bg-[#f3f7fc] flex items-center justify-center">
                <i class="fa-solid fa-calendar-check text-[#0e2c56]"></i>
            </div>

        </div>


        @if($attendances->count())

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-[#f8fafc]">

                        <tr class="text-left text-xs uppercase text-gray-500">

                            <th class="px-6 py-4">
                                Student
                            </th>

                            <th class="px-6 py-4">
                                Date
                            </th>

                            <th class="px-6 py-4">
                                Time In
                            </th>

                            <th class="px-6 py-4">
                                Time Out
                            </th>

                            <th class="px-6 py-4">
                                Status
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($attendances as $attendance)

                            <tr class="hover:bg-gray-50">

                                {{-- Student --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        @if($attendance->student?->photo)

                                            <img
                                                src="{{ asset('storage/' . $attendance->student->photo) }}"
                                                class="w-10 h-10 rounded-full object-cover"
                                                alt="Student"
                                            >

                                        @else

                                            <div class="w-10 h-10 rounded-full bg-[#f3f7fc] flex items-center justify-center">
                                                <i class="fa-solid fa-user text-gray-400"></i>
                                            </div>

                                        @endif

                                        <div>

                                            <p class="font-semibold text-gray-700">
                                                {{ $attendance->student?->first_name }}
                                                {{ $attendance->student?->last_name }}
                                            </p>

                                            <p class="text-xs text-gray-400">
                                                {{ $attendance->student?->student_no }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Date --}}
                                <td class="px-6 py-4 text-gray-600">

                                    {{ $attendance->attendance_date
                                        ? \Carbon\Carbon::parse($attendance->attendance_date)->format('M d, Y')
                                        : '—'
                                    }}

                                </td>


                                {{-- Time In --}}
                                <td class="px-6 py-4 text-gray-600">

                                    {{ $attendance->time_in
                                        ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A')
                                        : '—'
                                    }}

                                </td>


                                {{-- Time Out --}}
                                <td class="px-6 py-4 text-gray-600">

                                    {{ $attendance->time_out
                                        ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A')
                                        : '—'
                                    }}

                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    @php
                                        $status = strtolower($attendance->status ?? '');
                                    @endphp

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold

                                        @if($status === 'present')
                                            bg-green-100 text-green-700

                                        @elseif($status === 'late')
                                            bg-yellow-100 text-yellow-700

                                        @elseif($status === 'absent')
                                            bg-red-100 text-red-700

                                        @else
                                            bg-gray-100 text-gray-600
                                        @endif
                                    ">

                                        {{ $attendance->status ?? 'Unknown' }}

                                    </span>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $attendances->links() }}
            </div>


        @else

            <div class="py-16 text-center">

                <div class="w-14 h-14 mx-auto rounded-full bg-[#f3f7fc] flex items-center justify-center">
                    <i class="fa-solid fa-calendar-xmark text-xl text-gray-400"></i>
                </div>

                <h3 class="mt-4 font-semibold text-gray-700">
                    No attendance records found
                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Try changing your search or filter.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection