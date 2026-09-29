<x-admin-layout>

    <div class="max-w-7xl mx-auto" x-data="{ showImportModal: false }">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        {{-- Page Header --}}
        <div class="mb-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h1 class="text-2xl font-bold text-[#0e2c56]">
                        Students
                    </h1>

                    <p class="text-sm text-slate-400 mt-1">
                        Manage student records, batch enrollee cohorts, and print official ID badges
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center flex-wrap gap-2.5">

                    {{-- Export CSV --}}
                    <a
                        href="{{ route('students.export') }}"
                        class="inline-flex items-center gap-2
                               bg-white hover:bg-slate-50
                               border border-slate-200 text-slate-700
                               text-sm font-semibold
                               px-4 py-2.5 rounded-xl shadow-sm
                               transition"
                        title="Export students list to CSV"
                    >
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>Export CSV</span>
                    </a>

                    {{-- Import CSV Button --}}
                    <button
                        type="button"
                        @click="showImportModal = true"
                        class="inline-flex items-center gap-2
                               bg-white hover:bg-slate-50
                               border border-slate-200 text-slate-700
                               text-sm font-semibold
                               px-4 py-2.5 rounded-xl shadow-sm
                               transition"
                        title="Import students via CSV"
                    >
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <span>Import CSV</span>
                    </button>

                    {{-- Batch Badges Print --}}
                    <a
                        href="{{ route('students.badges.batch') }}"
                        class="inline-flex items-center gap-2
                               bg-indigo-50 hover:bg-indigo-100
                               border border-indigo-200 text-indigo-700
                               text-sm font-semibold
                               px-4 py-2.5 rounded-xl
                               transition"
                        title="Print batch official student ID cards"
                    >
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                        <span>Print Badges</span>
                    </a>

                    {{-- Add Student --}}
                    <a
                        href="{{ route('students.create') }}"
                        class="inline-flex items-center gap-2
                               bg-[#123b70] hover:bg-[#0e2c56]
                               text-white text-sm font-semibold
                               px-5 py-2.5 rounded-xl shadow-sm
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
                                d="M12 5v14M5 12h14"
                            />
                        </svg>
                        <span>Add Student</span>
                    </a>

                </div>

            </div>

        </div>


        {{-- Student Table --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- Search --}}
            <div class="p-5 border-b border-slate-100">

                <div class="relative">

                    <svg
                        class="absolute left-4 top-1/2 -translate-y-1/2
                               w-4 h-4 text-slate-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            cx="11"
                            cy="11"
                            r="7"
                            stroke-width="1.8"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-width="1.8"
                            d="M20 20l-4-4"
                        />
                    </svg>

                    <input
                        type="text"
                        placeholder="Search students..."
                        class="w-full pl-11 pr-4 py-3
                               border border-slate-200
                               rounded-xl
                               text-sm
                               focus:ring-2
                               focus:ring-[#123b70]/20
                               focus:border-[#123b70]"
                    >

                </div>

            </div>


            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    {{-- Table Header --}}
                    <thead class="bg-slate-50 border-b border-slate-100">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Student ID
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Student Name
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Grade / Level
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Parent
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Action
                            </th>

                        </tr>

                    </thead>


                    {{-- Table Body --}}
                    <tbody>

                        @forelse($students as $student)

                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">

                                {{-- Student ID --}}
                                <td class="px-6 py-4 text-sm font-semibold text-[#123b70]">

                                    {{ $student->student_no }}

                                </td>


                                {{-- Student Name --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        {{-- Student Icon --}}
                                        <div class="w-10 h-10 rounded-full
                                                    bg-blue-50
                                                    flex items-center justify-center
                                                    flex-shrink-0">

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

                                            <p class="text-sm font-semibold text-slate-700">

                                                {{ $student->first_name }}

                                                @if($student->middle_name)
                                                    {{ $student->middle_name }}
                                                @endif

                                                {{ $student->last_name }}

                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Grade Level --}}
                                <td class="px-6 py-4 text-sm text-slate-500">

                                    {{ $student->grade_level ?? '—' }}

                                </td>


                                {{-- Parent --}}
                                <td class="px-6 py-4 text-sm text-slate-500">

                                    @if($student->parents->isNotEmpty())
                                        <div class="space-y-1">

                                            @foreach($student->parents as $parent)
                                                <div class="flex items-center gap-2">

                                                    {{-- User Icon --}}
                                                    <svg
                                                        class="w-4 h-4 text-slate-400"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                                        />
                                                    </svg>

                                                    <span class="text-sm text-slate-600">
                                                        {{ $parent->first_name }}
                                                        {{ $parent->last_name }}
                                                    </span>

                                                </div>
                                            @endforeach

                                        </div>

                                    @else

                                        —

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    @if(($student->status ?? 'active') === 'active')

                                        <span
                                            class="inline-flex px-2.5 py-1
                                                   rounded-full
                                                   text-xs font-semibold
                                                   bg-green-50
                                                   text-green-600"
                                        >
                                            Active
                                        </span>

                                    @else

                                        <span
                                            class="inline-flex px-2.5 py-1
                                                   rounded-full
                                                   text-xs font-semibold
                                                   bg-red-50
                                                   text-red-600"
                                        >
                                            {{ ucfirst($student->status) }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-end gap-3">

                                        {{-- PRINT ID BADGE --}}
                                        <a
                                            href="{{ route('students.badge', $student) }}"
                                            class="text-indigo-600
                                                   hover:text-indigo-800
                                                   transition"
                                            title="Print ID Badge with QR"
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
                                                    stroke-width="1.8"
                                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"
                                                />
                                            </svg>
                                        </a>

                                        {{-- VIEW --}}
                                        <a
                                            href="{{ route('students.show', $student) }}"
                                            class="text-[#123b70]
                                                   hover:text-[#0e2c56]
                                                   transition"
                                            title="View Student"
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
                                                    stroke-width="1.8"
                                                    d="M2.5 12s3.5-6 9.5-6
                                                       9.5 6 9.5 6
                                                       -3.5 6-9.5 6
                                                       -9.5-6-9.5-6z"
                                                />

                                                <circle
                                                    cx="12"
                                                    cy="12"
                                                    r="2.5"
                                                    stroke-width="1.8"
                                                />

                                            </svg>

                                        </a>


                                        {{-- EDIT --}}
                                        <a
                                            href="{{ route('students.edit', $student) }}"
                                            class="text-amber-500
                                                   hover:text-amber-600
                                                   transition"
                                            title="Edit Student"
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
                                                    stroke-width="1.8"
                                                    d="M12 20h9"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4L16.5 3.5z"
                                                />

                                            </svg>

                                        </a>


                                        {{-- DELETE --}}
                                        <form
                                            action="{{ route('students.destroy', $student) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this student?');"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-red-500
                                                       hover:text-red-600
                                                       transition"
                                                title="Delete Student"
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
                                                        stroke-width="1.8"
                                                        d="M4 7h16"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M10 11v6M14 11v6"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M6 7l1 13h10l1-13"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M9 7V4h6v3"
                                                    />

                                                </svg>

                                            </button>

                                        </form>


                                    </div>

                                </td>

                            </tr>


                        @empty

                            {{-- Empty State --}}
                            <tr>

                                <td
                                    colspan="6"
                                    class="px-6 py-20 text-center"
                                >

                                    <div class="flex flex-col items-center">

                                        <div
                                            class="w-12 h-12 rounded-full
                                                   bg-slate-50
                                                   flex items-center justify-center
                                                   mb-4"
                                        >

                                            <svg
                                                class="w-6 h-6 text-slate-300"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >

                                                <circle
                                                    cx="9"
                                                    cy="7"
                                                    r="4"
                                                    stroke-width="1.8"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M2 21a7 7 0 0114 0"
                                                />

                                            </svg>

                                        </div>


                                        <p class="text-sm font-semibold text-slate-500">
                                            No students yet
                                        </p>


                                        <p class="text-xs text-slate-400 mt-1">
                                            Student records will appear here.
                                        </p>


                                        <a
                                            href="{{ route('students.create') }}"
                                            class="mt-4
                                                   text-sm font-semibold
                                                   text-[#123b70]
                                                   hover:underline"
                                        >
                                            Add your first student
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- ======================================================== --}}
    {{-- CSV BATCH IMPORT MODAL --}}
    {{-- ======================================================== --}}
    <div
        x-show="showImportModal"
        style="display: none;"
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        {{-- Backdrop --}}
        <div
            x-show="showImportModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
            @click="showImportModal = false"
        ></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div
                x-show="showImportModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200"
            >
                {{-- Modal Header --}}
                <div class="bg-gradient-to-r from-[#0e2c56] to-[#123b70] px-6 py-5 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold" id="modal-title">
                                Batch Import Students (CSV)
                            </h3>
                            <p class="text-xs text-blue-200 mt-0.5">
                                Enroll multiple student cohorts at once
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        @click="showImportModal = false"
                        class="text-white/70 hover:text-white transition rounded-lg p-1"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Form --}}
                <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="p-6 space-y-4">
                        {{-- Instructions Box --}}
                        <div class="bg-blue-50/70 border border-blue-100 rounded-xl p-4 text-xs text-slate-600 space-y-2">
                            <div class="font-bold text-[#0e2c56] flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>CSV Format Guidelines:</span>
                            </div>
                            <p>
                                Required columns: <code class="bg-white px-1.5 py-0.5 rounded border border-blue-200 font-mono text-[11px] text-blue-800">student_no</code>, <code class="bg-white px-1.5 py-0.5 rounded border border-blue-200 font-mono text-[11px] text-blue-800">first_name</code>, <code class="bg-white px-1.5 py-0.5 rounded border border-blue-200 font-mono text-[11px] text-blue-800">last_name</code>, <code class="bg-white px-1.5 py-0.5 rounded border border-blue-200 font-mono text-[11px] text-blue-800">grade_level</code>.
                            </p>
                            <p>
                                Optional: <span class="font-medium text-slate-700">middle_name, gender, birthdate (YYYY-MM-DD), section, status</span>. Duplicate student IDs will be automatically skipped.
                            </p>

                            <div class="pt-1">
                                <a
                                    href="{{ route('students.import.template') }}"
                                    class="inline-flex items-center gap-1.5 font-bold text-[#123b70] hover:text-[#0e2c56] hover:underline"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    <span>Download Sample CSV Template</span>
                                </a>
                            </div>
                        </div>

                        {{-- File Input --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Select CSV File
                            </label>
                            <div class="border-2 border-dashed border-slate-200 hover:border-[#123b70] rounded-xl p-5 text-center transition bg-slate-50/50">
                                <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <input
                                    type="file"
                                    name="csv_file"
                                    accept=".csv,text/csv,text/plain"
                                    required
                                    class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#123b70] file:text-white hover:file:bg-[#0e2c56] cursor-pointer"
                                >
                                <p class="text-[11px] text-slate-400 mt-2">Only .csv files up to 5MB are accepted</p>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-slate-100 rounded-b-2xl">
                        <button
                            type="button"
                            @click="showImportModal = false"
                            class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-100 transition"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-5 py-2 rounded-xl bg-[#123b70] hover:bg-[#0e2c56] text-white text-xs font-semibold shadow-sm transition flex items-center gap-1.5"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Upload & Enroll</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-admin-layout>