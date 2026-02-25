@props([
    'variant' => 'default',
    'padding' => 'md',
    'hover' => true,
])

@php
    $colors = config('design-tokens.colors');
    $spacing = config('design-tokens.spacing');
    
    // Variant styles
    $variants = [
        'default' => 'bg-white border border-gray-200',
        'premium' => 'card-premium',
        'glass' => 'glass',
        'elevated' => 'bg-white shadow-lg',
    ];
    
    // Padding styles
    $paddings = [
        'none' => 'p-0',
        'sm' => 'p-4',
        'md' => 'p-6',
        'lg' => 'p-8',
    ];
    
    $variantClass = $variants[$variant] ?? $variants['default'];
    $paddingClass = $paddings[$padding] ?? $paddings['md'];
    $hoverClass = $hover ? 'hover-lift' : '';
    
    $baseClass = 'rounded-3xl transition-all duration-300';
    
    $classes = $baseClass . ' ' . $variantClass . ' ' . $paddingClass . ' ' . $hoverClass;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
