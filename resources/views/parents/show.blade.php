<x-admin-layout>

    <div class="max-w-7xl mx-auto space-y-6">

        {{-- Breadcrumb & Actions --}}
        <div class="flex items-center justify-between">

            <div class="flex items-center gap-3">

                {{-- Back button --}}
                <a
                    href="{{ route('parents.index') }}"
                    class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-[#123b70] hover:border-[#123b70] transition shadow-sm"
                    title="Back to Parents"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>

                {{-- Breadcrumbs --}}
                <nav class="flex items-center gap-2 text-base font-semibold text-slate-500">
                    <a href="{{ route('parents.index') }}" class="hover:text-[#123b70] transition">
                        Parents
                    </a>
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-[#0e2c56] font-bold">
                        {{ $parent->first_name }} {{ $parent->middle_name ? $parent->middle_name . ' ' : '' }}{{ $parent->last_name }}
                    </span>
                </nav>

            </div>

            <div class="flex items-center gap-3">
                <a
                    href="{{ route('parents.edit', $parent) }}"
                    class="inline-flex items-center gap-2 bg-[#155d36] hover:bg-[#0f4628] active:bg-[#09321c] text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-md hover:shadow-lg transition border border-[#155d36]"
                >
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

        @if(session('error'))
            <div class="p-4 rounded-xl bg-red-50 border border-red-100 text-red-800 text-sm font-medium flex items-center gap-2">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif


        {{-- Top Cards Row (Profile & Family Portal Card) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Card: Parent Profile Summary (2 cols) --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-7">

                <div class="flex flex-col sm:flex-row gap-6 items-start">

                    {{-- Parent Photo with Upload Trigger --}}
                    <div class="relative group flex-shrink-0 mx-auto sm:mx-0" style="width: 144px;">
                        <div style="width: 144px; height: 144px; min-width: 144px; max-width: 144px; min-height: 144px; max-height: 144px; overflow: hidden; border-radius: 18px; border: 2px solid #f1f5f9; background-color: #f8fafc;" class="shadow-sm">
                            <img
                                id="parent-profile-photo"
                                src="{{ $parent->photo_url }}"
                                alt="{{ $parent->first_name }}"
                                style="width: 100%; height: 100%; object-fit: cover; display: block;"
                            >
                        </div>

                        {{-- Quick Upload Overlay --}}
                        <form
                            action="{{ route('parents.photo.update', $parent) }}"
                            method="POST"
                            enctype="multipart/form-data"
                            id="parent-photo-form"
                            class="mt-2 text-center"
                        >
                            @csrf
                            <label
                                for="quick-parent-photo"
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
                                id="quick-parent-photo"
                                name="photo"
                                accept="image/*"
                                class="hidden"
                                onchange="document.getElementById('parent-photo-form').submit()"
                            >
                        </form>
                    </div>

                    {{-- Parent Information Details --}}
                    <div class="flex-1 w-full space-y-3.5">

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-y-3.5 gap-x-4 text-sm pb-1">

                            <div class="text-slate-400 font-medium">
                                Parent ID
                            </div>
                            <div class="sm:col-span-2 font-semibold text-slate-800 font-mono">
                                #{{ str_pad($parent->id, 4, '0', STR_PAD_LEFT) }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Full Name
                            </div>
                            <div class="sm:col-span-2 font-bold text-[#0e2c56] text-base">
                                {{ $parent->first_name }}
                                @if($parent->middle_name) {{ $parent->middle_name }} @endif
                                {{ $parent->last_name }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Role
                            </div>
                            <div class="sm:col-span-2 font-semibold text-slate-800">
                                Registered Parent / Guardian
                            </div>

                            <div class="text-slate-400 font-medium">
                                Contact Number
                            </div>
                            <div class="sm:col-span-2 font-mono font-semibold text-slate-800">
                                {{ $parent->phone ?? '—' }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Email Address
                            </div>
                            <div class="sm:col-span-2 font-semibold text-[#123b70]">
                                {{ $parent->user->email ?? '—' }}
                            </div>

                            <div class="text-slate-400 font-medium">
                                Account Status
                            </div>
                            <div class="sm:col-span-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    Active Account
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Right Card: Family Portal Card (NO QR CODE) --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-7 flex flex-col justify-between items-center text-center">

                <div class="w-full text-left">
                    <h2 class="text-base font-bold text-[#0e2c56]">
                        Parent Portal
                    </h2>
                </div>

                {{-- VIP Family Emblem --}}
                <div class="my-3 flex flex-col items-center">
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-100 flex items-center justify-center text-amber-600 shadow-sm mb-3">
                        <svg class="w-12 h-12 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-8a4 4 0 11-8 0 4 4 0 018 0zm6 3a3 3 0 10-6 0"/>
                        </svg>
                    </div>

                    <p class="font-bold text-[#0e2c56] text-sm">
                        Family Guardian Access
                    </p>
                    <p class="text-xs text-slate-500 font-semibold mt-0.5">
                        {{ $parent->students->count() }} Linked {{ Str::plural('Student', $parent->students->count()) }}
                    </p>
                    <p class="text-[11px] text-slate-400 mt-1">
                        SMS Real-time Notifications Active
                    </p>
                </div>

                {{-- Edit Button --}}
                <a
                    href="{{ route('parents.edit', $parent) }}"
                    class="w-full mt-4 py-2.5 px-4 bg-[#155d36] hover:bg-[#0f4628] active:bg-[#09321c] text-white text-sm font-bold rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 border border-[#155d36]"
                >
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>Edit Parent Profile</span>
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
                    :class="activeTab === 'information' ? 'text-[#155d36]' : 'text-slate-500 hover:text-slate-700'"
                >
                    <span>Information</span>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#155d36] rounded-t-full transition-all"
                        x-show="activeTab === 'information'"
                    ></div>
                </button>

                <button
                    type="button"
                    @click="activeTab = 'students'"
                    class="px-5 py-3.5 text-sm font-bold transition-all relative"
                    :class="activeTab === 'students' ? 'text-[#155d36]' : 'text-slate-500 hover:text-slate-700'"
                >
                    <span>Linked Students</span>
                    <span class="ml-1.5 px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-200/80 text-slate-600">
                        {{ $parent->students->count() }}
                    </span>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#155d36] rounded-t-full transition-all"
                        x-show="activeTab === 'students'"
                    ></div>
                </button>

                @if(isset($students) && $students->count() > 0)
                    <button
                        type="button"
                        @click="activeTab = 'link'"
                        class="px-5 py-3.5 text-sm font-bold transition-all relative"
                        :class="activeTab === 'link' ? 'text-[#155d36]' : 'text-slate-500 hover:text-slate-700'"
                    >
                        <span>+ Link Student</span>
                        <div
                            class="absolute bottom-0 left-0 right-0 h-0.5 bg-[#155d36] rounded-t-full transition-all"
                            x-show="activeTab === 'link'"
                        ></div>
                    </button>
                @endif

            </div>


            {{-- Tab 1: Information --}}
            <div x-show="activeTab === 'information'" class="p-6 sm:p-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-8 text-sm">

                    {{-- Address --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Home Address</span>
                        <span class="col-span-2 font-semibold text-slate-800">
                            {{ $parent->address ?? '—' }}
                        </span>
                    </div>

                    {{-- Contact Number --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Contact Number</span>
                        <span class="col-span-2 font-semibold text-slate-800 font-mono">
                            {{ $parent->phone ?? '—' }}
                        </span>
                    </div>

                    {{-- Email --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Email Address</span>
                        <span class="col-span-2 font-semibold text-[#123b70]">
                            {{ $parent->user->email ?? '—' }}
                        </span>
                    </div>

                    {{-- Date Enrolled / Registered --}}
                    <div class="grid grid-cols-3 gap-2 py-2 border-b border-slate-100 sm:border-b-0">
                        <span class="text-slate-400 font-medium">Date Registered</span>
                        <span class="col-span-2 font-semibold text-slate-800">
                            {{ $parent->created_at ? $parent->created_at->format('F j, Y') : '—' }}
                        </span>
                    </div>

                </div>

            </div>


            {{-- Tab 2: Linked Students --}}
            <div x-show="activeTab === 'students'" class="p-6 sm:p-8">

                @if($parent->students->count() > 0)

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        @foreach($parent->students as $child)
                            <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50/50 flex items-start justify-between">

                                <div class="flex items-start gap-3.5">

                                    <div style="width: 56px; height: 56px; min-width: 56px; max-width: 56px; min-height: 56px; max-height: 56px; overflow: hidden; border-radius: 14px; border: 1px solid #e2e8f0; background-color: #ffffff;" class="flex-shrink-0 shadow-xs">
                                        <img
                                            src="{{ $child->photo_url }}"
                                            alt="{{ $child->first_name }}"
                                            style="width: 100%; height: 100%; object-fit: cover; display: block;"
                                        >
                                    </div>

                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <p class="font-bold text-[#0e2c56] text-sm">
                                                {{ $child->first_name }} {{ $child->last_name }}
                                            </p>
                                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-100 text-blue-800">
                                                {{ $child->pivot->relationship ?? 'Child' }}
                                            </span>
                                        </div>

                                        <p class="text-xs text-slate-500 font-mono">
                                            {{ $child->student_no }}
                                        </p>

                                        <p class="text-xs text-slate-400">
                                            Grade {{ $child->grade_level ?? '—' }} - {{ $child->section ?? '—' }}
                                        </p>
                                    </div>

                                </div>

                                <div class="flex items-center gap-2">

                                    {{-- View Student --}}
                                    <a
                                        href="{{ route('students.show', $child) }}"
                                        class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 text-[#123b70] hover:bg-slate-100 transition"
                                    >
                                        View
                                    </a>

                                    {{-- Detach Student --}}
                                    <form
                                        action="{{ route('parents.students.detach', [$parent, $child]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to unlink {{ $child->first_name }} from this parent?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="px-2.5 py-1.5 rounded-lg text-xs font-semibold text-red-600 hover:bg-red-50 border border-transparent hover:border-red-200 transition"
                                            title="Unlink student"
                                        >
                                            Unlink
                                        </button>
                                    </form>

                                </div>

                            </div>
                        @endforeach

                    </div>

                @else

                    <div class="py-12 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <p class="text-sm font-semibold text-slate-600">No linked students found</p>
                        <p class="text-xs mt-1">Link children to this parent using the "+ Link Student" tab above.</p>
                    </div>

                @endif

            </div>


            {{-- Tab 3: Link New Student Form --}}
            @if(isset($students) && $students->count() > 0)
                <div x-show="activeTab === 'link'" class="p-6 sm:p-8">

                    <form
                        action="{{ route('parents.students.attach', $parent) }}"
                        method="POST"
                        class="max-w-xl space-y-4"
                    >
                        @csrf

                        <div>
                            <label for="student_id" class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">
                                Select Student to Link
                            </label>
                            <select
                                id="student_id"
                                name="student_id"
                                required
                                class="w-full text-sm rounded-xl border-slate-300 focus:border-[#123b70] focus:ring-[#123b70]"
                            >
                                <option value="">-- Choose an enrolled student --</option>
                                @foreach($students as $st)
                                    <option value="{{ $st->id }}">
                                        {{ $st->last_name }}, {{ $st->first_name }} ({{ $st->student_no }}) - Grade {{ $st->grade_level }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="relationship" class="block text-xs font-semibold text-slate-700 uppercase mb-1.5">
                                Relationship to Student
                            </label>
                            <select
                                id="relationship"
                                name="relationship"
                                required
                                class="w-full text-sm rounded-xl border-slate-300 focus:border-[#123b70] focus:ring-[#123b70]"
                            >
                                <option value="Father">Father</option>
                                <option value="Mother">Mother</option>
                                <option value="Guardian">Guardian</option>
                                <option value="Grandparent">Grandparent</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 bg-[#155d36] hover:bg-[#0f4628] active:bg-[#09321c] text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition border border-[#155d36]"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Link Student</span>
                        </button>
                    </form>

                </div>
            @endif

        </div>

    </div>

</x-admin-layout>