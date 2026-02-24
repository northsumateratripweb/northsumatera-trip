@extends('layouts.main')

@section('title', $tour->title . ' | NorthSumateraTrip')
@section('meta_description', Str::limit(strip_tags($tour->description), 160))
@section('meta_image', asset('storage/' . $tour->thumbnail))

@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org/",
  "@@type": "Product",
  "name": "{{ $tour->title }}",
  "image": "{{ asset('storage/' . $tour->thumbnail) }}",
  "description": "{{ strip_tags($tour->description) }}",
  "brand": {
    "@@type": "Brand",
    "name": "NorthSumateraTrip"
  },
  "offers": {
    "@@type": "Offer",
    "url": "{{ url()->current() }}",
    "priceCurrency": "IDR",
    "price": "{{ $tour->price }}",
    "availability": "https://schema.org/InStock"
  }
}
</script>
@endpush

@section('content')
    <!-- Main Content -->
    <div class="pt-36 md:pt-40 pb-16 md:pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-3 gap-12">
            
            <!-- Left Content -->
            <div class="lg:col-span-2">
                
                <!-- Hero Image -->
                <div class="relative group rounded-[48px] overflow-hidden mb-12 bg-white shadow-2xl shadow-blue-500/5 border border-slate-100 p-3">
                    <div class="aspect-[16/9] overflow-hidden rounded-[40px]">
                        <img src="{{ str_starts_with($tour->thumbnail, 'http') ? $tour->thumbnail : asset('storage/' . $tour->thumbnail) }}" alt="{{ $tour->title }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" loading="lazy">
                    </div>
                    <div class="absolute top-8 right-8 flex flex-col gap-3">
                        <div class="px-6 py-3 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-white/20">
                            <span class="text-blue-700 font-extrabold text-xs uppercase tracking-widest">{{ $tour->duration_days }} Hari Trip</span>
                        </div>
                        <button onclick="toggleWishlist({{ $tour->id }}, '{{ $tour->title }}', '{{ $tour->thumbnail }}')" id="wishlistBtn" class="w-14 h-14 bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 flex items-center justify-center text-slate-400 hover:text-rose-500 transition-all group/wish">
                            <svg id="wishlistIcon" class="w-6 h-6 transition-transform group-hover/wish:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Title & Location -->
                <div class="mb-12 reveal">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-[10px] font-black uppercase tracking-widest">Premium Tour</span>
                        <div class="flex items-center gap-1 text-amber-400">
                            @for($i=0; $i<5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 mb-6 tracking-tight leading-tight">{{ $tour->title }}</h1>
                    
                    <!-- Social Sharing -->
                    <div class="flex flex-wrap items-center gap-3 mb-12">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mr-2">Bagikan:</span>
                        <a href="https://wa.me/?text={{ urlencode($tour->title . ' ' . url()->current()) }}" target="_blank" class="w-10 h-10 rounded-xl bg-[#25D366]/10 text-[#25D366] flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all shadow-sm">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.305 1.652zm6.599-3.835c1.544.918 3.513 1.404 5.289 1.405 5.451 0 9.886-4.434 9.889-9.885.002-2.641-1.026-5.124-2.895-6.995-1.868-1.871-4.354-2.9-6.997-2.9-5.453 0-9.888 4.435-9.891 9.886-.001 2.04.536 4.032 1.554 5.768l-1.023 3.732 3.824-.999zm11.366-5.438c-.312-.156-1.848-.912-2.134-1.017-.286-.104-.494-.156-.701.156-.207.312-.804 1.017-.986 1.225-.182.208-.364.234-.676.078-.312-.156-1.318-.486-2.51-1.548-.928-.827-1.554-1.849-1.736-2.161-.182-.312-.02-.481.136-.636.141-.14.312-.364.468-.546.156-.182.208-.312.312-.52.104-.208.052-.39-.026-.546-.078-.156-.701-1.691-.961-2.313-.253-.607-.511-.524-.701-.534-.181-.01-.389-.012-.597-.012-.208 0-.546.078-.831.39-.286.312-1.091 1.067-1.091 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 rounded-xl bg-[#1877F2]/10 text-[#1877F2] flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all shadow-sm">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($tour->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-900/10 text-slate-900 flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <button onclick="copyToClipboard('{{ url()->current() }}')" class="w-10 h-10 rounded-xl bg-blue-700/10 text-blue-700 flex items-center justify-center hover:bg-blue-700 hover:text-white transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                        </button>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                        <div class="flex items-center gap-3 text-slate-500">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center text-blue-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <span class="font-bold">{{ $tour->location }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-slate-500">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center text-blue-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="font-bold">{{ $tour->duration_days }} Hari Trip</span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-16">
                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-widest mb-8 flex items-center gap-4">
                        <span class="w-12 h-1 bg-blue-700 rounded-full"></span>
                        Deskripsi Paket
                    </h2>
                    <div id="tourDescription" class="bg-white dark:bg-slate-900 rounded-[48px] p-10 md:p-14 border border-slate-100 dark:border-slate-800 shadow-sm leading-relaxed text-slate-600 dark:text-slate-400 font-medium prose prose-slate dark:prose-invert max-w-none prose-p:my-4">
                        {!! $tour->description !!}
                    </div>
                </div>

                <!-- Itinerary -->
                <div class="mb-16">
                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-widest mb-8 flex items-center gap-4">
                        <span class="w-12 h-1 bg-blue-700 rounded-full"></span>
                        Itinerary Perjalanan
                    </h2>

                    @php
                        $itineraryHtml = $tour->itinerary;
                        $days = [];
                        if (preg_match_all('/(<li><strong>(?:Day|Hari)\s+\d+.*?<\/li>)/is', $itineraryHtml, $matches)) {
                            $days = $matches[1];
                        } else {
                            $days = explode('</p>', $itineraryHtml);
                        }
                    @endphp

                    <div id="tourItinerary" class="space-y-6" x-data="{ activeDay: 0 }">
                        @foreach($days as $index => $day)
                            @php
                                $cleanDay = preg_replace('/^<ul>/i', '', $day);
                                $cleanDay = preg_replace('/<\/ul>$/i', '', $cleanDay);
                                preg_match('/<strong>(.*?)\s*<\/strong>/i', $cleanDay, $titleMatch);
                                $dayTitle = isset($titleMatch[1]) ? $titleMatch[1] : 'Day ' . ($index + 1);
                                $dayContent = preg_replace('/<strong>.*?<\/strong>:/i', '', $cleanDay);
                                $dayContent = str_replace(['<li>', '</li>'], '', $dayContent);
                            @endphp
                            <div class="bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 overflow-hidden transition-all duration-500"
                                 :class="activeDay === {{ $index }} ? 'shadow-2xl shadow-blue-500/10 border-blue-100 dark:border-blue-900/30' : ''">
                                <button @click="activeDay = (activeDay === {{ $index }} ? -1 : {{ $index }})" 
                                        class="w-full px-10 py-8 flex items-center justify-between text-left">
                                    <div class="flex items-center gap-6">
                                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-black text-sm transition-all"
                                             :class="activeDay === {{ $index }} ? 'bg-blue-700 text-white shadow-lg shadow-blue-500/30' : 'bg-slate-50 dark:bg-slate-800 text-slate-400'">
                                            {{ $index + 1 }}
                                        </div>
                                        <h3 class="text-lg font-black text-slate-900 dark:text-white">{{ $dayTitle }}</h3>
                                    </div>
                                    <svg class="w-6 h-6 text-slate-300 transition-transform duration-500" :class="activeDay === {{ $index }} ? 'rotate-180 text-blue-700' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div x-show="activeDay === {{ $index }}" x-collapse>
                                    <div class="px-10 pb-10 pt-2 pl-28 text-slate-500 dark:text-slate-400 font-medium leading-[1.8] text-base prose dark:prose-invert max-w-none">
                                        {!! $dayContent !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Reviews -->
                <div class="mb-16">
                    <h2 class="text-xl font-black text-slate-900 uppercase tracking-widest mb-8 flex items-center gap-4">
                        <span class="w-12 h-1 bg-blue-700 rounded-full"></span>
                        Review Pelanggan
                    </h2>
                    
                    <div class="grid md:grid-cols-2 gap-8 mb-12">
                        @forelse($tour->reviews()->where('is_published', true)->latest()->get() as $review)
                            <div class="p-10 bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 shadow-sm transition-all duration-500">
                                <div class="flex items-center gap-5 mb-8">
                                    <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400 font-black text-lg">
                                        {{ substr($review->customer_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-base font-black text-slate-900 dark:text-white">{{ $review->customer_name }}</h4>
                                        <div class="flex gap-1 text-amber-400">
                                            @for($i=0; $i<$review->rating; $i++)
                                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="text-slate-600 dark:text-slate-400 font-medium leading-relaxed italic">"{{ $review->comment }}"</p>
                            </div>
                        @empty
                            <div class="md:col-span-2 p-16 bg-slate-50 dark:bg-slate-800/50 rounded-[48px] border-2 border-dashed border-slate-200 dark:border-slate-800 text-center text-slate-400 font-black">
                                Belum ada review untuk paket ini.
                            </div>
                        @endforelse
                    </div>

                    <!-- Add Review Form -->
                    <div class="p-10 md:p-14 bg-white dark:bg-slate-900 rounded-[48px] border border-slate-100 dark:border-slate-800 transition-all duration-500">
                        <h3 class="text-xl font-black text-slate-900 dark:text-white mb-10 flex items-center gap-4">
                            <span class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </span>
                            Tulis Review Anda
                        </h3>

                        <form action="{{ route('review.store', $tour->id) }}" method="POST" class="space-y-8">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Anda</label>
                                    <input type="text" name="customer_name" required placeholder="Masukkan nama Anda" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-8 py-5 text-sm font-bold focus:bg-white dark:focus:bg-slate-950 focus:ring-4 focus:ring-blue-700/5 focus:border-blue-700 outline-none transition-all">
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Rating</label>
                                    <div class="flex items-center gap-4 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-8 py-5">
                                        <div class="flex flex-row-reverse items-center justify-end gap-1">
                                            @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="peer hidden" required {{ $i == 5 ? 'checked' : '' }}>
                                            <label for="star{{ $i }}" class="cursor-pointer text-slate-300 peer-checked:text-amber-400 hover:text-amber-400 transition-colors">
                                                <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            </label>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Komentar</label>
                                <textarea name="comment" required rows="4" placeholder="Bagikan pengalaman Anda..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-[32px] px-8 py-6 text-sm font-bold focus:bg-white dark:focus:bg-slate-950 focus:ring-4 focus:ring-blue-700/5 focus:border-blue-700 outline-none transition-all resize-none"></textarea>
                            </div>
                            <button type="submit" class="px-12 py-6 bg-blue-700 hover:bg-blue-800 text-white rounded-full font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-blue-500/20">
                                Kirim Review
                            </button>
                        </form>
                    </div>
                </div>

                <!-- PDF & Itinerary Buttons -->
                <div class="grid sm:grid-cols-2 gap-6 mb-12 reveal">
                    @if($tour->itinerary_url)
                    <a href="{{ $tour->itinerary_url }}" target="_blank" class="group px-8 py-5 bg-blue-700 hover:bg-blue-800 text-white rounded-[24px] font-black text-[11px] uppercase tracking-widest transition-all flex items-center justify-center gap-4 shadow-xl shadow-blue-500/20">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Lihat Itinerary (Google Drive)
                    </a>
                    @endif
                    <div class="grid grid-cols-2 gap-4 {{ !$tour->itinerary_url ? 'sm:col-span-2' : '' }}">
                        <a href="{{ route('itinerary.pdf', $tour->id) }}" class="group px-6 py-5 bg-slate-900 hover:bg-slate-800 text-white rounded-[24px] font-black text-[10px] uppercase tracking-widest transition-all flex items-center justify-center gap-3 shadow-xl shadow-slate-900/20">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            PDF Itinerary
                        </a>
                        <a href="https://wa.me/{{ App\Helpers\SettingsHelper::whatsappNumber() }}?text={{ urlencode('Halo NorthSumateraTrip, saya ingin bertanya tentang paket: ' . $tour->title) }}" target="_blank" class="group px-6 py-5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-[24px] font-black text-[10px] uppercase tracking-widest transition-all flex items-center justify-center gap-3 shadow-xl shadow-emerald-600/20">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.305 1.652zm6.599-3.835c1.544.918 3.513 1.404 5.289 1.405 5.451 0 9.886-4.434 9.889-9.885.002-2.641-1.026-5.124-2.895-6.995-1.868-1.871-4.354-2.9-6.997-2.9-5.453 0-9.888 4.435-9.891 9.886-.001 2.04.536 4.032 1.554 5.768l-1.023 3.732 3.824-.999zm11.366-5.438c-.312-.156-1.848-.912-2.134-1.017-.286-.104-.494-.156-.701.156-.207.312-.804 1.017-.986 1.225-.182.208-.364.234-.676.078-.312-.156-1.318-.486-2.51-1.548-.928-.827-1.554-1.849-1.736-2.161-.182-.312-.02-.481.136-.636.141-.14.312-.364.468-.546.156-.182.208-.312.312-.52.104-.208.052-.39-.026-.546-.078-.156-.701-1.691-.961-2.313-.253-.607-.511-.524-.701-.534-.181-.01-.389-.012-.597-.012-.208 0-.546.078-.831.39-.286.312-1.091 1.067-1.091 2.601 0 1.534 1.117 3.015 1.273 3.223.156.208 2.197 3.356 5.323 4.706.743.321 1.324.512 1.777.656.747.237 1.427.203 1.965.123.599-.089 1.848-.755 2.108-1.483.26-.728.26-1.353.182-1.483-.078-.13-.286-.208-.598-.364z"/></svg>
                            Request Trip
                        </a>
                    </div>
                </div>

                <!-- Location Map Placeholder removed -->

            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-slate-900 rounded-[48px] p-10 sticky top-32 border border-slate-100 dark:border-slate-800 shadow-xl shadow-blue-500/5">
                    
                    <!-- Booking Stepper -->
                    <div class="mb-14">
                        <div class="flex items-center justify-between relative px-2">
                            <div class="absolute top-5 left-10 right-10 h-0.5 bg-slate-50 dark:bg-slate-800 -z-10">
                                <div id="stepperProgress" class="h-full bg-blue-700 transition-all duration-500" style="width: 0%"></div>
                            </div>
                            
                            @foreach([1, 2, 3] as $step)
                            <div class="flex flex-col items-center gap-3">
                                <div id="step{{ $step }}Icon" class="w-10 h-10 rounded-full {{ $step == 1 ? 'bg-blue-700 text-white shadow-lg shadow-blue-500/30' : 'bg-slate-50 dark:bg-slate-800 text-slate-400' }} flex items-center justify-center font-black text-xs transition-all">
                                    {{ $step }}
                                </div>
                                <span id="step{{ $step }}Text" class="text-[9px] font-black {{ $step == 1 ? 'text-blue-700' : 'text-slate-400' }} uppercase tracking-widest">
                                    {{ $step == 1 ? 'Pilih' : ($step == 2 ? 'Data' : 'Bayar') }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Trip Selection -->
                    <div class="mb-10">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-5 ml-1">Pilih Tipe Trip</label>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($tour->trips as $key => $trip)
                                <button onclick="selectTrip(this)" data-trip-id="{{ $key }}" data-trip-price="{{ $trip['price'] ?? 0 }}"
                                        class="trip-btn group px-4 py-5 rounded-3xl border border-slate-100 dark:border-slate-800 hover:border-blue-700 dark:hover:border-blue-600 transition-all text-left">
                                    <span class="block text-xs font-black text-slate-600 dark:text-slate-400 group-hover:text-blue-700 transition-colors uppercase">{{ $key }}</span>
                                    <span class="block text-[10px] text-slate-400 mt-1">Rp {{ number_format($trip['price'] ?? 0, 0, ',', '.') }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Input Fields -->
                    <div class="space-y-5 mb-10">
                        <div class="space-y-5">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Data Diri</label>
                            <input type="text" id="customerName" placeholder="Nama Lengkap" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-8 py-5 text-sm font-bold focus:bg-white dark:focus:bg-slate-950 focus:ring-4 focus:ring-blue-700/5 focus:border-blue-700 outline-none transition-all">
                            <input type="email" id="email" placeholder="Alamat Email (Opsional)" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-8 py-5 text-sm font-bold focus:bg-white dark:focus:bg-slate-950 focus:ring-4 focus:ring-blue-700/5 focus:border-blue-700 outline-none transition-all">
                            <div class="grid grid-cols-2 gap-4">
                                <input type="tel" id="customerPhone" placeholder="Telepon" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-6 py-5 text-sm font-bold focus:border-blue-700 outline-none">
                                <input type="tel" id="customerWhatsapp" placeholder="WhatsApp" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-6 py-5 text-sm font-bold focus:border-blue-700 outline-none">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Berangkat</label>
                                <input type="date" id="travelDate" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl px-6 py-4 text-xs font-bold focus:border-blue-700 outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Tiba / Selesai</label>
                                <input type="date" id="tiba" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl px-6 py-4 text-xs font-bold focus:border-blue-700 outline-none">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Detail Akomodasi & Penerbangan</label>
                            <div class="grid grid-cols-2 gap-3">
                                <input type="text" id="hotel_1" list="hotel-list" placeholder="Hotel 1" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-xs font-bold focus:border-blue-700 outline-none">
                                <input type="text" id="hotel_2" list="hotel-list" placeholder="Hotel 2" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-xs font-bold focus:border-blue-700 outline-none">
                                <input type="text" id="hotel_3" list="hotel-list" placeholder="Hotel 3" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-xs font-bold focus:border-blue-700 outline-none">
                                <input type="text" id="hotel_4" list="hotel-list" placeholder="Hotel 4" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-xs font-bold focus:border-blue-700 outline-none">
                            </div>
                            <input type="text" id="flight_balik" placeholder="Info Penerbangan (Optional)" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-8 py-5 text-sm font-bold focus:border-blue-700 outline-none">
                        </div>

                        <div class="space-y-4">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Layanan Tambahan</label>
                            <div class="flex items-center gap-4 bg-slate-50 dark:bg-slate-800 rounded-3xl px-8 py-5 border border-slate-100 dark:border-slate-700">
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-400">Gunakan Drone?</span>
                                <div class="flex items-center gap-4 ml-auto">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="use_drone" value="1" class="w-4 h-4 text-blue-700 border-slate-300 focus:ring-blue-700">
                                        <span class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase">Ya</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="use_drone" value="0" checked class="w-4 h-4 text-blue-700 border-slate-300 focus:ring-blue-700">
                                        <span class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase">Tidak</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                             <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Jumlah Peserta</label>
                             <select id="peopleCount" onchange="updatePrice()" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-8 py-5 text-sm font-bold focus:border-blue-700 outline-none appearance-none">
                                @for($i=1; $i<=10; $i++)
                                    <option value="{{ $i }}">{{ $i }} Orang</option>
                                @endfor
                             </select>
                        </div>

                        <!-- Honeypot -->
                        <div class="hidden" aria-hidden="true">
                            <input type="text" name="hp_field" value="" tabindex="-1" autocomplete="off">
                        </div>

                        <!-- Terms & Conditions Checkbox -->
                        <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800 p-6 rounded-3xl flex items-start gap-4">
                            <input type="checkbox" id="termsCheck" class="w-6 h-6 mt-1 rounded-lg border-slate-200 dark:border-slate-700 text-blue-600 focus:ring-blue-500/20 transition-all cursor-pointer">
                            <label for="termsCheck" class="text-[11px] font-bold text-slate-500 dark:text-slate-400 leading-relaxed cursor-pointer">
                                Saya menyetujui <a href="{{ route('legal.terms') }}" target="_blank" class="text-blue-600 hover:underline">Syarat & Ketentuan</a> serta memberikan izin penggunaan data sesuai kebijakan <a href="{{ route('legal.privacy') }}" target="_blank" class="text-blue-600 hover:underline">Privasi</a>.
                            </label>
                        </div>
                        
                        <textarea id="notes" placeholder="Catatan Tambahan (Optional)" rows="2" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-[32px] px-8 py-5 text-sm font-bold focus:border-blue-700 outline-none transition-all resize-none"></textarea>
                    </div>

                    <!-- Price Footer -->
                    <div class="p-10 bg-blue-700 rounded-[40px] shadow-2xl shadow-blue-500/30 text-white mb-10 text-center">
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-2">Total Pembayaran</p>
                        <p id="totalPrice" class="text-3xl font-black tracking-tight leading-none">Rp 0</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-4" x-data="{ bookingLoading: false, waLoading: false }">
                        <button id="bookNowBtn" @click="bookingLoading = true; handleBookingClick().finally(() => bookingLoading = false)"
                                class="w-full py-6 bg-slate-900 hover:bg-black text-white rounded-full font-black text-xs uppercase tracking-widest transition-all shadow-xl flex items-center justify-center gap-3">
                            <span x-show="!bookingLoading" class="flex items-center gap-3">
                                Pesan Sekarang
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                            <svg x-show="bookingLoading" class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                        <button id="whatsappBtn" @click="waLoading = true; handleWhatsappClick().finally(() => waLoading = false)"
                                class="w-full py-6 bg-white border border-slate-100 hover:border-blue-700 text-slate-900 rounded-full font-black text-xs uppercase tracking-widest transition-all flex items-center justify-center gap-3">
                            <span x-show="!waLoading" class="flex items-center gap-3">
                                Tanya via WhatsApp
                            </span>
                            <svg x-show="waLoading" class="animate-spin h-5 w-5 text-blue-700" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                        
                        <div class="pt-6 border-t border-slate-50 dark:border-slate-800">
                            <a href="{{ route('itinerary.pdf', $tour->id) }}" target="_blank"
                               class="w-full py-4 bg-slate-50 dark:bg-slate-800/50 hover:bg-blue-50 dark:hover:bg-blue-900/20 text-slate-400 hover:text-blue-700 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all flex items-center justify-center gap-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                Download PDF Trip
                            </a>
                        </div>
                    </div>
                </div>

        </div>
    </div>

    <!-- Manual Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 z-[200] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-md" onclick="closePaymentModal()"></div>
        <div class="relative w-full max-w-xl bg-white dark:bg-slate-950 rounded-[64px] shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-500 max-h-[95vh] overflow-y-auto border border-slate-100 dark:border-slate-800">
            <div class="p-12 md:p-16">
                <div class="flex items-center justify-between mb-12">
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Pembayaran</h3>
                    <button onclick="closePaymentModal()" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-slate-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-10">
                    <!-- Order Info -->
                    <div class="bg-blue-700 rounded-[40px] p-10 text-white shadow-2xl shadow-blue-500/20 text-center relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 blur-2xl rounded-full -mr-16 -mt-16 transition-transform duration-1000 group-hover:scale-110"></div>
                        <p class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-2">Total yang harus dibayar</p>
                        <p id="modalTotalAmount" class="text-4xl font-black tracking-tight leading-none mb-4">Rp 0</p>
                        <p class="text-[10px] font-black uppercase tracking-widest">Order ID: <span id="modalOrderId" class="opacity-60">ORD-XXXX</span></p>
                    </div>

                    <!-- Bank Accounts -->
                    <div class="space-y-6">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Silakan Transfer Ke:</p>
                        
                        @php $bankDetails = \App\Helpers\SettingsHelper::bankDetails(); @endphp
                        @foreach(['bank_1', 'bank_2'] as $bankKey)
                            @php $bank = $bankDetails[$bankKey] ?? null; @endphp
                            @if($bank && !empty($bank['name']) && !empty($bank['account']))
                                <div class="group p-8 rounded-[40px] border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-between hover:border-blue-700 transition-all cursor-pointer" onclick="copyToClipboard('{{ $bank['account'] }}')">
                                    <div class="flex items-center gap-8">
                                        <div class="w-20 h-12 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center border border-slate-100 dark:border-slate-800 font-extrabold text-xs text-blue-900 dark:text-blue-400 uppercase">
                                            {{ $bank['name'] }}
                                        </div>
                                        <div>
                                            <p class="text-xl font-black text-slate-900 dark:text-white leading-tight mb-1">{{ $bank['account'] }}</p>
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">a/n {{ $bank['holder'] }}</p>
                                        </div>
                                    </div>
                                    <svg class="w-6 h-6 text-slate-300 group-hover:text-blue-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if($bankDetails['qris'])
                    <div class="text-center pt-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Atau Scan QRIS Berikut:</p>
                        <div class="inline-block p-10 bg-white dark:bg-slate-800 rounded-[56px] shadow-sm border border-slate-100 dark:border-slate-700">
                            <img src="{{ asset('storage/' . $bankDetails['qris']) }}" alt="QRIS" class="w-64 h-64 mx-auto object-contain">
                        </div>
                    </div>
                    @endif
                </div>

                <div class="mt-16">
                    <button onclick="redirectToWhatsappFromModal()" class="w-full py-6 bg-[#25D366] text-white rounded-full font-black text-xs uppercase tracking-widest transition-all shadow-2xl shadow-emerald-500/20 flex items-center justify-center gap-3">
                        Kirim Bukti via WhatsApp
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    <p class="text-center text-[10px] font-bold text-slate-400 mt-6 uppercase tracking-widest">Verifikasi otomatis akan diproses tim kami.</p>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function reveal() {
            var reveals = document.querySelectorAll(".reveal");
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 150;
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                }
            }
        }
        window.addEventListener("scroll", reveal);
        document.addEventListener("DOMContentLoaded", reveal);
    </script>
    <script>
        let currentTrip = null;
        let currentOrderId = null;
        const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
        const csrf_token = csrfTokenElement ? csrfTokenElement.content : '';

        // Session Storage Keys
        const BOOKING_CLICK_KEY = `booking_clicks_{{ $tour->id }}`;
        const WHATSAPP_CLICK_KEY = `whatsapp_clicks_{{ $tour->id }}`;
        const ORDER_ID_KEY = `order_id_{{ $tour->id }}`;
        const SELECTED_TRIP_ID_KEY = `selected_trip_{{ $tour->id }}`;

        // Initialize clicks on load
        try {
            if (!sessionStorage.getItem(BOOKING_CLICK_KEY)) sessionStorage.setItem(BOOKING_CLICK_KEY, '0');
            if (!sessionStorage.getItem(WHATSAPP_CLICK_KEY)) sessionStorage.setItem(WHATSAPP_CLICK_KEY, '0');
            currentOrderId = sessionStorage.getItem(ORDER_ID_KEY);
        } catch (e) {
            console.warn('Session storage not available', e);
        }

        // Leading-edge debounce implementation
        function debounce(func, wait = 300) {
            let timeout;
            return function(...args) {
                const context = this;
                const later = function() {
                    timeout = null;
                };
                const callNow = !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        }

        window.handleBookingClick = function() {
            if (!currentTrip) {
                showNotification('Silakan pilih tipe trip terlebih dahulu', 'error');
                const container = document.getElementById('tripsContainer');
                if (container) {
                    container.classList.add('animate-bounce');
                    setTimeout(() => container.classList.remove('animate-bounce'), 1000);
                }
                return Promise.resolve();
            }

            const clicks = parseInt(sessionStorage.getItem(BOOKING_CLICK_KEY)) || 0;
            
            if (clicks === 0) {
                return createOrder('booking');
            } else {
                processPayment();
                return Promise.resolve();
            }
        };

        window.handleWhatsappClick = function() {
            if (!currentTrip) {
                showNotification('Silakan pilih tipe trip terlebih dahulu', 'error');
                const container = document.getElementById('tripsContainer');
                if (container) {
                    container.classList.add('animate-bounce');
                    setTimeout(() => container.classList.remove('animate-bounce'), 1000);
                }
                return Promise.resolve();
            }

            const clicks = parseInt(sessionStorage.getItem(WHATSAPP_CLICK_KEY)) || 0;
            
            if (clicks === 0) {
                return createOrder('whatsapp');
            } else {
                redirectToWhatsapp();
                return Promise.resolve();
            }
        };

        function selectTrip(button) {
            if (!button) return;
            
            // UI Visual Feedback
            document.querySelectorAll('.trip-btn').forEach(btn => {
                btn.classList.remove('border-blue-700', 'bg-blue-50', 'ring-4', 'ring-blue-700/10');
                btn.querySelector('span').classList.remove('text-blue-700');
                btn.querySelector('span').classList.add('text-slate-600');
            });
            
            button.classList.add('border-blue-700', 'bg-blue-50', 'ring-4', 'ring-blue-700/10');
            button.querySelector('span').classList.remove('text-slate-600');
            button.querySelector('span').classList.add('text-blue-700');
            
            const tripId = button.dataset.tripId;
            const price = parseInt(button.dataset.tripPrice);
            
            // Save to session storage
            sessionStorage.setItem(SELECTED_TRIP_ID_KEY, tripId);
            
            // Get trip details from tour data
            const tripData = @json($tour->trips);
            const trip = tripData[tripId];
            
            // Update global currentTrip
            currentTrip = { id: tripId, price: price, data: trip };
            
            // Show trip details with animation
            const tripDetails = document.getElementById('tripDetails');
            if (tripDetails) {
                tripDetails.classList.add('opacity-0', 'translate-y-2');
                
                setTimeout(() => {
                    const detailsHtml = `
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Detail Trip</span>
                        </div>
                        <strong class="text-slate-900 text-sm block mb-1">${trip.name || 'Tipe ' + tripId.toUpperCase()}</strong>
                        <p class="text-[11px] leading-relaxed">${trip.includes || ''}</p>
                    `;
                    tripDetails.innerHTML = detailsHtml;
                    tripDetails.classList.remove('opacity-0', 'translate-y-2');
                    tripDetails.classList.add('transition-all', 'duration-300');
                }, 150);
            }
            
            // Critical: Always update price after trip selection
            updatePrice();
            
            // Clear previous order state when trip changes
            sessionStorage.removeItem(ORDER_ID_KEY);
            currentOrderId = null;
            
            // Update Stepper to step 1 (Active)
            updateStepper(1);
            
            // Reset button states when trip changes
            resetButtonStates();
        }

        function resetButtonStates() {
            sessionStorage.setItem(BOOKING_CLICK_KEY, '0');
            sessionStorage.setItem(WHATSAPP_CLICK_KEY, '0');
            sessionStorage.removeItem(ORDER_ID_KEY);
            currentOrderId = null;
            
            // Reset Booking Button
            const btnText = document.getElementById('btnText');
            if (btnText) {
                btnText.innerHTML = `BOOKING SEKARANG <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>`;
                btnText.classList.remove('animate-pulse');
            }
            
            // Reset WA Button
            const waBtnText = document.getElementById('waBtnText');
            if (waBtnText) {
                waBtnText.innerHTML = `<svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.305 1.652zm6.599-3.835c1.544.918 3.513 1.404 5.289 1.405 5.451 0 9.886-4.434 9.889-9.885.002-2.641-1.026-5.124-2.895-6.995-1.868-1.871-4.354-2.9-6.997-2.9-5.453 0-9.888 4.435-9.891 9.886-.001 2.04.536 4.032 1.554 5.768l-1.023 3.732 3.824-.999zm11.366-5.438c-.312-.156-1.848-.912-2.134-1.017-.286-.104-.494-.156-.701.156-.207.312-.804 1.017-.986 1.225-.182.208-.364.234-.676.078-.312-.156-1.318-.486-2.51-1.548-.928-.827-1.554-1.849-1.736-2.161-.182-.312-.02-.481.136-.636.141-.14.312-.364.468-.546.156-.182.208-.312.312-.52.104-.208.052-.39-.026-.546-.078-.156-.701-1.691-.961-2.313-.253-.607-.511-.524-.701-.534-.181-.01-.389-.012-.597-.012-.208 0-.546.078-.831.39-.286.312-1.091 1.067-1.091 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg> Pesan dari WhatsApp`;
                waBtnText.classList.remove('animate-pulse');
            }
        }

        function updatePrice() {
            const peopleCountElement = document.getElementById('peopleCount');
            const totalPriceElement = document.getElementById('totalPrice');
            
            if (!peopleCountElement || !totalPriceElement) return;

            const people = parseInt(peopleCountElement.value) || 0;

            // Jika trip belum dipilih atau jumlah orang 0, tampilkan Rp 0
            if (!currentTrip || people <= 0) {
                totalPriceElement.textContent = `Rp 0`;
                return;
            }
            
            const total = currentTrip.price * people;
            totalPriceElement.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }

        function updateWhatsappLink() {
            // Placeholder to prevent errors
        }

        // --- NEW PHASE 2 JS LOGIC ---
        
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                showNotification('Link berhasil disalin ke clipboard!', 'success');
            }).catch(err => {
                console.error('Gagal menyalin: ', err);
            });
        }

        function updateStepper(step) {
            const progress = document.getElementById('stepperProgress');
            if (!progress) return;

            // Update Progress Bar
            if (step === 1) progress.style.width = '0%';
            if (step === 2) progress.style.width = '50%';
            if (step === 3) progress.style.width = '100%';

            // Update Icons & Text
            for (let i = 1; i <= 3; i++) {
                const icon = document.getElementById(`step${i}Icon`);
                const text = document.getElementById(`step${i}Text`) || document.querySelector(`div:has(#step${i}Icon) span`);
                
                if (i <= step) {
                    icon.classList.remove('bg-slate-100', 'text-slate-400');
                    icon.classList.add('bg-blue-700', 'text-white', 'shadow-lg', 'shadow-blue-500/30');
                    if (text) text.classList.add('text-blue-700');
                    if (text) text.classList.remove('text-slate-400');
                } else {
                    icon.classList.add('bg-slate-100', 'text-slate-400');
                    icon.classList.remove('bg-blue-700', 'text-white', 'shadow-lg', 'shadow-blue-500/30');
                    if (text) text.classList.remove('text-blue-700');
                    if (text) text.classList.add('text-slate-400');
                }
            }
        }

        // Listen for inputs to update to step 2
        document.addEventListener('DOMContentLoaded', () => {
            ['customerName', 'customerPhone', 'travelDate'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('input', () => {
                        if (currentTrip && el.value.trim() !== '') {
                            updateStepper(2);
                        }
                    });
                }
            });
        });
        // ------------------------------

        function createOrder(type) {
            if (!currentTrip) {
                showNotification('Silakan pilih tipe trip terlebih dahulu', 'error');
                return Promise.resolve();
            }

            const name = document.getElementById('customerName').value.trim();
            const phone = document.getElementById('customerPhone').value.trim();
            const whatsapp = document.getElementById('customerWhatsapp').value.trim();
            const peopleCountElement = document.getElementById('peopleCount');
            const people = parseInt(peopleCountElement.value);
            const date = document.getElementById('travelDate').value;
            const useDrone = document.querySelector('input[name="use_drone"]:checked')?.value || '0';

            if (!name || !phone || !whatsapp || isNaN(people) || people <= 0 || !date) {
                showNotification('Silakan isi semua data dengan lengkap (termasuk No. WhatsApp)', 'error');
                return Promise.resolve();
            }

            if (!document.getElementById('termsCheck').checked) {
                showNotification('Silakan setujui Syarat & Ketentuan untuk melanjutkan.', 'error');
                return Promise.resolve();
            }

            const total = currentTrip.price * people;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

            return fetch('{{ route("checkout", $tour->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    action: 'create',
                    trip_id: currentTrip.id,
                    qty: people,
                    customer_name: name,
                    phone: phone,
                    customer_whatsapp: whatsapp,
                    use_drone: useDrone,
                    travel_date: date,
                    gross_amount: total,
                    hotel_1: document.getElementById('hotel_1')?.value,
                    hotel_2: document.getElementById('hotel_2')?.value,
                    hotel_3: document.getElementById('hotel_3')?.value,
                    hotel_4: document.getElementById('hotel_4')?.value,
                    tiba: document.getElementById('tiba')?.value,
                    flight_balik: document.getElementById('flight_balik')?.value,
                    notes: document.getElementById('notes')?.value,
                    hp_field: document.querySelector('input[name="hp_field"]')?.value
                })
            })
            .then(async response => {
                if (response.status === 419) {
                    throw new Error('Sesi telah berakhir (CSRF mismatch). Silakan segarkan halaman (refresh) dan coba lagi.');
                }
                const data = await response.json();
                if (!response.ok) throw new Error(data.message || 'Terjadi kesalahan sistem');
                return data;
            })
            .then(data => {
                if (data.success) {
                    currentOrderId = data.order_id;
                    sessionStorage.setItem(ORDER_ID_KEY, currentOrderId);
                    
                    if (type === 'booking') {
                        sessionStorage.setItem(BOOKING_CLICK_KEY, '1');
                        updateButtonState('booking');
                        updateStepper(3);
                        showManualPaymentModal(data.order_id, data.gross_amount);
                    } else {
                        sessionStorage.setItem(WHATSAPP_CLICK_KEY, '1');
                        updateButtonState('whatsapp');
                        updateStepper(3);
                        redirectToWhatsapp();
                    }
                } else {
                    showNotification('Gagal membuat pesanan: ' + data.message, 'error');
                }
            })
            .catch(error => {
                showNotification(error.message, 'error');
                throw error; // Re-throw to be caught by Alpine finally
            });
        }

        function processPayment() {
            if (currentOrderId) {
                const people = parseInt(document.getElementById('peopleCount').value) || 0;
                const total = currentTrip ? currentTrip.price * people : 0;
                showManualPaymentModal(currentOrderId, total);
            } else {
                createOrder('booking');
            }
        }

        function showManualPaymentModal(orderId, amount) {
            const modalOrderId = document.getElementById('modalOrderId');
            const modalTotalAmount = document.getElementById('modalTotalAmount');
            if (modalOrderId) modalOrderId.textContent = orderId;
            if (modalTotalAmount) modalTotalAmount.textContent = `Rp ${amount.toLocaleString('id-ID')}`;
            
            const modal = document.getElementById('paymentModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        }

        function closePaymentModal() {
            const modal = document.getElementById('paymentModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }
        }

        function copyToClipboard(text, label) {
            navigator.clipboard.writeText(text).then(() => {
                showNotification(`Nomor Rekening ${label} berhasil disalin!`, 'success');
            }).catch(() => {
                showNotification('Gagal menyalin. Silakan salin manual.', 'error');
            });
        }

        function redirectToWhatsappFromModal() {
            redirectToWhatsapp('Bukti Transfer');
        }

        function redirectToWhatsapp(suffix = '') {
            const name = document.getElementById('customerName').value || 'Pengunjung';
            const people = document.getElementById('peopleCount').value || '1';
            const date = document.getElementById('travelDate').value || '-';
            const tripName = currentTrip ? (currentTrip.id.toUpperCase()) : 'General';
            const total = currentTrip ? currentTrip.price * (parseInt(people) || 0) : 0;

            let message = `Halo NorthSumateraTrip 👋\n\nSaya ingin konfirmasi pesanan saya.\n\n`;
            message += `🧾 ID Pesanan: ${currentOrderId ?? '-'}\n`;
            message += `📦 Paket: {{ $tour->title }}\n`;
            message += `👤 Nama: ${name}\n`;
            message += `💰 Total Bayar: Rp ${total.toLocaleString('id-ID')}\n\n`;
            
            if (suffix) {
                message += `Saya ingin mengirimkan *${suffix}*.\n\n`;
            } else {
                message += `Mohon info selanjutnya untuk proses pembayaran. Terima kasih 🙏`;
            }
            
            const whatsappNumber = '{{ App\Helpers\SettingsHelper::whatsappNumber() }}'.replace(/\D/g, '');
            window.open(`https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`, '_blank');
        }

        function createLoadingElement() {
            const div = document.createElement('div');
            div.className = 'absolute inset-0 bg-[#25D366] flex items-center justify-center rounded-[24px]';
            div.innerHTML = `<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;
            return div;
        }

        function removeLoading(type, btn, btnText, btnLoading, waBtnLoading) {
            if (btnLoading) {
                if (btnText) btnText.classList.remove('opacity-0');
                btnLoading.classList.add('hidden');
            } else if (waBtnLoading) {
                if (btnText) btnText.classList.remove('opacity-0');
                waBtnLoading.remove();
            }
        }

        function updateButtonState(type) {
            if (type === 'booking') {
                const btnText = document.getElementById('btnText');
                if (btnText) {
                    btnText.innerHTML = `💳 LIHAT INSTRUKSI BAYAR <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>`;
                    btnText.classList.add('animate-pulse');
                }
            } else if (type === 'whatsapp') {
                const waBtnText = document.getElementById('waBtnText');
                if (waBtnText) {
                    waBtnText.innerHTML = `<svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.305 1.652zm6.599-3.835c1.544.918 3.513 1.404 5.289 1.405 5.451 0 9.886-4.434 9.889-9.885.002-2.641-1.026-5.124-2.895-6.995-1.868-1.871-4.354-2.9-6.997-2.9-5.453 0-9.888 4.435-9.891 9.886-.001 2.04.536 4.032 1.554 5.768l-1.023 3.732 3.824-.999zm11.366-5.438c-.312-.156-1.848-.912-2.134-1.017-.286-.104-.494-.156-.701.156-.207.312-.804 1.017-.986 1.225-.182.208-.364.234-.676.078-.312-.156-1.318-.486-2.51-1.548-.928-.827-1.554-1.849-1.736-2.161-.182-.312-.02-.481.136-.636.141-.14.312-.364.468-.546.156-.182.208-.312.312-.52.104-.208.052-.39-.026-.546-.078-.156-.701-1.691-.961-2.313-.253-.607-.511-.524-.701-.534-.181-.01-.389-.012-.597-.012-.208 0-.546.078-.831.39-.286.312-1.091 1.067-1.091 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg> KONFIRMASI LAGI VIA WHATSAPP`;
                    waBtnText.classList.add('animate-pulse');
                }
            }
        }

        function showNotification(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-8 left-1/2 -translate-x-1/2 px-8 py-4 rounded-2xl text-white font-bold text-sm shadow-2xl z-[300] transition-all duration-500 transform translate-y-20 opacity-0`;
            toast.style.backgroundColor = type === 'success' ? '#10B981' : '#EF4444';
            toast.innerHTML = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.remove('translate-y-20', 'opacity-0');
            }, 100);

            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }

        // Initialize state based on session
        document.addEventListener('DOMContentLoaded', () => {
            const bClicks = parseInt(sessionStorage.getItem(BOOKING_CLICK_KEY));
            const wClicks = parseInt(sessionStorage.getItem(WHATSAPP_CLICK_KEY));
            const savedTripId = sessionStorage.getItem(SELECTED_TRIP_ID_KEY);
            currentOrderId = sessionStorage.getItem(ORDER_ID_KEY);
            
            if (savedTripId) {
                const tripBtn = document.querySelector(`.trip-btn[data-trip-id="${savedTripId}"]`);
                if (tripBtn) selectTrip(tripBtn);
            }
            
            if (bClicks === 1) updateButtonState('booking');
            if (wClicks === 1) updateButtonState('whatsapp');
            updateWishlistUI();
        });
    </script>
@endpush
