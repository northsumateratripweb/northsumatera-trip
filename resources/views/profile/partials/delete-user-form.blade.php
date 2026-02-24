<section class="space-y-6">
    <header>
        <h2 class="text-2xl font-black text-rose-600 tracking-tight">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-2 text-slate-500 font-medium">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, silakan unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    <div class="w-64">
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >{{ __('Hapus Akun Sekarang') }}</x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10 md:p-12">
            @csrf
            @method('delete')

            <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-4">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="text-slate-500 font-medium leading-relaxed mb-8">
                {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Silakan masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
            </p>

            <div class="mb-8">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full"
                    placeholder="{{ __('Masukkan Password Anda') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" />
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batalkan') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Ya, Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
