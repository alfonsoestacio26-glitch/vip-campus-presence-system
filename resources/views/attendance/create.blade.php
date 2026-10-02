<x-admin-layout>

    <div class="max-w-3xl mx-auto">

        <div class="mb-6">

            <h1 class="text-2xl font-bold text-[#0e2c56]">
                Add Attendance
            </h1>

            <p class="text-sm text-slate-400 mt-1">
                Record student attendance
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
            action="{{ route('attendance.store') }}"
            method="POST"
            class="bg-white
                   rounded-2xl
                   border border-slate-200
                   shadow-sm
                   p-6"
        >

            @csrf


            {{-- Student --}}
            <div class="mb-5">

                <label class="block text-sm
                              font-semibold
                              text-slate-600
                              mb-2">

                    Student

                </label>

                <select
                    name="student_id"
                    required
                    class="w-full
                           border border-slate-200
                           rounded-xl
                           px-4 py-3
                           text-sm
                           focus:ring-2
                           focus:ring-[#123b70]/20
                           focus:border-[#123b70]"
                >

                    <option value="">
                        Select student
                    </option>

                    @foreach($students as $student)

                        <option
                            value="{{ $student->id }}"
                            @selected(old('student_id') == $student->id)
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

                <label class="block text-sm
                              font-semibold
                              text-slate-600
                              mb-2">

                    Guard

                </label>

                <select
                    name="guard_id"
                    class="w-full
                           border border-slate-200
                           rounded-xl
                           px-4 py-3
                           text-sm
                           focus:ring-2
                           focus:ring-[#123b70]/20
                           focus:border-[#123b70]"
                >

                    <option value="">
                        Select guard
                    </option>

                    @foreach($guards as $guard)

                        <option
                            value="{{ $guard->id }}"
                            @selected(old('guard_id') == $guard->id)
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

                <label class="block text-sm
                              font-semibold
                              text-slate-600
                              mb-2">

                    Attendance Date

                </label>

                <input
                    type="date"
                    name="attendance_date"
                    value="{{ old('attendance_date', now()->format('Y-m-d')) }}"
                    required
                    class="w-full
                           border border-slate-200
                           rounded-xl
                           px-4 py-3
                           text-sm
                           focus:ring-2
                           focus:ring-[#123b70]/20
                           focus:border-[#123b70]"
                >

            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Time In --}}
                <div>

                    <label class="block text-sm
                                  font-semibold
                                  text-slate-600
                                  mb-2">

                        Time In

                    </label>

                    <input
                        type="time"
                        name="time_in"
                        value="{{ old('time_in') }}"
                        class="w-full
                               border border-slate-200
                               rounded-xl
                               px-4 py-3
                               text-sm
                               focus:ring-2
                               focus:ring-[#123b70]/20
                               focus:border-[#123b70]"
                    >

                </div>


                {{-- Time Out --}}
                <div>

                    <label class="block text-sm
                                  font-semibold
                                  text-slate-600
                                  mb-2">

                        Time Out

                    </label>

                    <input
                        type="time"
                        name="time_out"
                        value="{{ old('time_out') }}"
                        class="w-full
                               border border-slate-200
                               rounded-xl
                               px-4 py-3
                               text-sm
                               focus:ring-2
                               focus:ring-[#123b70]/20
                               focus:border-[#123b70]"
                    >

                </div>

            </div>


            {{-- Status --}}
            <div class="mt-5">

                <label class="block text-sm
                              font-semibold
                              text-slate-600
                              mb-2">

                    Status

                </label>

                <select
                    name="status"
                    required
                    class="w-full
                           border border-slate-200
                           rounded-xl
                           px-4 py-3
                           text-sm
                           focus:ring-2
                           focus:ring-[#123b70]/20
                           focus:border-[#123b70]"
                >

                    <option value="Present" @selected(old('status') == 'Present' || old('status') == 'present' || !old('status'))>
                        Present
                    </option>

                    <option value="Late" @selected(old('status') == 'Late' || old('status') == 'late')>
                        Late
                    </option>

                    <option value="Absent" @selected(old('status') == 'Absent' || old('status') == 'absent')>
                        Absent
                    </option>

                </select>

            </div>


            {{-- Buttons --}}
            <div class="flex
                        justify-end
                        gap-3
                        mt-8">

                <a
                    href="{{ route('attendance.index') }}"
                    class="px-5 py-2.5
                           rounded-xl
                           text-sm
                           font-semibold
                           text-slate-600
                           bg-slate-100
                           hover:bg-slate-200"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 bg-[#155d36] hover:bg-[#0f4628] active:bg-[#09321c] text-white font-bold text-sm rounded-xl px-5 py-2.5 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#155d36] focus:ring-offset-2 transition duration-200 border border-[#155d36]"
                >
                    Save Attendance
                </button>

            </div>

        </form>

    </div>

</x-admin-layout>