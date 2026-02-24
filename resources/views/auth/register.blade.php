<x-guest-layout>
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-black text-slate-900 mb-3 tracking-tight">Daftar <span class="text-blue-700">Akun</span></h2>
        <p class="text-slate-500 font-medium">Mulai petualangan Anda di Sumatera Utara.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Contoh: Ridho Harahap" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="Min. 8 karakter" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="pt-2">
            <x-primary-button>
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-4">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-blue-700 hover:underline ml-1">Masuk Saja</a>
            </p>
        </div>
    </form>
</x-guest-layout>
