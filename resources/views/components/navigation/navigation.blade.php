@props([
    'menuItems' => [],
    'logo' => null,
    'maxItems' => 5,
])

@php
    // Ensure max 5 menu items (Requirement 4.2)
    $menuItems = array_slice($menuItems, 0, $maxItems);
@endphp

<nav x-data="{ mobileMenu: false, isScrolled: false }" 
     x-init="window.addEventListener('scroll', function() { isScrolled = window.scrollY > 10 })"
     :class="{ 'bg-white dark:bg-slate-900 shadow-sm border-b border-slate-100 dark:border-slate-800 py-4': isScrolled || !$isHomePage, 'bg-transparent py-6 md:py-10': !isScrolled && $isHomePage }"
     class="fixed w-full top-0 left-0 z-[100] transition-all duration-500"
     role="navigation"
     aria-label="{{ __('Main Navigation') }}">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            
            {{-- Logo --}}
            <div class="flex-shrink-0">
                <a href="/" class="relative group" aria-label="{{ __('Home') }}">
                    <div class="flex items-center gap-2 sm:gap-3">
                        @if($logo)
                            <img src="{{ $logo['src'] }}" 
                                 alt="{{ $logo['alt'] }}" 
                                 class="h-10 md:h-12 w-auto object-contain transition-transform duration-500 group-hover:scale-110"
                                 width="{{ $logo['width'] ?? 'auto' }}"
                                 height="{{ $logo['height'] ?? 'auto' }}">
                        @else
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-700 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-500/20 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg width="24" height="24" class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 012 2v1.5a2.5 2.5 0 01-2.5 2.5h-1.5a2 2 0 01-2-2zm1 15.865V19a2 2 0 114 0v.865M19 16.314a7 7 0 01-8.686 0M3.055 11V10a7.438 7.438 0 011.083-3.865M19 16.314V17a2 2 0 11-4 0v-.686"></path>
                                </svg>
                            </div>
                            <span class="text-lg md:text-xl font-black text-slate-900 dark:text-white tracking-tighter uppercase">
                                North<span class="text-blue-700">Sumatera</span>Trip
                            </span>
                        @endif
                    </div>
                </a>
            </div>

            {{-- Desktop Menu (Requirement 4.5) --}}
            <div class="hidden md:flex items-center gap-6 lg:gap-8">
                @foreach($menuItems as $item)
                    <a href="{{ $item['url'] }}" 
                       class="text-sm font-black transition-all duration-300 {{ $item['isActive'] ? 'text-blue-600 dark:text-blue-400' : 'text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400' }}"
                       @if($item['isActive']) aria-current="page" @endif>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            {{-- Mobile Menu Toggle (Requirement 4.3) --}}
            <div class="md:hidden">
                <button class="tap-target p-2 text-slate-600 dark:text-slate-300 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        @click="mobileMenu = !mobileMenu"
                        :aria-expanded="mobileMenu.toString()"
                        aria-controls="mobile-menu"
                        aria-label="{{ __('Toggle Menu') }}">
                    <svg width="24" height="24" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenu" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                    <svg width="24" height="24" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenu" x-cloak aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu (Requirement 4.3, 4.4) --}}
    <div x-show="mobileMenu"
         id="mobile-menu"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="md:hidden fixed inset-x-0 top-16 sm:top-20 bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl border-b border-slate-200 dark:border-slate-700 shadow-2xl z-[90]"
         x-cloak
         role="menu">
        
        <div class="px-4 py-6 space-y-1">
            @foreach($menuItems as $item)
                <a href="{{ $item['url'] }}"
                   @click="mobileMenu = false"
                   class="flex items-center justify-between p-4 rounded-2xl text-base font-black transition-all duration-200 {{ $item['isActive'] ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400' : 'text-slate-900 dark:text-slate-100 hover:bg-slate-50 dark:hover:bg-slate-800 active:bg-slate-100' }}"
                   role="menuitem"
                   @if($item['isActive']) aria-current="page" @endif>
                    <span>{{ $item['label'] }}</span>
                    <svg width="16" height="16" class="w-4 h-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @endforeach
        </div>
    </div>
</nav>

{{-- Add smooth scroll behavior (Requirement 6.3) --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll to anchors
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href !== '#!') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
    });
</script>
@endpush
