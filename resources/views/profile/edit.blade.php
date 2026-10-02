<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Page Header --}}
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                Settings
            </div>

            <h1 class="text-2xl font-bold text-gray-900">
                Account Profile Settings
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Manage your account credentials, security settings, and profile information.
            </p>
        </div>

        {{-- Profile Information Card --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 sm:p-8">
            <div class="max-w-2xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Update Password Card --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 sm:p-8">
            <div class="max-w-2xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete Account Card --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 sm:p-8">
            <div class="max-w-2xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</x-app-layout>
