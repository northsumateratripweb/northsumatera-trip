@php
    use App\Models\BusinessSetting;
    $setting = BusinessSetting::get();
    $whatsapp = $setting->whatsapp ?? env('WHATSAPP_NUMBER', '6282200000000');
    $company = $setting->company_name ?? config('app.name', 'NorthSumateraTrip');
@endphp

<div class="fixed right-6 bottom-6 z-50">
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/','', $whatsapp) }}?text={{ urlencode('Halo, saya ingin info lebih lanjut tentang paket wisata') }}" target="_blank" class="flex items-center gap-3 bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-3 rounded-full shadow-lg transition">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20.52 3.48A11.94 11.94 0 0012 0C5.373 0 .023 5.35.023 12c0 2.11.548 4.165 1.588 5.988L0 24l6.285-1.602A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12 0-3.205-1.25-6.165-3.48-8.52zM12 21.8c-1.173 0-2.32-.195-3.392-.577l-.244-.088-3.74.953.998-3.65-.126-.302A9.4 9.4 0 012.6 12 9.4 9.4 0 0112 2.6 9.4 9.4 0 0121.4 12 9.4 9.4 0 0112 21.8z"></path></svg>
        <span class="font-bold">{{ $company }}</span>
    </a>
</div>
