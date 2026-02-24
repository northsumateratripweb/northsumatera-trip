@extends('layouts.main')

@section('title', '500 - Kesalahan Sistem')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6">
    <div class="text-center">
        <div class="relative inline-block mb-8">
            <h1 class="text-[150px] md:text-[200px] font-black text-slate-100 leading-none">500</h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <p class="text-2xl md:text-3xl font-black text-slate-900 uppercase tracking-widest">Ada Masalah</p>
            </div>
        </div>
        <p class="text-slate-500 text-lg mb-12 max-w-md mx-auto">
            Maaf, server kami sedang mengalami kendala teknis. Kami akan segera memperbaikinya untuk Anda.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="/" class="btn-primary text-white font-black py-4 px-8 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Kembali ke Beranda
            </a>
            <button onclick="window.location.reload()" class="bg-white text-slate-900 border border-slate-200 font-black py-4 px-8 rounded-2xl transition-all hover:bg-slate-50">
                Coba Lagi
            </button>
        </div>
    </div>
</div>
@endsection
