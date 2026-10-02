<x-admin-layout>

    <div class="max-w-4xl mx-auto">

        <div class="flex items-center justify-between mb-6">

            <div>

                <h1 class="text-2xl font-bold text-[#0e2c56]">
                    Attendance Details
                </h1>

                <p class="text-sm text-slate-400 mt-1">
                    View attendance record
                </p>

            </div>

            <a
                href="{{ route('attendance.index') }}"
                class="text-sm font-semibold text-[#123b70] hover:underline"
            >
                ← Back to Attendance
            </a>

        </div>


        <div class="bg-white
                    rounded-2xl
                    border border-slate-200
                    shadow-sm
                    overflow-hidden">

            <div class="p-6">

                <div class="flex items-center gap-4 mb-8">

                    <div class="w-14 h-14
                                rounded-full
                                bg-blue-50
                                flex items-center
                                justify-center">

                        <svg
                            class="w-7 h-7 text-[#123b70]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                cx="12"
                                cy="8"
                                r="4"
                                stroke-width="1.8"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-width="1.8"
                                d="M4 21a8 8 0 0116 0"
                            />
                        </svg>

                    </div>

                    <div>

                        <h2 class="text-lg font-bold text-slate-700">

                            {{ $attendance->student->first_name }}
                            {{ $attendance->student->last_name }}

                        </h2>

                        <p class="text-sm text-slate-400">

                            {{ $attendance->student->student_no }}

                        </p>

                    </div>

                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <p class="text-xs uppercase font-semibold text-slate-400">
                            Attendance Date
                        </p>

                        <p class="text-sm font-semibold text-slate-700 mt-1">
                            {{ $attendance->attendance_date?->format('F d, Y') }}
                        </p>
                    </div>


                    <div>
                        <p class="text-xs uppercase font-semibold text-slate-400">
                            Status
                        </p>

                        <div class="mt-1">
                            @if(strtolower($attendance->status) === 'present')
                                <span class="inline-flex px-2.5 py-1 rounded-lg bg-green-50 text-green-700 text-xs font-semibold">
                                    Present
                                </span>
                            @elseif(strtolower($attendance->status) === 'late')
                                <span class="inline-flex px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 text-xs font-semibold">
                                    Late
                                </span>
                            @else
                                <span class="inline-flex px-2.5 py-1 rounded-lg bg-red-50 text-red-700 text-xs font-semibold">
                                    Absent
                                </span>
                            @endif
                        </div>
                    </div>


                    <div>
                        <p class="text-xs uppercase font-semibold text-slate-400">
                            Time In
                        </p>

                        <p class="text-sm font-semibold text-slate-700 mt-1">

                            {{ $attendance->time_in
                                ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A')
                                : '—'
                            }}

                        </p>
                    </div>


                    <div>
                        <p class="text-xs uppercase font-semibold text-slate-400">
                            Time Out
                        </p>

                        <p class="text-sm font-semibold text-slate-700 mt-1">

                            {{ $attendance->time_out
                                ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A')
                                : '—'
                            }}

                        </p>
                    </div>


                    <div>
                        <p class="text-xs uppercase font-semibold text-slate-400">
                            Guard
                        </p>

                        <p class="text-sm font-semibold text-slate-700 mt-1">

                            {{ $attendance->guardProfile
                                ? $attendance->guardProfile->first_name . ' ' . $attendance->guardProfile->last_name
                                : '—'
                            }}

                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</x-admin-layout>