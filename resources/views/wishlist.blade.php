@extends('layouts.main')

@section('title', 'Wishlist Saya - NorthSumateraTrip')

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-24 max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-blue-100 dark:border-blue-800">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                My Collections
            </div>
            <h1 class="text-4xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-10 uppercase">
                {{ __t('wishlist_title_1') ?? 'Wishlist' }} <span class="text-blue-700">{{ __t('wishlist_title_2') ?? 'Saya' }}</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium text-lg md:text-xl leading-relaxed">
                {{ __t('wishlist_subtitle') ?? 'Simpan paket wisata impian Anda dan pesan kapan saja.' }}
            </p>
        </div>

        @if($wishlists->isEmpty())
            <div class="py-40 text-center bg-white dark:bg-slate-900 rounded-[64px] border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div class="w-24 h-24 bg-blue-50 dark:bg-slate-800 rounded-3xl flex items-center justify-center mx-auto mb-10 text-blue-600 dark:text-blue-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-6 uppercase">{{ __t('wishlist_empty_title') ?? 'Wishlist Kosong' }}</h2>
                <p class="text-slate-500 dark:text-slate-400 font-medium mb-12 max-w-md mx-auto">{{ __t('wishlist_empty_subtitle') ?? 'Anda belum menyimpan paket wisata atau sewa mobil apapun.' }}</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('packages') }}" class="px-10 py-5 bg-blue-700 text-white rounded-full text-[10px] font-black uppercase tracking-widest shadow-xl shadow-blue-500/20 active:scale-95 transition-all">
                        {{ __t('nav_packages') ?? 'Lihat Paket Wisata' }}
                    </a>
                    <a href="{{ route('rental') }}" class="px-10 py-5 bg-white dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-100 dark:border-slate-700 rounded-full text-[10px] font-black uppercase tracking-widest hover:border-blue-700 transition-all">
                        {{ __t('nav_rental') ?? 'Sewa Mobil' }}
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
                @foreach($wishlists as $wishlist)
                    @if($wishlist->tour)
                        @php $tour = $wishlist->tour; @endphp
                        <div class="group flex flex-col h-full bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 transition-all duration-700 hover:shadow-2xl hover:shadow-blue-500/10 p-4">
                            <div class="relative aspect-[4/3] overflow-hidden rounded-[36px] mb-8">
                                <img src="{{ $tour->image_url }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/10 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-700"></div>
                                
                                <!-- Category -->
                                <div class="absolute top-6 left-6 px-5 py-2 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 dark:border-slate-800">
                                    <span class="text-[9px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest">{{ $tour->location }}</span>
                                </div>

                                <!-- Remove Button -->
                                <form action="{{ route('wishlist.toggle', $tour->id) }}" method="POST" class="absolute top-6 right-6 z-10">
                                    @csrf
                                    <button type="submit" class="w-12 h-12 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md text-rose-500 rounded-2xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-xl border border-white/20 dark:border-slate-800 transform active:scale-90 group/heart">
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            
                            <div class="flex-1 flex flex-col px-6 pb-6 text-center md:text-left">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">{{ __t('wishlist_label_tour') ?? 'Paket Wisata' }}</p>
                                <h3 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white leading-tight mb-8 uppercase line-clamp-1 group-hover:text-blue-700 transition-colors">
                                    {{ $tour->title }}
                                </h3>
                                
                                <div class="mt-auto flex items-center justify-between pt-8 border-t border-slate-50 dark:border-slate-800/50">
                                    <div>
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Mulai Dari</p>
                                        <p class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Rp {{ number_format($tour->price, 0, ',', '.') }}</p>
                                    </div>
                                    <a href="{{ route('tour.show', $tour->slug) }}" class="w-14 h-14 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-400 hover:bg-blue-700 hover:text-white hover:rotate-[360deg] transition-all duration-700 shadow-sm hover:shadow-xl hover:shadow-blue-500/30">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @elseif($wishlist->car)
                        @php $car = $wishlist->car; @endphp
                        <div class="group flex flex-col h-full bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 transition-all duration-700 hover:shadow-2xl hover:shadow-blue-500/10 p-4">
                            <div class="relative aspect-[4/3] overflow-hidden rounded-[36px] mb-8">
                                <img src="{{ $car->image_url }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/10 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-700"></div>
                                
                                <!-- Brand -->
                                <div class="absolute top-6 left-6 px-5 py-2 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 dark:border-slate-800">
                                    <span class="text-[9px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">{{ $car->brand }}</span>
                                </div>

                                <!-- Remove Button -->
                                <form action="{{ route('wishlist.toggle-car', $car->id) }}" method="POST" class="absolute top-6 right-6 z-10">
                                    @csrf
                                    <button type="submit" class="w-12 h-12 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md text-rose-500 rounded-2xl flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-xl border border-white/20 dark:border-slate-800 transform active:scale-90 group/heart">
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            
                            <div class="flex-1 flex flex-col px-6 pb-6 text-center md:text-left">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">{{ __t('wishlist_label_rental') ?? 'Sewa Mobil' }}</p>
                                <h3 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white leading-tight mb-8 uppercase line-clamp-1 group-hover:text-blue-700 transition-colors">
                                    {{ $car->name }}
                                </h3>
                                
                                <div class="mt-auto flex items-center justify-between pt-8 border-t border-slate-100 dark:border-slate-800/50">
                                    <div>
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1.5">{{ __t('wishlist_label_price') ?? 'Mulai Dari' }}</p>
                                        <p class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Rp {{ number_format($car->price_per_day, 0, ',', '.') }} <span class="text-[11px] text-slate-400">{{ __t('rental_label_per_day') ?? '/ Hari' }}</span></p>
                                    </div>
                                    <a href="{{ route('car.show', $car->id) }}" class="w-14 h-14 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-400 hover:bg-blue-700 hover:text-white hover:rotate-[360deg] transition-all duration-700 shadow-sm hover:shadow-xl hover:shadow-blue-500/30">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endsection
