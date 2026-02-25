@props([
    'ratings' => [],
    'travelerCount' => 0,
    'legalBadges' => [],
    'testimonials' => [],
])

@php
    $colors = config('design-tokens.colors');
    $typography = config('design-tokens.typography');
    $spacing = config('design-tokens.spacing');
    $breakpoints = config('design-tokens.breakpoints');
    $grid = config('design-tokens.grid');
    
    // Default ratings if none provided
    $ratings = $ratings ?: [
        [
            'platform' => 'Google',
            'score' => 4.8,
            'count' => 150,
            'icon' => '⭐',
        ],
    ];
    
    // Default legal badges if none provided
    $legalBadges = $legalBadges ?: [
        [
            'name' => 'Licensed Tour Operator',
            'icon' => 'badge',
            'description' => 'Officially certified',
        ],
        [
            'name' => 'Secure Booking',
            'icon' => 'lock',
            'description' => 'Safe transactions',
        ],
        [
            'name' => '24/7 Support',
            'icon' => 'headset',
            'description' => 'Always available',
        ],
    ];
@endphp

<!-- Trust Section -->
<section class="py-16 sm:py-20 lg:py-24 bg-white"
         style="padding-top: {{ $spacing['scale']['2xl'] }}; padding-bottom: {{ $spacing['scale']['2xl'] }};">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Section: Ratings and Traveler Count -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12 mb-16 lg:mb-24"
             style="margin-bottom: {{ $spacing['scale']['3xl'] }};">
            
            <!-- Customer Ratings -->
            <div class="space-y-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900"
                    style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['headline'] }}; font-size: {{ $typography['font-size']['2xl'] }};">
                    Trusted by Travelers Worldwide
                </h2>
                
                <div class="space-y-4">
                    @foreach($ratings as $rating)
                        <x-trust.rating
                            :score="$rating['score'] ?? 0"
                            :count="$rating['count'] ?? 0"
                            :platform="$rating['platform'] ?? null"
                            :platformIcon="$rating['icon'] ?? null"
                            :maxScore="$rating['max_score'] ?? 5"
                        />
                    @endforeach
                </div>
            </div>
            
            <!-- Traveler Count -->
            <div class="flex flex-col justify-center items-center md:items-start text-center md:text-left py-8 md:py-0"
                 style="background: {{ $colors['accent']['light-gray']['50'] }}; border-radius: 0.75rem; padding: {{ $spacing['scale']['4xl'] }};">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2"
                   style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['semibold'] }}; font-size: {{ $typography['font-size']['sm'] }}; letter-spacing: 0.05em;">
                    Total Travelers Served
                </p>
                <p class="text-5xl sm:text-6xl lg:text-7xl font-bold text-primary"
                   style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['headline'] }}; font-size: {{ $typography['font-size']['7xl'] }}; color: {{ $colors['primary']['default'] }};">
                    {{ number_format($travelerCount) }}
                </p>
                <p class="text-lg sm:text-xl text-gray-600 mt-4"
                   style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['body'] }}; font-size: {{ $typography['font-size']['lg'] }}; line-height: {{ $typography['line-height']['relaxed'] }};">
                    And counting...
                </p>
            </div>
            
            <!-- Legal Badges -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900"
                    style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['semibold'] }}; font-size: {{ $typography['font-size']['lg'] }};">
                    Certifications & Badges
                </h3>
                <div class="space-y-3">
                    @foreach($legalBadges as $badge)
                        <x-trust.badge
                            :name="$badge['name'] ?? ''"
                            :icon="$badge['icon'] ?? null"
                            :description="$badge['description'] ?? ''"
                            :type="$badge['type'] ?? null"
                        />
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Testimonials Section -->
        @if(!empty($testimonials))
            <div class="space-y-8">
                <div class="text-center">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-6"
                        style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['headline'] }}; font-size: {{ $typography['font-size']['4xl'] }};">
                        What Travelers Say
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto"
                       style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['body'] }}; font-size: {{ $typography['font-size']['lg'] }}; line-height: {{ $typography['line-height']['relaxed'] }};">
                        Real experiences from real travelers who have explored the world with us
                    </p>
                </div>
                
                <!-- Responsive Grid for Testimonials -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8"
                     style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: {{ $grid['gap']['md'] }};">
                    @foreach($testimonials as $testimonial)
                        <x-trust.testimonial-card
                            :name="$testimonial['name'] ?? ''"
                            :location="$testimonial['location'] ?? ''"
                            :text="$testimonial['text'] ?? ''"
                            :rating="$testimonial['rating'] ?? 0"
                            :avatarInitial="strtoupper(substr($testimonial['name'], 0, 1)) ?? ''"
                        />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
