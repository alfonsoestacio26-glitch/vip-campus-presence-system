<x-admin-layout>

    <div class="max-w-7xl mx-auto">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-xs">
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
                        Campus Guards
                    </h1>
                    <p class="text-sm text-slate-400 mt-1">
                        Manage security personnel profiles, scan duties, and access accounts
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center flex-wrap gap-2.5">
                    <a
                        href="{{ route('guards.create') }}"
                        class="inline-flex items-center gap-2 bg-[#155d36] hover:bg-[#0f4628] active:bg-[#09321c] text-white font-bold text-sm rounded-xl px-5 py-2.5 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#155d36] focus:ring-offset-2 transition duration-200 border border-[#155d36]"
                    >
                        <svg class="w-4 h-4 text-white stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                        </svg>
                        <span>Add Guard</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Filter Toolbar --}}
        <form method="GET" action="{{ route('guards.index') }}" class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-6">
            <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
                
                {{-- Search Box --}}
                <div class="relative w-full" style="flex: 1 1 300px; min-width: 280px;">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="7" stroke-width="1.8"/>
                        <path stroke-linecap="round" stroke-width="1.8" d="M20 20l-4-4"/>
                    </svg>
                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? request('search') }}"
                        placeholder="Search by guard name, email, employee ID, or contact number..."
                        class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-[#123b70]/20 focus:border-[#123b70] transition shadow-xs"
                    >
                    @if(request('search'))
                        <a href="{{ route('guards.index', request()->except('search')) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 transition rounded-lg hover:bg-slate-200/50" title="Clear search">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>

                {{-- Action controls --}}
                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto" style="flex-shrink: 0;">
                    <button
                        type="submit"
                        class="px-4 py-2.5 bg-[#155d36] hover:bg-[#0f4628] active:bg-[#09321c] text-white text-sm font-semibold rounded-xl shadow-xs transition cursor-pointer"
                    >
                        Search
                    </button>

                    @if(!empty($search))
                        <a
                            href="{{ route('guards.index') }}"
                            class="px-3.5 py-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition cursor-pointer"
                        >
                            Reset
                        </a>
                    @endif
                </div>
            </div>

            {{-- Active Filters Badges --}}
            @if(!empty($search))
                <div class="mt-4 pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
                    <div class="flex flex-wrap items-center gap-2 text-slate-600">
                        <span class="font-bold text-slate-400 uppercase tracking-wider text-[10px]">Active Filter:</span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-700">Query: "{{ $search }}"</span>
                    </div>

                    <a href="{{ route('guards.index') }}" class="text-xs font-semibold text-rose-600 hover:text-rose-700 transition">
                        Clear Search &times;
                    </a>
                </div>
            @endif
        </form>

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/80 border-b border-slate-200/80">
                        <tr>
                            <th class="py-3.5 px-5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Employee No
                            </th>
                            <th class="py-3.5 px-5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Guard Name
                            </th>
                            <th class="py-3.5 px-5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="py-3.5 px-5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Contact
                            </th>
                            <th class="py-3.5 px-5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Scans Recorded
                            </th>
                            <th class="py-3.5 px-5 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($guards as $guard)
                            <tr class="hover:bg-slate-50/70 transition duration-150">
                                <td class="py-4 px-5 text-sm font-semibold text-[#123b70] whitespace-nowrap">
                                    {{ $guard->employee_no }}
                                </td>
                                <td class="py-4 px-5 text-sm align-middle">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-blue-50 text-[#123b70] font-bold text-xs flex items-center justify-center shrink-0 border border-blue-100">
                                            {{ strtoupper(substr($guard->first_name, 0, 1) . substr($guard->last_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800">
                                                {{ $guard->first_name }} {{ $guard->last_name }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-sm text-slate-600">
                                    {{ $guard->user->email ?? '—' }}
                                </td>
                                <td class="py-4 px-5 text-sm text-slate-600 whitespace-nowrap">
                                    {{ $guard->contact_number ?? '—' }}
                                </td>
                                <td class="py-4 px-5 text-sm">
                                    @if($guard->attendances && $guard->attendances->count())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-[#123b70] border border-blue-100">
                                            {{ $guard->attendances->count() }} {{ Str::plural('scan', $guard->attendances->count()) }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs italic">0 scans</span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-right text-sm whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        {{-- View --}}
                                        <a
                                            href="{{ route('guards.show', $guard) }}"
                                            class="p-2 text-[#123b70] hover:text-[#0e2c56] hover:bg-blue-50 rounded-xl transition"
                                            title="View Guard Profile"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z"/>
                                                <circle cx="12" cy="12" r="2.5" stroke-width="1.8"/>
                                            </svg>
                                        </a>

                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('guards.edit', $guard) }}"
                                            class="p-2 text-amber-600 hover:text-amber-700 hover:bg-amber-50 rounded-xl transition"
                                            title="Edit Guard"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 20h9"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4L16.5 3.5z"/>
                                            </svg>
                                        </a>

                                        {{-- Delete --}}
                                        <form
                                            action="{{ route('guards.destroy', $guard) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this guard? This will also delete their login account.');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="p-2 text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition cursor-pointer"
                                                title="Delete Guard"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3l7 3v5c0 4.5-3 8.5-7 10-4-1.5-7-5.5-7-10V6l7-3z"/>
                                            </svg>
                                        </div>
                                        @if(!empty($search))
                                            <h3 class="text-sm font-semibold text-slate-800">No matching guard records</h3>
                                            <p class="text-xs text-slate-400 mt-1">We couldn't find any guards matching your search query.</p>
                                            <a href="{{ route('guards.index') }}" class="mt-3 text-xs font-semibold text-[#123b70] hover:underline">Clear search</a>
                                        @else
                                            <h3 class="text-sm font-semibold text-slate-800">No guards registered yet</h3>
                                            <p class="text-xs text-slate-400 mt-1">Start by adding your first security guard profile.</p>
                                            <a href="{{ route('guards.create') }}" class="mt-4 inline-flex items-center gap-1.5 bg-[#155d36] hover:bg-[#0f4628] active:bg-[#09321c] text-white font-bold text-xs rounded-xl px-4 py-2 shadow-sm hover:shadow-md transition duration-200 border border-[#155d36]">Add First Guard</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            @if($guards->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $guards->withQueryString()->links() }}
                </div>
            @endif
        </div>

    </div>

</x-admin-layout>
