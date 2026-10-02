<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'VIP Learning Center') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#faf7f0] text-slate-800 antialiased font-sans">

    @php
        $role = auth()->user()->role ?? 'guard';
    @endphp

    @if($role === 'admin')
        <x-admin-layout>
            {{ $slot }}
        </x-admin-layout>
    @else
        <x-guard-layout>
            {{ $slot }}
        </x-guard-layout>
    @endif

</body>

</html>