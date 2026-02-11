<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $post->title }} - NorthSumateraTrip</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
          darkMode: 'class',
          theme: {
            extend: {
              colors: {
                clifford: '#da373d',
              }
            }
          }
        }
    </script>
</head>
<body class="bg-[#0a0a0a] text-[#EDEDEC] antialiased line-height-relaxed">
    <nav class="p-6 border-b border-[#3E3E3A] glass sticky top-0 z-50">
        <div class="max-w-4xl mx-auto flex justify-between">
            <a href="/" class="text-[#FF4433] font-bold">← Beranda</a>
            <span class="text-[#706f6c] text-sm uppercase font-bold tracking-widest">{{ $post->category }}</span>
        </div>
    </nav>

    <article class="max-w-3xl mx-auto py-20 px-6">
        <header class="mb-12">
            <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight">{{ $post->title }}</h1>
            <div class="flex items-center gap-4 text-[#A1A09A] text-sm">
                <span>Diterbitkan pada {{ $post->created_at->format('d M, Y') }}</span>
            </div>
        </header>

        <img src="{{ asset('storage/' . $post->thumbnail) }}" class="w-full rounded-3xl mb-12 shadow-2xl border border-[#3E3E3A]">

        <div class="prose prose-invert prose-orange max-w-none text-[#A1A09A] text-lg leading-loose">
            {!! $post->content !!}
        </div>
        
        <div class="mt-20 pt-10 border-t border-[#3E3E3A]">
            <p class="text-sm text-[#706f6c]">Terima kasih telah membaca. Bagikan informasi ini jika bermanfaat!</p>
        </div>
    </article>
</body>
</html>
