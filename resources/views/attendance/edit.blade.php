<x-admin-layout>

    <div class="max-w-3xl mx-auto">

        <div class="mb-6">

            <h1 class="text-2xl font-bold text-[#0e2c56]">
                Edit Attendance
            </h1>

            <p class="text-sm text-slate-400 mt-1">
                Update attendance record
            </p>

        </div>


        @if($errors->any())

            <div class="mb-5
                        bg-red-50
                        border border-red-100
                        text-red-700
                        px-4 py-3
                        rounded-xl
                        text-sm">

                <ul class="list-disc ml-5">

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        <form
            action="{{ route('attendance.update', $attendance) }}"
            method="POST"
            class="bg-white
                   rounded-2xl
                   border border-slate-200
                   shadow-sm
                   p-6"
        >

            @csrf
            @method('PUT')


            {{-- Student --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-slate-600 mb-2">
                    Student
                </label>

                <select
                    name="student_id"
                    required
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm"
                >

                    @foreach($students as $student)

                        <option
                            value="{{ $student->id }}"
                            @selected($attendance->student_id == $student->id)
                        >

                            {{ $student->student_no }}
                            —
                            {{ $student->first_name }}
                            {{ $student->last_name }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Guard --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-slate-600 mb-2">
                    Guard
                </label>

                <select
                    name="guard_id"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm"
                >

                    <option value="">
                        Select guard
                    </option>

                    @foreach($guards as $guard)

                        <option
                            value="{{ $guard->id }}"
                            @selected($attendance->guard_id == $guard->id)
                        >

                            {{ $guard->employee_no }}
                            —
                            {{ $guard->first_name }}
                            {{ $guard->last_name }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Date --}}
            <div class="mb-5">

                <label class="block text-sm font-semibold text-slate-600 mb-2">
                    Attendance Date
                </label>

                <input
                    type="date"
                    name="attendance_date"
                    value="{{ old(
                        'attendance_date',
                        $attendance->attendance_date?->format('Y-m-d')
                    ) }}"
                    required
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm"
                >

            </div>


            {{-- Times --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>

                    <label class="block text-sm font-semibold text-slate-600 mb-2">
                        Time In
                    </label>

                    <input
                        type="time"
                        name="time_in"
                        value="{{ old('time_in', $attendance->time_in) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm"
                    >

                </div>


                <div>

                    <label class="block text-sm font-semibold text-slate-600 mb-2">
                        Time Out
                    </label>

                    <input
                        type="time"
                        name="time_out"
                        value="{{ old('time_out', $attendance->time_out) }}"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm"
                    >

                </div>

            </div>


            {{-- Status --}}
            <div class="mt-5">

                <label class="block text-sm font-semibold text-slate-600 mb-2">
                    Status
                </label>

                <select
                    name="status"
                    required
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm"
                >

                    <option
                        value="present"
                        @selected($attendance->status === 'present')
                    >
                        Present
                    </option>

                    <option
                        value="late"
                        @selected($attendance->status === 'late')
                    >
                        Late
                    </option>

                    <option
                        value="absent"
                        @selected($attendance->status === 'absent')
                    >
                        Absent
                    </option>

                </select>

            </div>


            {{-- Buttons --}}
            <div class="flex justify-end gap-3 mt-8">

                <a
                    href="{{ route('attendance.index') }}"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 bg-slate-100"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-[#123b70] hover:bg-[#0e2c56]"
                >
                    Update Attendance
                </button>

            </div>

        </form>

    </div>

</x-admin-layout>