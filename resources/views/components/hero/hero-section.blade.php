@props([
    'headline' => null,
    'subheadline' => null,
    'backgroundImage' => null,
    'isVideo' => false,
    'imageFormats' => ['webp', 'avif', 'jpeg'],
])

@php
    $colors = config('design-tokens.colors');
    $typography = config('design-tokens.typography');
    $spacing = config('design-tokens.spacing');
    $breakpoints = config('design-tokens.breakpoints');
    
    // Generate responsive image sources
    $imageSizes = [
        '320w' => ['width' => 320, 'height' => 180],
        '640w' => ['width' => 640, 'height' => 360],
        '1024w' => ['width' => 1024, 'height' => 576],
        '1920w' => ['width' => 1920, 'height' => 1080],
    ];
    
    $baseImage = $backgroundImage;
    $imageInfo = $backgroundImage ? @getimagesize($backgroundImage) : null;
    $originalWidth = $imageInfo ? $imageInfo[0] : 1920;
    $originalHeight = $imageInfo ? $imageInfo[1] : 1080;
@endphp

<div class="relative min-h-screen w-full overflow-hidden"
     style="min-height: 100vh;">
    <!-- Background Media -->
    @if($isVideo && $backgroundImage)
        <video class="absolute inset-0 w-full h-full object-cover"
               autoplay
               muted
               loop
               playsinline
               poster="{{ $backgroundImage }}"
               loading="lazy">
            <source src="{{ $backgroundImage }}" type="video/mp4">
        </video>
    @elseif($backgroundImage)
        <!-- Responsive Image with WebP/AVIF support and lazy loading -->
        <picture class="absolute inset-0 w-full h-full object-cover">
            @if(in_array('avif', $imageFormats))
                <source srcset="
                    {{ str_replace(['.jpg', '.jpeg', '.png'], '.avif', $backgroundImage) }}?w=320 320w,
                    {{ str_replace(['.jpg', '.jpeg', '.png'], '.avif', $backgroundImage) }}?w=640 640w,
                    {{ str_replace(['.jpg', '.jpeg', '.png'], '.avif', $backgroundImage) }}?w=1024 1024w,
                    {{ str_replace(['.jpg', '.jpeg', '.png'], '.avif', $backgroundImage) }}?w=1920 1920w
                " sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw" type="image/avif">
            @endif
            
            @if(in_array('webp', $imageFormats))
                <source srcset="
                    {{ str_replace(['.jpg', '.jpeg', '.png'], '.webp', $backgroundImage) }}?w=320 320w,
                    {{ str_replace(['.jpg', '.jpeg', '.png'], '.webp', $backgroundImage) }}?w=640 640w,
                    {{ str_replace(['.jpg', '.jpeg', '.png'], '.webp', $backgroundImage) }}?w=1024 1024w,
                    {{ str_replace(['.jpg', '.jpeg', '.png'], '.webp', $backgroundImage) }}?w=1920 1920w
                " sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw" type="image/webp">
            @endif
            
            <!-- Fallback to original image format -->
            <img class="absolute inset-0 w-full h-full object-cover"
                 src="{{ $backgroundImage }}"
                 srcset="
                    {{ $backgroundImage }}?w=320 320w,
                    {{ $backgroundImage }}?w=640 640w,
                    {{ $backgroundImage }}?w=1024 1024w,
                    {{ $backgroundImage }}?w=1920 1920w
                 "
                 sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
                 alt="{{ $headline ?? 'Hero background' }}"
                 loading="lazy"
                 style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
        </picture>
        
        <!-- Loading placeholder with gradient for better visual feedback -->
        <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-gray-100 to-gray-300 animate-pulse z-0"
             style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 50%, #d1d5db 100%);">
        </div>
    @endif

    <!-- Overlay for readability -->
    <div class="absolute inset-0 bg-black/30"></div>

    <!-- Content Container -->
    <div class="relative z-10 flex items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-4xl mx-auto space-y-6 sm:space-y-8">
            <!-- Headline -->
            @if($headline)
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white"
                    style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['headline'] }};">
                    {{ $headline }}
                </h1>
            @endif

            <!-- Subheadline -->
            @if($subheadline)
                <p class="text-lg sm:text-xl md:text-2xl text-white/90 max-w-2xl mx-auto"
                   style="font-family: {{ $typography['font-family']['sans'] }}; font-weight: {{ $typography['font-weight']['body'] }}; line-height: {{ $typography['line-height']['relaxed'] }};">
                    {{ $subheadline }}
                </p>
            @endif

            <!-- CTA Buttons Container -->
            <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                @isset($slot)
                    {{ $slot }}
                @endisset
            </div>
        </div>
    </div>
</div>
