@props([
    'score' => 0,
    'count' => 0,
    'platform' => null,
    'platformIcon' => null,
    'maxScore' => 5,
    'scale' => 'star',
    'showPlatform' => true,
    'showCount' => true,
])

@php
    $colors = config('design-tokens.colors');
    $typography = config('design-tokens.typography');
    $spacing = config('design-tokens.spacing');
    
    // Platform-specific styling
    $platformStyles = [
        'google' => [
            'icon' => '⭐',
            'color' => '#4285F4',
            'bg' => '#F8F9FA',
        ],
        'tripadvisor' => [
            'icon' => '⭐',
            'color' => '#00AEF0',
            'bg' => '#E6F4F7',
        ],
        'booking' => [
            'icon' => '⭐',
            'color' => '#26A646',
            'bg' => '#E8F5E9',
        ],
        'expedia' => [
            'icon' => '⭐',
            'color' => '#007BFF',
            'bg' => '#E3F2FD',
        ],
        'agoda' => [
            'icon' => '⭐',
            'color' => '#FF4444',
            'bg' => '#FFF3E0',
        ],
    ];
    
    // Determine platform styling
    $platformKey = strtolower($platform ?? '');
    $style = $platformStyles[$platformKey] ?? [
        'icon' => '⭐',
        'color' => $colors['primary']['default'],
        'bg' => $colors['accent']['light-gray']['50'],
    ];
    
    // Calculate percentage for visual rating
    $percentage = min(100, max(0, ($score / $maxScore) * 100));
    
    // Format count with commas
    $formattedCount = number_format($count);
@endphp

<div class="rating"
     style="display: flex; align-items: center; gap: {{ $spacing['scale']['md'] }}; padding: {{ $spacing['scale']['sm'] }} {{ $spacing['scale']['md'] }}; background: {{ $style['bg'] }}; border-radius: 0.5rem;">
    
    <!-- Rating Score and Stars -->
    <div class="rating-score"
         style="display: flex; flex-direction: column; align-items: flex-start;">
        <div class="rating-stars"
             style="display: flex; align-items: center; gap: 0.25rem; color: {{ $style['color'] }}; font-size: {{ $typography['font-size']['xl'] }};">
            <span>{{ $style['icon'] }}</span>
            <span class="score"
                  style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['semibold'] }}; font-size: {{ $typography['font-size']['lg'] }}; color: {{ $colors['primary']['default'] }};">
                {{ number_format($score, 1) }}
            </span>
            <span class="max-score"
                  style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['body'] }}; font-size: {{ $typography['font-size']['sm'] }}; color: {{ $colors['accent']['light-gray']['600'] }};">
                /{{ $maxScore }}
            </span>
        </div>
        
        <!-- Platform Name (Optional) -->
        @if($showPlatform && $platform)
            <div class="rating-platform"
                 style="display: flex; align-items: center; gap: 0.25rem; margin-top: {{ $spacing['scale']['xs'] }};">
                @if($platformIcon)
                    <span class="platform-icon"
                          style="font-size: {{ $typography['font-size']['sm'] }};">
                        {{ $platformIcon }}
                    </span>
                @elseif($platformKey && isset($platformStyles[$platformKey]))
                    <span class="platform-icon"
                          style="font-size: {{ $typography['font-size']['sm'] }};">
                        {{ $platformStyles[$platformKey]['icon'] }}
                    </span>
                @endif
                <span class="platform-name"
                      style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['body'] }}; font-size: {{ $typography['font-size']['sm'] }}; color: {{ $colors['accent']['light-gray']['700'] }};">
                    {{ $platform }}
                </span>
            </div>
        @endif
    </div>
    
    <!-- Rating Count (Optional) -->
    @if($showCount && $count > 0)
        <div class="rating-count"
             style="display: flex; align-items: center; gap: {{ $spacing['scale']['xs'] }}; padding-left: {{ $spacing['scale']['md'] }}; border-left: 1px solid {{ $colors['accent']['light-gray']['300'] }};">
            <span class="count-label"
                  style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['body'] }}; font-size: {{ $typography['font-size']['sm'] }}; color: {{ $colors['accent']['light-gray']['600'] }};">
                {{ $formattedCount }} review{{ $count !== 1 ? 's' : '' }}
            </span>
        </div>
    @endif
</div>
