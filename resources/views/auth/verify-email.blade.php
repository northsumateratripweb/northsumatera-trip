<x-guest-layout>
    <div class="mb-10 text-center">
        <div class="w-20 h-20 bg-blue-50 rounded-[30px] flex items-center justify-center text-blue-700 mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>
        <h2 class="text-3xl font-black text-slate-900 mb-3 tracking-tight">Verifikasi <span class="text-blue-700">Email</span></h2>
        <p class="text-slate-500 font-medium leading-relaxed">Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda melalui tautan yang baru saja kami kirimkan.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-8 p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
            <p class="text-xs font-bold text-emerald-700 leading-relaxed text-center">
                {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
            </p>
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                {{ __('Kirim Ulang Email Verifikasi') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500 transition-colors">
                {{ __('Keluar Akun') }}
            </button>
        </form>
    </div>
</x-guest-layout>
