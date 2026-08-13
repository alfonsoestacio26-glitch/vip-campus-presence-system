<x-admin-layout>

    <div class="max-w-7xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-6">

            <div class="flex items-center justify-between">

                <div>
                    <h1 class="text-2xl font-bold text-[#0e2c56]">
                        Guards
                    </h1>

                    <p class="text-sm text-slate-400 mt-1">
                        Manage campus security guards and their login profiles
                    </p>
                </div>

                {{-- Add Guard --}}
                <a
                    href="{{ route('guards.create') }}"
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
                            d="M12 5v14M5 12h14"
                        />
                    </svg>
                    Add Guard
                </a>

            </div>

        </div>

        {{-- Success Message --}}
        @if(session('success'))

            <div
                class="mb-5
                       bg-green-50
                       border border-green-100
                       text-green-700
                       px-4 py-3
                       rounded-xl
                       text-sm
                       font-medium"
            >
                {{ session('success') }}
            </div>

        @endif

        {{-- Table Card --}}
        <div
            class="bg-white
                   rounded-2xl
                   border border-slate-200
                   shadow-sm
                   overflow-hidden"
        >

            {{-- Search Bar --}}
            <div class="p-5 border-b border-slate-100">

                <form
                    method="GET"
                    action="{{ route('guards.index') }}"
                    class="relative"
                >
                    <svg
                        class="absolute left-4 top-1/2
                               -translate-y-1/2
                               w-4 h-4
                               text-slate-400"
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
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Search guards by name, email, employee number..."
                        class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#123b70]/20 focus:border-[#123b70]"
                    >
                </form>

            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead
                        class="bg-slate-50
                               border-b border-slate-100"
                    >
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Employee No
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Guard Name
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Email
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Contact
                            </th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wide">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($guards as $guard)
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition text-sm text-slate-600">
                                <td class="px-6 py-4 font-semibold text-slate-700">
                                    {{ $guard->employee_no }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-[#123b70] font-bold text-xs">
                                            {{ strtoupper(substr($guard->first_name, 0, 1) . substr($guard->last_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-700">
                                                {{ $guard->first_name }} {{ $guard->last_name }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $guard->user->email ?? '—' }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $guard->contact_number ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        {{-- View --}}
                                        <a
                                            href="{{ route('guards.show', $guard) }}"
                                            class="text-[#123b70] hover:text-[#0e2c56] transition"
                                            title="View Profile"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z"/>
                                                <circle cx="12" cy="12" r="2.5" stroke-width="1.8"/>
                                            </svg>
                                        </a>

                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('guards.edit', $guard) }}"
                                            class="text-amber-500 hover:text-amber-600 transition"
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
                                                class="text-red-500 hover:text-red-600 transition"
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
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mb-4">
                                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3l7 3v5c0 4.5-3 8.5-7 10-4-1.5-7-5.5-7-10V6l7-3z"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-500">No guards found</p>
                                        <p class="text-xs text-slate-400 mt-1">Security guard profiles will appear here.</p>
                                        <a
                                            href="{{ route('guards.create') }}"
                                            class="mt-4 text-sm font-semibold text-[#123b70] hover:underline"
                                        >
                                            Add your first guard
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

</x-admin-layout>
