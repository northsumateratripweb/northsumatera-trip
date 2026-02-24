@extends('layouts.main')

@section('title', 'Kontak Kami - NorthSumateraTrip')
@section('meta_description', 'Hubungi tim NorthSumateraTrip untuk bantuan pemesanan paket wisata, sewa mobil, atau kustomisasi perjalanan Anda di Sumatera Utara. Layanan pelanggan 24/7.')

@section('content')
    <div class="pt-36 md:pt-44 pb-24 max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Decorative Blobs -->
        <div class="absolute top-0 right-0 w-[60%] h-[60%] bg-blue-100/30 dark:bg-blue-900/10 blur-[120px] rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-1/4 left-0 w-[50%] h-[50%] bg-indigo-100/20 dark:bg-indigo-900/5 blur-[100px] rounded-full translate-y-1/2 -translate-x-1/2"></div>

        <!-- Header -->
        <div class="text-center mb-24 max-w-3xl mx-auto reveal">
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-blue-100 dark:border-blue-800">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                {{ __t('contact_badge') ?? 'Get In Touch' }}
            </div>
            <h1 class="text-4xl md:text-7xl font-black text-slate-900 dark:text-white tracking-tight leading-none mb-10 uppercase">
                {{ __t('contact_title_1') ?? 'Hubungi' }} <span class="text-blue-700">{{ __t('contact_title_2') ?? 'Kami' }}</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium text-lg md:text-xl leading-relaxed">
                {{ __t('contact_subtitle') ?? 'Punya pertanyaan atau ingin kustomisasi paket? Tim kami siap membantu Anda 24/7.' }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 md:gap-24 items-start">
            <!-- Contact Info -->
            <div class="space-y-8">
                @if(session('success'))
                    <div class="p-8 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-[40px] flex items-center gap-6 animate-in fade-in slide-in-from-top-4 duration-500">
                        <div class="w-14 h-14 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-emerald-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <p class="text-emerald-900 dark:text-emerald-100 font-black uppercase text-xs tracking-widest">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 gap-6">
                    @php
                        $contactInfo = [
                            [
                                'label' => 'WhatsApp Kami',
                                'value' => App\Helpers\SettingsHelper::whatsappNumber(),
                                'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>',
                                'delay' => '0'
                            ],
                            [
                                'label' => 'Email Kami',
                                'value' => 'info@northsumateratrip.com',
                                'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
                                'delay' => '100'
                            ],
                            [
                                'label' => 'Lokasi Kami',
                                'value' => 'Medan, Sumatera Utara',
                                'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>',
                                'delay' => '200'
                            ]
                        ];
                    @endphp

                    @foreach($contactInfo as $info)
                    <div class="group p-8 bg-white dark:bg-slate-900 rounded-[40px] border border-slate-100 dark:border-slate-800 transition-all duration-700 hover:shadow-2xl hover:shadow-blue-500/10 flex items-center gap-8">
                        <div class="w-16 h-16 bg-blue-50 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 rounded-2xl flex items-center justify-center transition-all duration-700 group-hover:bg-blue-700 group-hover:text-white group-hover:rotate-[360deg] shadow-sm">
                            {!! $info['icon'] !!}
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-2">{{ $info['label'] }}</p>
                            <p class="text-xl font-black text-slate-900 dark:text-white tracking-tight">{{ $info['value'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white dark:bg-slate-900 rounded-[56px] p-10 md:p-14 border border-slate-100 dark:border-slate-800 shadow-2xl shadow-blue-500/5">
                <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-10 tracking-tight uppercase">{{ __t('contact_form_title') ?? 'Kirim Pesan' }}</h2>
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-8" x-data="{ loading: false }" @submit="loading = true">
                    @csrf
                    <!-- Honeypot -->
                    <div style="display: none;"><input type="text" name="hp_field"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __t('contact_label_name') ?? 'Nama' }}</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Anda" class="w-full px-8 py-5 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl text-sm font-bold focus:bg-white dark:focus:bg-slate-950 focus:ring-4 focus:ring-blue-500/5 focus:border-blue-700 transition-all outline-none dark:text-white">
                        </div>
                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __t('contact_label_email') ?? 'Email' }}</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" class="w-full px-8 py-5 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl text-sm font-bold focus:bg-white dark:focus:bg-slate-950 focus:ring-4 focus:ring-blue-500/5 focus:border-blue-700 transition-all outline-none dark:text-white">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __t('contact_label_subject') ?? 'Subjek' }}</label>
                        <div class="relative">
                            <select name="subject" class="w-full px-8 py-5 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl text-sm font-bold focus:bg-white dark:focus:bg-slate-950 focus:ring-4 focus:ring-blue-500/5 focus:border-blue-700 transition-all outline-none appearance-none dark:text-white">
                                <option value="Tanya Paket Wisata">{{ __t('contact_subject_option_1') ?? 'Tanya Paket Wisata' }}</option>
                                <option value="Sewa Mobil">{{ __t('contact_subject_option_2') ?? 'Sewa Mobil' }}</option>
                                <option value="Kustom Perjalanan">{{ __t('contact_subject_option_3') ?? 'Kustom Perjalanan' }}</option>
                                <option value="Kerjasama">{{ __t('contact_subject_option_4') ?? 'Kerjasama' }}</option>
                                <option value="Lainnya">{{ __t('contact_subject_option_5') ?? 'Lainnya' }}</option>
                            </select>
                            <div class="absolute right-8 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ __t('contact_label_message') ?? 'Pesan' }}</label>
                        <textarea name="message" rows="5" placeholder="Bagaimana kami bisa membantu Anda?" class="w-full px-8 py-6 bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-[32px] text-sm font-bold focus:bg-white dark:focus:bg-slate-950 focus:ring-4 focus:ring-blue-500/5 focus:border-blue-700 transition-all outline-none resize-none dark:text-white">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-6 bg-blue-700 hover:bg-blue-800 text-white rounded-full font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-blue-500/20 flex items-center justify-center gap-3 disabled:opacity-50" :disabled="loading">
                        <span x-show="!loading">{{ __t('contact_button_send') ?? 'Kirim Pesan Sekarang' }}</span>
                        <div x-show="loading" class="animate-spin h-5 w-5 border-2 border-white/30 border-t-white rounded-full"></div>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
