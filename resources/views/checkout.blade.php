<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - {{ $tour->title }} - NorthSumateraTrip</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
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
            <span class="text-[#706f6c] text-sm uppercase font-bold tracking-widest">Checkout</span>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto py-20 px-6">
        <h1 class="text-4xl font-black mb-8">Checkout Paket {{ $tour->title }}</h1>

        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Order Summary -->
            <div class="bg-[#161615] p-8 rounded-3xl border border-[#3E3E3A]">
                <h2 class="text-2xl font-bold mb-6">Ringkasan Pesanan</h2>
                <div class="space-y-4 mb-6 pb-6 border-b border-[#3E3E3A]">
                    <div class="flex justify-between">
                        <span class="text-[#A1A09A]">Paket</span>
                        <span class="font-bold">{{ $tour->title }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#A1A09A]">Harga per Peserta</span>
                        <span class="font-bold">Rp {{ number_format($tour->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#A1A09A]">Jumlah Peserta</span>
                        <span class="font-bold">{{ $booking->qty }}</span>
                    </div>
                </div>
                <div class="flex justify-between text-lg">
                    <span class="font-bold">Total</span>
                    <span class="text-[#FF4433] font-black">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Payment Button -->
            <div class="bg-[#161615] p-8 rounded-3xl border border-[#3E3E3A]">
                <h2 class="text-2xl font-bold mb-6">Pembayaran</h2>
                <div class="space-y-4 mb-8">
                    <div>
                        <p class="text-sm text-[#A1A09A] mb-2">Nama Pemesan</p>
                        <p class="font-bold">{{ $booking->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-[#A1A09A] mb-2">Email</p>
                        <p class="font-bold">{{ $booking->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-[#A1A09A] mb-2">Nomor HP</p>
                        <p class="font-bold">{{ $booking->phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-[#A1A09A] mb-2">Tanggal Perjalanan</p>
                        <p class="font-bold">{{ \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') }}</p>
                    </div>
                </div>

                <button id="pay-button" class="w-full bg-[#FF4433] hover:bg-red-600 text-white font-bold py-4 rounded-xl transition-all duration-300 text-lg">
                    Bayar Sekarang
                </button>
                <p class="text-center text-[#A1A09A] text-sm mt-4">Anda akan diarahkan ke halaman pembayaran Midtrans yang aman</p>
            </div>
        </div>

        <!-- Location & Description -->
        <div class="bg-[#161615] p-8 rounded-3xl border border-[#3E3E3A]">
            <h2 class="text-2xl font-bold mb-4">Detail Paket</h2>
            <p class="text-[#A1A09A] mb-4"><strong>Lokasi:</strong> {{ $tour->location }}</p>
            <div class="prose prose-invert max-w-none text-[#A1A09A]">
                {!! $tour->description !!}
            </div>
        </div>
    </main>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    console.log("Payment Success", result);
                    alert("Pembayaran berhasil! ID transaksi: " + result.transaction_id);
                    // Redirect ke halaman sukses atau dashboard
                    window.location.href = '/payment-success/' + {{ $booking->id }};
                },
                onPending: function(result) {
                    console.log("Payment Pending", result);
                    alert("Pembayaran menunggu verifikasi...");
                },
                onError: function(result) {
                    console.log("Payment Error", result);
                    alert("Pembayaran gagal! Silakan coba lagi.");
                },
                onClose: function() {
                    console.log("Customer closed the popup without finishing the payment");
                }
            });
        };
    </script>
</body>
</html>
