@props([
    'name' => '',
    'location' => '',
    'text' => '',
    'rating' => 0,
    'avatarInitial' => '',
    'showAvatar' => true,
])

@php
    $colors = config('design-tokens.colors');
    $typography = config('design-tokens.typography');
    $spacing = config('design-tokens.spacing');
@endphp

<div class="testimonial-card bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300"
     style="background: {{ $colors['secondary']['default'] }}; padding: {{ $spacing['scale']['lg'] }}; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: box-shadow 0.3s ease;"
     role="article"
     aria-label="Customer testimonial from {{ $name }}">
    
    <!-- Star Rating -->
    <div class="testimonial-rating flex items-center mb-4"
         style="display: flex; align-items: center; gap: 0.25rem; color: {{ $colors['accent']['light-gray']['500'] }}; font-size: {{ $typography['font-size']['lg'] }};">
        @for($i = 1; $i <= 5; $i++)
            <span class="{{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}"
                  style="color: {{ $i <= $rating ? '#FBBF24' : '#D1D5DB' }};">
                ★
            </span>
        @endfor
    </div>
    
    <!-- Testimonial Text -->
    <div class="testimonial-text mb-6">
        <p class="italic text-gray-700"
           style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['body'] }}; font-size: {{ $typography['font-size']['base'] }}; line-height: {{ $typography['line-height']['relaxed'] }}; color: {{ $colors['accent']['light-gray']['800'] }};">
            "{{ $text }}"
        </p>
    </div>
    
    <!-- Customer Info -->
    <div class="testimonial-author flex items-center space-x-3"
         style="display: flex; align-items: center; gap: {{ $spacing['scale']['md'] }};">
        @if($showAvatar && $avatarInitial)
            <div class="author-avatar flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-white font-semibold"
                 style="background: {{ $colors['primary']['default'] }}; border-radius: 50%; font-size: {{ $typography['font-size']['sm'] }}; font-weight: {{ $typography['font-weight']['semibold'] }}; flex-shrink: 0;">
                {{ $avatarInitial }}
            </div>
        @endif
        
        <div class="author-info">
            <p class="author-name font-semibold text-gray-900"
               style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['semibold'] }}; font-size: {{ $typography['font-size']['sm'] }}; color: {{ $colors['accent']['light-gray']['900'] }};">
                {{ $name }}
            </p>
            <p class="author-location text-sm text-gray-500"
               style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['body'] }}; font-size: {{ $typography['font-size']['sm'] }}; color: {{ $colors['accent']['light-gray']['600'] }};">
                {{ $location }}
            </p>
        </div>
    </div>
</div>
