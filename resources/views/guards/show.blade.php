<x-admin-layout>

    <div class="max-w-7xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-6">

            <div class="flex items-center justify-between">

                <div class="flex items-center gap-3">
                    {{-- Back Button --}}
                    <a
                        href="{{ route('guards.index') }}"
                        class="w-9 h-9 rounded-xl
                               bg-white border border-slate-200
                               flex items-center justify-center
                               text-slate-500 hover:text-[#123b70] hover:border-[#123b70]
                               transition"
                        title="Back to Guards"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>

                    <div>
                        <h1 class="text-2xl font-bold text-[#0e2c56]">
                            Guard Profile
                        </h1>
                        <p class="text-sm text-slate-400 mt-1">
                            Detailed profile information
                        </p>
                    </div>
                </div>

                {{-- Edit Button --}}
                <a
                    href="{{ route('guards.edit', $guard) }}"
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
                        {{ strtoupper(substr($guard->first_name, 0, 1) . substr($guard->last_name, 0, 1)) }}
                    </div>

                    {{-- Guard Name --}}
                    <div class="text-white">
                        <h2 class="text-2xl font-bold">
                            {{ $guard->first_name }} {{ $guard->last_name }}
                        </h2>
                        <p class="text-white/70 text-sm mt-1">
                            Employee ID: <span class="text-white font-semibold">{{ $guard->employee_no }}</span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Profile Details Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-px bg-slate-100 border-t border-slate-100">
                {{-- Employee ID --}}
                <div class="bg-white px-6 py-5">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Employee ID</p>
                    <p class="text-base font-bold text-[#0e2c56] mt-1">{{ $guard->employee_no }}</p>
                </div>

                {{-- Phone --}}
                <div class="bg-white px-6 py-5">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Phone Number</p>
                    <p class="text-base font-bold text-[#0e2c56] mt-1">{{ $guard->contact_number ?? '—' }}</p>
                </div>

                {{-- Email --}}
                <div class="bg-white px-6 py-5">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Email Address</p>
                    <p class="text-base font-medium text-slate-600 mt-1">{{ $guard->user->email ?? '—' }}</p>
                </div>
            </div>

        </div>

        {{-- Activity Summary --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="text-sm font-bold text-[#0e2c56]">Activity Summary</h3>
                <p class="text-xs text-slate-400 mt-1">System activity logs for this security guard</p>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="p-5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Total Scans Recorded</p>
                            <p class="text-2xl font-bold text-[#0e2c56] mt-1">
                                {{ $guard->attendance ? $guard->attendance->count() : 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-[#123b70]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="p-5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Role Status</p>
                            <p class="text-lg font-bold text-[#0e2c56] mt-1">Authorized Guard</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-admin-layout>
