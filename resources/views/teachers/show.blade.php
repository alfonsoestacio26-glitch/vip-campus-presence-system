<x-admin-layout>

    <div class="max-w-7xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-6">

            <div class="flex items-center justify-between">

                <div class="flex items-center gap-3">
                    {{-- Back Button --}}
                    <a
                        href="{{ route('teachers.index') }}"
                        class="w-9 h-9 rounded-xl
                               bg-white border border-slate-200
                               flex items-center justify-center
                               text-slate-500 hover:text-[#123b70] hover:border-[#123b70]
                               transition"
                        title="Back to Teachers"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>

                    <div>
                        <h1 class="text-2xl font-bold text-[#0e2c56]">
                            Teacher Profile
                        </h1>
                        <p class="text-sm text-slate-400 mt-1">
                            Detailed profile information
                        </p>
                    </div>
                </div>

                {{-- Edit Button --}}
                <a
                    href="{{ route('teachers.edit', $teacher) }}"
                    class="inline-flex items-center gap-2
                           bg-[#123b70] hover:bg-[#0e2c56]
                           text-white text-sm font-semibold
                           px-5 py-2.5 rounded-xl transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487a2.25 2.25 0 013.182 3.182L8.25 18.464 4 19.75l1.286-4.25L16.862 3.487z"/>
                    </svg>
                    Edit Profile
                </a>

            </div>

        </div>

        {{-- Profile Header Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">

            {{-- Blue Header Banner --}}
            <div class="bg-[#123b70] px-6 py-6">
                <div class="flex items-center gap-5">
                    {{-- Avatar --}}
                    <div class="w-20 h-20 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center flex-shrink-0 text-white font-bold text-2xl">
                        {{ strtoupper(substr($teacher->first_name, 0, 1) . substr($teacher->last_name, 0, 1)) }}
                    </div>

                    {{-- Teacher Name --}}
                    <div class="text-white">
                        <h2 class="text-2xl font-bold">
                            {{ $teacher->first_name }} {{ $teacher->last_name }}
                        </h2>
                        <p class="text-white/70 text-sm mt-1">
                            Employee ID: <span class="text-white font-semibold">{{ $teacher->employee_no }}</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Profile Details Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-px bg-slate-100 border-t border-slate-100">
                {{-- Employee ID --}}
                <div class="bg-white px-6 py-5">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Employee ID</p>
                    <p class="text-base font-bold text-[#0e2c56] mt-1">{{ $teacher->employee_no }}</p>
                </div>

                {{-- Phone --}}
                <div class="bg-white px-6 py-5">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Phone Number</p>
                    <p class="text-base font-bold text-[#0e2c56] mt-1">{{ $teacher->contact_number ?? '—' }}</p>
                </div>

                {{-- Email --}}
                <div class="bg-white px-6 py-5">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Email Address</p>
                    <p class="text-base font-medium text-slate-600 mt-1">{{ $teacher->user->email ?? '—' }}</p>
                </div>
            </div>

        </div>

        {{-- Teacher Announcements Section --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="text-sm font-bold text-[#0e2c56]">Announcements Made</h3>
                <p class="text-xs text-slate-400 mt-1">Announcements published by this teacher</p>
            </div>

            <div class="p-6">
                @if($teacher->announcements && $teacher->announcements->count())
                    <div class="space-y-4">
                        @foreach($teacher->announcements as $announcement)
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-slate-200 transition">
                                <h4 class="font-bold text-slate-700 text-sm">{{ $announcement->title }}</h4>
                                <p class="text-xs text-slate-400 mt-1">Published: {{ $announcement->created_at->format('M d, Y h:i A') }}</p>
                                <p class="text-sm text-slate-600 mt-2">{{ $announcement->content }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center py-8">
                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-500">No announcements published</p>
                        <p class="text-xs text-slate-400 mt-1">This teacher hasn't published any announcements yet.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

</x-admin-layout>
