@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@hasSection('title')@yield('title')@else{{ $title ? ($title . ' - ' . config('app.name', 'StayEase')) : config('app.name', 'StayEase') }}@endif</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex">
            <!-- Left: Image Panel -->
            <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
                <img src="{{ asset('images/home/hero-pg.jpg') }}"
                     alt="Modern apartment interior"
                     class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 hero-gradient opacity-80"></div>
                <div class="relative z-10 flex flex-col justify-between p-12 text-white w-full">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        <span class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center font-bold text-sm">SE</span>
                        <span class="font-bold text-xl">StayEase</span>
                    </a>
                    <div class="animate-fade-in-up">
                        <h2 class="text-4xl font-bold leading-tight mb-4">Your perfect PG<br>is waiting for you</h2>
                        <p class="text-white/80 text-lg max-w-md">Join thousands of students and professionals who found their ideal accommodation through StayEase.</p>
                    </div>
                    <p class="text-white/60 text-sm">&copy; {{ date('Y') }} StayEase</p>
                </div>
            </div>

            <!-- Right: Form Panel -->
            <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 bg-slate-50">
                <div class="lg:hidden mb-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                        <span class="w-10 h-10 rounded-xl hero-gradient flex items-center justify-center text-white font-bold text-sm">SE</span>
                        <span class="font-bold text-xl text-slate-900">Stay<span class="text-brand-600">Ease</span></span>
                    </a>
                </div>

                <div class="w-full sm:max-w-md animate-scale-in">
                    <div class="card p-8 shadow-card">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        <x-sweetalert />
    </body>
</html>
