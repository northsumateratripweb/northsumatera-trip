<x-guest-layout>
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-black text-slate-900 mb-3 tracking-tight">Selamat <span class="text-blue-700">Datang</span></h2>
        <p class="text-slate-500 font-medium">Silakan masuk ke akun Anda untuk melanjutkan.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-black text-blue-700 uppercase tracking-widest hover:underline" href="{{ route('password.request') }}">
                        {{ __('Lupa Password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <div class="relative flex items-center">
                    <input id="remember_me" type="checkbox" class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-slate-200 checked:bg-blue-700 transition-all" name="remember">
                    <svg class="absolute h-3.5 w-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="ms-3 text-xs font-black text-slate-400 uppercase tracking-widest group-hover:text-slate-600 transition-colors">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button>
                {{ __('Masuk Sekarang') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-4">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-700 hover:underline ml-1">Daftar Gratis</a>
            </p>
        </div>
    </form>
</x-guest-layout>
