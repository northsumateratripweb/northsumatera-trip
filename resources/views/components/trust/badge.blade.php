@props([
    'name' => '',
    'icon' => null,
    'description' => '',
    'type' => null,
])

@php
    $colors = config('design-tokens.colors');
    $typography = config('design-tokens.typography');
    $spacing = config('design-tokens.spacing');
    
    // Default icon mapping based on badge type
    $iconMapping = [
        'ssl' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>',
        'payment' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>',
        'privacy' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>',
        'certified' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>',
        'licensed' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>',
        'support' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
        'secure' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>',
        'badge' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>',
        'lock' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>',
        'headset' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg>',
    ];
    
    // Determine icon based on type or icon parameter
    $iconType = $type ?? $icon ?? 'badge';
    $iconSvg = $iconMapping[$iconType] ?? $iconMapping['badge'];
    
    // Determine badge styling based on type
    $badgeStyles = [
        'ssl' => [
            'bg' => '#ECFDF5',
            'text' => '#059669',
        ],
        'payment' => [
            'bg' => '#EFF6FF',
            'text' => '#2563EB',
        ],
        'privacy' => [
            'bg' => '#F5F3FF',
            'text' => '#7C3AED',
        ],
        'certified' => [
            'bg' => '#FEF3C7',
            'text' => '#D97706',
        ],
        'licensed' => [
            'bg' => '#ECFDF5',
            'text' => '#059669',
        ],
        'support' => [
            'bg' => '#EFF6FF',
            'text' => '#2563EB',
        ],
        'secure' => [
            'bg' => '#F5F3FF',
            'text' => '#7C3AED',
        ],
        'badge' => [
            'bg' => $colors['primary']['light'],
            'text' => '#FFFFFF',
        ],
        'lock' => [
            'bg' => $colors['primary']['light'],
            'text' => '#FFFFFF',
        ],
        'headset' => [
            'bg' => $colors['primary']['light'],
            'text' => '#FFFFFF',
        ],
    ];
    
    $style = $badgeStyles[$iconType] ?? $badgeStyles['badge'];
@endphp

<div class="trust-badge flex items-start space-x-3 p-3 rounded-lg"
     style="background: {{ $style['bg'] }}; border-radius: 0.5rem; padding: {{ $spacing['scale']['md'] }};">
    
    <!-- Icon Container -->
    <div class="badge-icon flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full"
         style="background: {{ $style['text'] }}; border-radius: 50%; color: {{ $style['bg'] }}; transition: transform 0.2s ease;">
        {!! $iconSvg !!}
    </div>
    
    <!-- Badge Content -->
    <div class="badge-content">
        <p class="badge-name font-semibold text-gray-900"
           style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['semibold'] }}; font-size: {{ $typography['font-size']['sm'] }}; color: {{ $colors['accent']['light-gray']['900'] }};">
            {{ $name }}
        </p>
        <p class="badge-description text-sm text-gray-600"
           style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['body'] }}; font-size: {{ $typography['font-size']['sm'] }}; line-height: {{ $typography['line-height']['normal'] }}; color: {{ $colors['accent']['light-gray']['700'] }};">
            {{ $description }}
        </p>
    </div>
</div>
