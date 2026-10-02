@extends('layouts.teacher')

@section('page-title', 'My Students')
@section('page-subtitle', 'View students across campus sections')

@section('content')

<div class="space-y-6">

    <!-- STUDENTS TABLE PANEL -->
    <div class="dashboard-panel">
        <div class="panel-header">
            <div>
                <h2 class="panel-title">
                    Student Roster
                </h2>
                <p class="panel-subtitle">
                    {{ $students->total() ?? $students->count() }} student(s) enrolled
                </p>
            </div>
        </div>

        @if($students->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/50">
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Student Photo & Name
                            </th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Student No.
                            </th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Grade Level
                            </th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Section
                            </th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Gender
                            </th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="py-3 px-5 text-xs font-semibold text-slate-400 uppercase tracking-wider text-right">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach($students as $student)
                            <tr class="hover:bg-slate-50/60 transition duration-150">
                                <!-- STUDENT PHOTO & NAME -->
                                <td class="py-3.5 px-5">
                                    <div class="flex items-center gap-3">
                                        <img
                                            src="{{ $student->photo_url }}"
                                            class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-2xs"
                                            alt="Student Photo"
                                        >
                                        <div>
                                            <p class="text-xs font-bold text-[#0e2c56]">
                                                {{ $student->formatted_name }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- STUDENT NUMBER -->
                                <td class="py-3.5 px-5 text-xs font-medium text-slate-700 font-mono">
                                    {{ $student->student_no }}
                                </td>

                                <!-- GRADE LEVEL -->
                                <td class="py-3.5 px-5 text-xs text-slate-600">
                                    {{ $student->grade_level ? 'Grade ' . $student->grade_level : '—' }}
                                </td>

                                <!-- SECTION -->
                                <td class="py-3.5 px-5 text-xs text-slate-600">
                                    {{ $student->section ?: '—' }}
                                </td>

                                <!-- GENDER -->
                                <td class="py-3.5 px-5 text-xs text-slate-600">
                                    {{ $student->gender ?: '—' }}
                                </td>

                                <!-- STATUS -->
                                <td class="py-3.5 px-5 whitespace-nowrap">
                                    @if(strtolower($student->status) === 'active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                            {{ $student->status ?? 'Inactive' }}
                                        </span>
                                    @endif
                                </td>

                                <!-- ACTION -->
                                <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                    <a
                                        href="{{ route('teacher.students.show', $student) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 transition border border-blue-200/60"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View Profile
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="h-64 flex flex-col items-center justify-center text-center p-6">
                <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center border border-slate-100">
                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-500 mt-4">
                    No students found
                </h3>
                <p class="text-xs text-slate-400 mt-1">
                    Enrolled student records will appear here.
                </p>
            </div>
        @endif
    </div>
</div>

@endsection