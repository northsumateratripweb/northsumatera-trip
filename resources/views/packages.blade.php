@extends('layouts.main')

@section('title', 'Paket Wisata - NorthSumateraTrip')
@section('meta_description', 'Daftar paket wisata Sumatera Utara terlengkap. Mulai dari paket Danau Toba, Samosir, hingga paket adventure di Bukit Lawang.')
@section('meta_keywords', 'paket tour sumut, daftar wisata danau toba, paket liburan medan, harga tour samosir')

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Decorative Blobs -->
        <div class="absolute top-0 right-0 w-[60%] h-[60%] bg-blue-100/30 dark:bg-blue-900/10 blur-[120px] rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-[50%] h-[50%] bg-indigo-100/20 dark:bg-indigo-900/5 blur-[100px] rounded-full translate-y-1/2 -translate-x-1/2"></div>

        <!-- Header -->
        <div class="text-center mb-24 max-w-3xl mx-auto reveal">
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-blue-100 dark:border-blue-800">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                Explore North Sumatera
            </div>
            <h1 class="text-4xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-10 uppercase">
                {{ __t('packages_title_1') ?? 'Paket' }} <span class="text-blue-700">{{ __t('packages_title_2') ?? 'Wisata' }}</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium text-lg md:text-xl leading-relaxed">
                {{ __t('packages_subtitle') ?? 'Pilih paket liburan impian Anda dengan layanan terbaik dan harga terjangkau.' }}
            </p>
        </div>

        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto mb-24">
            <div class="bg-white dark:bg-slate-900 rounded-[40px] p-2 border border-slate-100 dark:border-slate-800 shadow-xl shadow-blue-500/5 group focus-within:border-blue-700 transition-all">
                <form action="{{ route('packages') }}" method="GET" class="flex items-center">
                    <div class="pl-8 text-slate-300 group-focus-within:text-blue-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __t('packages_search_placeholder') ?? 'Cari destinasi atau paket wisata...' }}" 
                           class="w-full pl-6 pr-6 py-6 bg-transparent text-slate-900 dark:text-white font-bold text-sm focus:outline-none placeholder:text-slate-300 placeholder:font-medium">
                    <button type="submit" class="px-10 py-5 bg-blue-700 text-white rounded-[32px] text-[10px] font-black uppercase tracking-widest transition-all hover:bg-blue-800 active:scale-95 shadow-lg shadow-blue-500/20">
                        {{ __t('packages_search_button') ?? 'Cari' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Tour Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
            @forelse($tours as $tour)
                <div class="group flex flex-col h-full bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 transition-all duration-700 hover:shadow-2xl hover:shadow-blue-500/10 p-4">
                    <div class="relative aspect-[4/3] overflow-hidden rounded-[36px] mb-8">
                        <img src="{{ $tour->image_url }}" alt="{{ $tour->title }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/10 to-transparent"></div>
                        
                        <div class="absolute top-6 left-6 px-5 py-2 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 dark:border-slate-800">
                            <span class="text-[9px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest">{{ $tour->location }}</span>
                        </div>

                        <!-- Wishlist Toggle -->
                        <form action="{{ route('wishlist.toggle', $tour->id) }}" method="POST" class="absolute top-6 right-6">
                            @csrf
                            <button type="submit" class="w-12 h-12 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md rounded-2xl flex items-center justify-center text-slate-400 hover:text-rose-500 transition-all shadow-xl border border-white/20 dark:border-slate-800 transform active:scale-90 group/heart">
                                <svg class="w-5 h-5 transition-transform group-hover/heart:scale-110 {{ $tour->wishlists->isNotEmpty() ? 'fill-rose-500 text-rose-500' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <div class="flex-1 flex flex-col px-6 pb-6">
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-4 leading-tight tracking-tight uppercase group-hover:text-blue-700 transition-colors">
                            {{ $tour->title }}
                        </h3>
                        
                        <div class="text-slate-500 dark:text-slate-400 text-sm font-medium leading-relaxed mb-10 line-clamp-2">
                            {!! strip_tags($tour->description) !!}
                        </div>

                        <div class="mt-auto flex items-center justify-between pt-8 border-t border-slate-50 dark:border-slate-800/50">
                            <div>
                                <span class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">{{ __t('packages_label_starting_from') ?? 'Mulai Dari' }}</span>
                                <span class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Rp {{ number_format($tour->price, 0, ',', '.') }}</span>
                            </div>
                            
                            <a href="{{ route('tour.show', $tour->slug) }}" class="w-14 h-14 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-400 hover:bg-blue-700 hover:text-white hover:rotate-[360deg] transition-all duration-700 shadow-sm hover:shadow-xl hover:shadow-blue-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-40 text-center bg-white dark:bg-slate-900 rounded-[64px] border border-slate-100 dark:border-slate-800">
                    <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-3xl flex items-center justify-center mx-auto mb-8 text-slate-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <p class="text-slate-400 font-black uppercase text-xs tracking-widest">{{ __t('packages_empty_state') ?? 'Tidak ada paket wisata ditemukan' }}</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($tours->hasPages())
        <div class="mt-24 flex justify-center">
            {{ $tours->links() }}
        </div>
        @endif
    </div>
@endsection
