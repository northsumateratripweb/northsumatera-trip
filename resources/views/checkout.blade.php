@extends('layouts.main')

@section('title', 'Checkout - ' . ($tour->title ?? $car->name) . ' - NorthSumateraTrip')
@section('meta_description', 'Selesaikan pemesanan Anda dengan aman di NorthSumateraTrip. Pilih metode pembayaran dan konfirmasi detail perjalanan Anda untuk petualangan seru di Sumatera Utara.')

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-blue-100 dark:border-blue-800">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                Secure Checkout
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-8 uppercase">
                Selesaikan <span class="text-blue-700">Pembayaran</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium text-lg leading-relaxed">
                Silakan lakukan pembayaran sesuai instruksi di bawah ini untuk mengonfirmasi pesanan Anda.
            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-12 items-start mb-16">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-12">
                <!-- Summary Card -->
                <div class="bg-white dark:bg-slate-900 rounded-[48px] p-10 md:p-14 border border-slate-100 dark:border-slate-800 shadow-xl shadow-blue-500/5">
                    <h2 class="text-2xl font-black text-slate-900 dark:text-white mb-10 flex items-center gap-5 uppercase tracking-tight">
                        <span class="w-12 h-12 bg-blue-50 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 rounded-2xl flex items-center justify-center text-lg shadow-sm font-black">01</span>
                        Ringkasan Pesanan
                    </h2>
                    
                    <div class="space-y-6 mb-12">
                        @if(isset($tour))
                            <div class="flex justify-between items-center py-5 border-b border-slate-50 dark:border-slate-800/50">
                                <span class="text-slate-400 font-black uppercase text-[10px] tracking-widest">Paket Wisata</span>
                                <span class="font-bold text-slate-900 dark:text-white text-right">{{ $tour->title }}</span>
                            </div>
                            <div class="flex justify-between items-center py-5 border-b border-slate-50 dark:border-slate-800/50">
                                <span class="text-slate-400 font-black uppercase text-[10px] tracking-widest">Harga per Peserta</span>
                                <span class="font-bold text-slate-900 dark:text-white">Rp {{ number_format($tour->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-5 border-b border-slate-50 dark:border-slate-800/50">
                                <span class="text-slate-400 font-black uppercase text-[10px] tracking-widest">Jumlah Peserta</span>
                                <span class="font-bold text-slate-900 dark:text-white">{{ $booking->qty }} Orang</span>
                            </div>
                        @else
                            <div class="flex justify-between items-center py-5 border-b border-slate-50 dark:border-slate-800/50">
                                <span class="text-slate-400 font-black uppercase text-[10px] tracking-widest">Unit Mobil</span>
                                <span class="font-bold text-slate-900 dark:text-white text-right">{{ $car->name }}</span>
                            </div>
                            <div class="flex justify-between items-center py-5 border-b border-slate-50 dark:border-slate-800/50">
                                <span class="text-slate-400 font-black uppercase text-[10px] tracking-widest">Harga per Hari</span>
                                <span class="font-bold text-slate-900 dark:text-white">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-5 border-b border-slate-50 dark:border-slate-800/50">
                                <span class="text-slate-400 font-black uppercase text-[10px] tracking-widest">Durasi Sewa</span>
                                <span class="font-bold text-slate-900 dark:text-white">{{ $booking->duration_days }} Hari</span>
                            </div>
                        @endif
                    </div>

                    <div class="p-8 bg-slate-50 dark:bg-slate-800 rounded-[32px] flex flex-col md:flex-row items-center justify-between gap-6 border border-slate-100 dark:border-slate-700">
                        <span class="font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] text-[10px]">Total Pembayaran</span>
                        <span class="text-4xl font-black text-blue-700 dark:text-blue-400 tracking-tight">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Payment Card -->
                <div class="bg-blue-700 dark:bg-slate-900 rounded-[48px] p-10 md:p-14 shadow-2xl shadow-blue-500/20 text-white border-2 border-blue-600 dark:border-slate-800">
                    <h2 class="text-2xl font-black mb-10 flex items-center gap-5 uppercase tracking-tight">
                        <span class="w-12 h-12 bg-white/10 backdrop-blur-md text-white rounded-2xl flex items-center justify-center text-lg shadow-sm font-black border border-white/20">02</span>
                        Instruksi Transfer
                    </h2>
                    
                    @php $bankDetails = \App\Helpers\SettingsHelper::bankDetails(); @endphp

                    <div class="space-y-10">
                        <p class="text-white/70 font-medium leading-relaxed max-w-lg">
                            Silakan transfer pembayaran Anda ke salah satu rekening bank resmi berikut:
                        </p>

                        <div class="grid md:grid-cols-2 gap-6">
                            @foreach(['bank_1', 'bank_2'] as $bankKey)
                                @php $bank = $bankDetails[$bankKey]; @endphp
                                @if(!empty($bank['name']) && !empty($bank['account']))
                                    <div class="p-8 bg-white/5 dark:bg-white/5 rounded-[40px] border border-white/10 relative group transition-all hover:bg-white/10 cursor-pointer" onclick="copyToClipboard('{{ $bank['account'] }}', '{{ $bank['name'] }}')">
                                        <div class="flex justify-between items-start mb-6">
                                            <div class="px-4 py-1.5 bg-white text-blue-700 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-sm">
                                                {{ $bank['name'] }}
                                            </div>
                                            <button class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-white/50 group-hover:text-white transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                            </button>
                                        </div>
                                        <p class="text-2xl font-black mb-1 whitespace-nowrap tracking-tight">{{ $bank['account'] }}</p>
                                        <p class="text-[9px] font-black text-white/50 uppercase tracking-[0.2em]">a/n {{ $bank['holder'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        @if($bankDetails['qris'])
                            <div class="flex flex-col items-center gap-8 pt-8 border-t border-white/10">
                                <p class="text-[10px] font-black text-white/50 uppercase tracking-[0.2em]">Atau Scan QRIS Berikut:</p>
                                <div class="p-8 bg-white rounded-[40px] shadow-sm">
                                    <img src="{{ $bankDetails['qris'] }}" alt="QRIS" class="w-48 h-48 object-contain">
                                </div>
                            </div>
                        @endif

                        <div class="p-8 bg-white/5 rounded-[40px] border border-white/10 flex gap-6 items-start">
                            <div class="w-12 h-12 bg-amber-400 text-blue-900 rounded-2xl flex items-center justify-center shrink-0 shadow-lg font-black">!</div>
                            <div>
                                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] mb-2">Penting</h4>
                                <p class="text-sm text-white/70 font-medium leading-relaxed">
                                    Setelah melakukan transfer, silakan kirimkan bukti pembayaran melalui WhatsApp agar pesanan Anda dapat segera kami aktifkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8 lg:sticky lg:top-44">
                <div class="bg-white dark:bg-slate-900 p-10 rounded-[48px] border border-slate-100 dark:border-slate-800 shadow-2xl shadow-blue-500/5 transition-all">
                    <h2 class="text-xl font-black text-slate-900 dark:text-white mb-8 uppercase tracking-tight">Kontak Anda</h2>
                    <div class="space-y-6 mb-10">
                        @foreach([
                            'Nama Pemesan' => $booking->customer_name,
                            'Order ID' => $booking->external_id ?? '#' . $booking->id,
                            'WhatsApp' => $booking->phone
                        ] as $label => $value)
                            <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-slate-100 dark:border-slate-800">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ $label }}</p>
                                <p class="text-sm font-black text-slate-900 dark:text-white truncate">{{ $value }}</p>
                            </div>
                        @endforeach
                    </div>

                    <a href="https://wa.me/{{ preg_replace('/\D/', '', App\Helpers\SettingsHelper::whatsappNumber()) }}?text={{ urlencode("Halo NorthSumateraTrip 👋\n\nSaya ingin konfirmasi pembayaran.\n\n🧾 ID Pesanan: " . ($booking->external_id ?? $booking->id) . "\n💰 Total: Rp " . number_format($booking->total_price, 0, ',', '.') . "\n👤 Nama: " . $booking->customer_name . "\n\nMohon bantuannya ya! Terima kasih 🙏") }}" target="_blank" 
                       class="w-full py-6 bg-[#25D366] text-white rounded-full font-black text-xs uppercase tracking-widest hover:bg-[#128C7E] transition-all shadow-xl shadow-emerald-500/20 flex items-center justify-center gap-3 mb-6">
                        Konfirmasi WA
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.305 1.652zm6.599-3.835c1.544.918 3.513 1.404 5.289 1.405 5.451 0 9.886-4.434 9.889-9.885.002-2.641-1.026-5.124-2.895-6.995-1.868-1.871-4.354-2.9-6.997-2.9-5.453 0-9.888 4.435-9.891 9.886-.001 2.04.536 4.032 1.554 5.768l-1.023 3.732 3.824-.999zm11.366-5.438c-.312-.156-1.848-.912-2.134-1.017-.286-.104-.494-.156-.701.156-.207.312-.804 1.017-.986 1.225-.182.208-.364.234-.676.078-.312-.156-1.318-.486-2.51-1.548-.928-.827-1.554-1.849-1.736-2.161-.182-.312-.02-.481.136-.636.141-.14.312-.364.468-.546.156-.182.208-.312.312-.52.104-.208.052-.39-.026-.546-.078-.156-.701-1.691-.961-2.313-.253-.607-.511-.524-.701-.534-.181-.01-.389-.012-.597-.012-.208 0-.546.078-.831.39-.286.312-1.091 1.067-1.091 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                    </a>

                    <a href="{{ route('invoice.pdf', $booking) }}" class="flex items-center justify-center gap-3 w-full py-5 bg-white dark:bg-slate-800 border-2 border-slate-100 dark:border-slate-800 text-slate-400 dark:text-slate-500 rounded-full text-[10px] font-black uppercase tracking-widest hover:border-blue-700 hover:text-blue-700 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Download Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text, label) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Nomor Rekening ' + label + ' berhasil disalin!');
            }).catch(function() {
                alert('Gagal menyalin. Silakan salin manual.');
            });
        }
    </script>
@endsection
