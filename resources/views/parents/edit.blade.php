<x-admin-layout>

<div class="max-w-4xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-6">

        <div class="flex items-center gap-3">

            <a
                href="{{ route('parents.show', $parent) }}"
                class="w-9 h-9 rounded-xl
                       bg-white
                       border border-slate-200
                       flex items-center justify-center
                       text-slate-500
                       hover:text-[#123b70]
                       hover:border-[#123b70]
                       transition"
                title="Back to Profile"
            >
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>
            </a>

            <div>
                <h1 class="text-2xl font-bold text-[#0e2c56]">
                    Edit Parent
                </h1>

                <p class="text-sm text-slate-400 mt-1">
                    Update parent or guardian record
                </p>
            </div>

        </div>

    </div>


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="mb-5
                    bg-red-50
                    border border-red-100
                    text-red-700
                    px-4 py-3
                    rounded-xl
                    text-sm">

            <p class="font-semibold mb-1">
                Please fix the following errors:
            </p>

            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    {{-- Form --}}
    <div class="bg-white
                rounded-2xl
                border border-slate-200
                shadow-sm
                overflow-hidden">

        <form
            action="{{ route('parents.update', $parent) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            {{-- Form Header --}}
            <div class="px-6 py-5
                        border-b border-slate-100">

                <div class="flex items-center gap-3">

                    <div
                        class="w-10 h-10
                               rounded-xl
                               bg-blue-50
                               flex items-center
                               justify-center"
                    >
                        <svg
                            class="w-5 h-5 text-[#123b70]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                cx="12"
                                cy="8"
                                r="4"
                                stroke-width="1.8"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-width="1.8"
                                d="M4 21a8 8 0 0116 0"
                            />
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-slate-700">
                            Parent Information
                        </h2>

                        <p class="text-xs text-slate-400 mt-0.5">
                            Modify the parent's basic information below.
                        </p>
                    </div>

                </div>

            </div>


            {{-- Form Body --}}
            <div class="p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                    {{-- First Name --}}
                    <div>

                        <label
                            for="first_name"
                            class="block text-sm
                                   font-semibold
                                   text-slate-600
                                   mb-2"
                        >
                            First Name
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="first_name"
                            name="first_name"
                            value="{{ old('first_name', $parent->first_name) }}"
                            required
                            class="w-full
                                   px-4 py-3
                                   border border-slate-200
                                   rounded-xl
                                   text-sm
                                   text-slate-700
                                   outline-none
                                   focus:ring-2
                                   focus:ring-[#123b70]/20
                                   focus:border-[#123b70]"
                            placeholder="Enter first name"
                        >

                    </div>


                    {{-- Middle Name --}}
                    <div>

                        <label
                            for="middle_name"
                            class="block text-sm
                                   font-semibold
                                   text-slate-600
                                   mb-2"
                        >
                            Middle Name
                        </label>

                        <input
                            type="text"
                            id="middle_name"
                            name="middle_name"
                            value="{{ old('middle_name', $parent->middle_name) }}"
                            class="w-full
                                   px-4 py-3
                                   border border-slate-200
                                   rounded-xl
                                   text-sm
                                   text-slate-700
                                   outline-none
                                   focus:ring-2
                                   focus:ring-[#123b70]/20
                                   focus:border-[#123b70]"
                            placeholder="Enter middle name"
                        >

                    </div>


                    {{-- Last Name --}}
                    <div>

                        <label
                            for="last_name"
                            class="block text-sm
                                   font-semibold
                                   text-slate-600
                                   mb-2"
                        >
                            Last Name
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="last_name"
                            name="last_name"
                            value="{{ old('last_name', $parent->last_name) }}"
                            required
                            class="w-full
                                   px-4 py-3
                                   border border-slate-200
                                   rounded-xl
                                   text-sm
                                   text-slate-700
                                   outline-none
                                   focus:ring-2
                                   focus:ring-[#123b70]/20
                                   focus:border-[#123b70]"
                            placeholder="Enter last name"
                        >

                    </div>


                    {{-- Phone --}}
                    <div>

                        <label
                            for="phone"
                            class="block text-sm
                                   font-semibold
                                   text-slate-600
                                   mb-2"
                        >
                            Phone Number
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone', $parent->phone) }}"
                            class="w-full
                                   px-4 py-3
                                   border border-slate-200
                                   rounded-xl
                                   text-sm
                                   text-slate-700
                                   outline-none
                                   focus:ring-2
                                   focus:ring-[#123b70]/20
                                   focus:border-[#123b70]"
                            placeholder="e.g. 09123456789"
                        >

                    </div>


                    {{-- Address --}}
                    <div class="md:col-span-2">

                        <label
                            for="address"
                            class="block text-sm
                                   font-semibold
                                   text-slate-600
                                   mb-2"
                        >
                            Address
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            class="w-full
                                   px-4 py-3
                                   border border-slate-200
                                   rounded-xl
                                   text-sm
                                   text-slate-700
                                   outline-none
                                   resize-none
                                   focus:ring-2
                                   focus:ring-[#123b70]/20
                                   focus:border-[#123b70]"
                            placeholder="Enter complete address"
                        >{{ old('address', $parent->address) }}</textarea>

                    </div>

                </div>

            </div>
                    {{-- Account Information --}}
                    <div class="md:col-span-2 mt-3 pt-6 border-t border-slate-100">

                        <div class="flex items-center gap-3 mb-5">

                            <div
                                class="w-10 h-10
                                       rounded-xl
                                       bg-blue-50
                                       flex items-center
                                       justify-center"
                            >
                                <svg
                                    class="w-5 h-5 text-[#123b70]"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                                    />
                                    <circle
                                        cx="9"
                                        cy="7"
                                        r="4"
                                        stroke-width="1.8"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-width="1.8"
                                        d="M19 8v6M22 11h-6"
                                    />
                                </svg>
                            </div>

                            <div>
                                <h2 class="text-sm font-semibold text-slate-700">
                                    Parent Login Account
                                </h2>

                                <p class="text-xs text-slate-400 mt-0.5">
                                    Manage the parent's login credentials.
                                </p>
                            </div>

                        </div>


                        {{-- Account Status --}}
                        <div class="mb-5">

                            @if ($parent->user_id && $parent->user)

                                <div class="flex items-center gap-2
                                            px-4 py-3
                                            rounded-xl
                                            bg-green-50
                                            border border-green-100
                                            text-sm">

                                    <span
                                        class="w-2 h-2
                                               rounded-full
                                               bg-green-500"
                                    ></span>

                                    <span class="font-semibold text-green-700">
                                        Login account connected
                                    </span>

                                </div>

                            @else

                                <div class="flex items-center gap-2
                                            px-4 py-3
                                            rounded-xl
                                            bg-amber-50
                                            border border-amber-100
                                            text-sm">

                                    <span
                                        class="w-2 h-2
                                               rounded-full
                                               bg-amber-500"
                                    ></span>

                                    <span class="font-semibold text-amber-700">
                                        No login account yet
                                    </span>

                                </div>

                            @endif

                        </div>


                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            {{-- Email --}}
                            <div class="md:col-span-2">

                                <label
                                    for="email"
                                    class="block text-sm
                                           font-semibold
                                           text-slate-600
                                           mb-2"
                                >
                                    Login Email
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $parent->user?->email) }}"
                                    required
                                    class="w-full
                                           px-4 py-3
                                           border border-slate-200
                                           rounded-xl
                                           text-sm
                                           text-slate-700
                                           outline-none
                                           focus:ring-2
                                           focus:ring-[#123b70]/20
                                           focus:border-[#123b70]"
                                    placeholder="parent@example.com"
                                >

                            </div>


                            {{-- Password --}}
                            <div>

                                <label
                                    for="password"
                                    class="block text-sm
                                           font-semibold
                                           text-slate-600
                                           mb-2"
                                >
                                    New Password
                                </label>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="w-full
                                           px-4 py-3
                                           border border-slate-200
                                           rounded-xl
                                           text-sm
                                           text-slate-700
                                           outline-none
                                           focus:ring-2
                                           focus:ring-[#123b70]/20
                                           focus:border-[#123b70]"
                                    placeholder="Enter new password"
                                >

                                <p class="text-xs text-slate-400 mt-2">
                                    Leave blank to keep the current password.
                                </p>

                            </div>


                            {{-- Confirm Password --}}
                            <div>

                                <label
                                    for="password_confirmation"
                                    class="block text-sm
                                           font-semibold
                                           text-slate-600
                                           mb-2"
                                >
                                    Confirm Password
                                </label>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="w-full
                                           px-4 py-3
                                           border border-slate-200
                                           rounded-xl
                                           text-sm
                                           text-slate-700
                                           outline-none
                                           focus:ring-2
                                           focus:ring-[#123b70]/20
                                           focus:border-[#123b70]"
                                    placeholder="Confirm new password"
                                >

                            </div>

                        </div>

                    </div>

            {{-- Form Footer --}}
            <div
                class="px-6 py-4
                       bg-slate-50
                       border-t border-slate-100
                       flex items-center
                       justify-end gap-3"
            >

                <a
                    href="{{ route('parents.show', $parent) }}"
                    class="px-5 py-2.5
                           rounded-xl
                           border border-slate-200
                           bg-white
                           text-sm
                           font-semibold
                           text-slate-600
                           hover:bg-slate-100
                           transition"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 bg-[#155d36] hover:bg-[#0f4628] active:bg-[#09321c] text-white font-bold text-sm rounded-xl px-5 py-2.5 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#155d36] focus:ring-offset-2 transition duration-200 border border-[#155d36]"
                >
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>

</x-admin-layout>
