@extends('layouts.main')

@section('title', 'Syarat & Ketentuan | NorthSumateraTrip')

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-4xl mx-auto px-6 lg:px-8">
        <!-- Header -->
        <header class="mb-16 text-center">
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-blue-100 dark:border-blue-800">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                Legal Agreement
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-4 uppercase">
                Syarat & <span class="text-blue-700">Ketentuan</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium text-lg leading-relaxed">
                Mohon baca dengan teliti sebelum menggunakan layanan kami.
            </p>
        </header>

        <!-- Terms Content -->
        <div class="bg-white dark:bg-slate-900 rounded-[64px] p-10 md:p-16 border border-slate-100 dark:border-slate-800 shadow-2xl shadow-blue-500/5 relative overflow-hidden group">
            <div class="relative z-10 space-y-16">
                <!-- Section 1 -->
                <section>
                    <h2 class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                        <span class="w-8 h-px bg-blue-100 dark:bg-blue-900"></span>
                        01. Pendahuluan
                    </h2>
                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-[1.8] font-medium">
                        Selamat datang di NorthSumateraTrip. Dengan mengakses dan menggunakan layanan kami, Anda dianggap telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan yang berlaku.
                    </p>
                </section>

                <!-- Section 2 -->
                <section>
                    <h2 class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-[0.3em] mb-8 flex items-center gap-4">
                        <span class="w-8 h-px bg-blue-100 dark:bg-blue-900"></span>
                        02. Pemesanan & Pembayaran
                    </h2>
                    <div class="space-y-6">
                        @foreach([
                            'Pemesanan dianggap sah setelah pelanggan menerima konfirmasi dan melakukan pembayaran sesuai tagihan.',
                            'Pembayaran dilakukan melalui transfer bank resmi atau scan QRIS yang informasinya tersedia setelah proses booking.',
                            'Harga dapat berubah sewaktu-waktu sebelum konfirmasi pemesanan dilakukan oleh pihak admin.'
                        ] as $item)
                        <div class="flex items-start gap-6 p-6 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-slate-100 dark:border-slate-800 transition-colors hover:border-blue-100 dark:hover:border-blue-900">
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
                    <h2 class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-[0.3em] mb-8 flex items-center gap-4">
                        <span class="w-8 h-px bg-blue-100 dark:bg-blue-900"></span>
                        03. Pembatalan (Refund)
                    </h2>
                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-[1.8] font-medium mb-10">
                        Kebijakan pembatalan bergantung pada masing-masing paket wisata. Secara umum berlaku aturan:
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="p-10 bg-blue-50 dark:bg-blue-900/20 rounded-[40px] border border-blue-100 dark:border-blue-900/30">
                            <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-4">Lebih dari 7 Hari</p>
                            <p class="text-4xl font-black text-blue-700 dark:text-blue-400 tracking-tight leading-none mb-4">Refund 50%</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium leading-relaxed">Dari total biaya yang telah dibayarkan sebelumnya.</p>
                        </div>
                        <div class="p-10 bg-slate-50 dark:bg-slate-800/50 rounded-[40px] border border-slate-100 dark:border-slate-800">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-4">Kurang dari 3 Hari</p>
                            <p class="text-4xl font-black text-rose-500 tracking-tight leading-none mb-4 uppercase">No Refund</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium leading-relaxed">Pembatalan tidak dapat dilakukan pengembalian dana.</p>
                        </div>
                    </div>
                </section>

                <!-- Section 4 -->
                <section>
                    <h2 class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                        <span class="w-8 h-px bg-blue-100 dark:bg-blue-900"></span>
                        04. Lainnya
                    </h2>
                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-[1.8] font-medium">
                        NorthSumateraTrip tidak bertanggung jawab atas kehilangan barang pribadi atau gangguan perjalanan yang disebabkan oleh faktor alam (force majeure). Kami berhak mengubah syarat ini kapan saja tanpa pemberitahuan.
                    </p>
                </section>
            </div>

            <!-- Footer Legal -->
            <div class="mt-20 pt-10 border-t border-slate-100 dark:border-slate-800 flex flex-col md:flex-row items-center justify-between gap-6">
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">Pembaruan: 12 Feb 2026</span>
                <div class="flex items-center gap-8">
                    <a href="{{ route('legal.privacy') }}" class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest hover:underline">Privasi</a>
                    <div class="w-1.5 h-1.5 rounded-full bg-slate-100 dark:bg-slate-800"></div>
                    <a href="/" class="text-[10px] font-black text-slate-900 dark:text-white uppercase tracking-widest hover:text-blue-700 transition-colors">Beranda</a>
                </div>
            </div>
        </div>
    </div>
@endsection
