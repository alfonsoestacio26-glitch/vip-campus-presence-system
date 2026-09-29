@extends('layouts.teacher')

@section('page-title', 'Student Profile')

@section('content')

<div class="space-y-6">

    {{-- Back --}}
    <div>
        <a href="{{ route('teacher.students.index') }}"
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#0e2c56]">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Students
        </a>
    </div>

    {{-- Student Profile --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        <div class="flex flex-col md:flex-row gap-6">

            {{-- Photo --}}
            <div class="flex-shrink-0">

                @if($student->photo)
                    <img
                        src="{{ asset('storage/' . $student->photo) }}"
                        alt="{{ $student->first_name }}"
                        class="w-32 h-32 rounded-2xl object-cover border border-gray-200"
                    >
                @else
                    <div class="w-32 h-32 rounded-2xl bg-[#f3f7fc] flex items-center justify-center">
                        <i class="fa-solid fa-user text-4xl text-gray-400"></i>
                    </div>
                @endif

            </div>

            {{-- Basic Information --}}
            <div class="flex-1">

                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3">

                    <div>
                        <h2 class="text-2xl font-bold text-[#0e2c56]">
                            {{ $student->first_name }}
                            {{ $student->middle_name }}
                            {{ $student->last_name }}
                        </h2>

                        <p class="text-gray-500 mt-1">
                            Student No: {{ $student->student_no }}
                        </p>
                    </div>

                    <span class="inline-flex w-fit px-3 py-1 rounded-full text-xs font-semibold
                        {{ strtolower($student->status) === 'active'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-gray-100 text-gray-600' }}">
                        {{ $student->status }}
                    </span>

                </div>

                {{-- Details --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-6">

                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">
                            Grade Level
                        </p>
                        <p class="text-sm font-semibold text-gray-700 mt-1">
                            {{ $student->grade_level }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">
                            Section
                        </p>
                        <p class="text-sm font-semibold text-gray-700 mt-1">
                            {{ $student->section ?? '—' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">
                            Gender
                        </p>
                        <p class="text-sm font-semibold text-gray-700 mt-1">
                            {{ $student->gender ?? '—' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 uppercase font-semibold">
                            Birthdate
                        </p>
                        <p class="text-sm font-semibold text-gray-700 mt-1">
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
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">

        <div class="p-6 border-b border-gray-100">

            <div class="flex items-center justify-between">

                <div>
                    <h3 class="text-lg font-bold text-[#0e2c56]">
                        Attendance History
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Student campus attendance records
                    </p>
                </div>

                <div class="w-10 h-10 rounded-xl bg-[#f3f7fc] flex items-center justify-center">
                    <i class="fa-solid fa-calendar-check text-[#0e2c56]"></i>
                </div>

            </div>

        </div>


        @if($student->attendances->count())

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-[#f8fafc]">

                        <tr class="text-left text-xs uppercase text-gray-500">

                            <th class="px-6 py-4 font-semibold">
                                Date
                            </th>

                            <th class="px-6 py-4 font-semibold">
                                Time In
                            </th>

                            <th class="px-6 py-4 font-semibold">
                                Time Out
                            </th>

                            <th class="px-6 py-4 font-semibold">
                                Status
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach($student->attendances as $attendance)

                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-4 font-medium text-gray-700">
                                    {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('M d, Y') }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $attendance->time_in
                                        ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A')
                                        : '—' }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $attendance->time_out
                                        ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A')
                                        : '—' }}
                                </td>

                                <td class="px-6 py-4">

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if(strtolower($attendance->status) === 'present')
                                            bg-green-100 text-green-700
                                        @elseif(strtolower($attendance->status) === 'absent')
                                            bg-red-100 text-red-700
                                        @elseif(strtolower($attendance->status) === 'late')
                                            bg-yellow-100 text-yellow-700
                                        @else
                                            bg-gray-100 text-gray-600
                                        @endif">

                                        {{ $attendance->status }}

                                    </span>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="p-10 text-center">

                <div class="w-14 h-14 mx-auto rounded-full bg-[#f3f7fc] flex items-center justify-center">
                    <i class="fa-solid fa-calendar-xmark text-xl text-gray-400"></i>
                </div>

                <h4 class="mt-4 font-semibold text-gray-700">
                    No attendance records
                </h4>

                <p class="text-sm text-gray-500 mt-1">
                    This student does not have any attendance records yet.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection