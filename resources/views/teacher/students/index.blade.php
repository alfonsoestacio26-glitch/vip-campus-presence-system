@extends('layouts.teacher')

@section('page-title', 'Students')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- HEADER -->

    <div class="mb-7">

        <h1 class="text-2xl font-bold text-[#0e2c56]">
            Students
        </h1>

        <p class="text-sm text-slate-400 mt-1">
            View student profiles and attendance information.
        </p>

    </div>


    <!-- STUDENTS TABLE -->

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">

            <div>

                <h2 class="text-sm font-bold text-[#0e2c56]">
                    Student List
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    {{ $students->count() }} student(s)
                </p>

            </div>

        </div>


        @if($students->count() > 0)

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50">

                        <tr class="border-b border-slate-200">

                            <th class="px-6 py-4 text-left text-xs uppercase tracking-wide text-slate-500">
                                Student
                            </th>

                            <th class="px-6 py-4 text-left text-xs uppercase tracking-wide text-slate-500">
                                Student No.
                            </th>

                            <th class="px-6 py-4 text-left text-xs uppercase tracking-wide text-slate-500">
                                Grade & Section
                            </th>

                            <th class="px-6 py-4 text-left text-xs uppercase tracking-wide text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right text-xs uppercase tracking-wide text-slate-500">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @foreach($students as $student)

                            <tr class="hover:bg-slate-50 transition">

                                <!-- STUDENT -->

                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        @if($student->photo)

                                            <img
                                                src="{{ asset('storage/' . $student->photo) }}"
                                                class="w-10 h-10 rounded-full object-cover"
                                                alt="Student">

                                        @else

                                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">

                                                <i class="fa-solid fa-user"></i>

                                            </div>

                                        @endif


                                        <div>

                                            <p class="text-sm font-medium text-[#0e2c56]">

                                                {{ $student->first_name }}
                                                {{ $student->middle_name ? $student->middle_name . ' ' : '' }}
                                                {{ $student->last_name }}

                                            </p>

                                        </div>

                                    </div>

                                </td>


                                <!-- STUDENT NUMBER -->

                                <td class="px-6 py-4 text-sm text-slate-600">

                                    {{ $student->student_no }}

                                </td>


                                <!-- GRADE -->

                                <td class="px-6 py-4 text-sm text-slate-600">

                                    {{ $student->grade_level }}

                                    @if($student->section)
                                        - {{ $student->section }}
                                    @endif

                                </td>


                                <!-- STATUS -->

                                <td class="px-6 py-4">

                                    @if($student->status === 'Active' || $student->status === 'active')

                                        <span class="px-2.5 py-1 rounded-full bg-green-50 text-green-600 text-xs font-medium">
                                            Active
                                        </span>

                                    @else

                                        <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-medium">
                                            {{ $student->status ?? 'Inactive' }}
                                        </span>

                                    @endif

                                </td>


                                <!-- ACTION -->

                                <td class="px-6 py-4 text-right">

                                    <a
                                        href="{{ route('teacher.students.show', $student) }}"
                                        class="inline-flex items-center gap-2 px-3 py-2 rounded-lg
                                        text-sm font-medium text-[#0e4a8a]
                                        hover:bg-blue-50"
                                    >

                                        <i class="fa-regular fa-eye"></i>

                                        View

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="py-16 text-center">

                <div class="w-12 h-12 mx-auto rounded-full bg-slate-50 flex items-center justify-center">

                    <i class="fa-solid fa-user-graduate text-slate-300"></i>

                </div>

                <h3 class="text-sm font-medium text-slate-500 mt-4">
                    No students found
                </h3>

                <p class="text-xs text-slate-400 mt-1">
                    Student records will appear here.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection