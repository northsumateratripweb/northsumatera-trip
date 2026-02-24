<x-guest-layout>
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-black text-slate-900 mb-3 tracking-tight">Atur Ulang <span class="text-blue-700">Password</span></h2>
        <p class="text-slate-500 font-medium">Silakan masukkan password baru Anda.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password Baru')" />
            <x-text-input id="password" class="block w-full" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 karakter" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password baru" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="pt-2">
            <x-primary-button>
                {{ __('Simpan Password Baru') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
