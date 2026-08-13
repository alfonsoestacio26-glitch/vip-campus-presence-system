<x-admin-layout>

<div class="max-w-4xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-6">

        <div class="flex items-center gap-3">
            <a
                href="{{ route('guards.index') }}"
                class="w-9 h-9 rounded-xl
                       bg-white border border-slate-200
                       flex items-center justify-center
                       text-slate-500 hover:text-[#123b70] hover:border-[#123b70]
                       transition"
                title="Back"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <div>
                <h1 class="text-2xl font-bold text-[#0e2c56]">
                    Add Guard
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Register a new security guard profile and login credentials
                </p>
            </div>
        </div>

    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="mb-5 bg-red-50 border border-red-100 text-red-700 px-4 py-3 rounded-xl text-sm">
            <p class="font-semibold mb-1">Please fix the following errors:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <form
            action="{{ route('guards.store') }}"
            method="POST"
        >
            @csrf

            {{-- Section 1: Profile Info --}}
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-sm font-semibold text-slate-700">Guard Profile Details</h2>
                <p class="text-xs text-slate-400 mt-0.5">Basic profile details for the security guard.</p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Employee No --}}
                <div>
                    <label for="employee_no" class="block text-sm font-semibold text-slate-600 mb-2">
                        Employee No <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="employee_no"
                        name="employee_no"
                        value="{{ old('employee_no') }}"
                        required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm text-slate-700 outline-none focus:ring-2 focus:ring-[#123b70]/20 focus:border-[#123b70]"
                        placeholder="e.g. GRD-2026-001"
                    >
                </div>

                {{-- Contact Number --}}
                <div>
                    <label for="contact_number" class="block text-sm font-semibold text-slate-600 mb-2">
                        Contact Number
                    </label>
                    <input
                        type="text"
                        id="contact_number"
                        name="contact_number"
                        value="{{ old('contact_number') }}"
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm text-slate-700 outline-none focus:ring-2 focus:ring-[#123b70]/20 focus:border-[#123b70]"
                        placeholder="e.g. 09123456789"
                    >
                </div>

                {{-- First Name --}}
                <div>
                    <label for="first_name" class="block text-sm font-semibold text-slate-600 mb-2">
                        First Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="{{ old('first_name') }}"
                        required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm text-slate-700 outline-none focus:ring-2 focus:ring-[#123b70]/20 focus:border-[#123b70]"
                        placeholder="Enter first name"
                    >
                </div>

                {{-- Last Name --}}
                <div>
                    <label for="last_name" class="block text-sm font-semibold text-slate-600 mb-2">
                        Last Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="{{ old('last_name') }}"
                        required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm text-slate-700 outline-none focus:ring-2 focus:ring-[#123b70]/20 focus:border-[#123b70]"
                        placeholder="Enter last name"
                    >
                </div>
            </div>

            {{-- Section 2: Account Info --}}
            <div class="px-6 py-5 border-t border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-sm font-semibold text-slate-700">Login Account Credentials</h2>
                <p class="text-xs text-slate-400 mt-0.5">Used by the guard to log in to the VIP presence portal.</p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-600 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm text-slate-700 outline-none focus:ring-2 focus:ring-[#123b70]/20 focus:border-[#123b70]"
                        placeholder="e.g. guard@school.com"
                    >
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-600 mb-2">
                        Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm text-slate-700 outline-none focus:ring-2 focus:ring-[#123b70]/20 focus:border-[#123b70]"
                        placeholder="Defaults to 'password' if left blank"
                    >
                </div>
            </div>

            {{-- Footer Buttons --}}
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                <a
                    href="{{ route('guards.index') }}"
                    class="px-5 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 hover:bg-slate-100 transition"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#123b70] hover:bg-[#0e2c56] text-white text-sm font-semibold transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/>
                    </svg>
                    Add Guard
                </button>
            </div>

        </form>

    </div>

</div>

</x-admin-layout>
