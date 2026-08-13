<x-admin-layout>

    <div class="max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-2xl font-bold text-[#0e2c56]">
                    Edit Student
                </h1>

                <p class="text-sm text-slate-400 mt-1">
                    Update student information
                </p>
            </div>

            <a
                href="{{ route('students.show', $student) }}"
                class="px-4 py-2.5 rounded-lg border border-slate-300
                       text-sm font-semibold text-slate-600
                       hover:bg-slate-50 transition"
            >
                Back to Profile
            </a>

        </div>


        {{-- Form --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-100">

                <h2 class="text-lg font-bold text-[#0e2c56]">
                    Student Information
                </h2>

                <p class="text-sm text-slate-400 mt-1">
                    Modify the information below and save your changes.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('students.update', $student) }}"
                class="p-6"
            >

                @csrf
                @method('PUT')


                {{-- Student ID --}}
                <div class="mb-6">

                    <label
                        for="student_no"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Student ID
                    </label>

                    <input
                        type="text"
                        id="student_no"
                        name="student_no"
                        value="{{ old('student_no', $student->student_no) }}"
                        class="w-full rounded-lg border-slate-300
                               focus:border-[#2f5995]
                               focus:ring-[#2f5995]"
                        required
                    >

                    @error('student_no')
                        <p class="text-sm text-red-500 mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Names --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

                    <div>

                        <label
                            for="first_name"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            First Name
                        </label>

                        <input
                            type="text"
                            id="first_name"
                            name="first_name"
                            value="{{ old('first_name', $student->first_name) }}"
                            class="w-full rounded-lg border-slate-300
                                   focus:border-[#2f5995]
                                   focus:ring-[#2f5995]"
                            required
                        >

                        @error('first_name')
                            <p class="text-sm text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div>

                        <label
                            for="middle_name"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Middle Name
                        </label>

                        <input
                            type="text"
                            id="middle_name"
                            name="middle_name"
                            value="{{ old('middle_name', $student->middle_name) }}"
                            class="w-full rounded-lg border-slate-300
                                   focus:border-[#2f5995]
                                   focus:ring-[#2f5995]"
                        >

                    </div>


                    <div>

                        <label
                            for="last_name"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Last Name
                        </label>

                        <input
                            type="text"
                            id="last_name"
                            name="last_name"
                            value="{{ old('last_name', $student->last_name) }}"
                            class="w-full rounded-lg border-slate-300
                                   focus:border-[#2f5995]
                                   focus:ring-[#2f5995]"
                            required
                        >

                        @error('last_name')
                            <p class="text-sm text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                {{-- Gender / Birthdate --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

                    <div>

                        <label
                            for="gender"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Gender
                        </label>

                        <select
                            id="gender"
                            name="gender"
                            class="w-full rounded-lg border-slate-300
                                   focus:border-[#2f5995]
                                   focus:ring-[#2f5995]"
                        >

                            <option value="">
                                Select gender
                            </option>

                            <option value="Male"
                                {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>
                                Male
                            </option>

                            <option value="Female"
                                {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>
                                Female
                            </option>

                        </select>

                    </div>


                    <div>

                        <label
                            for="birthdate"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Birthdate
                        </label>

                        <input
                            type="date"
                            id="birthdate"
                            name="birthdate"
                            value="{{ old('birthdate', $student->birthdate) }}"
                            class="w-full rounded-lg border-slate-300
                                   focus:border-[#2f5995]
                                   focus:ring-[#2f5995]"
                        >

                    </div>

                </div>


                {{-- Grade / Section --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">

                    <div>

                        <label
                            for="grade_level"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Grade / Level
                        </label>

                        <input
                            type="text"
                            id="grade_level"
                            name="grade_level"
                            value="{{ old('grade_level', $student->grade_level) }}"
                            class="w-full rounded-lg border-slate-300
                                   focus:border-[#2f5995]
                                   focus:ring-[#2f5995]"
                        >

                    </div>


                    <div>

                        <label
                            for="section"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Section
                        </label>

                        <input
                            type="text"
                            id="section"
                            name="section"
                            value="{{ old('section', $student->section) }}"
                            class="w-full rounded-lg border-slate-300
                                   focus:border-[#2f5995]
                                   focus:ring-[#2f5995]"
                        >

                    </div>

                </div>


                {{-- Status --}}
                <div class="mb-8">

                    <label
                        for="status"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-lg border-slate-300
                               focus:border-[#2f5995]
                               focus:ring-[#2f5995]"
                        required
                    >

                        <option value="active"
                            {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive"
                            {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                </div>


                {{-- Buttons --}}
                <div class="flex justify-end gap-3 pt-5 border-t border-slate-100">

                    <a
                        href="{{ route('students.show', $student) }}"
                        class="px-5 py-2.5 rounded-lg
                               border border-slate-300
                               text-sm font-semibold text-slate-600
                               hover:bg-slate-50 transition"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-2.5 rounded-lg
                               bg-[#0e2c56] text-white
                               text-sm font-semibold
                               hover:bg-[#163d70] transition"
                    >
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-admin-layout>