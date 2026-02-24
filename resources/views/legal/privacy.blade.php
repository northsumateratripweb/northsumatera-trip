@extends('layouts.main')

@section('title', 'Kebijakan Privasi | NorthSumateraTrip')

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-4xl mx-auto px-6 lg:px-8">
        <!-- Header -->
        <header class="mb-16 text-center">
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-blue-100 dark:border-blue-800">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                Privacy Protection
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-4 uppercase">
                Kebijakan <span class="text-blue-700">Privasi</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium text-lg leading-relaxed">
                Bagaimana kami menjaga dan melindungi data pribadi Anda.
            </p>
        </header>

        <!-- Privacy Content -->
        <div class="bg-white dark:bg-slate-900 rounded-[64px] p-10 md:p-16 border border-slate-100 dark:border-slate-800 shadow-2xl shadow-blue-500/5 relative overflow-hidden group">
            <div class="relative z-10 space-y-16">
                <!-- Section 1 -->
                <section>
                    <h2 class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                        <span class="w-8 h-px bg-blue-100 dark:bg-blue-900"></span>
                        01. Data yang Dikumpulkan
                    </h2>
                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-[1.8] font-medium">
                        Kami mengumpulkan informasi yang Anda berikan secara sukarela saat melakukan pemesanan, seperti nama lengkap, alamat email, nomor telepon/WhatsApp, dan detail pembayaran yang diperlukan untuk memproses pesanan Anda.
                    </p>
                </section>

                <!-- Section 2 -->
                <section>
                    <h2 class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-[0.3em] mb-8 flex items-center gap-4">
                        <span class="w-8 h-px bg-blue-100 dark:bg-blue-900"></span>
                        02. Penggunaan Informasi
                    </h2>
                    <div class="space-y-6">
                        @foreach([
                            'Memproses pemesanan dan verifikasi pembayaran secara aman.',
                            'Mengirimkan invoice, tiket, dan detail perjalanan Anda.',
                            'Memberikan dukungan teknis dan layanan bantuan pelanggan.'
                        ] as $item)
                        <div class="flex items-start gap-6 p-6 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-slate-100 dark:border-slate-800">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-lg text-slate-600 dark:text-slate-400 font-medium leading-relaxed">{{ $item }}</span>
                        </div>
                        @endforeach
                    </div>
                </section>

                <!-- Section 3 -->
                <section>
                    <h2 class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                        <span class="w-8 h-px bg-blue-100 dark:bg-blue-900"></span>
                        03. Keamanan Data
                    </h2>
                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-[1.8] font-medium">
                        Kami berkomitmen untuk menjaga keamanan data pribadi Anda. Kami menggunakan teknologi enkripsi SSL dan sistem keamanan standar industri untuk melindungi informasi Anda selama proses transaksi berlangsung.
                    </p>
                </section>

                <!-- Section 4 -->
                <section>
                    <h2 class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                        <span class="w-8 h-px bg-blue-100 dark:bg-blue-900"></span>
                        04. Berbagi Informasi
                    </h2>
                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-[1.8] font-medium">
                        Kami tidak akan menjual atau menyewakan informasi pribadi Anda kepada pihak manapun. Data Anda hanya dibagikan dengan mitra resmi kami (seperti hotel) demi kelancaran operasional perjalanan Anda.
                    </p>
                </section>
            </div>

            <!-- Footer Legal -->
            <div class="mt-20 pt-10 border-t border-slate-100 dark:border-slate-800 flex flex-col md:flex-row items-center justify-between gap-6">
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">Pembaruan: 12 Feb 2026</span>
                <div class="flex items-center gap-8">
                    <a href="{{ route('legal.terms') }}" class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest hover:underline">Ketentuan</a>
                    <div class="w-1.5 h-1.5 rounded-full bg-slate-100 dark:bg-slate-800"></div>
                    <a href="/" class="text-[10px] font-black text-slate-900 dark:text-white uppercase tracking-widest hover:text-blue-700 transition-colors">Beranda</a>
                </div>
            </div>
        </div>
    </div>
@endsection
