@php
    $currentLocale = session('locale', app()->getLocale());
    $locales = [
        'id' => ['name' => 'Bahasa Indonesia', 'flag' => '🇮🇩'],
        'en' => ['name' => 'English', 'flag' => '🇬🇧'],
        'ms' => ['name' => 'Bahasa Melayu', 'flag' => '🇲🇾'],
    ];
@endphp

<div class="relative inline-block" x-data="{ open: false }">
    <button @click="open = !open" 
            class="flex items-center gap-2 px-4 py-2 bg-[#161615] border border-[#3E3E3A] rounded-lg hover:border-[#FF4433] transition-colors">
        <span class="text-xl">{{ $locales[$currentLocale]['flag'] ?? '🌐' }}</span>
        <span class="text-sm font-medium hidden md:inline">{{ strtoupper($currentLocale) }}</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-48 bg-[#161615] border border-[#3E3E3A] rounded-lg shadow-xl z-50 overflow-hidden">
        @foreach($locales as $code => $locale)
            <a href="{{ route('lang.switch', $code) }}" 
               class="flex items-center gap-3 px-4 py-3 hover:bg-[#3E3E3A] transition-colors {{ $currentLocale === $code ? 'bg-[#FF4433]/20 border-l-2 border-[#FF4433]' : '' }}">
                <span class="text-xl">{{ $locale['flag'] }}</span>
                <span class="text-sm font-medium">{{ $locale['name'] }}</span>
                @if($currentLocale === $code)
                    <svg class="w-4 h-4 ml-auto text-[#FF4433]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </a>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
