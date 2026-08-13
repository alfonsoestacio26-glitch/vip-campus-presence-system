<x-admin-layout>

    <div class="max-w-7xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-6">

            <div class="flex items-center justify-between">

                <div>
                    <div class="flex items-center gap-3">

                        {{-- Back --}}
                        <a
                            href="{{ route('students.index') }}"
                            class="w-9 h-9 rounded-xl
                                   bg-white border border-slate-200
                                   flex items-center justify-center
                                   text-slate-500
                                   hover:text-[#123b70]
                                   hover:border-[#123b70]
                                   transition"
                            title="Back to Students"
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
                                Student Profile
                            </h1>

                            <p class="text-sm text-slate-400 mt-1">
                                View complete student information
                            </p>
                        </div>

                    </div>
                </div>


                {{-- Edit Button --}}
                <a
                    href="{{ route('students.edit', $student) }}"
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

                    Edit Student

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

            {{-- Blue Header --}}
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


                    {{-- Student Name --}}
                    <div class="text-white">

                        <h2 class="text-2xl font-bold">

                            {{ $student->first_name }}

                            @if($student->middle_name)
                                {{ $student->middle_name }}
                            @endif

                            {{ $student->last_name }}

                        </h2>

                        <p class="text-white/70 text-sm mt-1">
                            Student ID:
                            <span class="text-white font-semibold">
                                {{ $student->student_no }}
                            </span>
                        </p>

                    </div>


                    {{-- Status --}}
                    <div class="ml-auto">

                        @if(($student->status ?? 'active') === 'active')

                            <span
                                class="inline-flex items-center gap-2
                                       px-3 py-1.5
                                       rounded-full
                                       bg-green-400/15
                                       text-green-100
                                       border border-green-300/20
                                       text-xs font-semibold"
                            >

                                <span
                                    class="w-2 h-2 rounded-full bg-green-300"
                                ></span>

                                Active

                            </span>

                        @else

                            <span
                                class="inline-flex items-center
                                       px-3 py-1.5
                                       rounded-full
                                       bg-red-400/15
                                       text-red-100
                                       border border-red-300/20
                                       text-xs font-semibold"
                            >
                                {{ ucfirst($student->status) }}
                            </span>

                        @endif

                    </div>

                </div>

            </div>


            {{-- Quick Information --}}
            <div class="grid grid-cols-1 md:grid-cols-3">

                {{-- Grade --}}
                <div class="px-6 py-5 border-b md:border-b-0 md:border-r border-slate-100">

                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">
                        Grade / Level
                    </p>

                    <p class="text-lg font-bold text-[#0e2c56] mt-1">
                        {{ $student->grade_level ?? '—' }}
                    </p>

                </div>


                {{-- Section --}}
                <div class="px-6 py-5 border-b md:border-b-0 md:border-r border-slate-100">

                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">
                        Section
                    </p>

                    <p class="text-lg font-bold text-[#0e2c56] mt-1">
                        {{ $student->section ?? '—' }}
                    </p>

                </div>


                {{-- Gender --}}
                <div class="px-6 py-5">

                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">
                        Gender
                    </p>

                    <p class="text-lg font-bold text-[#0e2c56] mt-1">
                        {{ $student->gender ?? '—' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Main Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


            {{-- Personal Information --}}
            <div
                class="lg:col-span-2
                       bg-white
                       rounded-2xl
                       border border-slate-200
                       shadow-sm
                       overflow-hidden"
            >

                {{-- Header --}}
                <div
                    class="px-6 py-4
                           border-b border-slate-100
                           flex items-center gap-3"
                >

                    <div
                        class="w-9 h-9 rounded-lg
                               bg-blue-50
                               flex items-center justify-center"
                    >

                        <svg
                            class="w-5 h-5 text-[#123b70]"
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

                        <h3 class="text-sm font-bold text-[#0e2c56]">
                            Personal Information
                        </h3>

                        <p class="text-xs text-slate-400">
                            Basic information about the student
                        </p>

                    </div>

                </div>


                {{-- Information --}}
                <div class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">


                        {{-- Student Number --}}
                        <div>

                            <p class="text-xs font-medium text-slate-400 mb-1">
                                Student Number
                            </p>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $student->student_no ?? '—' }}
                            </p>

                        </div>


                        {{-- First Name --}}
                        <div>

                            <p class="text-xs font-medium text-slate-400 mb-1">
                                First Name
                            </p>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $student->first_name ?? '—' }}
                            </p>

                        </div>


                        {{-- Middle Name --}}
                        <div>

                            <p class="text-xs font-medium text-slate-400 mb-1">
                                Middle Name
                            </p>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $student->middle_name ?? '—' }}
                            </p>

                        </div>


                        {{-- Last Name --}}
                        <div>

                            <p class="text-xs font-medium text-slate-400 mb-1">
                                Last Name
                            </p>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $student->last_name ?? '—' }}
                            </p>

                        </div>


                        {{-- Gender --}}
                        <div>

                            <p class="text-xs font-medium text-slate-400 mb-1">
                                Gender
                            </p>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $student->gender ?? '—' }}
                            </p>

                        </div>


                        {{-- Birthdate --}}
                        <div>

                            <p class="text-xs font-medium text-slate-400 mb-1">
                                Birthdate
                            </p>

                            <p class="text-sm font-semibold text-slate-700">

                                @if($student->birthdate)

                                    {{ \Carbon\Carbon::parse($student->birthdate)->format('F d, Y') }}

                                @else

                                    —

                                @endif

                            </p>

                        </div>


                        {{-- Grade --}}
                        <div>

                            <p class="text-xs font-medium text-slate-400 mb-1">
                                Grade / Level
                            </p>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $student->grade_level ?? '—' }}
                            </p>

                        </div>


                        {{-- Section --}}
                        <div>

                            <p class="text-xs font-medium text-slate-400 mb-1">
                                Section
                            </p>

                            <p class="text-sm font-semibold text-slate-700">
                                {{ $student->section ?? '—' }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- QR Code --}}
            <div
                class="bg-white
                       rounded-2xl
                       border border-slate-200
                       shadow-sm
                       overflow-hidden"
            >

                {{-- Header --}}
                <div
                    class="px-6 py-4
                           border-b border-slate-100"
                >

                    <h3 class="text-sm font-bold text-[#0e2c56]">
                        Campus Presence QR
                    </h3>

                    <p class="text-xs text-slate-400 mt-1">
                        Student identification code
                    </p>

                </div>


                {{-- QR Content --}}
                <div class="p-6">

                    <div
                        class="aspect-square
                               max-w-[220px]
                               mx-auto
                               rounded-2xl
                               bg-slate-50
                               border border-slate-200
                               flex items-center justify-center"
                    >

                        @if($student->qr_code)

                            <div class="text-center">

                                {{-- If QR image exists --}}
                                <img
                                    src="{{ asset('storage/' . $student->qr_code) }}"
                                    alt="Student QR Code"
                                    class="w-44 h-44 object-contain mx-auto"
                                >

                            </div>

                        @else

                            <div class="text-center px-5">

                                <div
                                    class="w-14 h-14
                                           rounded-full
                                           bg-white
                                           flex items-center justify-center
                                           mx-auto mb-3
                                           border border-slate-200"
                                >

                                    <svg
                                        class="w-7 h-7 text-slate-300"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <rect
                                            x="3"
                                            y="3"
                                            width="7"
                                            height="7"
                                            rx="1"
                                            stroke-width="1.6"
                                        />

                                        <rect
                                            x="14"
                                            y="3"
                                            width="7"
                                            height="7"
                                            rx="1"
                                            stroke-width="1.6"
                                        />

                                        <rect
                                            x="3"
                                            y="14"
                                            width="7"
                                            height="7"
                                            rx="1"
                                            stroke-width="1.6"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-width="1.6"
                                            d="M14 14h3v3h-3zM18 18h3v3h-3zM14 18h2"
                                        />

                                    </svg>

                                </div>

                                <p class="text-sm font-semibold text-slate-500">
                                    QR Code Not Generated
                                </p>

                                <p class="text-xs text-slate-400 mt-1">
                                    A QR code will appear here once generated.
                                </p>

                            </div>

                        @endif

                    </div>


                    {{-- QR Code Value --}}
                    @if($student->qr_code)

                        <div class="mt-4 text-center">

                            <p class="text-xs text-slate-400">
                                QR Code
                            </p>

                            <p class="text-sm font-semibold text-[#123b70] mt-1 break-all">
                                {{ $student->qr_code }}
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- Parent Information --}}
        <div
            class="bg-white
                   rounded-2xl
                   border border-slate-200
                   shadow-sm
                   overflow-hidden
                   mt-6"
        >

            {{-- Header --}}
            <div
                class="px-6 py-4
                       border-b border-slate-100
                       flex items-center justify-between"
            >

                <div>

                    <h3 class="text-sm font-bold text-[#0e2c56]">
                        Parent / Guardian
                    </h3>

                    <p class="text-xs text-slate-400 mt-1">
                        Parent or guardian linked to this student
                    </p>

                </div>

            </div>


            {{-- Parent Content --}}
            <div class="p-6">

                {{-- We are not loading the parent relationship yet --}}
                <div
                    class="flex items-center gap-4
                           p-4
                           rounded-xl
                           bg-slate-50
                           border border-slate-100"
                >

                    <div
                        class="w-11 h-11
                               rounded-xl
                               bg-white
                               flex items-center justify-center
                               border border-slate-200"
                    >

                        <svg
                            class="w-5 h-5 text-slate-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >

                            <circle
                                cx="12"
                                cy="8"
                                r="4"
                                stroke-width="1.7"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-width="1.7"
                                d="M4 21a8 8 0 0116 0"
                            />

                        </svg>

                    </div>

                    <div>

                        <p class="text-sm font-semibold text-slate-600">
                            No parent linked
                        </p>

                        <p class="text-xs text-slate-400 mt-1">
                            Parent information will appear here once linked.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- Record Information --}}
        <div
            class="mt-6
                   flex flex-col sm:flex-row
                   items-start sm:items-center
                   justify-between
                   gap-3
                   text-xs text-slate-400"
        >

            <p>
                Student record created
                {{ $student->created_at ? $student->created_at->format('F d, Y h:i A') : '—' }}
            </p>

            <p>
                Last updated
                {{ $student->updated_at ? $student->updated_at->format('F d, Y h:i A') : '—' }}
            </p>

        </div>


    </div>

</x-admin-layout>