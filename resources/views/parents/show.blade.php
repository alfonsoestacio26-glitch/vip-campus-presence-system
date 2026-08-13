<x-admin-layout>

    <div class="max-w-7xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-6">

            <div class="flex items-center justify-between">

                <div class="flex items-center gap-3">

                    {{-- Back Button --}}
                    <a
                        href="{{ route('parents.index') }}"
                        class="w-9 h-9 rounded-xl
                               bg-white border border-slate-200
                               flex items-center justify-center
                               text-slate-500
                               hover:text-[#123b70]
                               hover:border-[#123b70]
                               transition"
                        title="Back to Parents"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 19l-7-7 7-7"
                            />
                        </svg>
                    </a>

                    <div>
                        <h1 class="text-2xl font-bold text-[#0e2c56]">
                            Parent Profile
                        </h1>

                        <p class="text-sm text-slate-400 mt-1">
                            Detailed profile information
                        </p>
                    </div>

                </div>

                {{-- Edit Button --}}
                <a
                    href="{{ route('parents.edit', $parent) }}"
                    class="inline-flex items-center gap-2
                           bg-[#123b70]
                           hover:bg-[#0e2c56]
                           text-white
                           text-sm font-semibold
                           px-5 py-2.5
                           rounded-xl
                           transition"
                >
                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16.862 3.487a2.25 2.25 0 013.182 3.182L8.25 18.464 4 19.75l1.286-4.25L16.862 3.487z"
                        />
                    </svg>
                    Edit Profile
                </a>

            </div>

        </div>

        {{-- Profile Header Card --}}
        <div
            class="bg-white rounded-2xl
                   border border-slate-200
                   shadow-sm
                   overflow-hidden
                   mb-6"
        >

            {{-- Blue Header Banner --}}
            <div class="bg-[#123b70] px-6 py-6">

                <div class="flex items-center gap-5">

                    {{-- Avatar --}}
                    <div
                        class="w-20 h-20
                               rounded-2xl
                               bg-white/10
                               border border-white/20
                               flex items-center justify-center
                               flex-shrink-0"
                    >
                        <svg
                            class="w-10 h-10 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                cx="12"
                                cy="8"
                                r="4"
                                stroke-width="1.6"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-width="1.6"
                                d="M4 21a8 8 0 0116 0"
                            />
                        </svg>
                    </div>

                    {{-- Parent Name --}}
                    <div class="text-white">

                        <h2 class="text-2xl font-bold">
                            {{ $parent->first_name }}
                            @if($parent->middle_name)
                                {{ $parent->middle_name }}
                            @endif
                            {{ $parent->last_name }}
                        </h2>

                        <p class="text-white/70 text-sm mt-1">
                            Role: <span class="text-white font-semibold">Parent / Guardian</span>
                        </p>

                    </div>

                </div>

            </div>

            {{-- Profile Details Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-px bg-slate-100 border-t border-slate-100">

                {{-- Phone --}}
                <div class="bg-white px-6 py-5">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">
                        Phone Number
                    </p>
                    <p class="text-base font-bold text-[#0e2c56] mt-1">
                        {{ $parent->phone ?? '—' }}
                    </p>
                </div>

                {{-- Address --}}
                <div class="bg-white px-6 py-5">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">
                        Home Address
                    </p>
                    <p class="text-base font-medium text-slate-600 mt-1">
                        {{ $parent->address ?? '—' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Linked Children/Students Section --}}
        <div
            class="bg-white
                   rounded-2xl
                   border border-slate-200
                   shadow-sm
                   overflow-hidden"
        >

            {{-- Section Header --}}
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="text-sm font-bold text-[#0e2c56]">
                    Linked Students / Children
                </h3>
                <p class="text-xs text-slate-400 mt-1">
                    List of students associated with this parent
                </p>
            </div>

            {{-- Children List --}}
            <div class="p-6">
                @if($parent->students && $parent->students->count())
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                    <th class="px-6 py-3">Student ID</th>
                                    <th class="px-6 py-3">Student Name</th>
                                    <th class="px-6 py-3">Grade / Section</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($parent->students as $student)
                                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition text-sm text-slate-600">
                                        <td class="px-6 py-4 font-semibold text-slate-700">
                                            {{ $student->student_no }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $student->first_name }}
                                            @if($student->middle_name)
                                                {{ $student->middle_name }}
                                            @endif
                                            {{ $student->last_name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $student->grade_level }} - {{ $student->section ?? '—' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ ($student->status ?? 'active') === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($student->status ?? 'active') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a
                                                href="{{ route('students.show', $student) }}"
                                                class="text-[#123b70] hover:underline font-semibold"
                                            >
                                                View Profile
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="flex flex-col items-center py-8">
                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-4">
                            <svg
                                class="w-6 h-6 text-slate-300"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                                />
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-500">
                            No students linked
                        </p>
                        <p class="text-xs text-slate-400 mt-1">
                            This parent profile is not linked to any student records.
                        </p>
                    </div>
                @endif
            </div>

        </div>

    </div>

</x-admin-layout>
