@php
    use App\Helpers\SettingsHelper;
    $companyName = SettingsHelper::companyName();
    $whatsappNumber = preg_replace('/[^0-9]/', '', SettingsHelper::whatsappNumber());
    $whatsappUrl = 'https://wa.me/' . $whatsappNumber;
    $instagramUrl = SettingsHelper::instagramUrl();
    $facebookUrl = SettingsHelper::facebookUrl();
    $tiktokUrl = SettingsHelper::tiktokUrl();
    $email = SettingsHelper::email();
@endphp

<footer id="contact" class="bg-white dark:bg-slate-900 py-20 sm:py-32 border-t border-slate-100 dark:border-slate-800 transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-16 lg:gap-24 mb-20">
            <div class="lg:col-span-5">
                <a href="/" class="text-2xl font-black tracking-tighter flex items-center gap-2" aria-label="{{ App\Helpers\SettingsHelper::companyName() }} Home">
                    @if(App\Helpers\SettingsHelper::logo())
                        <img src="{{ App\Helpers\SettingsHelper::logo() }}" alt="{{ App\Helpers\SettingsHelper::companyName() }}" class="h-8 w-auto object-contain">
                    @else
                        <div class="w-8 h-8 bg-blue-700 rounded-lg flex items-center justify-center">
                            <svg width="20" height="20" class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </div>
                        <span class="text-slate-900 dark:text-white uppercase">North<span class="text-blue-700">Sumatera</span>Trip</span>
                    @endif
                </a>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-6 max-w-md font-medium leading-relaxed">
                    {{ App\Helpers\SettingsHelper::get()->meta_description ?? 'Solusi perjalanan wisata profesional untuk menjelajahi keindahan Danau Toba, Berastagi, dan Bukit Lawang dengan layanan eksklusif dan terpercaya.' }}
                </p>
                <div class="flex items-center gap-4 mt-8">
                    @if($whatsappNumber)
                        <a href="{{ $whatsappUrl }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-600 flex items-center justify-center text-emerald-500 hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 hover:shadow-lg transition-all duration-300" aria-label="Chat WhatsApp">
                            <svg width="20" height="20" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347Z"/></svg>
                        </a>
                    @endif
                    @if($instagramUrl)
                        <a href="{{ $instagramUrl }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-600 flex items-center justify-center text-rose-500 hover:border-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 hover:shadow-lg transition-all duration-300" aria-label="Follow Instagram">
                            <svg width="20" height="20" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    @endif
                    @if($facebookUrl)
                        <a href="{{ $facebookUrl }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-600 flex items-center justify-center text-blue-600 hover:border-blue-600 hover:bg-blue-50 dark:hover:bg-blue-500/10 hover:shadow-lg transition-all duration-300" aria-label="Follow Facebook">
                            <svg width="20" height="20" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    @endif
                    @if($tiktokUrl)
                        <a href="{{ $tiktokUrl }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-600 flex items-center justify-center text-slate-900 dark:text-white hover:border-slate-900 dark:hover:border-white hover:bg-slate-50 dark:hover:bg-white/10 hover:shadow-lg transition-all duration-300" aria-label="Follow TikTok">
                            <svg width="20" height="20" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.9-.32-1.98-.23-2.81.33-.85.51-1.44 1.43-1.58 2.41-.14.99.13 2.02.73 2.81.59.7 1.48 1.1 2.37 1.12 1.13.07 2.22-.52 2.87-1.44.42-.56.63-1.26.65-1.95.06-3.48.01-6.96.02-10.45Z"/></svg>
                        </a>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-3">
                <h4 class="text-sm font-black uppercase tracking-[0.2em] mb-8 text-blue-700">{{ __t('nav_navigation') ?? 'Navigasi' }}</h4>
                <ul class="space-y-4">
                    <li><a href="/" class="text-slate-600 dark:text-slate-400 hover:text-blue-700 dark:hover:text-blue-400 font-bold transition-colors">{{ __t('nav_home') ?? 'Beranda' }}</a></li>
                    <li><a href="{{ route('packages') }}" class="text-slate-600 dark:text-slate-400 hover:text-blue-700 dark:hover:text-blue-400 font-bold transition-colors">{{ __t('nav_packages') ?? 'Paket Wisata' }}</a></li>
                    <li><a href="{{ route('rental') }}" class="text-slate-600 dark:text-slate-400 hover:text-blue-700 dark:hover:text-blue-400 font-bold transition-colors">{{ __t('nav_rental') ?? 'Sewa Mobil' }}</a></li>
                    <li><a href="{{ route('gallery.index') }}" class="text-slate-600 dark:text-slate-400 hover:text-blue-700 dark:hover:text-blue-400 font-bold transition-colors">{{ __t('nav_gallery') ?? 'Galeri' }}</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-slate-600 dark:text-slate-400 hover:text-blue-700 dark:hover:text-blue-400 font-bold transition-colors">{{ __t('nav_blog') ?? 'Blog' }}</a></li>
                </ul>
            </div>

            <div class="lg:col-span-4">
                <h4 class="text-sm font-black uppercase tracking-[0.2em] mb-8 text-blue-700">{{ __t('footer_address_title') ?? 'Alamat Kami' }}</h4>
                <p class="text-slate-600 dark:text-slate-400 font-bold leading-relaxed mb-6">
                    {{ App\Helpers\SettingsHelper::get()->address ?? 'Medan, Sumatera Utara, Indonesia' }}
                </p>
                @if($email)
                    <a href="mailto:{{ $email }}" class="text-slate-600 dark:text-slate-400 hover:text-blue-700 dark:hover:text-blue-400 font-bold transition-colors">
                        {{ $email }}
                    </a>
                @endif
            </div>
        </div>

        <div class="pt-8 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-slate-400 dark:text-slate-500 text-xs font-bold">
                © {{ date('Y') }} {{ $companyName }}. All rights reserved.
            </p>
            <div class="flex items-center gap-6">
                <a href="{{ route('sitemap') }}" class="text-slate-400 dark:text-slate-500 hover:text-blue-700 dark:hover:text-blue-400 text-xs font-bold transition-colors">Sitemap</a>
                <a href="{{ route('legal.terms') }}" class="text-slate-400 dark:text-slate-500 hover:text-blue-700 dark:hover:text-blue-400 text-xs font-bold transition-colors">{{ __t('footer_legal_terms') ?? 'Syarat & Ketentuan' }}</a>
                <a href="{{ route('legal.privacy') }}" class="text-slate-400 dark:text-slate-500 hover:text-blue-700 dark:hover:text-blue-400 text-xs font-bold transition-colors">{{ __t('footer_legal_privacy') ?? 'Kebijakan Privasi' }}</a>
            </div>
        </div>
    </div>
</footer>

<!-- Floating Action Button (Back to Top) -->
<div x-data="{ show: false }" 
     x-init="window.addEventListener('scroll', function() { show = window.pageYOffset > 500 })"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-10"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-10"
     class="fixed bottom-8 right-28 z-[90]"
     x-cloak>
    <button @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="group w-12 h-12 sm:w-14 sm:h-14 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-2xl shadow-2xl flex items-center justify-center hover:bg-blue-600 hover:text-white hover:border-blue-600 hover:-translate-y-2 transition-all duration-500"
            aria-label="Kembali ke Atas">
        <svg width="24" height="24" class="w-5 h-5 sm:w-6 sm:h-6 transform group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path></svg>
    </button>
</div>
