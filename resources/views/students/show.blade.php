<x-admin-layout>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Breadcrumb & Actions --}}
        <div class="flex items-center justify-between">

            <div class="flex items-center gap-3">

                {{-- Back button --}}
                <a
                    href="{{ route('students.index') }}"
                    class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-[#123b70] hover:border-[#123b70] transition shadow-sm"
                    title="Back to Students"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>

                {{-- Breadcrumbs --}}
                <nav class="flex items-center gap-2 text-base font-semibold text-slate-500">
                    <a href="{{ route('students.index') }}" class="hover:text-[#123b70] transition">
                        Students
                    </a>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-[#0e2c56] font-bold">
                        {{ $student->first_name }} {{ $student->middle_name ? $student->middle_name . ' ' : '' }}{{ $student->last_name }}
                    </span>
                </nav>

            </div>

            <div class="flex items-center gap-3">
                <a
                    href="{{ route('students.edit', $student) }}"
                    class="inline-flex items-center gap-2 bg-[#123b70] hover:bg-[#0e2c56] text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-sm transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>Edit Profile</span>
                </a>
            </div>

        </div>


        {{-- Alerts --}}
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm font-medium flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif


        {{-- Top Cards Row (Profile & QR Code) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Card: Student Profile Summary --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-7">

                <div class="flex flex-col sm:flex-row gap-6 items-start">

                    {{-- Student Photo with Upload Trigger --}}
                    <div class="relative group flex-shrink-0 mx-auto sm:mx-0" style="width: 144px;">
                        <div style="width: 144px; height: 144px; min-width: 144px; max-width: 144px; min-height: 144px; max-height: 144px; overflow: hidden; border-radius: 18px; border: 2px solid #f1f5f9; background-color: #f8fafc;" class="shadow-sm">
                            <img
                                id="student-profile-photo"
                                src="{{ $student->photo_url }}"
                                alt="{{ $student->first_name }}"
                                style="width: 100%; height: 100%; object-fit: cover; display: block;"
                            >
                        </div>

                        {{-- Quick Upload Overlay --}}
                        <form
                            action="{{ route('students.photo.update', $student) }}"
                            method="POST"
                            enctype="multipart/form-data"
                            id="photo-upload-form"
                            class="mt-2 text-center"
                        >
                            @csrf
                            <label
                                for="quick-photo-input"
                                class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-[#123b70] hover:text-[#0e2c56] cursor-pointer hover:underline"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>Change Photo</span>
                            </label>
                            <input
                                type="file"
                                id="quick-photo-input"
                                name="photo"
                                accept="image/*"
                                class="hidden"
                                onchange="document.getElementById('photo-upload-form').submit()"
                            >
                        </form>
                    </div>

                    {{-- Student Information Details --}}
                    <div class="flex-1 w-full space-y-3.5">

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-y-3 gap-x-4 text-sm pb-1">

                            <div class="text-slate-400 font-medium">
                                Student Number
                            </div>
                            <div class="sm:col-span-2 font-semibold text-slate-800 font-mono">
                                {{ $student->student_no }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Name
                            </div>
                            <div class="sm:col-span-2 font-bold text-[#0e2c56] text-base">
                                {{ $student->first_name }}
                                @if($student->middle_name) {{ $student->middle_name }} @endif
                                {{ $student->last_name }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Grade/Section
                            </div>
                            <div class="sm:col-span-2 font-semibold text-slate-800">
                                Grade {{ $student->grade_level ?? '—' }} - {{ $student->section ?? '—' }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Birthdate
                            </div>
                            <div class="sm:col-span-2 font-semibold text-slate-800">
                                {{ $student->birthdate ? \Carbon\Carbon::parse($student->birthdate)->format('F d, Y') : '—' }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Gender
                            </div>
                            <div class="sm:col-span-2 font-semibold text-slate-800">
                                {{ $student->gender ?? '—' }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Status
                            </div>
                            <div class="sm:col-span-2">
                                @if(strtolower($student->status ?? 'active') === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-slate-100 text-slate-600">
                                        {{ ucfirst($student->status) }}
                                    </span>
                                @endif
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Right Card: QR Code Card --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-7 flex flex-col justify-between items-center text-center">

                <div class="w-full text-left">
                    <h2 class="text-base font-bold text-[#0e2c56]">
                        QR Code
                    </h2>
                </div>

                {{-- QR Code Image --}}
                <div class="my-4 p-3 bg-white border border-slate-100 rounded-xl shadow-sm inline-block">
                    <img
                        id="student-qr-img"
                        crossorigin="anonymous"
                        src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($student->qr_code ?: $student->student_no) }}"
                        alt="QR Code for {{ $student->student_no }}"
                        class="w-44 h-44 object-contain mx-auto"
                    >
                </div>

                {{-- Student Number Under QR --}}
                <p class="font-mono font-bold text-slate-700 text-sm tracking-wider">
                    {{ $student->student_no }}
                </p>

                {{-- Download Button --}}
                <button
                    type="button"
                    onclick="downloadStudentQR()"
                    class="w-full mt-4 py-2.5 px-4 bg-[#123b70] hover:bg-[#0e2c56] text-white text-sm font-semibold rounded-xl shadow-sm transition flex items-center justify-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span>Download QR</span>
                </button>

                {{-- Print Badge Button --}}
                <a
                    href="{{ route('students.badge', $student) }}"
                    class="w-full mt-2 py-2.5 px-4 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-xl border border-indigo-200 transition flex items-center justify-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                    <span>Print ID Badge</span>
                </a>

            </div>

        </div>


        {{-- Bottom Tabbed Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden" x-data="{ activeTab: 'information' }">

            {{-- Tabs Navigation Bar --}}
            <div class="flex items-center border-b border-slate-200 px-6 pt-2 bg-slate-50/50">

                <button
                    type="button"
                    @click="activeTab = 'information'"
                    class="px-5 py-3.5 text-sm font-bold transition-all relative"
                    :class="activeTab === 'information' ? 'text-[#123b70]' : 'text-slate-500 hover:text-slate-700'"
                >
                    <span>Information</span>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#123b70] rounded-t-full transition-all"
                        x-show="activeTab === 'information'"
                    ></div>
                </button>

                <button
                    type="button"
                    @click="activeTab = 'parents'"
                    class="px-5 py-3.5 text-sm font-bold transition-all relative"
                    :class="activeTab === 'parents' ? 'text-[#123b70]' : 'text-slate-500 hover:text-slate-700'"
                >
                    <span>Parents/Guardians</span>
                    <span class="ml-1.5 px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-200/80 text-slate-600">
                        {{ $student->parents->count() }}
                    </span>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#123b70] rounded-t-full transition-all"
                        x-show="activeTab === 'parents'"
                    ></div>
                </button>

                <button
                    type="button"
                    @click="activeTab = 'attendance'"
                    class="px-5 py-3.5 text-sm font-bold transition-all relative"
                    :class="activeTab === 'attendance' ? 'text-[#123b70]' : 'text-slate-500 hover:text-slate-700'"
                >
                    <span>Attendance Summary</span>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#123b70] rounded-t-full transition-all"
                        x-show="activeTab === 'attendance'"
                    ></div>
                </button>

            </div>


            {{-- Tab 1: Information --}}
            <div x-show="activeTab === 'information'" class="p-6 sm:p-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-8 text-sm">

                    {{-- Address --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Address</span>
                        <span class="col-span-2 font-semibold text-slate-800">
                            {{ $student->parents->first()->address ?? '123 Rizal St, Cityville' }}
                        </span>
                    </div>

                    {{-- Contact Number --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Contact Number</span>
                        <span class="col-span-2 font-semibold text-slate-800 font-mono">
                            {{ $student->parents->first()->phone_number ?? '0917-123-4567' }}
                        </span>
                    </div>

                    {{-- Email --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Email</span>
                        <span class="col-span-2 font-semibold text-[#123b70]">
                            {{ $student->parents->first()->user->email ?? strtolower($student->first_name . '.' . $student->last_name . '@email.com') }}
                        </span>
                    </div>

                    {{-- Date Enrolled --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Date Enrolled</span>
                        <span class="col-span-2 font-semibold text-slate-800">
                            {{ $student->created_at ? $student->created_at->format('F j, Y') : 'June 3, 2024' }}
                        </span>
                    </div>

                </div>

            </div>


            {{-- Tab 2: Parents/Guardians --}}
            <div x-show="activeTab === 'parents'" class="p-6 sm:p-8">

                @if($student->parents->count() > 0)

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        @foreach($student->parents as $parent)
                            <div class="p-5 rounded-xl border border-slate-200 bg-slate-50/50 flex items-start justify-between">

                                <div class="flex items-start gap-3.5">
                                    <div class="w-10 h-10 rounded-full bg-[#123b70] text-white font-bold flex items-center justify-center flex-shrink-0 shadow-sm">
                                        {{ strtoupper(substr($parent->first_name, 0, 1)) }}
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <p class="font-bold text-[#0e2c56] text-sm">
                                                {{ $parent->first_name }} {{ $parent->last_name }}
                                            </p>
                                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-100 text-blue-800">
                                                {{ $parent->pivot->relationship ?? 'Guardian' }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-slate-500 font-mono">
                                            {{ $parent->phone_number ?? 'No phone listed' }}
                                        </p>
                                        <p class="text-xs text-slate-400">
                                            {{ $parent->address ?? 'No address listed' }}
                                        </p>
                                    </div>
                                </div>

                                <a
                                    href="{{ route('parents.show', $parent) }}"
                                    class="text-xs font-semibold text-[#123b70] hover:underline"
                                >
                                    View
                                </a>

                            </div>
                        @endforeach

                    </div>

                @else

                    <div class="py-12 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-8a4 4 0 11-8 0 4 4 0 018 0zm6 3a3 3 0 10-6 0"/>
                        </svg>
                        <p class="text-sm font-semibold text-slate-600">No linked parents or guardians</p>
                        <p class="text-xs mt-1">Parents can be linked from the Parents Management page.</p>
                    </div>

                @endif

            </div>


            {{-- Tab 3: Attendance Summary --}}
            <div x-show="activeTab === 'attendance'" class="p-6 sm:p-8 space-y-6">

                @php
                    $totalScans = $student->attendances->count();
                    $presentCount = $student->attendances->where('status', 'Present')->count();
                    $completedCount = $student->attendances->whereNotNull('time_out')->count();
                @endphp

                {{-- Stats Pill Badges --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <p class="text-xs font-semibold text-slate-400">Total Scans</p>
                        <p class="text-2xl font-bold text-[#0e2c56] mt-1">{{ $totalScans }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100">
                        <p class="text-xs font-semibold text-emerald-700">Days Present</p>
                        <p class="text-2xl font-bold text-emerald-700 mt-1">{{ $presentCount }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-blue-50 border border-blue-100">
                        <p class="text-xs font-semibold text-blue-700">Completed Sessions</p>
                        <p class="text-2xl font-bold text-blue-700 mt-1">{{ $completedCount }}</p>
                    </div>
                </div>

                {{-- Recent Attendance History Table --}}
                @if($student->attendances->count() > 0)

                    <div class="overflow-x-auto border border-slate-200 rounded-xl">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase border-b border-slate-200">
                                <tr>
                                    <th class="px-5 py-3">Date</th>
                                    <th class="px-5 py-3">Time In</th>
                                    <th class="px-5 py-3">Time Out</th>
                                    <th class="px-5 py-3 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($student->attendances->take(15) as $record)
                                    <tr class="hover:bg-slate-50/60">
                                        <td class="px-5 py-3 font-semibold text-slate-800">
                                            {{ $record->attendance_date ? $record->attendance_date->format('M d, Y') : '—' }}
                                        </td>
                                        <td class="px-5 py-3 text-slate-600 font-mono text-xs">
                                            {{ $record->time_in ? $record->time_in->format('h:i:s A') : '—' }}
                                        </td>
                                        <td class="px-5 py-3 text-slate-600 font-mono text-xs">
                                            {{ $record->time_out ? $record->time_out->format('h:i:s A') : '—' }}
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            @if($record->time_out)
                                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                                    Completed
                                                </span>
                                            @else
                                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    Present
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @else

                    <div class="py-12 text-center text-slate-400">
                        <p class="text-sm font-semibold text-slate-600">No attendance records found</p>
                        <p class="text-xs mt-1">Attendance will be logged automatically when the student's QR is scanned.</p>
                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- QR Download Script --}}
    <script>
        function downloadStudentQR() {
            const img = document.getElementById('student-qr-img');
            const studentNo = "{{ $student->student_no }}";
            const studentName = "{{ $student->first_name }}_{{ $student->last_name }}";

            // Fetch image via canvas to allow direct high-quality PNG download
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const newImg = new Image();
            newImg.crossOrigin = 'anonymous';

            newImg.onload = function() {
                canvas.width = newImg.naturalWidth || 250;
                canvas.height = (newImg.naturalHeight || 250) + 40;

                // White background
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                // Draw QR Code
                ctx.drawImage(newImg, 0, 0);

                // Add Student Number label
                ctx.fillStyle = '#0e2c56';
                ctx.font = 'bold 16px monospace';
                ctx.textAlign = 'center';
                ctx.fillText(studentNo, canvas.width / 2, canvas.height - 14);

                // Trigger download
                const link = document.createElement('a');
                link.download = `QR_${studentName}_${studentNo}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
            };

            newImg.onerror = function() {
                // Fallback direct link
                const link = document.createElement('a');
                link.download = `QR_${studentNo}.png`;
                link.href = img.src;
                link.target = '_blank';
                link.click();
            };

            newImg.src = img.src;
        }
    </script>

</x-admin-layout>