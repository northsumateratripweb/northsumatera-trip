@extends('layouts.main')

@section('title', $post->title . ' - NorthSumateraTrip')
@section('meta_description', Str::limit(strip_tags($post->content), 160))
@section('meta_image', $post->image_url)

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org/",
  "@@type": "BlogPosting",
  "headline": "{{ $post->title }}",
  "image": "{{ $post->image_url }}",
  "author": {
    "@@type": "Organization",
    "name": "NorthSumateraTrip"
  },
  "publisher": {
    "@@type": "Organization",
    "name": "NorthSumateraTrip",
    "logo": {
      "@@type": "ImageObject",
      "url": "{{ App\Helpers\SettingsHelper::logo() ?? asset('images/logo.png') }}"
    }
  },
  "datePublished": "{{ $post->created_at->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "description": "{{ Str::limit(strip_tags($post->content), 160) }}"
}
</script>
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
    "item": "{{ route('blog.index') }}"
  },{
    "@@type": "ListItem",
    "position": 3,
    "name": "{{ $post->title }}",
    "item": "{{ url()->current() }}"
  }]
}
</script>
@endpush

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-4xl mx-auto px-6 lg:px-8 relative">
        <!-- Decorative Blobs -->
        <div class="absolute top-0 right-0 w-[60%] h-[60%] bg-blue-100/30 dark:bg-blue-900/10 blur-[120px] rounded-full -translate-y-1/2 translate-x-1/2 opacity-50"></div>
        <div class="absolute bottom-1/4 left-0 w-[50%] h-[50%] bg-indigo-100/20 dark:bg-indigo-900/5 blur-[100px] rounded-full translate-y-1/2 -translate-x-1/2 opacity-30"></div>

        <!-- Header -->
        <header class="mb-16 text-center reveal">
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-blue-100 dark:border-blue-800">
                {{ $post->category }}
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white tracking-tight leading-[1.1] mb-8 uppercase">
                {{ $post->title }}
            </h1>
            <div class="flex items-center justify-center gap-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                <span>{{ $post->created_at->format('d M, Y') }}</span>
                <div class="w-1.5 h-1.5 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} Min Read</span>
            </div>
        </header>

        <!-- Featured Image -->
        <div class="mb-20 relative group rounded-[64px] overflow-hidden bg-white dark:bg-slate-900 shadow-2xl shadow-blue-500/5 border border-slate-100 dark:border-slate-800 p-3">
            <div class="aspect-video overflow-hidden rounded-[54px] relative">
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-[2s] group-hover:scale-105">
            </div>
        </div>

        <!-- Content -->
        <div class="prose prose-slate dark:prose-invert max-w-none prose-p:text-slate-600 dark:prose-p:text-slate-400 prose-p:text-lg prose-p:leading-[1.8] prose-p:font-medium prose-headings:font-black prose-headings:text-slate-900 dark:prose-headings:text-white prose-headings:uppercase prose-headings:tracking-tight prose-strong:text-slate-900 dark:prose-strong:text-white mb-24">
            {!! $post->content !!}
        </div>
        
        <!-- Footer -->
        <footer class="pt-16 border-t border-slate-100 dark:border-slate-800">
            <div class="flex flex-col items-center gap-10">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em] text-center">Bagikan informasi ini jika bermanfaat!</p>
                
                <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-4 px-10 py-5 bg-slate-900 dark:bg-white text-white dark:text-slate-950 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 dark:hover:text-white transition-all transform hover:-translate-y-1 shadow-2xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Blog
                </a>
            </div>
        </footer>
    </div>
@endsection
