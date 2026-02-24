@extends('layouts.main')

@section('title', 'NorthSumateraTrip | Solusi Perjalanan Wisata Sumatera Utara Terbaik')
@section('meta_description', 'Jelajahi keindahan Sumatera Utara dengan paket wisata Danau Toba, Berastagi, dan Medan terbaik. Sewa mobil premium dan layanan tour profesional.')
@section('meta_keywords', 'wisata sumut, danau toba tour, paket wisata medan, sewa mobil medan murah, trip berastagi, liburan sumatera utara, transport medan')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "LocalBusiness",
  "name": "{{ App\Helpers\SettingsHelper::companyName() }}",
  "image": "{{ App\Helpers\SettingsHelper::heroImage() ?? asset('images/og-image.jpg') }}",
  "@@id": "{{ url('/') }}",
  "url": "{{ url('/') }}",
  "telephone": "+{{ App\Helpers\SettingsHelper::whatsappNumber() }}",
  "address": {
    "@@type": "PostalAddress",
    "streetAddress": "Medan, Sumatera Utara",
    "addressLocality": "Medan",
    "addressRegion": "Sumatera Utara",
    "postalCode": "20000",
    "addressCountry": "ID"
  },
  "geo": {
    "@@type": "GeoCoordinates",
    "latitude": 3.5952,
    "longitude": 98.6722
  },
  "openingHoursSpecification": {
    "@@type": "OpeningHoursSpecification",
    "dayOfWeek": [
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday",
      "Sunday"
    ],
    "opens": "00:00",
    "closes": "23:59"
  },
  "sameAs": [
    "https://facebook.com/northsumateratrip",
    "https://instagram.com/northsumateratrip",
    "https://twitter.com/northsumateratrip"
  ]
}
</script>
@endpush

@section('content')
    @push('styles')
    <style>
        @media (max-width: 640px) {
            .hero-title { font-size: 2.25rem !important; line-height: 1.2 !important; }
            #tourModal .p-8 { padding: 1.5rem !important; }
            #tripsContainer { grid-template-cols: repeat(2, minmax(0, 1fr)) !important; }
        }
    </style>
    @endpush
    <section class="relative min-h-[85vh] md:min-h-screen flex items-center justify-center pt-32 md:pt-40 overflow-hidden bg-slate-50 dark:bg-slate-950 transition-colors duration-700">
    @php
        $isMobile = request()->header('User-Agent') && (strpos(strtolower(request()->header('User-Agent')), 'mobile') !== false);
    @endphp
        <!-- Subtle Refined Background -->
        <div class="absolute inset-0 z-0 pointer-events-none opacity-40">
            <div class="absolute top-0 right-0 w-[60%] h-[60%] bg-blue-100/50 dark:bg-blue-900/10 blur-[120px] rounded-full"></div>
            <div class="absolute bottom-0 left-0 w-[50%] h-[50%] bg-blue-50/50 dark:bg-indigo-900/5 blur-[100px] rounded-full"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            <div class="text-left py-8 lg:py-0">
                <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 md:px-5 md:py-2 rounded-full bg-blue-50 border border-blue-100 mb-6 md:mb-8 animate-fade-up shadow-sm">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-600"></span>
                    </span>
                    <span class="text-[11px] font-black uppercase tracking-[0.2em] text-blue-700">{{ App\Helpers\SettingsHelper::heroBadge() }}</span>
                    <!-- Deployment Trigger: Realtime Sync Active -->
                </div>
                
                <h1 class="text-4xl sm:text-6xl lg:text-7xl xl:text-8xl font-black text-slate-900 dark:text-white leading-[1.05] tracking-tight mb-8">
                    {{ App\Helpers\SettingsHelper::heroTitle() }}
                </h1>
                
                <p class="max-w-xl text-base md:text-xl text-slate-600 dark:text-slate-400 mb-10 md:mb-12 leading-relaxed animate-fade-up font-medium" style="animation-delay: 0.2s">
                    {{ App\Helpers\SettingsHelper::heroSubtitle() }}
                </p>

                <div class="flex flex-wrap items-center gap-4">
                    <a href="#tours" class="px-8 py-4 bg-blue-600 text-white rounded-full font-black text-sm lg:text-base hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/20">
                        {{ __t('home_cta_booking') ?? 'Pesan Sekarang' }}
                    </a>
                    <a href="{{ route('rental') }}" class="px-8 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-full font-black text-sm lg:text-base hover:bg-slate-50 transition-all">
                        {{ __t('nav_rental') ?? 'Sewa Mobil' }}
                    </a>
                </div>
            </div>

            <div class="hidden lg:block relative animate-fade-up" style="animation-delay: 0.2s">
                <!-- Main Hero Image -->
                <div class="parallax-el relative z-10 rounded-[48px] overflow-hidden border-[12px] border-white dark:border-slate-800 shadow-2xl transition-all duration-1000 group hover:scale-[1.02]" data-speed="0.01">
                    <img src="{{ App\Helpers\SettingsHelper::heroImage() ?? 'https://images.unsplash.com/photo-1571732117565-d01449b803f2?q=80&w=1200' }}" alt="Pemandangan Indah Danau Toba Sumatera Utara" class="w-full aspect-[4/5] object-cover transition-transform duration-1000 group-hover:scale-110" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-blue-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                </div>
                
                <!-- Floating Badge 1 -->
                <div class="parallax-el absolute top-0 -left-10 z-20 glass p-6 rounded-[32px] shadow-2xl animate-fade-up" style="animation-duration: 6s" data-speed="0.04">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                            <svg width="24" height="24" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest">Trust</p>
                            <p class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-tight">Verified Partner</p>
                        </div>
                    </div>
                </div>

                <!-- Floating Badge 2 -->
                <div class="parallax-el absolute bottom-0 -right-10 z-20 glass p-6 rounded-[32px] shadow-2xl animate-fade-up" style="animation-duration: 8s; animation-delay: 1s" data-speed="0.03">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white dark:bg-slate-700 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm border border-slate-100 dark:border-white/10">
                            <svg width="24" height="24" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Support</p>
                            <p class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-tight">Expert Guides</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(isset($banners) && $banners->count())
        <section class="py-10 bg-slate-50 dark:bg-slate-950">
            <div class="max-w-7xl mx-auto px-6 grid gap-6 md:grid-cols-3">
                @foreach($banners as $banner)
                    <div class="relative overflow-hidden rounded-[32px] border border-slate-200/80 bg-slate-50 group">
                        @if($banner->image)
                            <div class="h-40 overflow-hidden">
                                <img src="{{ str_starts_with($banner->image, 'http') ? $banner->image : asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                            </div>
                        @endif
                        <div class="p-6 space-y-3">
                            <h3 class="text-lg font-black text-slate-900">{{ $banner->title }}</h3>
                            @if($banner->subtitle)
                                <p class="text-sm text-slate-500">{{ $banner->subtitle }}</p>
                            @endif
                            @if($banner->button_link && $banner->button_text)
                                <a href="{{ $banner->button_link }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-blue-600 text-white text-xs font-black uppercase tracking-[0.2em] hover:bg-blue-700 transition-colors" aria-label="{{ $banner->button_text }}">
                                    {{ $banner->button_text }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <section class="py-16 md:py-24 bg-white dark:bg-slate-900 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50/50 blur-3xl rounded-full -mr-32 -mt-32"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12">
                @forelse($stats as $stat)
                    <div class="text-center group">
                        <div class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-2">{{ $stat->value }}</div>
                        <div class="text-[10px] text-slate-400 uppercase tracking-widest font-black">{{ $stat->label }}</div>
                    </div>
                @empty
                    <div class="text-center group">
                        <div class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-2">50+</div>
                        <div class="text-[10px] text-slate-400 uppercase tracking-widest font-black">Destinasi Pilihan</div>
                    </div>
                    <div class="text-center group">
                        <div class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-2">1.2k+</div>
                        <div class="text-[10px] text-slate-400 uppercase tracking-widest font-black">Wisatawan Puas</div>
                    </div>
                    <div class="text-center group">
                        <div class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-2">4.9/5</div>
                        <div class="text-[10px] text-slate-400 uppercase tracking-widest font-black">Rating Layanan</div>
                    </div>
                    <div class="text-center group">
                        <div class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-2">24/7</div>
                        <div class="text-[10px] text-slate-400 uppercase tracking-widest font-black">Bantuan Cepat</div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    </section>

    <!-- Why Choose Us Section (Content SEO Boost) -->
    <section class="py-24 md:py-32 bg-white dark:bg-slate-900 reveal">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 md:gap-24 items-center">
                <div class="relative">
                    <div class="absolute -top-10 -left-10 w-32 h-32 bg-blue-50 dark:bg-blue-900/20 rounded-full blur-3xl"></div>
                    <div class="relative z-10 space-y-8">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-600">Keunggulan Kami</span>
                        </div>
                        <h2 class="text-4xl md:text-5xl font-black tracking-tight text-slate-900 dark:text-white leading-[1.1]">
                            Solusi Perjalanan Wisata <span class="text-blue-600">Terpercaya</span> di Sumatera Utara
                        </h2>
                        <p class="text-slate-500 dark:text-slate-400 text-lg leading-relaxed font-medium">
                            NorthSumateraTrip adalah agen perjalanan wisata profesional yang berdedikasi untuk memberikan pengalaman liburan terbaik bagi Anda. Kami memahami bahwa setiap perjalanan adalah momen berharga, itulah sebabnya kami menawarkan layanan yang dipersonalisasi dan berkualitas tinggi.
                        </p>
                        <div class="grid gap-6">
                            <div class="flex gap-5 p-6 rounded-3xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 hover:border-blue-200 transition-all">
                                <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center text-white shrink-0 shadow-lg shadow-blue-500/20">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-900 dark:text-white mb-1 uppercase text-xs tracking-widest">Layanan Berizin Resmi</h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Kami beroperasi di bawah PT Jelajah Wisata Sumatera dengan izin resmi, memberikan jaminan keamanan dan profesionalisme.</p>
                                </div>
                            </div>
                            <div class="flex gap-5 p-6 rounded-3xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 hover:border-blue-200 transition-all">
                                <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center text-white shrink-0 shadow-lg shadow-blue-500/20">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-900 dark:text-white mb-1 uppercase text-xs tracking-widest">Supir & Guide Profesional</h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Tim lapangan kami sudah sangat berpengalaman menjelajahi medan di Sumatera Utara dan ramah dalam melayani tamu.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hidden lg:block relative">
                    <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-blue-100 dark:bg-blue-900/30 rounded-full blur-[100px]"></div>
                    <div class="relative z-10 rounded-[56px] overflow-hidden border-[12px] border-slate-50 dark:border-slate-800 shadow-2xl rotate-2">
                        <img src="https://images.unsplash.com/photo-1596402184320-417d7178b2cd?q=80&w=800" alt="Layanan Wisata Profesional Sumatera Utara - NorthSumateraTrip" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="tours" class="py-20 md:py-32 bg-slate-50/50 dark:bg-slate-950/50 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 md:mb-16 gap-6 md:gap-8">
                <div class="max-w-2xl">
                    <h2 class="text-4xl md:text-5xl font-black mb-6 tracking-tight">{{ __t('home_popular_tours') ?? 'Paket Tour Terpopuler' }}</h2>
                    <p class="text-slate-500 text-lg">{{ __t('home_popular_tours_subtitle') ?? 'Pilih dari berbagai paket wisata yang telah kami kurasi khusus untuk kenyamanan dan pengalaman tak terlupakan Anda.' }}</p>
                </div>
                <a href="{{ route('packages') }}" class="text-blue-600 font-bold hover:underline flex items-center gap-2" aria-label="Lihat Semua Paket Wisata Danau Toba dan Medan">
                    {{ __t('home_link_all_packages') ?? 'Lihat Semua Paket' }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-[40px] p-8 md:p-12 mb-20 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 relative overflow-hidden group">
                <form method="get" class="relative z-10">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">
                        <div class="lg:col-span-4">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-1">Destinasi</label>
                            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Danau Toba, Berastagi..." class="w-full bg-slate-50 border border-slate-100 dark:bg-slate-800 dark:border-slate-700 rounded-2xl px-6 py-4.5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 dark:text-slate-200">
                        </div>
                        <div class="lg:col-span-3">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-1">Lokasi</label>
                            <input type="text" name="location" value="{{ $filters['location'] ?? '' }}" placeholder="Semua Lokasi" class="w-full bg-slate-50 border border-slate-100 dark:bg-slate-800 dark:border-slate-700 rounded-2xl px-6 py-4.5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 dark:text-slate-200">
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4 ml-1">Urutan</label>
                            <select name="sort" class="w-full bg-slate-50 border border-slate-100 dark:bg-slate-800 dark:border-slate-700 rounded-2xl px-6 py-4.5 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all font-bold text-slate-700 dark:text-slate-200 appearance-none">
                                <option value="popular" @selected(($filters['sort'] ?? '')==='popular')>Terpopuler</option>
                                <option value="cheapest" @selected(($filters['sort'] ?? '')==='cheapest')>Termurah</option>
                                <option value="latest" @selected(($filters['sort'] ?? '')==='latest')>Terbaru</option>
                            </select>
                        </div>
                        <div class="lg:col-span-3 text-right">
                            <button type="submit" class="w-full bg-blue-600 text-white rounded-2xl py-4.5 font-black text-sm uppercase tracking-widest hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all">
                                Cari Paket
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse($tours as $tour)
                    <div class="group bg-white dark:bg-slate-900 rounded-[48px] overflow-hidden border border-slate-100 dark:border-slate-800 hover:shadow-2xl hover:shadow-slate-200/50 dark:hover:shadow-none transition-all duration-500 flex flex-col h-full">
                        <div class="relative overflow-hidden aspect-[4/3] m-4 rounded-[40px]">
                            <img src="{{ $tour->image_url }}" loading="lazy" alt="Paket Wisata {{ $tour->title }} - NorthSumateraTrip" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                            
                            <div class="absolute top-5 left-5">
                                <div class="bg-white/95 backdrop-blur-md px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest text-blue-600 shadow-sm flex items-center gap-2">
                                    {{ $tour->duration_days }} Hari
                                </div>
                            </div>

                            @if($tour->is_popular)
                                <div class="absolute top-5 right-5">
                                    <div class="bg-amber-400 px-4 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white shadow-sm">
                                        Populer
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="p-8 pt-2 flex flex-col flex-grow">
                            <h3 class="text-2xl font-black mb-4 group-hover:text-blue-600 transition-colors line-clamp-2 leading-tight tracking-tight text-slate-900 dark:text-white">
                                {{ $tour->title }}
                            </h3>
                            
                            <div class="mt-auto pt-8 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-1">{{ __t('packages_label_starting_from') ?? 'Mulai Dari' }}</p>
                                    <p class="text-2xl font-black text-slate-900 dark:text-white">Rp {{ number_format($tour->price, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('tour.show', $tour->slug) }}" class="w-14 h-14 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-24 text-center bg-white rounded-[40px] border-2 border-dashed border-slate-200">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <p class="text-slate-400 font-bold">Belum ada paket wisata yang sesuai kriteria.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    <section id="rental" class="py-32 bg-white dark:bg-slate-900 relative overflow-hidden reveal">
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-50/50 blur-[120px] rounded-full -ml-48 -mb-48"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 mb-6 transition-colors">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-600">Premium Fleet</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black mb-6 tracking-tight">Sewa Mobil <span class="text-blue-500">Premium</span></h2>
                <p class="text-slate-500 text-lg">Jelajahi Sumatera Utara dengan armada terbaru dan supir berpengalaman yang siap mengantar Anda dengan aman dan nyaman.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($cars as $car)
                <div class="group bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 hover:shadow-2xl transition-all duration-500 flex flex-col h-full overflow-hidden">
                    <div class="relative overflow-hidden aspect-[16/10] m-4 rounded-[40px]">
                        <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110">
                        <div class="absolute bottom-5 right-5">
                            <span class="bg-blue-600 text-white px-5 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl">
                                Rp {{ number_format($car->price_per_day, 0, ',', '.') }} <span class="opacity-70">/ Hari</span>
                            </span>
                        </div>
                    </div>
                    
                    <div class="px-10 pb-10 pt-4 flex-grow flex flex-col">
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-6 group-hover:text-blue-600 transition-colors leading-tight">{{ $car->name }}</h3>
                        
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="flex flex-col gap-1">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Kapasitas</span>
                                <span class="text-sm font-black text-slate-700 dark:text-slate-300">{{ $car->capacity }} Penumpang</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Transmisi</span>
                                <span class="text-sm font-black text-slate-700 dark:text-slate-300">Manual / AT</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('car.show', $car->id) }}" class="w-full py-5 border-2 border-slate-900 dark:border-slate-700 text-slate-900 dark:text-white rounded-full font-black text-xs uppercase tracking-widest flex items-center justify-center gap-3 hover:bg-slate-900 hover:text-white dark:hover:bg-slate-700 transition-all mt-auto">
                            Detail Mobil
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-32 bg-slate-50/50 dark:bg-slate-950/50 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 mb-6 transition-colors">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-600">Travel Blog</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black mb-6 tracking-tight text-slate-900">Inspirasi <span class="text-gradient">Perjalanan</span></h2>
                <p class="text-slate-500 text-lg">Temukan tips, panduan, dan cerita menarik dari destinasi terbaik di Sumatera Utara.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($posts as $post)
                    <div class="group bg-white dark:bg-slate-900 rounded-[48px] overflow-hidden border border-slate-100 dark:border-slate-800 hover:shadow-2xl transition-all duration-700 flex flex-col h-full">
                        <div class="relative overflow-hidden aspect-[16/10] m-4 rounded-[40px]">
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110" loading="lazy">
                        </div>
                        <div class="px-10 pb-10 pt-4 flex flex-col flex-grow">
                            <div class="flex items-center gap-3 text-slate-400 text-[10px] font-black uppercase tracking-widest mb-4">
                                <span>{{ $post->created_at->format('d M Y') }}</span>
                            </div>
                            <h3 class="text-2xl font-black mb-8 group-hover:text-blue-600 transition-colors leading-tight text-slate-900 dark:text-white line-clamp-2">{{ $post->title }}</h3>
                            <a href="{{ route('post.show', $post->slug) }}" class="mt-auto flex items-center gap-3 text-blue-600 font-black text-[11px] uppercase tracking-widest hover:translate-x-2 transition-transform" aria-label="Baca Selengkapnya: {{ $post->title }}">
                                Baca Detail
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-32 bg-white dark:bg-slate-900 relative overflow-hidden reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 mb-6 transition-colors">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-600">Common Questions</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black mb-6 tracking-tight text-slate-900">Pertanyaan yang <span class="text-gradient">Sering Diajukan</span></h2>
                <p class="text-slate-500 text-lg leading-relaxed">Semua yang perlu Anda ketahui tentang layanan dan proses booking kami.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                @forelse($faqs as $faq)
                    <div class="p-10 bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 transition-all duration-500">
                        <h4 class="text-xl font-black text-slate-900 dark:text-white mb-6 flex items-start gap-4">
                            <span class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 text-xs font-black">Q</span>
                            {{ $faq->question }}
                        </h4>
                        <p class="text-slate-500 dark:text-slate-400 text-base leading-relaxed ml-14">{{ $faq->answer }}</p>
                    </div>
                @empty
                    @php
                        $defaultFaqs = [
                            ['q' => 'Bagaimana cara memesan paket tour atau rental mobil?', 'a' => 'Anda dapat memesan langsung melalui website ini dengan memilih paket yang diinginkan, mengisi formulir pemesanan, dan melakukan konfirmasi pembayaran via WhatsApp.'],
                            ['q' => 'Apakah harga paket sudah termasuk tiket pesawat?', 'a' => 'Harga yang tertera umumnya hanya mencakup layanan darat (land arrangement) di Sumatera Utara. Tiket pesawat dari kota asal tidak termasuk dalam paket standar kami.'],
                            ['q' => 'Apa saja metode pembayaran yang tersedia?', 'a' => 'Kami mendukung pembayaran melalui Transfer Bank (Mandiri/BCA) dan scan QRIS. Konfirmasi pembayaran dilakukan dengan mengirimkan bukti transfer via WhatsApp.'],
                            ['q' => 'Apakah ada layanan penjemputan di Bandara Kualanamu?', 'a' => 'Ya, semua paket tour dan rental mobil kami sudah termasuk layanan penjemputan dan pengantaran kembali ke Bandara Internasional Kualanamu (KNO).'],
                        ];
                    @endphp
                    @foreach($defaultFaqs as $faq)
                        <div class="p-10 bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 transition-all duration-500">
                            <h4 class="text-xl font-black text-slate-900 dark:text-white mb-6 flex items-start gap-4">
                                <span class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0 text-xs font-black">Q</span>
                                {{ $faq['q'] }}
                            </h4>
                            <p class="text-slate-500 dark:text-slate-400 text-base leading-relaxed ml-14">{{ $faq['a'] }}</p>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-32 bg-slate-50/50 dark:bg-slate-950/50 reveal">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 mb-6 transition-colors">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-600">Testimonials</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-black mb-6 tracking-tight text-slate-900">Apa Kata <span class="text-gradient">Mereka?</span></h2>
                <p class="text-slate-500 text-lg">Kepercayaan Anda adalah prioritas kami. Berikut adalah pengalaman mereka bersama NorthSumateraTrip.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @forelse($reviews as $review)
                    <div class="p-10 bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 transition-all duration-500">
                        <div class="flex gap-1 text-amber-400 mb-8">
                            @for($i=0; $i<$review->rating; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 font-medium leading-relaxed mb-10 italic">"{{ $review->comment }}"</p>
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400 font-black text-lg">
                                {{ substr($review->customer_name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-base font-black text-slate-900 dark:text-white">{{ $review->customer_name }}</h4>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">{{ $review->tour->location ?? 'Sumatera Utara' }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-10 bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 transition-all duration-500">
                        <div class="flex gap-1 text-amber-400 mb-8">
                            @for($i=0; $i<5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 font-medium leading-relaxed mb-10 italic">"Layanan yang sangat memuaskan, driver tepat waktu dan sangat ramah."</p>
                        <div class="flex items-center gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400 font-black text-lg">A</div>
                            <div>
                                <h4 class="text-base font-black text-slate-900 dark:text-white">Agus Santoso</h4>
                                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Medan, Indonesia</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    @if(isset($galleries) && $galleries->count() > 0)
    <section class="py-32 bg-white dark:bg-slate-900 reveal">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 mb-6 transition-colors">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-600">Visual Journey</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black tracking-tight text-slate-900">{{ __t('home_gallery_title') ?? 'Galeri Wisata' }}</h2>
                    <p class="text-slate-500 text-lg mt-4 font-medium">{{ __t('home_gallery_subtitle') ?? 'Kilasan keindahan alam dan momen berharga tamu selama menjelajahi Sumatera Utara.' }}</p>
                </div>
                <a href="{{ route('gallery.index') }}" class="text-blue-600 font-black text-xs uppercase tracking-widest hover:underline flex items-center gap-2 group" aria-label="Lihat Galeri Lengkap">
                    Lihat Galeri Lengkap
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 md:gap-8">
                @foreach($galleries as $gallery)
                <div class="group relative rounded-[48px] overflow-hidden aspect-square md:aspect-auto md:h-[400px] border border-slate-100 dark:border-slate-800 shadow-sm first:md:col-span-2">
                    <img src="{{ str_starts_with($gallery->image_url, 'http') ? $gallery->image_url : asset('storage/' . $gallery->image_url) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-10">
                        <span class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-3">{{ $gallery->category }}</span>
                        <h4 class="text-2xl font-black text-white leading-tight translate-y-4 group-hover:translate-y-0 transition-transform duration-500">{{ $gallery->title }}</h4>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    <!-- Instagram Feed Section -->
    @if(isset($socialFeeds) && $socialFeeds->count() > 0)
    <section class="py-32 bg-slate-50 dark:bg-slate-950 relative overflow-hidden reveal">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rose-50 dark:bg-rose-900/20 border border-rose-100 dark:border-rose-800/30 mb-6">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-rose-600">Social Proof</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black tracking-tight text-slate-900">Momen Seru <span class="text-rose-500">@NorthSumateraTrip</span></h2>
                    <p class="text-slate-500 text-lg mt-4 leading-relaxed font-medium">Ikuti perjalanan tamu kami menjelajahi keindahan alam Sumatera Utara melalui Instagram.</p>
                </div>
                <a href="https://instagram.com/northsumateratrip" target="_blank" class="inline-flex items-center gap-3 px-8 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-xs font-black uppercase tracking-widest text-slate-600 dark:text-slate-300 hover:bg-rose-50 dark:hover:bg-rose-900/30 hover:border-rose-200 dark:hover:border-rose-800 hover:text-rose-600 transition-all duration-300 shadow-sm">
                    Follow Instagram
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                @foreach($socialFeeds as $feed)
                <a href="{{ $feed->instagram_url ?? '#' }}" target="_blank" class="group relative aspect-square rounded-[48px] overflow-hidden bg-slate-200 border border-slate-200/60 shadow-sm transition-all duration-700">
                    <img src="{{ asset('storage/' . $feed->image) }}" alt="Momen Wisata Sumatera Utara Bersama NorthSumateraTrip - Instagram Feed" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110" loading="lazy">
                    <div class="absolute inset-0 bg-rose-600/60 opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center p-8">
                        <div class="text-center transform translate-y-8 group-hover:translate-y-0 transition-transform duration-500">
                            <svg class="w-12 h-12 text-white mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p class="text-white font-black text-[10px] uppercase tracking-widest">Instagram</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Footer Section -->
    <section class="py-32 relative overflow-hidden reveal">
        <div class="max-w-7xl mx-auto px-6">
            <div class="relative bg-slate-900 dark:bg-slate-950 rounded-[64px] p-16 md:p-24 overflow-hidden border border-slate-800 shadow-2xl">
                <!-- Ambient glow effects -->
                <div class="absolute top-0 left-1/4 w-[500px] h-[400px] rounded-full pointer-events-none" style="background:radial-gradient(ellipse at center, rgba(59,130,246,0.15) 0%, transparent 70%); filter:blur(100px);"></div>
                <div class="absolute bottom-0 right-1/4 w-[400px] h-[300px] rounded-full pointer-events-none" style="background:radial-gradient(ellipse at center, rgba(99,102,241,0.1) 0%, transparent 70%); filter:blur(100px);"></div>

                <div class="relative z-10 grid lg:grid-cols-5 gap-16 items-center">
                    <div class="lg:col-span-3 text-center lg:text-left">
                        <h2 class="text-4xl md:text-6xl font-black text-white mb-8 leading-[1.1] tracking-tight">
                            {{ App\Helpers\SettingsHelper::ctaTitle() }}
                        </h2>
                        <p class="text-slate-400 text-lg md:text-xl leading-relaxed mb-12 max-w-2xl">
                            {{ App\Helpers\SettingsHelper::ctaSubtitle() }}
                        </p>
                        
                        <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                            <a href="https://wa.me/{{ App\Helpers\SettingsHelper::whatsappNumber() }}" target="_blank" class="group px-10 py-5 bg-white text-slate-900 rounded-full font-black text-sm uppercase tracking-widest hover:bg-blue-50 transition-all shadow-xl shadow-white/10 flex items-center gap-3">
                                {{ App\Helpers\SettingsHelper::ctaButtonText() }}
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <a href="#tours" class="px-10 py-5 border-2 border-white/20 text-white rounded-full font-black text-sm uppercase tracking-widest hover:bg-white/5 hover:border-white/40 transition-all">
                                Lihat Paket Wisata
                            </a>
                        </div>
                    </div>
                    <div class="hidden lg:flex lg:col-span-2 justify-end">
                        <div class="relative w-full max-w-[320px] aspect-square bg-slate-800 rounded-[48px] overflow-hidden border border-slate-700/50 shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-700">
                             <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover opacity-50" alt="Agen Wisata Premium Sumatera Utara - NorthSumateraTrip Adventure" loading="lazy">
                             <div class="absolute inset-0 flex items-center justify-center p-10">
                                <div class="text-center">
                                    <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-[24px] flex items-center justify-center mx-auto mb-5 border border-white/20">
                                        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    </div>
                                    <p class="text-white font-black text-lg tracking-tight mb-3">Premium Travel Agency</p>
                                    <div class="flex justify-center gap-1">
                                        @for($i=0; $i<5; $i++)
                                        <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Tour Modal -->
    <div id="tourModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[150] flex items-center justify-center p-4">
        <div class="bg-white rounded-[40px] border border-slate-200 max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col shadow-2xl animate-fade-up">
            <!-- Header -->
            <div class="bg-white border-b border-slate-100 p-6 md:p-8 flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-600 mb-1">Booking Package</p>
                    <h2 id="modalTitle" class="text-2xl font-black text-slate-900 tracking-tight"></h2>
                </div>
                <button onclick="closeTourModal()" class="w-12 h-12 bg-slate-50 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-2xl flex items-center justify-center transition-all duration-300" aria-label="Tutup Detail Paket">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-8 space-y-8 overflow-y-auto custom-scrollbar">
                <!-- Trips Selection -->
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4 ml-1">Pilih Kategori Trip</label>
                    <div id="tripsContainer" class="grid grid-cols-4 gap-3">
                        <!-- Dynamically populated -->
                    </div>
                </div>

                <!-- Customer Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Nama Lengkap</label>
                        <input type="text" id="customerName" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-slate-900 font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition placeholder:font-medium placeholder:text-slate-300" placeholder="John Doe" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Nomor Telepon</label>
                        <input type="tel" id="customerPhone" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-slate-900 font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition placeholder:font-medium placeholder:text-slate-300" placeholder="0812..." required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Nomor WhatsApp</label>
                        <input type="tel" id="customerWhatsapp" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-slate-900 font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition placeholder:font-medium placeholder:text-slate-300" placeholder="0812..." required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Tanggal Perjalanan</label>
                        <input type="date" id="travelDate" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-slate-900 font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition text-slate-600" required>
                    </div>
                </div>

                <!-- Honeypot -->
                <div class="hidden" aria-hidden="true">
                    <input type="text" id="hp_field" value="" tabindex="-1" autocomplete="off">
                </div>

                <!-- Hotel & Extra Details -->
                <div class="space-y-6">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Informasi Perjalanan & Hotel</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <input type="text" id="hotel_1" placeholder="Hotel 1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold focus:border-blue-500 outline-none transition">
                        <input type="text" id="hotel_2" placeholder="Hotel 2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold focus:border-blue-500 outline-none transition">
                        <input type="text" id="hotel_3" placeholder="Hotel 3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold focus:border-blue-500 outline-none transition">
                        <input type="text" id="hotel_4" placeholder="Hotel 4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold focus:border-blue-500 outline-none transition">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" id="flight_balik" placeholder="Info Penerbangan (Contoh: GA-123 18:00)" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold focus:border-blue-500 outline-none transition">
                        <textarea id="notes" placeholder="Catatan Tambahan..." rows="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold focus:border-blue-500 outline-none transition"></textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- People Count -->
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4 ml-1">Jumlah Orang</label>
                        <div class="relative">
                            <select id="peopleCount" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-900 font-bold focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition appearance-none cursor-pointer">
                                @for($i=1; $i<=10; $i++)
                                    <option value="{{ $i }}">{{ $i }} Orang</option>
                                @endfor
                                <option value="more">Lainnya (Grup)</option>
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Price Display -->
                    <div class="bg-blue-50/50 border border-blue-100 rounded-[32px] p-6 flex flex-col justify-center">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-blue-600 mb-1">Estimasi Total</p>
                        <div id="totalPrice" class="text-3xl font-black text-slate-900">Rp 0</div>
                    </div>
                </div>

                <!-- Terms & Conditions Checkbox -->
                <div class="bg-slate-50 border border-slate-100 p-6 rounded-3xl flex items-start gap-4">
                    <input type="checkbox" id="termsCheck" class="w-6 h-6 mt-1 rounded-lg border-slate-200 text-blue-600 focus:ring-blue-500/20 transition-all cursor-pointer">
                    <label for="termsCheck" class="text-[11px] font-bold text-slate-500 leading-relaxed cursor-pointer">
                        Saya menyetujui <a href="{{ route('legal.terms') }}" target="_blank" class="text-blue-600 hover:underline">Syarat & Ketentuan</a> serta memberikan izin untuk memproses data pribadi saya sesuai kebijakan <a href="{{ route('legal.privacy') }}" target="_blank" class="text-blue-600 hover:underline">Privasi</a> NorthSumateraTrip.
                    </label>
                </div>

                <!-- Tabs -->
                <div x-data="{ tab: 'description' }" class="space-y-6">
                    <div class="flex gap-2 p-1.5 bg-slate-100 rounded-2xl w-fit">
                        <button @click="tab = 'description'" :class="tab === 'description' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300">Deskripsi</button>
                        <button @click="tab = 'itinerary'" :class="tab === 'itinerary' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300">Itinerari</button>
                    </div>

                    <div x-show="tab === 'description'" x-transition class="text-slate-500 text-sm leading-relaxed prose prose-blue max-w-none">
                        <div id="modalDescription"></div>
                    </div>
                    
                    <div x-show="tab === 'itinerary'" x-transition class="text-slate-500 text-sm leading-relaxed prose prose-blue max-w-none">
                        <div id="modalItinerary"></div>
                    </div>
                </div>
            </div>

            <div class="p-8 bg-slate-50 border-t border-slate-100 flex flex-col gap-4">
                <button id="bookNowBtn" class="w-full btn-primary text-white font-black py-5 rounded-[24px] flex items-center justify-center gap-3 text-[11px] uppercase tracking-[0.2em] disabled:opacity-50 disabled:cursor-not-allowed group relative overflow-hidden" onclick="handleBookingClick()">
                    <span id="btnText" class="flex items-center gap-3">
                        📍 BUAT PESANAN
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                    <div id="btnLoading" class="hidden absolute inset-0 bg-blue-700 flex items-center justify-center">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </button>
                <button id="whatsappBtn" onclick="handleWhatsappClick()" class="w-full py-5 bg-[#25D366] text-white rounded-[24px] font-black text-[11px] uppercase tracking-[0.2em] transition-all flex items-center justify-center gap-3 hover:bg-[#20ba5a] shadow-lg shadow-emerald-500/20" aria-label="Pesan via WhatsApp">
                    <span id="waBtnText" class="flex items-center gap-3">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" aria-hidden="true"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.305 1.652zm6.599-3.835c1.544.918 3.513 1.404 5.289 1.405 5.451 0 9.886-4.434 9.889-9.885.002-2.641-1.026-5.124-2.895-6.995-1.868-1.871-4.354-2.9-6.997-2.9-5.453 0-9.888 4.435-9.891 9.886-.001 2.04.536 4.032 1.554 5.768l-1.023 3.732 3.824-.999zm11.366-5.438c-.312-.156-1.848-.912-2.134-1.017-.286-.104-.494-.156-.701.156-.207.312-.804 1.017-.986 1.225-.182.208-.364.234-.676.078-.312-.156-1.318-.486-2.51-1.548-.928-.827-1.554-1.849-1.736-2.161-.182-.312-.02-.481.136-.636.141-.14.312-.364.468-.546.156-.182.208-.312.312-.52.104-.208.052-.39-.026-.546-.078-.156-.701-1.691-.961-2.313-.253-.607-.511-.524-.701-.534-.181-.01-.389-.012-.597-.012-.208 0-.546.078-.831.39-.286.312-1.091 1.067-1.091 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"></path></svg>
                        Pesan dari WhatsApp
                    </span>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        var currentTour = null;
        var currentTrips = null;

        function openTourModal(slug, title, days, location, url, trips) {
            currentTour = { slug: slug, title: title, days: days, location: location, url: url };
            currentTrips = trips || {};

            document.getElementById('tourModal').classList.remove('hidden');
            document.getElementById('modalTitle').textContent = title + ' (' + days + ' Hari)';

            // Populate trips
            var container = document.getElementById('tripsContainer');
            container.innerHTML = '';
            
            if (trips && Object.keys(trips).length > 0) {
                Object.keys(trips).forEach(function(key) {
                    var tripData = trips[key];
                    var btn = document.createElement('button');
                    btn.className = 'bg-slate-50 hover:bg-blue-50 text-slate-400 hover:text-blue-600 border border-slate-100 hover:border-blue-200 font-black py-4 rounded-2xl transition-all duration-300 trip-btn text-xs tracking-widest';
                    btn.textContent = key.toUpperCase();
                    btn.dataset.tripId = key;
                    btn.dataset.tripPrice = tripData.price || 0;
                    btn.onclick = function(e) { selectTrip(e); };
                    container.appendChild(btn);
                });
            } else {
                container.innerHTML = '<p class="col-span-4 text-slate-400 text-center py-8 font-bold">Tidak ada pilihan trip</p>';
            }

            // Load description and itinerary
            fetch(url)
                .then(function(response) { return response.text(); })
                .then(function(html) {
                    var parser = new DOMParser();
                    var doc = parser.parseFromString(html, 'text/html');
                    var descEl = doc.getElementById('tourDescription');
                    var itinEl = doc.getElementById('tourItinerary');
                    var desc = descEl ? descEl.innerHTML : '';
                    var itin = itinEl ? itinEl.innerHTML : '';
                    document.getElementById('modalDescription').innerHTML = desc;
                    document.getElementById('modalItinerary').innerHTML = itin;
                });
        }

        function closeTourModal() {
            document.getElementById('tourModal').classList.add('hidden');
            currentTour = null;
        }

        function selectTrip(event) {
            document.querySelectorAll('.trip-btn').forEach(function(btn) {
                btn.classList.remove('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-lg', 'shadow-blue-500/20');
                btn.classList.add('bg-slate-50', 'text-slate-400', 'border-slate-100');
            });
            event.target.classList.remove('bg-slate-50', 'text-slate-400', 'border-slate-100');
            event.target.classList.add('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-lg', 'shadow-blue-500/20');
            updatePrice();
        }

        function updatePrice() {
            var selectedTrip = document.querySelector('.trip-btn.bg-blue-600');
            var people = parseInt(document.getElementById('peopleCount').value) || 1;
            
            if (selectedTrip) {
                var price = parseInt(selectedTrip.dataset.tripPrice) || 0;
                var total = price * people;
                document.getElementById('totalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
            }
        }

        var peopleCountInput = document.getElementById('peopleCount');
        if (peopleCountInput) {
            peopleCountInput.addEventListener('change', updatePrice);
        }

        function handleBookingClick() {
            var btn = document.getElementById('bookNowBtn');
            var btnText = document.getElementById('btnText');
            var btnLoading = document.getElementById('btnLoading');
            
            var selectedTrip = document.querySelector('.trip-btn.bg-blue-600');
            if (!selectedTrip) {
                alert('Silakan pilih trip terlebih dahulu');
                return;
            }

            var people = document.getElementById('peopleCount').value;
            var tripId = selectedTrip.dataset.tripId;
            var price = parseInt(selectedTrip.dataset.tripPrice);
            var total = price * people;

            // Get Form Data
            var name = document.getElementById('customerName').value;
            var phone = document.getElementById('customerPhone').value;
            var whatsapp = document.getElementById('customerWhatsapp').value;
            var date = document.getElementById('travelDate').value;

            // Simple Validation
            if (!name || !phone || !whatsapp || !date) {
                alert('Mohon lengkapi semua data diri (termasuk No. WhatsApp) dan tanggal perjalanan.');
                return;
            }

            if (!document.getElementById('termsCheck').checked) {
                alert('Silakan setujui Syarat & Ketentuan untuk melanjutkan.');
                return;
            }

            // Change button state
            btn.disabled = true;
            btnText.classList.add('invisible');
            btnLoading.classList.remove('hidden');

            // Perform checkout via AJAX
            fetch('{{ route("checkout", ":id") }}'.replace(':id', currentTour.slug), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') || {}).content || (document.querySelector('input[name="_token"]') || {}).value || ''
                },
                body: JSON.stringify({
                    trip_id: tripId,
                    qty: people,
                    customer_name: name,
                    phone: phone,
                    customer_whatsapp: whatsapp,
                    travel_date: date,
                    hotel_1: (document.getElementById('hotel_1') || {}).value || '',
                    hotel_2: (document.getElementById('hotel_2') || {}).value || '',
                    hotel_3: (document.getElementById('hotel_3') || {}).value || '',
                    hotel_4: (document.getElementById('hotel_4') || {}).value || '',
                    tiba: (document.getElementById('tiba') || {}).value || '',
                    flight_balik: (document.getElementById('flight_balik') || {}).value || '',
                    notes: (document.getElementById('notes') || {}).value || '',
                    hp_field: (document.getElementById('hp_field') || {}).value || ''
                })
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.success) {
                    // Manual Payment Success Logic
                    var bank = data.payment_info.bank_details;
                    var paymentMsg = 'Pesanan Berhasil!\n\nID Pesanan: ' + data.order_id + '\nTotal: Rp ' + data.gross_amount.toLocaleString('id-ID') + '\n\nPembayaran via Transfer:\n';
                    
                    if (bank.bank_1 && bank.bank_1.name) {
                        paymentMsg += bank.bank_1.name + ': ' + bank.bank_1.account + ' a/n ' + bank.bank_1.holder + '\n';
                    }
                    if (bank.bank_2 && bank.bank_2.name) {
                        paymentMsg += bank.bank_2.name + ': ' + bank.bank_2.account + ' a/n ' + bank.bank_2.holder + '\n';
                    }
                    
                    alert(paymentMsg + '\nInstruksi lengkap telah dikirim ke WhatsApp Anda.');
                    closeTourModal();
                    window.location.href = '{{ route("home") }}';
                } else {
                    alert('Gagal membuat pesanan: ' + (data.message || 'Unknown error'));
                    btn.disabled = false;
                    btnText.classList.remove('invisible');
                    btnLoading.classList.add('hidden');
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                btn.disabled = false;
                btnText.classList.remove('invisible');
                btnLoading.classList.add('hidden');
            });
        }

        function handleWhatsappClick() {
            var selectedTrip = document.querySelector('.trip-btn.bg-blue-600');
            if (!selectedTrip) {
                alert('Silakan pilih trip terlebih dahulu');
                return;
            }

            var people = document.getElementById('peopleCount').value;
            var tripId = selectedTrip.dataset.tripId;
            var price = parseInt(selectedTrip.dataset.tripPrice);
            var total = price * people;
            
            // Get Form Data
            var name = document.getElementById('customerName').value || 'Pelanggan';
            var date = document.getElementById('travelDate').value || 'Belum ditentukan';
            var tiba = (document.getElementById('tiba') || {}).value || '-';
            var h1 = (document.getElementById('hotel_1') || {}).value || '-';
            var notes = (document.getElementById('notes') || {}).value || '-';

            var message = 'Halo NorthSumateraTrip,\n\nSaya ingin memesan paket:\n*' + currentTour.title + '*\n\nDetail Pesanan:\n- Trip: ' + tripId.toUpperCase() + '\n- Jumlah: ' + people + ' orang\n- Tanggal Trip: ' + date + '\n- Tanggal Tiba: ' + tiba + '\n- Hotel 1: ' + h1 + '\n- Nama: ' + name + '\n- Catatan: ' + notes + '\n\nTotal: Rp ' + total.toLocaleString('id-ID') + '\n\nMohon info selanjutnya.';
            
            var whatsappUrl = 'https://wa.me/{{ App\Helpers\SettingsHelper::whatsappNumber() }}?text=' + encodeURIComponent(message);
            window.open(whatsappUrl, '_blank');
        }
        
        // Expose functions to global scope
        window.handleBookingClick = handleBookingClick;
        window.handleWhatsappClick = handleWhatsappClick;

        // Close modal when clicking outside
        document.getElementById('tourModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTourModal();
            }
        });
    </script>
@endpush
