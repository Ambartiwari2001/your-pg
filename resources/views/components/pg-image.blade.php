@props(['pg', 'class' => 'w-full h-full object-cover', 'alt' => null])

@php
    $src = $pg?->primary_image_url;

    if (empty($src)) {
        $fallbacks = [
            'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800&q=80',
            'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=800&q=80',
            'https://images.unsplash.com/photo-1560185127-6ed189bf02f4?w=800&q=80',
            'https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=800&q=80',
            'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=800&q=80',
            'https://images.unsplash.com/photo-1560185007-c5ca9d684c08?w=800&q=80',
        ];
        $src = $fallbacks[($pg?->id ?? 0) % count($fallbacks)];
    }

    $altText = $alt ?? ($pg?->name ?? 'PG accommodation');
    $defaultFallback = asset('images/default-pg.jpg');
@endphp

<img {{ $attributes->merge(['class' => $class, 'src' => $src, 'alt' => $altText, 'loading' => 'lazy']) }}
     onerror="if (this.src !== '{{ $defaultFallback }}') { this.src = '{{ $defaultFallback }}'; }">
