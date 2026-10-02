<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VIP Learning Center') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#faf7f0] min-h-screen">

    <div class="min-h-screen flex items-center justify-center p-4 sm:p-8">

        <!-- Main Login Container -->
        <div class="w-full max-w-6xl min-h-[650px] bg-white rounded-2xl overflow-hidden
                    shadow-[0_25px_70px_-15px_rgba(21,93,54,0.18)]
                    border-t-4 border-t-[#155d36] border border-stone-200/70
                    flex flex-col lg:flex-row">

            <!-- ========================================= -->
            <!-- LEFT SIDE — LOGIN -->
            <!-- ========================================= -->

            <div class="w-full lg:w-1/2 bg-white flex items-center justify-center px-8 py-12 sm:px-14 lg:px-16">

                <div class="w-full max-w-md">

                    <!-- Logo -->
                    <div class="flex justify-center mb-6">
                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="VIP Learning Center Logo"
                            class="h-20 w-20 object-contain"
                        >
                    </div>

                    <!-- Heading -->
                    <div class="text-center mb-8">

                        <h1 class="text-4xl font-extrabold text-[#155d36] tracking-tight">
                            Sign In
                        </h1>

                        <p class="mt-2 text-sm text-stone-500">
                            Access your VIP Learning Center account
                        </p>

                    </div>

                    <!-- Laravel Login Form -->
                    {{ $slot }}

                </div>

            </div>


            <!-- ========================================= -->
            <!-- RIGHT SIDE — WELCOME PANEL -->
            <!-- ========================================= -->

            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden
                        bg-gradient-to-br from-[#155d36] via-[#0f4628] to-[#1b7444]
                        items-center justify-center text-white">

                <!-- Decorative circles -->

                <div class="absolute -top-32 -right-32
                            w-96 h-96 rounded-full
                            bg-white/10">
                </div>

                <div class="absolute -bottom-40 -left-40
                            w-[500px] h-[500px] rounded-full
                            bg-white/5">
                </div>

                <div class="absolute top-20 right-20
                            w-20 h-20 rounded-full
                            border border-white/10">
                </div>

                <div class="absolute bottom-24 right-32
                            w-12 h-12 rounded-full
                            bg-white/10">
                </div>


                <!-- Welcome Content -->
                <div class="relative z-10 max-w-lg px-12 text-center">

                    <!-- Logo -->
                    <div class="flex justify-center mb-8">

                        <div class="h-28 w-28 rounded-full
                                    bg-white/10 backdrop-blur-md
                                    border border-white/20
                                    flex items-center justify-center
                                    shadow-2xl">

                            <img
                                src="{{ asset('images/logo.png') }}"
                                alt="VIP Logo"
                                class="h-24 w-24 object-contain"
                            >

                        </div>

                    </div>


                    <!-- Welcome -->
                    <h2 class="text-4xl font-extrabold tracking-tight">
                        Welcome Back!
                    </h2>

                    <p class="mt-6 text-lg leading-8 text-white/90">
                        Welcome to the
                        <span class="font-bold text-white">
                            VIP Learning Center
                        </span>
                        Campus Management System.
                    </p>

                    <p class="mt-3 text-sm leading-6 text-white/75">
                        Manage campus presence, attendance,
                        student information, parent communication,
                        and reports — all in one place.
                    </p>


                    <!-- Feature Pills -->
                    <div class="mt-8 flex flex-wrap justify-center gap-3">

                        <span class="px-4 py-2 rounded-full
                                     bg-white/15 border border-white/20
                                     text-sm text-white/95 font-medium">
                            Campus Presence
                        </span>

                        <span class="px-4 py-2 rounded-full
                                     bg-white/15 border border-white/20
                                     text-sm text-white/95 font-medium">
                            Attendance
                        </span>

                        <span class="px-4 py-2 rounded-full
                                     bg-white/15 border border-white/20
                                     text-sm text-white/95 font-medium">
                            Parent Portal
                        </span>

                    </div>


                    <!-- Bottom Branding -->
                    <div class="mt-10 pt-6 border-t border-white/15">

                        <p class="text-xs uppercase tracking-[0.25em] text-white/60 font-semibold">
                            VIP LEARNING CENTER INC.
                        </p>

                        <p class="mt-2 text-xs text-white/50">
                            Automated Campus-Presence Verification System
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>
</html>