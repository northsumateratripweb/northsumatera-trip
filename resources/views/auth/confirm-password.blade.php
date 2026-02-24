<x-guest-layout>
    <div class="mb-10 text-center">
        <div class="w-20 h-20 bg-amber-50 rounded-[30px] flex items-center justify-center text-amber-600 mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        </div>
        <h2 class="text-3xl font-black text-slate-900 mb-3 tracking-tight">Konfirmasi <span class="text-blue-700">Password</span></h2>
        <p class="text-slate-500 font-medium">Ini adalah area aman. Harap konfirmasi password Anda sebelum melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="pt-2">
            <x-primary-button>
                {{ __('Konfirmasi Sekarang') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
