@extends('layouts.main')

@section('title', 'Blog & Artikel Wisata - NorthSumateraTrip')
@section('meta_description', 'Temukan tips perjalanan, destinasi tersembunyi, dan panduan wisata terlengkap di Sumatera Utara melalui blog resmi kami.')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [{
    "@@type": "ListItem",
    "position": 1,
    "name": "Home",
    "item": "{{ route('home') }}"
  },{
    "@@type": "ListItem",
    "position": 2,
    "name": "Blog",
    "item": "{{ url()->current() }}"
  }]
}
</script>
@endpush

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-24 max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-blue-100 dark:border-blue-800">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                Wawasan Wisata
            </div>
            <h1 class="text-4xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-10 uppercase">
                {{ __t('blog_title_1') ?? 'Blog' }} <span class="text-blue-700">{{ __t('blog_title_2') ?? '& Artikel' }}</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium text-lg md:text-xl leading-relaxed">
                {{ __t('blog_subtitle') ?? 'Temukan inspirasi dan panduan lengkap untuk petualangan Anda berikutnya di tanah Batak.' }}
            </p>
        </div>

        <!-- Blog Grid -->
        <div class="relative">
            <!-- Decorative Blobs -->
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-100/30 dark:bg-blue-900/10 blur-[120px] rounded-full"></div>
            <div class="absolute top-1/2 -right-24 w-80 h-80 bg-indigo-100/30 dark:bg-indigo-900/10 blur-[100px] rounded-full"></div>

            @if($posts->count() > 0)
                <!-- Featured Post -->
                @php $featured = $posts->first(); @endphp
                <div class="mb-24 reveal">
                    <article class="group relative bg-white dark:bg-slate-900 rounded-[64px] overflow-hidden border border-slate-100 dark:border-slate-800 flex flex-col lg:flex-row gap-12 p-8 transition-all duration-700 hover:shadow-2xl hover:shadow-blue-500/10">
                        <div class="w-full lg:w-1/2 aspect-[16/10] overflow-hidden rounded-[48px] relative">
                            <img src="{{ $featured->image_url }}" alt="{{ $featured->title }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-105">
                            <div class="absolute top-8 left-8">
                                <span class="bg-blue-600 text-white px-6 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl">
                                    Unggulan
                                </span>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/2 flex flex-col justify-center py-6 px-4">
                            <div class="flex items-center gap-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-8">
                                <span class="text-blue-600">{{ $featured->category }}</span>
                                <div class="w-1.5 h-1.5 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                                <span>{{ $featured->created_at->format('d M, Y') }}</span>
                            </div>
                            <h2 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white mb-8 leading-tight tracking-tight uppercase">
                                <a href="{{ route('post.show', $featured->slug) }}" class="hover:text-blue-700 transition-colors">
                                    {{ $featured->title }}
                                </a>
                            </h2>
                            <p class="text-slate-500 dark:text-slate-400 font-medium text-lg leading-relaxed mb-12 line-clamp-3">
                                {{ Str::limit(strip_tags($featured->content), 200) }}
                            </p>
                            <div>
                                <a href="{{ route('post.show', $featured->slug) }}" class="inline-flex items-center gap-6 px-10 py-5 bg-slate-900 dark:bg-slate-800 text-white rounded-full font-black text-[10px] uppercase tracking-widest hover:bg-blue-700 transition-all group/btn">
                                    Baca Artikel
                                    <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 md:gap-16">
                @foreach($posts->skip(1) as $post)
                    <article class="group flex flex-col reveal">
                        <div class="relative aspect-[16/10] overflow-hidden rounded-[48px] bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 p-3 mb-10 transition-all duration-700 hover:shadow-2xl hover:shadow-blue-500/10">
                            <div class="w-full h-full overflow-hidden rounded-[40px] relative">
                                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-110" loading="lazy">
                                <div class="absolute top-6 left-6">
                                    <span class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md text-blue-700 dark:text-blue-400 px-5 py-2 rounded-2xl text-[9px] font-black uppercase tracking-widest shadow-xl border border-white/20 dark:border-slate-800">
                                        {{ $post->category }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 px-4">
                            <span>{{ $post->created_at->format('d M, Y') }}</span>
                            <div class="w-1.5 h-1.5 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                            <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} Min Read</span>
                        </div>
    
                        <h2 class="text-2xl md:text-3xl font-black text-slate-900 dark:text-white mb-6 leading-tight tracking-tight uppercase group-hover:text-blue-700 transition-colors px-4">
                            <a href="{{ route('post.show', $post->slug) }}">
                                {{ $post->title }}
                            </a>
                        </h2>
                        
                        <p class="text-slate-500 dark:text-slate-400 font-medium leading-[1.8] mb-10 px-4 line-clamp-3">
                            {{ Str::limit(strip_tags($post->content), 120) }}
                        </p>
    
                        <div class="mt-auto px-4">
                            <a href="{{ route('post.show', $post->slug) }}" class="inline-flex items-center gap-4 text-[10px] font-black uppercase tracking-widest text-slate-900 dark:text-white hover:text-blue-700 dark:hover:text-blue-400 transition-colors group/link">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </article>
                @endforeach

                @if($posts->count() == 0)
                    <div class="col-span-full py-40 text-center bg-white dark:bg-slate-900 rounded-[64px] border border-slate-100 dark:border-slate-800">
                        <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-3xl flex items-center justify-center mx-auto mb-8 text-slate-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <p class="text-slate-400 font-black uppercase text-xs tracking-widest">{{ __t('blog_empty_state') ?? 'Belum ada artikel' }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="mt-24 flex justify-center">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
@endsection
