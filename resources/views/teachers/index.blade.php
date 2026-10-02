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
                        Teachers
                    </h1>
                    <p class="text-sm text-slate-400 mt-1">
                        Manage faculty members and login accounts
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center flex-wrap gap-2.5">
                    <a
                        href="{{ route('teachers.create') }}"
                        class="inline-flex items-center gap-2 bg-[#155d36] hover:bg-[#0f4628] active:bg-[#09321c] text-white font-bold text-sm rounded-xl px-5 py-2.5 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#155d36] focus:ring-offset-2 transition duration-200 border border-[#155d36]"
                    >
                        <svg class="w-4 h-4 text-white stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                        </svg>
                        <span>Add Teacher</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Filter Toolbar --}}
        <form method="GET" action="{{ route('teachers.index') }}" class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-6">
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
                        placeholder="Search by teacher name, email, employee ID..."
                        class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-[#123b70]/20 focus:border-[#123b70] transition shadow-xs"
                    >
                    @if(request('search'))
                        <a href="{{ route('teachers.index', request()->except('search')) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 transition rounded-lg hover:bg-slate-200/50" title="Clear search">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>

                {{-- Dropdowns & Filter Controls --}}
                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto" style="flex-shrink: 0;">
                    @if(!empty($gradeLevels) && count($gradeLevels) > 0)
                        <select
                            name="grade_level"
                            onchange="this.form.submit()"
                            class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:bg-white focus:ring-2 focus:ring-[#123b70]/20 focus:border-[#123b70] transition shadow-xs cursor-pointer"
                        >
                            <option value="">All Grade Levels</option>
                            @foreach($gradeLevels as $gl)
                                <option value="{{ $gl }}" {{ ($gradeLevel ?? '') == $gl ? 'selected' : '' }}>
                                    Grade {{ $gl }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    @if(!empty($sections) && count($sections) > 0)
                        <select
                            name="section"
                            onchange="this.form.submit()"
                            class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:bg-white focus:ring-2 focus:ring-[#123b70]/20 focus:border-[#123b70] transition shadow-xs cursor-pointer"
                        >
                            <option value="">All Sections</option>
                            @foreach($sections as $sec)
                                <option value="{{ $sec }}" {{ ($section ?? '') == $sec ? 'selected' : '' }}>
                                    Section: {{ $sec }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    <button
                        type="submit"
                        class="px-4 py-2.5 bg-[#155d36] hover:bg-[#0f4628] active:bg-[#09321c] text-white text-sm font-semibold rounded-xl shadow-xs transition cursor-pointer"
                    >
                        Filter
                    </button>

                    @if(!empty($search) || !empty($section) || !empty($gradeLevel))
                        <a
                            href="{{ route('teachers.index') }}"
                            class="px-3.5 py-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-600 text-sm font-semibold rounded-xl transition cursor-pointer"
                        >
                            Reset
                        </a>
                    @endif
                </div>
            </div>

            {{-- Active Filters Badges --}}
            @if(!empty($search) || !empty($section) || !empty($gradeLevel))
                <div class="mt-4 pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
                    <div class="flex flex-wrap items-center gap-2 text-slate-600">
                        <span class="font-bold text-slate-400 uppercase tracking-wider text-[10px]">Active Filters:</span>
                        @if(!empty($search))
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-700">Search: "{{ $search }}"</span>
                        @endif
                        @if(!empty($gradeLevel))
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 border border-blue-200 text-blue-700">Grade: {{ $gradeLevel }}</span>
                        @endif
                        @if(!empty($section))
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-indigo-50 border border-indigo-200 text-indigo-700">Section: {{ $section }}</span>
                        @endif
                    </div>

                    <a href="{{ route('teachers.index') }}" class="text-xs font-semibold text-rose-600 hover:text-rose-700 transition">
                        Clear Filters &times;
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
                                Teacher Name
                            </th>
                            <th class="py-3.5 px-5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="py-3.5 px-5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Contact
                            </th>
                            <th class="py-3.5 px-5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Announcements
                            </th>
                            <th class="py-3.5 px-5 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($teachers as $teacher)
                            <tr class="hover:bg-slate-50/70 transition duration-150">
                                <td class="py-4 px-5 text-sm font-semibold text-[#123b70] whitespace-nowrap">
                                    {{ $teacher->employee_no }}
                                </td>
                                <td class="py-4 px-5 text-sm align-middle">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-blue-50 text-[#123b70] font-bold text-xs flex items-center justify-center shrink-0 border border-blue-100">
                                            {{ strtoupper(substr($teacher->first_name, 0, 1) . substr($teacher->last_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800">
                                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-sm text-slate-600">
                                    {{ $teacher->user->email ?? '—' }}
                                </td>
                                <td class="py-4 px-5 text-sm text-slate-600">
                                    {{ $teacher->contact_number ?? '—' }}
                                </td>
                                <td class="py-4 px-5 text-sm">
                                    @if($teacher->announcements && $teacher->announcements->count())
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-bold text-blue-700 bg-blue-50 rounded-full border border-blue-100">
                                            {{ $teacher->announcements->count() }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-xs">0</span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-right text-sm whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        {{-- View --}}
                                        <a
                                            href="{{ route('teachers.show', $teacher) }}"
                                            class="p-2 text-[#123b70] hover:text-[#0e2c56] hover:bg-blue-50 rounded-xl transition"
                                            title="View Profile"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z"/>
                                                <circle cx="12" cy="12" r="2.5" stroke-width="1.8"/>
                                            </svg>
                                        </a>

                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('teachers.edit', $teacher) }}"
                                            class="p-2 text-amber-600 hover:text-amber-700 hover:bg-amber-50 rounded-xl transition"
                                            title="Edit Teacher"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 20h9"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4L16.5 3.5z"/>
                                            </svg>
                                        </a>

                                        {{-- Delete --}}
                                        <form
                                            action="{{ route('teachers.destroy', $teacher) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this teacher? This will also delete their login account.');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="p-2 text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition cursor-pointer"
                                                title="Delete Teacher"
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
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                            </svg>
                                        </div>
                                        @if(!empty($search) || !empty($section) || !empty($gradeLevel))
                                            <h3 class="text-sm font-semibold text-slate-800">No matching teacher records</h3>
                                            <p class="text-xs text-slate-400 mt-1">We couldn't find any teachers matching your filter criteria.</p>
                                            <a href="{{ route('teachers.index') }}" class="mt-3 text-xs font-semibold text-[#123b70] hover:underline">Clear search & filters</a>
                                        @else
                                            <h3 class="text-sm font-semibold text-slate-800">No teachers registered yet</h3>
                                            <p class="text-xs text-slate-400 mt-1">Start by adding your first teacher profile.</p>
                                            <a href="{{ route('teachers.create') }}" class="mt-4 inline-flex items-center gap-1.5 bg-[#155d36] hover:bg-[#0f4628] active:bg-[#09321c] text-white font-bold text-xs rounded-xl px-4 py-2 shadow-sm hover:shadow-md transition duration-200 border border-[#155d36]">Add First Teacher</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            @if($teachers->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $teachers->withQueryString()->links() }}
                </div>
            @endif
        </div>

    </div>

</x-admin-layout>
