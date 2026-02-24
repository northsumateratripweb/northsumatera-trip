@extends('layouts.main')

@section('title', 'Sewa Mobil Medan - NorthSumateraTrip')
@section('meta_description', 'Sewa mobil Medan murah dengan supir profesional. Tersedia Toyota Innova Reborn, Avanza, Fortuner, hingga Hiace untuk grup besar di Sumatera Utara.')
@section('meta_keywords', 'sewa mobil medan, rental mobil sumatera utara, sewa innova reborn medan, rental hiace medan, sewa mobil lepas kunci medan, transportasi medan')

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Decorative Blobs -->
        <div class="absolute top-0 right-0 w-[60%] h-[60%] bg-blue-100/30 dark:bg-blue-900/10 blur-[120px] rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-[50%] h-[50%] bg-indigo-100/20 dark:bg-indigo-900/5 blur-[100px] rounded-full translate-y-1/2 -translate-x-1/2"></div>

        <!-- Header -->
        <div class="text-center mb-24 max-w-3xl mx-auto reveal">
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-blue-100 dark:border-blue-800">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                {{ __t('rental_badge') ?? 'Premium Fleet & Transport' }}
            </div>
            <h1 class="text-4xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-10 uppercase">
                {{ __t('rental_title_1') ?? 'Mobilitas' }} <span class="text-blue-700">{{ __t('rental_title_2') ?? 'Tanpa Batas' }}</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium text-lg md:text-xl leading-relaxed">
                {{ __t('rental_subtitle') ?? 'Sewa mobil lepas kunci atau dengan supir profesional untuk perjalanan yang lebih aman dan nyaman.' }}
            </p>
        </div>

        <!-- Fleet Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12">
            @foreach($cars as $car)
                <div class="group flex flex-col h-full bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 transition-all duration-700 hover:shadow-2xl hover:shadow-blue-500/10 p-4">
                    <div class="relative aspect-[4/3] overflow-hidden rounded-[36px] mb-8">
                        <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/10 to-transparent"></div>
                        
                        <!-- Brand/Badge -->
                        <div class="absolute top-6 left-6 px-5 py-2 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 dark:border-slate-800">
                            <span class="text-[9px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest">{{ $car->brand }}</span>
                        </div>

                        <!-- Capacity -->
                        <div class="absolute bottom-6 left-6 px-5 py-2 bg-slate-900/80 dark:bg-slate-800/90 backdrop-blur-md rounded-2xl shadow-xl border border-white/10 dark:border-slate-700 flex items-center gap-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span class="text-[9px] font-black text-white uppercase tracking-[0.2em]">{{ $car->capacity }} {{ __t('rental_label_capacity') ?? 'Pax' }}</span>
                        </div>

                        <!-- Wishlist Button -->
                        <form action="{{ route('wishlist.toggle-car', $car->id) }}" method="POST" class="absolute top-6 right-6 z-10">
                            @csrf
                            <button type="submit" class="w-12 h-12 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md text-slate-400 hover:text-rose-500 transition-all shadow-xl border border-white/20 dark:border-slate-800 transform active:scale-90 group/heart">
                                <svg class="w-5 h-5 transition-transform group-heart:scale-110 {{ $car->wishlists->isNotEmpty() ? 'fill-rose-500 text-rose-500' : 'fill-none' }}" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    
                    <div class="flex-1 flex flex-col px-6 pb-6">
                        <h3 class="text-2xl md:text-3xl font-black text-slate-900 dark:text-white mb-6 leading-tight tracking-tight uppercase group-hover:text-blue-700 transition-colors">
                            {{ $car->name }}
                        </h3>
                        
                        <div class="flex flex-wrap gap-3 mb-12">
                            @foreach([__t('rental_feature_ac') ?? 'Full AC', __t('rental_feature_driver') ?? 'Driver', __t('rental_feature_fuel') ?? 'BBM'] as $feature)
                                <span class="px-5 py-2 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-2xl text-[9px] font-black uppercase tracking-widest border border-slate-100 dark:border-slate-700 group-hover:bg-blue-50 dark:group-hover:bg-blue-900/20 group-hover:text-blue-700 dark:group-hover:text-blue-400 transition-all duration-500">{{ $feature }}</span>
                            @endforeach
                        </div>

                        <div class="mt-auto flex items-center justify-between pt-8 border-t border-slate-50 dark:border-slate-800/50">
                            <div>
                                <span class="block text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">{{ __t('rental_label_price') ?? 'Mulai Dari' }}</span>
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">{{ __t('rental_label_per_day') ?? '/hari' }}</span>
                                </div>
                            </div>
                            
                            <a href="{{ route('car.show', $car->id) }}" class="w-14 h-14 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-400 hover:bg-blue-700 hover:text-white hover:rotate-[360deg] transition-all duration-700 shadow-sm hover:shadow-xl hover:shadow-blue-500/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Info CTA Section -->
        <div class="mt-32 p-12 md:p-20 bg-slate-900 dark:bg-slate-950 rounded-[64px] relative overflow-hidden group">
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-16">
                <div class="text-center lg:text-left max-w-2xl">
                    <h2 class="text-4xl md:text-6xl font-black text-white mb-8 tracking-tight uppercase leading-none">
                        {{ __t('rental_info_title_1') ?? 'Butuh Kapasitas' }} <span class="text-blue-500">{{ __t('rental_info_title_2') ?? 'Lebih Besar?' }}</span>
                    </h2>
                    <p class="text-slate-400 font-medium text-lg leading-relaxed">
                        {{ __t('rental_info_subtitle') ?? 'Kami juga menyediakan Bus Pariwisata & Hiace Luxury untuk rombongan keluarga atau kantor. Hubungi kami untuk penawaran harga spesial.' }}
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-6 w-full lg:w-auto">
                    <a href="{{ route('contact') }}" class="px-12 py-6 bg-blue-700 text-white rounded-full font-black text-xs uppercase tracking-[0.2em] hover:bg-blue-800 hover:-translate-y-1 transition-all shadow-2xl shadow-blue-600/20 text-center">
                        {{ __t('rental_button_consultation') ?? 'Konsultasi' }}
                    </a>
                    @php
                        $waRentalMsg = "Halo Admin NorthSumateraTrip, saya ingin bertanya mengenai penyewaan mobil.";
                        $waRentalUrl = "https://wa.me/" . \App\Helpers\SettingsHelper::whatsappNumber() . "?text=" . urlencode($waRentalMsg);
                    @endphp
                    <a href="{{ $waRentalUrl }}" target="_blank" class="px-12 py-6 bg-white/5 dark:bg-white/10 backdrop-blur-xl text-white border border-white/10 rounded-full font-black text-xs uppercase tracking-[0.2em] hover:bg-white/10 transition-all text-center">
                        WhatsApp
                    </a>
                </div>
            </div>
            
            <!-- Bg Decorative -->
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
        </div>
    </div>
@endsection
