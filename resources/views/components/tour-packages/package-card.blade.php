@props(['package'])

<div class="group bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
    {{-- Package Image --}}
    <div class="relative h-64 md:h-72 overflow-hidden">
        @php
            $imageUrl = $package->image_url ?? asset('images/default-tour.jpg');
        @endphp
        
        <picture>
            {{-- AVIF format for modern browsers --}}
            <source 
                srcset="
                    {{ str_replace(['.jpg', '.jpeg', '.png'], '.avif', $imageUrl) }}?w=400 400w,
                    {{ str_replace(['.jpg', '.jpeg', '.png'], '.avif', $imageUrl) }}?w=800 800w
                " 
                sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw" 
                type="image/avif"
            >
            
            {{-- WebP format for better compression --}}
            <source 
                srcset="
                    {{ str_replace(['.jpg', '.jpeg', '.png'], '.webp', $imageUrl) }}?w=400 400w,
                    {{ str_replace(['.jpg', '.jpeg', '.png'], '.webp', $imageUrl) }}?w=800 800w
                " 
                sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw" 
                type="image/webp"
            >
            
            {{-- Fallback to original format --}}
            <img 
                src="{{ $imageUrl }}" 
                srcset="
                    {{ $imageUrl }}?w=400 400w,
                    {{ $imageUrl }}?w=800 800w
                "
                sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
                alt="{{ $package->title }}"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                loading="lazy"
            >
        </picture>
        
        {{-- Duration Badge --}}
        @if($package->duration_days)
            <div class="absolute top-4 right-4 bg-white/90 dark:bg-slate-800/90 backdrop-blur-sm px-4 py-2 rounded-full">
                <span class="text-sm font-bold text-slate-900 dark:text-white">
                    {{ $package->duration_days }} {{ __('Days') }}
                </span>
            </div>
        @endif
    </div>

    {{-- Package Content --}}
    <div class="p-6 md:p-8">
        {{-- Location --}}
        @if($package->location)
            <p class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400 mb-2">
                {{ $package->location }}
            </p>
        @endif

        {{-- Title --}}
        <h3 class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white mb-3 line-clamp-2">
            {{ $package->title }}
        </h3>

        {{-- Description --}}
        @if($package->description)
            <p class="text-slate-600 dark:text-slate-400 font-light mb-6 line-clamp-3">
                {{ Str::limit($package->description, 120) }}
            </p>
        @endif

        {{-- Price and CTA --}}
        <div class="flex items-center justify-between pt-6 border-t border-slate-100 dark:border-slate-700">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-1">
                    {{ __('Starting From') }}
                </p>
                <p class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white">
                    Rp {{ number_format($package->price, 0, ',', '.') }}
                </p>
            </div>

            <a 
                href="{{ route('checkout', $package->id) }}" 
                class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full transition-all duration-300 transform hover:scale-105"
                aria-label="{{ __('Book') }} {{ $package->title }}"
            >
                {{ __('Book Now') }}
            </a>
        </div>
    </div>
</div>
