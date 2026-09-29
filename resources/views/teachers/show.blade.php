<x-admin-layout>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Breadcrumb & Actions --}}
        <div class="flex items-center justify-between">

            <div class="flex items-center gap-3">

                {{-- Back button --}}
                <a
                    href="{{ route('teachers.index') }}"
                    class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-[#123b70] hover:border-[#123b70] transition shadow-sm"
                    title="Back to Teachers"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>

                {{-- Breadcrumbs --}}
                <nav class="flex items-center gap-2 text-base font-semibold text-slate-500">
                    <a href="{{ route('teachers.index') }}" class="hover:text-[#123b70] transition">
                        Teachers
                    </a>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-[#0e2c56] font-bold">
                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                    </span>
                </nav>

            </div>

            <div class="flex items-center gap-3">
                <a
                    href="{{ route('teachers.edit', $teacher) }}"
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


        {{-- Top Cards Row (Profile & Faculty Account Card) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Card: Teacher Profile Summary (2 cols) --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-7">

                <div class="flex flex-col sm:flex-row gap-6 items-start">

                    {{-- Teacher Photo with Upload Trigger --}}
                    <div class="relative group flex-shrink-0 mx-auto sm:mx-0" style="width: 144px;">
                        <div style="width: 144px; height: 144px; min-width: 144px; max-width: 144px; min-height: 144px; max-height: 144px; overflow: hidden; border-radius: 18px; border: 2px solid #f1f5f9; background-color: #f8fafc;" class="shadow-sm">
                            <img
                                id="teacher-profile-photo"
                                src="{{ $teacher->photo_url }}"
                                alt="{{ $teacher->first_name }}"
                                style="width: 100%; height: 100%; object-fit: cover; display: block;"
                            >
                        </div>

                        {{-- Quick Upload Overlay --}}
                        <form
                            action="{{ route('teachers.photo.update', $teacher) }}"
                            method="POST"
                            enctype="multipart/form-data"
                            id="teacher-photo-form"
                            class="mt-2 text-center"
                        >
                            @csrf
                            <label
                                for="quick-teacher-photo"
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
                                id="quick-teacher-photo"
                                name="photo"
                                accept="image/*"
                                class="hidden"
                                onchange="document.getElementById('teacher-photo-form').submit()"
                            >
                        </form>
                    </div>

                    {{-- Teacher Information Details --}}
                    <div class="flex-1 w-full space-y-3.5">

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-y-3.5 gap-x-4 text-sm pb-1">

                            <div class="text-slate-400 font-medium">
                                Employee ID
                            </div>
                            <div class="sm:col-span-2 font-semibold text-slate-800 font-mono">
                                {{ $teacher->employee_no }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Full Name
                            </div>
                            <div class="sm:col-span-2 font-bold text-[#0e2c56] text-base">
                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Position
                            </div>
                            <div class="sm:col-span-2 font-semibold text-slate-800">
                                Academic Faculty Member
                            </div>

                            <div class="text-slate-400 font-medium">
                                Contact Number
                            </div>
                            <div class="sm:col-span-2 font-mono font-semibold text-slate-800">
                                {{ $teacher->contact_number ?? '—' }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Email Address
                            </div>
                            <div class="sm:col-span-2 font-semibold text-[#123b70]">
                                {{ $teacher->user->email ?? '—' }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Account Status
                            </div>
                            <div class="sm:col-span-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    Active Faculty
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Right Card: Faculty Account & Security Card (NO QR CODE) --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-7 flex flex-col justify-between items-center text-center">

                <div class="w-full text-left">
                    <h2 class="text-base font-bold text-[#0e2c56]">
                        Faculty Account
                    </h2>
                </div>

                {{-- VIP Faculty Emblem --}}
                <div class="my-3 flex flex-col items-center">
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 flex items-center justify-center text-[#123b70] shadow-sm mb-3">
                        <svg class="w-12 h-12 text-[#123b70]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 14v7"/>
                        </svg>
                    </div>

                    <p class="font-bold text-[#0e2c56] text-sm">
                        VIP Faculty ID
                    </p>
                    <p class="font-mono text-xs text-slate-500 font-semibold mt-0.5">
                        {{ $teacher->employee_no }}
                    </p>
                    <p class="text-[11px] text-slate-400 mt-1">
                        Authorized Academic Staff
                    </p>
                </div>

                {{-- Account Details Button --}}
                <a
                    href="{{ route('teachers.edit', $teacher) }}"
                    class="w-full mt-4 py-2.5 px-4 bg-[#123b70] hover:bg-[#0e2c56] text-white text-sm font-semibold rounded-xl shadow-sm transition flex items-center justify-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>Edit Teacher Profile</span>
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
                    @click="activeTab = 'announcements'"
                    class="px-5 py-3.5 text-sm font-bold transition-all relative"
                    :class="activeTab === 'announcements' ? 'text-[#123b70]' : 'text-slate-500 hover:text-slate-700'"
                >
                    <span>Announcements</span>
                    <span class="ml-1.5 px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-200/80 text-slate-600">
                        {{ $teacher->announcements->count() }}
                    </span>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#123b70] rounded-t-full transition-all"
                        x-show="activeTab === 'announcements'"
                    ></div>
                </button>

                <button
                    type="button"
                    @click="activeTab = 'activity'"
                    class="px-5 py-3.5 text-sm font-bold transition-all relative"
                    :class="activeTab === 'activity' ? 'text-[#123b70]' : 'text-slate-500 hover:text-slate-700'"
                >
                    <span>Account Overview</span>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#123b70] rounded-t-full transition-all"
                        x-show="activeTab === 'activity'"
                    ></div>
                </button>

            </div>


            {{-- Tab 1: Information --}}
            <div x-show="activeTab === 'information'" class="p-6 sm:p-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-8 text-sm">

                    {{-- Employee ID --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Employee Number</span>
                        <span class="col-span-2 font-semibold text-slate-800 font-mono">
                            {{ $teacher->employee_no }}
                        </span>
                    </div>

                    {{-- Contact Number --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Contact Number</span>
                        <span class="col-span-2 font-semibold text-slate-800 font-mono">
                            {{ $teacher->contact_number ?? '—' }}
                        </span>
                    </div>

                    {{-- Email --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Email Address</span>
                        <span class="col-span-2 font-semibold text-[#123b70]">
                            {{ $teacher->user->email ?? '—' }}
                        </span>
                    </div>

                    {{-- Date Enrolled / Created --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Date Registered</span>
                        <span class="col-span-2 font-semibold text-slate-800">
                            {{ $teacher->created_at ? $teacher->created_at->format('F j, Y') : '—' }}
                        </span>
                    </div>

                </div>

            </div>


            {{-- Tab 2: Announcements --}}
            <div x-show="activeTab === 'announcements'" class="p-6 sm:p-8">

                @if($teacher->announcements->count() > 0)

                    <div class="space-y-4">
                        @foreach($teacher->announcements as $announcement)
                            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50">
                                <h4 class="font-bold text-[#0e2c56] text-sm">
                                    {{ $announcement->title }}
                                </h4>
                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $announcement->content }}
                                </p>
                                <p class="text-[11px] text-slate-400 mt-2">
                                    Posted on {{ $announcement->created_at->format('M d, Y • h:i A') }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                @else

                    <div class="py-12 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                        <p class="text-sm font-semibold text-slate-600">No announcements posted yet</p>
                        <p class="text-xs mt-1">Announcements created by this teacher will appear here.</p>
                    </div>

                @endif

            </div>


            {{-- Tab 3: Account Overview --}}
            <div x-show="activeTab === 'activity'" class="p-6 sm:p-8 space-y-6">

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <p class="text-xs font-semibold text-slate-400">Total Announcements</p>
                        <p class="text-2xl font-bold text-[#0e2c56] mt-1">{{ $teacher->announcements->count() }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100">
                        <p class="text-xs font-semibold text-emerald-700">Account Role</p>
                        <p class="text-2xl font-bold text-emerald-700 mt-1 capitalize">{{ $teacher->user->role ?? 'Teacher' }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-blue-50 border border-blue-100">
                        <p class="text-xs font-semibold text-blue-700">System Access</p>
                        <p class="text-2xl font-bold text-blue-700 mt-1">Granted</p>
                    </div>
                </div>

            </div>

        </div>

    </div>

</x-admin-layout>
