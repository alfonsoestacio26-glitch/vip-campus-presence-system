<x-admin-layout>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Breadcrumb & Actions --}}
        <div class="flex items-center justify-between">

            <div class="flex items-center gap-3">

                {{-- Back button --}}
                <a
                    href="{{ route('guards.index') }}"
                    class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-[#123b70] hover:border-[#123b70] transition shadow-sm"
                    title="Back to Guards"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>

                {{-- Breadcrumbs --}}
                <nav class="flex items-center gap-2 text-base font-semibold text-slate-500">
                    <a href="{{ route('guards.index') }}" class="hover:text-[#123b70] transition">
                        Guards
                    </a>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-[#0e2c56] font-bold">
                        {{ $guard->first_name }} {{ $guard->last_name }}
                    </span>
                </nav>

            </div>

            <div class="flex items-center gap-3">
                <a
                    href="{{ route('guards.edit', $guard) }}"
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
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm font-medium flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif


        {{-- Top Cards Row (Profile & Security Badge Card) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Card: Guard Profile Summary (2 cols) --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-7">

                <div class="flex flex-col sm:flex-row gap-6 items-start">

                    {{-- Guard Photo with Upload Trigger --}}
                    <div class="relative group flex-shrink-0 mx-auto sm:mx-0" style="width: 144px;">
                        <div style="width: 144px; height: 144px; min-width: 144px; max-width: 144px; min-height: 144px; max-height: 144px; overflow: hidden; border-radius: 18px; border: 2px solid #f1f5f9; background-color: #f8fafc;" class="shadow-sm">
                            <img
                                id="guard-profile-photo"
                                src="{{ $guard->photo_url }}"
                                alt="{{ $guard->first_name }}"
                                style="width: 100%; height: 100%; object-fit: cover; display: block;"
                            >
                        </div>

                        {{-- Quick Upload Overlay --}}
                        <form
                            action="{{ route('guards.photo.update', $guard) }}"
                            method="POST"
                            enctype="multipart/form-data"
                            id="guard-photo-form"
                            class="mt-2 text-center"
                        >
                            @csrf
                            <label
                                for="quick-guard-photo"
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
                                id="quick-guard-photo"
                                name="photo"
                                accept="image/*"
                                class="hidden"
                                onchange="document.getElementById('guard-photo-form').submit()"
                            >
                        </form>
                    </div>

                    {{-- Guard Information Details --}}
                    <div class="flex-1 w-full space-y-3.5">

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-y-3.5 gap-x-4 text-sm pb-1">

                            <div class="text-slate-400 font-medium">
                                Badge / Guard ID
                            </div>
                            <div class="sm:col-span-2 font-semibold text-slate-800 font-mono">
                                {{ $guard->employee_no }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Full Name
                            </div>
                            <div class="sm:col-span-2 font-bold text-[#0e2c56] text-base">
                                {{ $guard->first_name }} {{ $guard->last_name }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Station Assignment
                            </div>
                            <div class="sm:col-span-2 font-semibold text-slate-800">
                                Campus Gate 1 • Security Terminal
                            </div>

                            <div class="text-slate-400 font-medium">
                                Contact Number
                            </div>
                            <div class="sm:col-span-2 font-mono font-semibold text-slate-800">
                                {{ $guard->contact_number ?? '—' }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Email Address
                            </div>
                            <div class="sm:col-span-2 font-semibold text-[#123b70]">
                                {{ $guard->user->email ?? '—' }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Duty Status
                            </div>
                            <div class="sm:col-span-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    Active Duty
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Right Card: Security Badge & Station Summary (NO QR CODE) --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-7 flex flex-col justify-between items-center text-center">

                <div class="w-full text-left">
                    <h2 class="text-base font-bold text-[#0e2c56]">
                        Security Access Badge
                    </h2>
                </div>

                {{-- VIP Security Emblem --}}
                <div class="my-3 flex flex-col items-center">
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-slate-800 to-[#0e2c56] border border-slate-700 flex items-center justify-center text-amber-400 shadow-sm mb-3">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>

                    <p class="font-bold text-[#0e2c56] text-sm">
                        VIP Security Personnel
                    </p>
                    <p class="font-mono text-xs text-slate-500 font-semibold mt-0.5">
                        Badge #{{ $guard->employee_no }}
                    </p>
                    <p class="text-[11px] text-slate-400 mt-1">
                        Authorized Gate Operator
                    </p>
                </div>

                {{-- Account Details Button --}}
                <a
                    href="{{ route('guards.edit', $guard) }}"
                    class="w-full mt-4 py-2.5 px-4 bg-[#123b70] hover:bg-[#0e2c56] text-white text-sm font-semibold rounded-xl shadow-sm transition flex items-center justify-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>Edit Guard Profile</span>
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
                    @click="activeTab = 'scans'"
                    class="px-5 py-3.5 text-sm font-bold transition-all relative"
                    :class="activeTab === 'scans' ? 'text-[#123b70]' : 'text-slate-500 hover:text-slate-700'"
                >
                    <span>Scans Processed</span>
                    <span class="ml-1.5 px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-200/80 text-slate-600">
                        {{ $guard->attendances->count() }}
                    </span>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#123b70] rounded-t-full transition-all"
                        x-show="activeTab === 'scans'"
                    ></div>
                </button>

                <button
                    type="button"
                    @click="activeTab = 'duty'"
                    class="px-5 py-3.5 text-sm font-bold transition-all relative"
                    :class="activeTab === 'duty' ? 'text-[#123b70]' : 'text-slate-500 hover:text-slate-700'"
                >
                    <span>Duty Overview</span>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#123b70] rounded-t-full transition-all"
                        x-show="activeTab === 'duty'"
                    ></div>
                </button>

            </div>


            {{-- Tab 1: Information --}}
            <div x-show="activeTab === 'information'" class="p-6 sm:p-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-8 text-sm">

                    {{-- Badge ID --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Badge Number</span>
                        <span class="col-span-2 font-semibold text-slate-800 font-mono">
                            {{ $guard->employee_no }}
                        </span>
                    </div>

                    {{-- Contact Number --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Contact Number</span>
                        <span class="col-span-2 font-semibold text-slate-800 font-mono">
                            {{ $guard->contact_number ?? '—' }}
                        </span>
                    </div>

                    {{-- Email --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Email Address</span>
                        <span class="col-span-2 font-semibold text-[#123b70]">
                            {{ $guard->user->email ?? '—' }}
                        </span>
                    </div>

                    {{-- Date Registered --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Date Registered</span>
                        <span class="col-span-2 font-semibold text-slate-800">
                            {{ $guard->created_at ? $guard->created_at->format('F j, Y') : '—' }}
                        </span>
                    </div>

                </div>

            </div>


            {{-- Tab 2: Scans Processed --}}
            <div x-show="activeTab === 'scans'" class="p-6 sm:p-8">

                @if($guard->attendances->count() > 0)

                    <div class="overflow-x-auto border border-slate-200 rounded-xl">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 text-xs font-semibold text-slate-500 uppercase border-b border-slate-200">
                                <tr>
                                    <th class="px-5 py-3">Student</th>
                                    <th class="px-5 py-3">Date</th>
                                    <th class="px-5 py-3">Time In</th>
                                    <th class="px-5 py-3">Time Out</th>
                                    <th class="px-5 py-3 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($guard->attendances as $att)
                                    <tr class="hover:bg-slate-50/60">
                                        <td class="px-5 py-3 font-semibold text-slate-800">
                                            {{ $att->student->first_name ?? '' }} {{ $att->student->last_name ?? '' }}
                                        </td>
                                        <td class="px-5 py-3 text-slate-600 text-xs">
                                            {{ $att->attendance_date ? $att->attendance_date->format('M d, Y') : '—' }}
                                        </td>
                                        <td class="px-5 py-3 text-slate-600 font-mono text-xs">
                                            {{ $att->time_in ? $att->time_in->format('h:i:s A') : '—' }}
                                        </td>
                                        <td class="px-5 py-3 text-slate-600 font-mono text-xs">
                                            {{ $att->time_out ? $att->time_out->format('h:i:s A') : '—' }}
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            @if($att->time_out)
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
                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="text-sm font-semibold text-slate-600">No attendance scans verified yet</p>
                        <p class="text-xs mt-1">Attendance logs registered through this guard's terminal will appear here.</p>
                    </div>

                @endif

            </div>


            {{-- Tab 3: Duty Overview --}}
            <div x-show="activeTab === 'duty'" class="p-6 sm:p-8 space-y-6">

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <p class="text-xs font-semibold text-slate-400">Total Scans Handled</p>
                        <p class="text-2xl font-bold text-[#0e2c56] mt-1">{{ $guard->attendances->count() }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100">
                        <p class="text-xs font-semibold text-emerald-700">Terminal Access</p>
                        <p class="text-2xl font-bold text-emerald-700 mt-1">Authorized</p>
                    </div>
                    <div class="p-4 rounded-xl bg-blue-50 border border-blue-100">
                        <p class="text-xs font-semibold text-blue-700">Active Shift</p>
                        <p class="text-2xl font-bold text-blue-700 mt-1">Gate 1</p>
                    </div>
                </div>

            </div>

        </div>

    </div>

</x-admin-layout>
