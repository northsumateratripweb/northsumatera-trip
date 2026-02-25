@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'icon' => null,
])

@php
    $colors = config('design-tokens.colors');
    $typography = config('design-tokens.typography');
    $spacing = config('design-tokens.spacing');
    
    // Variant styles
    $variants = [
        'primary' => 'bg-primary text-white hover:bg-primary-dark',
        'secondary' => 'bg-white text-primary border border-gray-200 hover:bg-gray-50',
        'outline' => 'bg-transparent text-primary border-2 border-primary hover:bg-primary hover:text-white',
        'ghost' => 'bg-transparent text-gray-700 hover:bg-gray-100',
    ];
    
    // Size styles
    $sizes = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-base',
        'lg' => 'px-8 py-4 text-lg',
    ];
    
    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    
    $baseClass = 'inline-flex items-center justify-center gap-2 rounded-full font-semibold transition-all duration-300 ease-in-out hover:transform hover:-translate-y-1 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary tap-target';
    
    $classes = $baseClass . ' ' . $variantClass . ' ' . $sizeClass;
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            {!! $icon !!}
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            {!! $icon !!}
        @endif
        {{ $slot }}
    </button>
@endif
