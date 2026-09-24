@props(['title', 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'mb-8 lg:mb-10 animate-fade-in-down']) }}>
    <h1 class="section-title">{{ $title }}</h1>
    @if($subtitle)
        <p class="section-subtitle">{{ $subtitle }}</p>
    @endif
</div>
