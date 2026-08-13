<x-admin-layout>

    <div class="max-w-7xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-6">

            <div class="flex items-center justify-between">

                <div>
                    <h1 class="text-2xl font-bold text-[#0e2c56]">
                        Parents
                    </h1>

                    <p class="text-sm text-slate-400 mt-1">
                        Manage parent and guardian records
                    </p>
                </div>


                {{-- Add Parent --}}
                <a
                    href="{{ route('parents.create') }}"
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

                    Add Parent

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


        {{-- Parents Table --}}
        <div
            class="bg-white
                   rounded-2xl
                   border border-slate-200
                   shadow-sm
                   overflow-hidden"
        >

            {{-- Search --}}
<div class="p-5 border-b border-slate-100">

    <form
        method="GET"
        action="{{ route('parents.index') }}"
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
        placeholder="Search parents..."
        class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl text-sm"
    >

    </form>

</div>


            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    {{-- Header --}}
                    <thead
                        class="bg-slate-50
                               border-b border-slate-100"
                    >

                        <tr>

                            <th
                                class="px-6 py-4
                                       text-left
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase
                                       tracking-wide"
                            >
                                Parent Name
                            </th>


                            <th
                                class="px-6 py-4
                                       text-left
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase
                                       tracking-wide"
                            >
                                Phone
                            </th>


                            <th
                                class="px-6 py-4
                                       text-left
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase
                                       tracking-wide"
                            >
                                Address
                            </th>


                            <th
                                class="px-6 py-4
                                       text-left
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase
                                       tracking-wide"
                            >
                                Children
                            </th>


                            <th
                                class="px-6 py-4
                                       text-right
                                       text-xs
                                       font-semibold
                                       text-slate-500
                                       uppercase
                                       tracking-wide"
                            >
                                Action
                            </th>

                        </tr>

                    </thead>


                    {{-- Body --}}
                    <tbody>

                        @forelse($parents as $parent)

                            <tr
                                class="border-b
                                       border-slate-100
                                       hover:bg-slate-50
                                       transition"
                            >

                                {{-- Parent Name --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        {{-- Avatar --}}
                                        <div
                                            class="w-10 h-10
                                                   rounded-full
                                                   bg-blue-50
                                                   flex items-center
                                                   justify-center
                                                   flex-shrink-0"
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

                                            <p
                                                class="text-sm
                                                       font-semibold
                                                       text-slate-700"
                                            >

                                                {{ $parent->first_name }}

                                                @if($parent->middle_name)
                                                    {{ $parent->middle_name }}
                                                @endif

                                                {{ $parent->last_name }}

                                            </p>


                                            <p
                                                class="text-xs
                                                       text-slate-400
                                                       mt-0.5"
                                            >
                                                Parent / Guardian
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Phone --}}
                                <td
                                    class="px-6 py-4
                                           text-sm
                                           text-slate-500"
                                >

                                    {{ $parent->phone ?? '—' }}

                                </td>


                                {{-- Address --}}
                                <td
                                    class="px-6 py-4
                                           text-sm
                                           text-slate-500
                                           max-w-xs"
                                >

                                    <span class="line-clamp-2">

                                        {{ $parent->address ?? '—' }}

                                    </span>

                                </td>


                                {{-- Children --}}
                                <td class="px-6 py-4">

                                    {{-- Relationship will be used once linked --}}
                                    @if($parent->students && $parent->students->count())

                                        <div class="flex items-center gap-2">

                                            <span
                                                class="inline-flex
                                                       items-center
                                                       justify-center
                                                       min-w-7 h-7
                                                       px-2
                                                       rounded-lg
                                                       bg-blue-50
                                                       text-[#123b70]
                                                       text-xs
                                                       font-bold"
                                            >
                                                {{ $parent->students->count() }}
                                            </span>

                                            <span
                                                class="text-xs
                                                       text-slate-500"
                                            >
                                                {{ $parent->students->count() === 1 ? 'Student' : 'Students' }}
                                            </span>

                                        </div>

                                    @else

                                        <span
                                            class="text-sm
                                                   text-slate-400"
                                        >
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-4">

                                    <div
                                        class="flex
                                               items-center
                                               justify-end
                                               gap-4"
                                    >

                                        {{-- View --}}
                                        <a
                                            href="{{ route('parents.show', $parent) }}"
                                            class="text-[#123b70]
                                                   hover:text-[#0e2c56]
                                                   transition"
                                            title="View Parent"
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
                                                    d="M2.5 12s3.5-6 9.5-6
                                                       9.5 6 9.5 6
                                                       -3.5 6-9.5 6
                                                       -9.5-6-9.5-6z"
                                                />

                                                <circle
                                                    cx="12"
                                                    cy="12"
                                                    r="2.5"
                                                    stroke-width="1.8"
                                                />

                                            </svg>

                                        </a>


                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('parents.edit', $parent) }}"
                                            class="text-amber-500
                                                   hover:text-amber-600
                                                   transition"
                                            title="Edit Parent"
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
                                                    d="M12 20h9"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4L16.5 3.5z"
                                                />

                                            </svg>

                                        </a>


                                        {{-- Delete --}}
                                        <form
                                            action="{{ route('parents.destroy', $parent) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this parent?');"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-red-500
                                                       hover:text-red-600
                                                       transition"
                                                title="Delete Parent"
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
                                                        d="M4 7h16"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M10 11v6M14 11v6"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M6 7l1 13h10l1-13"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M9 7V4h6v3"
                                                    />

                                                </svg>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            {{-- Empty State --}}
                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-20
                                           text-center"
                                >

                                    <div
                                        class="flex
                                               flex-col
                                               items-center"
                                    >

                                        <div
                                            class="w-12 h-12
                                                   rounded-full
                                                   bg-slate-50
                                                   flex items-center
                                                   justify-center
                                                   mb-4"
                                        >

                                            <svg
                                                class="w-6 h-6 text-slate-300"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >

                                                <circle
                                                    cx="9"
                                                    cy="7"
                                                    r="4"
                                                    stroke-width="1.8"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M2 21a7 7 0 0114 0"
                                                />

                                            </svg>

                                        </div>


                                        <p
                                            class="text-sm
                                                   font-semibold
                                                   text-slate-500"
                                        >
                                            No parents yet
                                        </p>


                                        <p
                                            class="text-xs
                                                   text-slate-400
                                                   mt-1"
                                        >
                                            Parent records will appear here.
                                        </p>


                                        <a
                                            href="{{ route('parents.create') }}"
                                            class="mt-4
                                                   text-sm
                                                   font-semibold
                                                   text-[#123b70]
                                                   hover:underline"
                                        >
                                            Add your first parent
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