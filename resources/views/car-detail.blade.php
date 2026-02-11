<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $car->name }} - NorthSumateraTrip</title>
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
<body class="bg-[#0a0a0a] text-[#EDEDEC] antialiased">
    <nav class="p-6 border-b border-[#3E3E3A] glass sticky top-0 z-50">
        <div class="max-w-4xl mx-auto flex justify-between">
            <a href="/" class="text-[#FF4433] font-bold">← Beranda</a>
            <span class="text-[#706f6c] text-sm uppercase font-bold tracking-widest">Rental Mobil</span>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto py-20 px-6">
        <h1 class="text-4xl font-black mb-6">{{ $car->name }}</h1>
        <img src="{{ asset('storage/' . $car->thumbnail) }}" class="w-full rounded-3xl mb-10 border border-[#3E3E3A]">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10 text-center">
            <div class="bg-[#161615] p-4 rounded-xl border border-[#3E3E3A]">
                <p class="text-xs text-[#706f6c] uppercase">Kapasitas</p>
                <p class="font-bold">{{ $car->capacity }} Kursi</p>
            </div>
            <div class="bg-[#161615] p-4 rounded-xl border border-[#3E3E3A]">
                <p class="text-xs text-[#706f6c] uppercase">Harga / Hari</p>
                <p class="font-bold">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</p>
            </div>
            <div class="bg-[#161615] p-4 rounded-xl border border-[#3E3E3A]">
                <p class="text-xs text-[#706f6c] uppercase">Transmisi</p>
                <p class="font-bold">{{ $car->transmission ?? '-' }}</p>
            </div>
            <div class="bg-[#161615] p-4 rounded-xl border border-[#3E3E3A]">
                <p class="text-xs text-[#706f6c] uppercase">Ketersediaan</p>
                <p class="font-bold">{{ $car->is_available ? 'Tersedia' : 'Tidak Tersedia' }}</p>
            </div>
        </div>
        <a href="https://wa.me/{{ env('WHATSAPP_NUMBER') }}?text=Sewa%20{{ urlencode($car->name) }}" 
           class="block w-full text-center bg-[#FF4433] py-4 rounded-xl font-bold">Booking Mobil Sekarang</a>
    </main>
</body>
</html>
