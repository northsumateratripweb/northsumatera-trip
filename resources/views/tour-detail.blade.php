<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tour->title }} - NorthSumateraTrip</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
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
    <nav class="p-6 bg-[#161615]/80 backdrop-blur-md sticky top-0 z-50 border-b border-[#3E3E3A]">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold tracking-tighter text-[#FF4433]">
                ← Kembali
            </a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 md:px-8 py-12">
        <h1 class="text-4xl md:text-5xl font-black mb-6">{{ $tour->title }}</h1>
        
        <div class="rounded-3xl overflow-hidden mb-10 border border-[#3E3E3A]">
            <img src="{{ asset('storage/' . $tour->thumbnail) }}" class="w-full aspect-video object-cover">
        </div>

        <div class="flex flex-col lg:flex-row gap-10 mt-10">
            <div class="w-full lg:w-2/3">
                <div class="prose prose-invert max-w-none">
                    <h2 class="text-2xl font-bold text-white mb-4 italic">Rincian Perjalanan</h2>
                    <div class="text-[#A1A09A]" data-description>
                        {!! $tour->description !!}
                    </div>
                    
                    <hr class="border-[#3E3E3A] my-10">
                    
                    <h2 class="text-2xl font-bold text-white mb-4 italic">Itinerari / Jadwal</h2>
                    <div class="text-[#A1A09A]" data-itinerary>
                        {!! $tour->itinerary !!}
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/3">
                <div class="sticky top-24 bg-[#161615] p-8 rounded-[32px] border border-[#3E3E3A] shadow-2xl">
                    <div class="mb-8">
                        <p class="text-[#A1A09A] text-xs uppercase tracking-[0.2em] font-bold mb-2">Harga Paket Mulai</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-black text-[#FF4433]">Rp {{ number_format($tour->price, 0, ',', '.') }}</span>
                            <span class="text-[#706f6c] text-sm">/pax</span>
                        </div>
                    </div>

                    <div class="space-y-4 mb-10 border-y border-[#3E3E3A] py-6">
                        <div class="flex items-center gap-3 text-sm text-[#EDEDEC]">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            Status: Tersedia (Pre-Order)
                        </div>
                        <div class="flex items-center gap-3 text-sm text-[#A1A09A]">
                            <svg class="w-5 h-5 text-[#FF4433]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Termasuk Driver & BBM
                        </div>
                    </div>

                    <div class="flex flex-col gap-4">
                        <button id="pay-button" class="w-full bg-[#1e88e5] hover:bg-[#1565c0] text-white font-black py-5 rounded-2xl transition-all transform hover:scale-[1.03] flex items-center justify-center gap-3 shadow-xl shadow-blue-900/20">
                            <span class="text-lg">BOOK NOW</span>
                        </button>

                        <a href="https://wa.me/{{ env('WHATSAPP_NUMBER') }}?text=Halo Ridho, saya ingin tanya paket *{{ $tour->title }}*" 
                           target="_blank"
                           class="w-full bg-[#43A047] hover:bg-[#2e7d32] text-white font-black py-5 rounded-2xl transition-all transform hover:scale-[1.03] text-center flex items-center justify-center gap-3 shadow-xl shadow-green-900/20">
                            <span class="text-lg">WHATSAPP</span>
                        </a>
                    </div>
                    
                    <p class="text-[10px] text-[#706f6c] text-center mt-6 uppercase tracking-widest font-bold">Aman • Terpercaya • Instan</p>
                </div>
            </div>
        </div>
    </main>

    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-[#161615] border-t border-[#3E3E3A] p-4 z-[100] flex gap-3 shadow-[0_-10px_40px_rgba(0,0,0,0.8)]">
        <a href="https://wa.me/{{ env('WHATSAPP_NUMBER') }}?text=Tanya Paket {{ $tour->title }}" class="flex-1 bg-[#43A047] text-white py-4 rounded-xl font-black text-center text-sm">WHATSAPP</a>
        <button onclick="document.getElementById('pay-button').click()" class="flex-1 bg-[#1e88e5] text-white py-4 rounded-xl font-black text-sm text-center">BOOK NOW</button>
    </div>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // Pastikan snapToken dikirim dari controller
            window.snap.pay('{{ $snapToken ?? "" }}', {
                onSuccess: function(result){ alert("Pembayaran Berhasil!"); window.location.href = "/"; },
                onPending: function(result){ alert("Menunggu pembayaran..."); },
                onError: function(result){ alert("Pembayaran Gagal!"); }
            });
        });
    </script>