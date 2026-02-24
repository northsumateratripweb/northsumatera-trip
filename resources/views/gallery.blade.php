@extends('layouts.main')

@section('title', 'Galeri Wisata - NorthSumateraTrip')
@section('meta_description', 'Koleksi foto perjalanan wisata di Sumatera Utara. Lihat keindahan Danau Toba, Bukit Lawang, dan budaya lokal melalui galeri kami.')

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-24 max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-blue-100 dark:border-blue-800">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                Visual Journey
            </div>
            <h1 class="text-4xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-10 uppercase">
                {{ __t('gallery_title_1') ?? 'Galeri' }} <span class="text-blue-700">{{ __t('gallery_title_2') ?? 'Wisata' }}</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium text-lg md:text-xl leading-relaxed">
                {{ __t('gallery_subtitle') ?? 'Jelajahi keindahan alam dan budaya Sumatera Utara melalui lensa kamera kami.' }}
            </p>
        </div>

        <!-- Filter Pills -->
        <div class="flex flex-wrap justify-center gap-3 mb-20">
            <a href="{{ route('gallery.index') }}" 
               class="px-8 py-4 rounded-full text-[10px] font-black uppercase tracking-widest transition-all duration-500 {{ !request('category') ? 'bg-blue-700 text-white shadow-xl shadow-blue-500/20' : 'bg-white dark:bg-slate-900 text-slate-400 hover:text-blue-700 border border-slate-100 dark:border-slate-800' }}">
                {{ __t('gallery_all_categories') ?? 'Semua' }}
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('gallery.index', ['category' => $cat]) }}" 
                   class="px-8 py-4 rounded-full text-[10px] font-black uppercase tracking-widest transition-all duration-500 {{ request('category') === $cat ? 'bg-blue-700 text-white shadow-xl shadow-blue-500/20' : 'bg-white dark:bg-slate-900 text-slate-400 hover:text-blue-700 border border-slate-100 dark:border-slate-800' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <!-- Gallery Grid -->
        <div x-data="{ 
            open: false, 
            currentIndex: 0,
            images: {{ $galleries->map(fn($g) => ['url' => $g->image_url, 'title' => $g->title, 'category' => $g->category])->toJson() }},
            
            showLightbox(index) {
                this.currentIndex = index;
                this.open = true;
                document.body.style.overflow = 'hidden';
            },
            closeLightbox() {
                this.open = false;
                document.body.style.overflow = '';
            },
            next() {
                this.currentIndex = (this.currentIndex + 1) % this.images.length;
            },
            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
            }
        }" @keydown.escape.window="closeLightbox()" @keydown.right.window="next()" @keydown.left.window="prev()">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
                @forelse($galleries as $index => $g)
                    <div class="group relative aspect-[4/5] overflow-hidden rounded-[48px] bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 cursor-pointer transition-all duration-700 hover:shadow-2xl hover:shadow-blue-500/10 p-3"
                         @click="showLightbox({{ $index }})">
                        <div class="w-full h-full overflow-hidden rounded-[40px] relative">
                            <img src="{{ $g->image_url }}" alt="{{ $g->title }}" 
                                 class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110" loading="lazy">
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-700 flex flex-col justify-end p-10 translate-y-4 group-hover:translate-y-0">
                                <span class="text-blue-400 text-[10px] font-black uppercase tracking-[0.3em] mb-4">{{ $g->category ?? 'Wisata' }}</span>
                                <h3 class="text-white text-3xl font-black leading-[1.1] tracking-tight uppercase">{{ $g->title }}</h3>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-40 text-center bg-white dark:bg-slate-900 rounded-[64px] border border-slate-100 dark:border-slate-800 shadow-sm">
                        <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-3xl flex items-center justify-center mx-auto mb-8 text-slate-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-slate-400 font-black uppercase text-xs tracking-widest">{{ __t('gallery_empty_state') ?? 'Tidak ada foto' }}</p>
                    </div>
                @endforelse
            </div>

            <!-- Lightbox -->
            <template x-teleport="body">
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 backdrop-blur-0"
                     x-transition:enter-end="opacity-100 backdrop-blur-2xl"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 backdrop-blur-2xl"
                     x-transition:leave-end="opacity-0 backdrop-blur-0"
                     class="fixed inset-0 z-[200] flex items-center justify-center bg-slate-950/95 p-6 md:p-12"
                     @click="closeLightbox()"
                     x-cloak>
                    
                    <!-- Close -->
                    <button class="absolute top-10 right-10 text-white/50 hover:text-white transition-colors z-50 focus:outline-none" @click="closeLightbox()">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <!-- Nav -->
                    <button class="absolute left-10 top-1/2 -translate-y-1/2 text-white/30 hover:text-blue-500 transition-all z-50 p-4 hidden md:block" @click.stop="prev()">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button class="absolute right-10 top-1/2 -translate-y-1/2 text-white/30 hover:text-blue-500 transition-all z-50 p-4 hidden md:block" @click.stop="next()">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    </button>

                    <!-- Image -->
                    <div class="relative max-w-7xl w-full h-full flex flex-col items-center justify-center gap-12" @click.stop>
                        <div class="relative w-full h-[75vh] flex items-center justify-center">
                            <img :src="images[currentIndex]?.url" 
                                 :key="currentIndex"
                                 class="max-h-full max-w-full rounded-[40px] shadow-2xl object-contain animate-in zoom-in-95 duration-500" />
                        </div>
                        
                        <div class="text-center group">
                            <h4 x-text="images[currentIndex]?.title" class="text-white text-3xl md:text-5xl font-black tracking-tight mb-4 uppercase"></h4>
                            <div class="inline-flex items-center gap-4">
                                <span class="w-8 h-px bg-white/20"></span>
                                <p class="text-white/40 text-xs font-black uppercase tracking-[0.4em]" x-text="`${currentIndex + 1} / ${images.length}`"></p>
                                <span class="w-8 h-px bg-white/20"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
@endsection
