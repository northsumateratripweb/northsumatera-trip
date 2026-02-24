<x-guest-layout>
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-black text-slate-900 mb-3 tracking-tight">Lupa <span class="text-blue-700">Password?</span></h2>
        <p class="text-slate-500 font-medium">Jangan khawatir, kami akan membantu Anda mengatur ulang password akun Anda.</p>
    </div>

    <div class="mb-8 p-4 bg-blue-50 rounded-2xl border border-blue-100">
        <p class="text-xs font-bold text-blue-700 leading-relaxed">
            {{ __('Cukup beritahu kami alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password yang memungkinkan Anda memilih password baru.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="pt-2">
            <x-primary-button>
                {{ __('Kirim Tautan Reset') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-4">
            <a href="{{ route('login') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-blue-700 transition-colors">
                Kembali ke Login
            </a>
        </div>
    </form>
</x-guest-layout>
