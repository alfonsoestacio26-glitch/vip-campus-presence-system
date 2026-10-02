<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if (session('error'))
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold rounded-xl flex items-center justify-between">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-700 font-bold">&times;</button>
        </div>
    @endif

    <h2 class="text-xl font-bold text-center text-[#155d36] mb-6">
        {{ __('Login to your account') }}
    </h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <div class="relative flex items-center">
                <span class="absolute left-3.5 text-stone-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </span>
                <input id="email" 
                       class="pl-11 pr-4 py-3 w-full bg-stone-50 border border-stone-200 text-stone-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#155d36] focus:border-[#155d36] transition duration-200 text-sm shadow-xs placeholder:text-stone-400" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus 
                       autocomplete="username" 
                       placeholder="Email" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="relative flex items-center">
                <span class="absolute left-3.5 text-stone-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </span>
                <input id="password" 
                       class="pl-11 pr-4 py-3 w-full bg-stone-50 border border-stone-200 text-stone-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#155d36] focus:border-[#155d36] transition duration-200 text-sm shadow-xs placeholder:text-stone-400" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="current-password" 
                       placeholder="Password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-2 px-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded bg-stone-50 border-stone-300 text-[#155d36] shadow-xs focus:ring-[#155d36]" name="remember">
                <span class="ms-2 text-xs font-semibold text-stone-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-[#155d36] hover:text-[#0f4628] hover:underline transition duration-150" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-3 px-4 bg-[#155d36] hover:bg-[#0f4628] text-white font-bold rounded-xl transition duration-200 text-center shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#155d36] text-sm">
                {{ __('Login') }}
            </button>
        </div>
    </form>

    <!-- Divider -->
    <div class="relative my-6 flex items-center justify-center">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-stone-200"></div>
        </div>
        <div class="relative bg-white px-3 text-xs font-bold uppercase tracking-wider text-stone-400">
            OR
        </div>
    </div>

    <!-- Google Sign-In Button -->
    <div>
        <a href="{{ route('auth.google') }}" 
           class="w-full flex items-center justify-center gap-3 py-3 px-4 bg-white hover:bg-stone-50 text-stone-700 font-bold border border-stone-200 rounded-xl transition duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#155d36] text-sm">
            <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
            </svg>
            <span>Sign in with Google</span>
        </a>
    </div>
</x-guest-layout>
