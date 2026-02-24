<section>
    <header>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
            {{ __('Perbarui Password') }}
        </h2>

        <p class="mt-2 text-slate-500 font-medium">
            {{ __('Pastikan akun Anda menggunakan password yang panjang dan acak untuk tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Password Saat Ini')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="block w-full" autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Password Baru')" />
            <x-text-input id="update_password_password" name="password" type="password" class="block w-full" autocomplete="new-password" placeholder="Min. 8 karakter" />
            <x-input-error :messages="$errors->updatePassword->get('password')" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password Baru')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full" autocomplete="new-password" placeholder="Ulangi password baru" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <div class="w-48">
                <x-primary-button>{{ __('Simpan Password') }}</x-primary-button>
            </div>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-black text-emerald-600 uppercase tracking-widest"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
