@php
    $currentLocale = session('locale', app()->getLocale());
    $locales = [
        'id' => ['name' => 'Bahasa Indonesia', 'flag' => '🇮🇩', 'label' => 'ID'],
        'en' => ['name' => 'English', 'flag' => '🇺🇸', 'label' => 'EN'],
        'ms' => ['name' => 'Bahasa Melayu', 'flag' => '🇲🇾', 'label' => 'MS'],
    ];
@endphp

<div class="relative inline-block" x-data="{ open: false }">
    <button @click="open = !open" 
            class="group flex items-center gap-1.5 md:gap-2.5 px-2.5 md:px-3.5 py-2 md:py-2.5 bg-white/50 hover:bg-white border border-slate-200/60 rounded-2xl transition-all duration-500 shadow-sm hover:shadow-xl hover:shadow-blue-500/10 hover:-translate-y-0.5 active:scale-95 active:translate-y-0"
            aria-label="{{ (__t('select_language') == 'select_language' ? 'Pilih Bahasa' : __t('select_language')) }}"
            :aria-expanded="open">
        <div class="w-7 h-7 flex items-center justify-center rounded-xl bg-slate-100/80 group-hover:bg-blue-100 group-hover:rotate-12 transition-all duration-500">
            <span class="text-sm leading-none" aria-hidden="true">{{ $locales[$currentLocale]['flag'] ?? '🌐' }}</span>
        </div>
        <span class="text-xs font-black text-slate-700 uppercase tracking-[0.15em] ml-0.5">{{ $locales[$currentLocale]['label'] }}</span>
        <svg width="16" height="16" class="w-4 h-4 text-slate-400 group-hover:text-blue-700 transition-all duration-500" 
             :class="{ 'rotate-180': open }"
             fill="none" stroke="currentColor" viewBox="0 0 24 24"
             aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-8 scale-90"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-8 scale-90"
         class="absolute left-0 sm:left-auto sm:right-0 mt-5 w-[280px] sm:w-72 bg-white/95 backdrop-blur-xl border border-white rounded-[32px] shadow-[0_40px_80px_-15px_rgba(15,23,42,0.15)] z-[110] overflow-hidden p-3.5"
         style="display: none;">
        
        <div class="px-4 py-3 mb-2 flex items-center justify-between">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em]">{{ (__t('select_language') == 'select_language' ? 'Pilih Bahasa' : __t('select_language')) }}</p>
            <div class="h-px flex-1 bg-slate-100 ml-4"></div>
        </div>

        <div class="space-y-1.5">
            @foreach($locales as $code => $locale)
                <a href="{{ route('lang.switch', $code) }}" 
                   class="group/item flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-500 {{ $currentLocale === $code ? 'bg-blue-50/80 text-blue-700' : 'text-slate-600 hover:bg-slate-50 hover:text-blue-700 hover:translate-x-1' }}"
                   aria-label="{{ $locale['name'] }}">
                    <div class="w-12 h-12 flex items-center justify-center rounded-2xl {{ $currentLocale === $code ? 'bg-white shadow-lg shadow-blue-200/50 rotate-3' : 'bg-slate-100 group-hover/item:bg-white group-hover/item:rotate-6 transition-all duration-500' }}">
                        <span class="text-2xl leading-none" aria-hidden="true">{{ $locale['flag'] }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[13px] font-black leading-none mb-1.5 tracking-tight">{{ $locale['name'] }}</span>
                        <div class="flex items-center gap-2">
                            <span class="text-[9px] font-black opacity-40 tracking-[0.2em] uppercase">{{ $code }}</span>
                            @if($currentLocale === $code)
                                <span class="w-1 h-1 bg-blue-400 rounded-full"></span>
                                <span class="text-[9px] font-black text-blue-400 uppercase tracking-widest">{{ __t('lang_active') ?? 'Active' }}</span>
                            @endif
                        </div>
                    </div>
                    @if($currentLocale === $code)
                        <div class="ml-auto w-7 h-7 bg-blue-700 rounded-xl flex items-center justify-center shadow-xl shadow-blue-700/30 -rotate-6">
                            <svg width="16" height="16" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>

