@extends('layouts.main')

@section('title', 'Cek Status Booking | NorthSumateraTrip')

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-7xl mx-auto px-6 lg:px-8">
        <div class="max-w-xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-3 px-6 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-blue-100 dark:border-blue-800">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    Order Status
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-8 uppercase">
                    Cek <span class="text-blue-700">Status</span>
                </h1>
                <p class="text-slate-500 dark:text-slate-400 font-medium text-lg leading-relaxed">
                    Masukkan Order ID dan No. WhatsApp yang Anda gunakan saat melakukan pemesanan.
                </p>
            </div>

            <!-- Form -->
            <div class="bg-white dark:bg-slate-900 rounded-[48px] p-10 md:p-12 border border-slate-100 dark:border-slate-800 shadow-xl shadow-blue-500/5 transition-all mb-12">
                <form action="{{ route('booking.check') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1">Order ID</label>
                            <input type="text" name="order_id" required placeholder="Contoh: TRIP-0012345" value="{{ old('order_id') }}" 
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-8 py-5 text-sm font-bold focus:bg-white dark:focus:bg-slate-950 focus:ring-4 focus:ring-blue-700/5 focus:border-blue-700 outline-none transition-all dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1">No. WhatsApp / Telepon</label>
                            <input type="tel" name="phone" required placeholder="0812..." value="{{ old('phone') }}" 
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl px-8 py-5 text-sm font-bold focus:bg-white dark:focus:bg-slate-950 focus:ring-4 focus:ring-blue-700/5 focus:border-blue-700 outline-none transition-all dark:text-white">
                        </div>
                    </div>

                    @if(session('error'))
                        <div class="p-5 bg-rose-50 dark:bg-rose-900/30 border border-rose-100 dark:border-rose-800 rounded-3xl text-rose-600 dark:text-rose-400 text-xs font-bold flex items-center gap-4">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    <button type="submit" class="w-full py-6 bg-blue-700 hover:bg-blue-800 text-white rounded-full font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-blue-500/20 flex items-center justify-center gap-3">
                        Cek Status Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>

            <!-- Result -->
            @if(isset($booking))
                <div class="bg-white dark:bg-slate-900 rounded-[56px] border border-slate-100 dark:border-slate-800 shadow-2xl shadow-blue-500/5 overflow-hidden animate-in fade-in slide-in-from-bottom-10 duration-700">
                    
                    <!-- Header -->
                    <div class="p-10 md:p-12 bg-slate-50 dark:bg-slate-800/50 flex flex-col md:flex-row md:items-center justify-between gap-8 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Order ID</p>
                            <p class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">{{ $booking->external_id ?? '#' . $booking->id }}</p>
                        </div>
                        <div>
                            @php
                                $statusColors = [
                                    'paid'     => 'bg-emerald-50 text-emerald-600 border-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800',
                                    'pending'  => 'bg-amber-50 text-amber-600 border-amber-100 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800',
                                    'expired'  => 'bg-slate-100 text-slate-500 border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700',
                                    'failed'   => 'bg-rose-50 text-rose-600 border-rose-100 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800',
                                ];
                                $statusLabel = [
                                    'paid'    => 'Lunas ✓',
                                    'pending' => 'Pending',
                                    'expired' => 'Expired',
                                    'failed'  => 'Gagal',
                                ][$booking->payment_status] ?? strtoupper($booking->payment_status);
                            @endphp
                            <span class="px-6 py-2 rounded-2xl border {{ $statusColors[$booking->payment_status] ?? '' }} text-[10px] font-black uppercase tracking-widest block text-center">
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>

                    <div class="p-10 md:p-12 space-y-12">
                        <!-- Item -->
                        <div class="flex flex-col md:flex-row items-center gap-10">
                            @php 
                                $thumbnail = $booking->tour ? $booking->tour->thumbnail : ($booking->car ? $booking->car->image : '');
                                $title = $booking->tour ? $booking->tour->title : ($booking->car ? $booking->car->name : 'Trip Sumatera');
                            @endphp
                            <div class="w-32 h-32 rounded-[32px] overflow-hidden border border-slate-100 dark:border-slate-800 shadow-xl shadow-blue-500/5 flex-shrink-0">
                                <img src="{{ asset($thumbnail) }}" class="w-full h-full object-cover" alt="{{ $title }}">
                            </div>
                            <div class="text-center md:text-left">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">{{ $booking->tour ? 'Paket Wisata' : 'Sewa Mobil' }}</p>
                                <h3 class="text-2xl font-black text-slate-900 dark:text-white leading-tight mb-3 uppercase">{{ $title }}</h3>
                                <div class="flex flex-wrap justify-center md:justify-start gap-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    <span class="text-blue-700 dark:text-blue-400">{{ \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') }}</span>
                                    <div class="w-1.5 h-1.5 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                                    <span>{{ $booking->qty ?? 1 }} {{ $booking->tour ? 'Orang' : 'Hari' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-2 gap-6">
                            @foreach([
                                'Nama' => $booking->customer_name,
                                'Total' => 'Rp ' . number_format($booking->total_price, 0, ',', '.'),
                                'Tanggal' => $booking->created_at->format('d M Y'),
                                'Tipe' => strtoupper($booking->trip_type ?? 'Standard')
                            ] as $label => $value)
                                <div class="bg-slate-50 dark:bg-slate-900/50 rounded-3xl p-6 border border-slate-100 dark:border-slate-800">
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-2">{{ $label }}</p>
                                    <p class="text-sm font-black text-slate-900 dark:text-white truncate">{{ $value }}</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Progress -->
                        <div class="pt-4 px-4">
                            <div class="flex items-center">
                                @php
                                    $steps = [
                                        'Dipesan' => true,
                                        'Payment' => in_array($booking->payment_status, ['paid', 'pending']),
                                        'Lunas'   => $booking->payment_status === 'paid',
                                        'Selesai' => $booking->status === 'success',
                                    ];
                                    $stepKeys = array_keys($steps);
                                @endphp
                                @foreach($stepKeys as $index => $label)
                                    <div class="relative flex flex-col items-center flex-1">
                                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-500 {{ $steps[$label] ? 'bg-blue-700 text-white shadow-lg shadow-blue-500/20' : 'bg-slate-100 dark:bg-slate-800 text-slate-300 dark:text-slate-600' }} mb-4 z-10">
                                            @if($steps[$label]) 
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            @else 
                                                <span class="text-[10px]">{{ $index + 1 }}</span>
                                            @endif
                                        </div>
                                        <p class="text-[8px] font-black uppercase tracking-widest {{ $steps[$label] ? 'text-slate-900 dark:text-white' : 'text-slate-300 dark:text-slate-600' }}">{{ $label }}</p>
                                        
                                        @if($index < count($stepKeys) - 1)
                                            <div class="absolute left-[50%] top-5 w-full h-[3px] -z-0 {{ $steps[$stepKeys[$index+1]] ? 'bg-blue-700' : 'bg-slate-100 dark:bg-slate-800' }}"></div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Instructions -->
                        @if($booking->payment_status === 'pending')
                            @php $bankDetails = \App\Helpers\SettingsHelper::bankDetails(); @endphp
                            <div class="space-y-6 pt-6">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 text-center">Silakan Transfer Ke:</p>
                                @foreach(['bank_1', 'bank_2'] as $bankKey)
                                    @php $bank = $bankDetails[$bankKey] ?? null; @endphp
                                    @if($bank && !empty($bank['name']) && !empty($bank['account']))
                                        <div class="group p-8 rounded-[40px] border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-between hover:border-blue-700 transition-all cursor-pointer" onclick="copyToClipboard('{{ $bank['account'] }}', '{{ $bank['name'] }}')">
                                            <div class="flex items-center gap-8">
                                                <div class="w-20 h-12 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center border border-slate-100 dark:border-slate-800 font-extrabold text-xs text-blue-900 dark:text-blue-400 uppercase">
                                                    {{ $bank['name'] }}
                                                </div>
                                                <div>
                                                    <p class="text-lg font-black text-slate-900 dark:text-white leading-tight mb-1">{{ $bank['account'] }}</p>
                                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">a/n {{ $bank['holder'] }}</p>
                                                </div>
                                            </div>
                                            <svg class="w-6 h-6 text-slate-300 group-hover:text-blue-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                        </div>
                                    @endif
                                @endforeach

                                @if($bankDetails['qris'])
                                    <div class="text-center pt-4">
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Atau Scan QRIS Berikut:</p>
                                        <div class="inline-block p-10 bg-white dark:bg-slate-800 rounded-[56px] shadow-sm border border-slate-100 dark:border-slate-700">
                                            <img src="{{ $bankDetails['qris'] }}" alt="QRIS" class="w-48 h-48 mx-auto object-contain">
                                        </div>
                                    </div>
                                @endif

                                <a href="https://wa.me/{{ preg_replace('/\D/', '', App\Helpers\SettingsHelper::whatsappNumber()) }}?text={{ urlencode("Halo NorthSumateraTrip 👋\n\nSaya ingin konfirmasi pembayaran.\n\n🧾 ID Pesanan: " . ($booking->external_id ?? $booking->id) . "\n💰 Total: Rp " . number_format($booking->total_price, 0, ',', '.') . "\n👤 Nama: " . $booking->customer_name . "\n\nMohon bantuannya ya! Terima kasih 🙏") }}" target="_blank" 
                                   class="w-full py-6 bg-[#25D366] text-white rounded-full font-black text-xs uppercase tracking-widest transition-all shadow-2xl shadow-emerald-500/20 flex items-center justify-center gap-3">
                                    Konfirmasi via WhatsApp
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        @elseif($booking->payment_status === 'paid')
                            <div class="pt-6">
                                <a href="{{ route('invoice.show', $booking->id) }}" class="w-full py-6 bg-blue-700 hover:bg-blue-800 text-white rounded-full font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-blue-500/20 flex items-center justify-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Lihat & Download Invoice
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard(text, label) {
            navigator.clipboard.writeText(text).then(() => {
                alert(`Nomor Rekening ${label} berhasil disalin!`);
            }).catch(() => {
                alert('Gagal menyalin. Silakan salin manual.');
            });
        }
    </script>
@endsection