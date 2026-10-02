<x-admin-layout>

    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="mb-6">

            <div class="flex items-center justify-between">

                <div>
                    <h1 class="text-2xl font-bold text-[#0e2c56]">
                        Attendance
                    </h1>

                    <p class="text-sm text-slate-400 mt-1">
                        Manage student attendance records
                    </p>
                </div>

                <a
                    href="{{ route('attendance.create') }}"
                    class="inline-flex items-center gap-2 bg-[#155d36] hover:bg-[#0f4628] active:bg-[#09321c] text-white font-bold text-sm rounded-xl px-5 py-2.5 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#155d36] focus:ring-offset-2 transition duration-200 border border-[#155d36]"
                >
                    <svg class="w-4 h-4 text-white stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                    </svg>
                    <span>Add Attendance</span>
                </a>

            </div>

        </div>


        {{-- Success --}}
        @if(session('success'))

            <div class="mb-5
                        bg-green-50
                        border border-green-100
                        text-green-700
                        px-4 py-3
                        rounded-xl
                        text-sm
                        font-medium">

                {{ session('success') }}

            </div>

        @endif


        {{-- Table --}}
        <div class="bg-white
                    rounded-2xl
                    border border-slate-200
                    shadow-sm
                    overflow-hidden">

            {{-- Search --}}
            <div class="p-5 border-b border-slate-100">

                <form
                    method="GET"
                    action="{{ route('attendance.index') }}"
                >

                    <div class="relative min-w-0">
                        <svg
                            class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <circle cx="11" cy="11" r="7" stroke-width="1.8"/>
                            <path stroke-linecap="round" stroke-width="1.8" d="M20 20l-4-4"/>
                        </svg>

                        <input
                            type="text"
                            name="search"
                            value="{{ $search ?? request('search') }}"
                            placeholder="Search student by name or student ID..."
                            class="w-full pl-11 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#123b70]/20 focus:border-[#123b70] transition"
                        >

                        @if(request('search'))
                            <a href="{{ route('attendance.index', request()->except('search')) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 transition rounded-lg hover:bg-slate-200/50" title="Clear search">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        @endif
                    </div>

                </form>

            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50
                                  border-b border-slate-100">

                        <tr>

                            <th class="px-6 py-4
                                       text-left
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase">
                                Student
                            </th>

                            <th class="px-6 py-4
                                       text-left
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase">
                                Date
                            </th>

                            <th class="px-6 py-4
                                       text-left
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase">
                                Time In
                            </th>

                            <th class="px-6 py-4
                                       text-left
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase">
                                Time Out
                            </th>

                            <th class="px-6 py-4
                                       text-left
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase">
                                Status
                            </th>

                            <th class="px-6 py-4
                                       text-right
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($attendances as $attendance)

                            <tr class="border-b
                                       border-slate-100
                                       hover:bg-slate-50
                                       transition">

                                {{-- Student --}}
                                <td class="px-6 py-4">

                                    <div>

                                        <p class="text-sm
                                                  font-semibold
                                                  text-slate-700">

                                            {{ $attendance->student->first_name }}

                                            @if($attendance->student->middle_name)
                                                {{ $attendance->student->middle_name }}
                                            @endif

                                            {{ $attendance->student->last_name }}

                                        </p>

                                        <p class="text-xs
                                                  text-slate-400
                                                  mt-0.5">

                                            {{ $attendance->student->student_no }}

                                        </p>

                                    </div>

                                </td>


                                {{-- Date --}}
                                <td class="px-6 py-4
                                           text-sm
                                           text-slate-500">

                                    {{ $attendance->attendance_date?->format('M d, Y') }}

                                </td>


                                {{-- Time In --}}
                                <td class="px-6 py-4
                                           text-sm
                                           text-slate-500">

                                    {{ $attendance->time_in
                                        ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A')
                                        : '—'
                                    }}

                                </td>


                                {{-- Time Out --}}
                                <td class="px-6 py-4
                                           text-sm
                                           text-slate-500">

                                    {{ $attendance->time_out
                                        ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A')
                                        : '—'
                                    }}

                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    @if(strtolower($attendance->status) === 'present')

                                        <span class="inline-flex
                                                     px-2.5 py-1
                                                     rounded-lg
                                                     bg-green-50
                                                     text-green-700
                                                     text-xs
                                                     font-semibold">
                                            Present
                                        </span>

                                    @elseif(strtolower($attendance->status) === 'late')

                                        <span class="inline-flex
                                                     px-2.5 py-1
                                                     rounded-lg
                                                     bg-amber-50
                                                     text-amber-700
                                                     text-xs
                                                     font-semibold">
                                            Late
                                        </span>

                                    @else

                                        <span class="inline-flex
                                                     px-2.5 py-1
                                                     rounded-lg
                                                     bg-red-50
                                                     text-red-700
                                                     text-xs
                                                     font-semibold">
                                            Absent
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-4">

                                    <div class="flex
                                                items-center
                                                justify-end
                                                gap-4">

                                        <a
                                            href="{{ route('attendance.show', $attendance) }}"
                                            class="text-[#123b70]
                                                   hover:text-[#0e2c56]"
                                            title="View"
                                        >
                                            View
                                        </a>

                                        <a
                                            href="{{ route('attendance.edit', $attendance) }}"
                                            class="text-amber-500
                                                   hover:text-amber-600"
                                            title="Edit"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('attendance.destroy', $attendance) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this attendance record?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-red-500
                                                       hover:text-red-600"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-6 py-20 text-center"
                                >

                                    <p class="text-sm
                                              font-semibold
                                              text-slate-500">

                                        No attendance records yet.

                                    </p>

                                    <p class="text-xs
                                              text-slate-400
                                              mt-1">

                                        Add an attendance record to get started.

                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Pagination --}}
            @if($attendances->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $attendances->links() }}
                </div>
            @endif

        </div>

    </div>

</x-admin-layout>