@props(['label', 'value', 'color' => 'brand', 'icon' => null])

@php
    $colors = [
        'brand' => 'from-brand-500 to-violet-500',
        'green' => 'from-emerald-500 to-teal-500',
        'amber' => 'from-amber-500 to-orange-500',
        'red' => 'from-red-500 to-rose-500',
        'purple' => 'from-purple-500 to-violet-500',
        'blue' => 'from-blue-500 to-cyan-500',
    ];
    $gradient = $colors[$color] ?? $colors['brand'];
@endphp

<div {{ $attributes->merge(['class' => 'stat-card animate-on-scroll']) }}>
    <div class="relative z-10">
        @if($icon)
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $gradient }} flex items-center justify-center text-white text-lg mb-3 shadow-soft">
                {!! $icon !!}
            </div>
        @endif
        <p class="text-slate-500 text-sm font-medium">{{ $label }}</p>
        <p class="text-3xl font-bold text-slate-900 mt-1">{{ $value }}</p>
    </div>
    <div class="absolute -right-4 -bottom-4 w-24 h-24 rounded-full bg-gradient-to-br {{ $gradient }} opacity-10 blur-2xl"></div>
</div>
