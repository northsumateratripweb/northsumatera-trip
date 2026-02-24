<section>
    <header>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-2 text-slate-500 font-medium">
            {{ __("Perbarui informasi profil akun dan alamat email Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" placeholder="Nama Anda" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="block w-full" :value="old('email', $user->email)" required autocomplete="username" placeholder="email@contoh.com" />
            <x-input-error :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-100">
                    <p class="text-xs font-bold text-amber-700 leading-relaxed">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="ml-1 underline hover:text-amber-800 transition-colors">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-[10px] font-black text-emerald-600 uppercase tracking-widest">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <div class="w-48">
                <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
            </div>

            @if (session('status') === 'profile-updated')
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
