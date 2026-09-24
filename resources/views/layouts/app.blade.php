@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@hasSection('title')@yield('title')@else{{ $title ? ($title . ' - ' . config('app.name', 'StayEase')) : config('app.name', 'StayEase') }}@endif</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.svg') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-slate-50 min-h-screen flex flex-col">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white/60 backdrop-blur-sm border-b border-slate-200/60">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="flex-1">
            @hasSection('content')
                <div class="page-container">
                    @yield('content')
                </div>
            @else
                {{ $slot ?? '' }}
            @endif
        </main>

        @include('layouts.footer')

        <x-sweetalert />

        @stack('scripts')
    </body>
</html>
