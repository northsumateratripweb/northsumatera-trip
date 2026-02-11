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

<footer id="contact" class="border-t border-[#3E3E3A] bg-[#0a0a0a] py-16 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-8">
            <div>
                <a href="/" class="text-2xl font-extrabold tracking-tighter">
                    {{ $companyName }}<span class="text-[#FF4433]">Trip</span>
                </a>
                <p class="text-[#A1A09A] text-sm mt-3 max-w-md">
                    Solusi perjalanan wisata profesional untuk menjelajahi keindahan Danau Toba, Berastagi, dan Bukit Lawang.
                </p>
            </div>

            <div class="flex flex-col gap-4">
                <span class="text-xs font-bold uppercase tracking-widest text-[#A1A09A]">{{ __('common.contact') }}</span>
                <div class="flex items-center gap-4">
                    @if($whatsappNumber)
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 rounded-xl bg-[#161615] border border-[#3E3E3A] flex items-center justify-center text-[#25D366] hover:border-[#25D366] hover:scale-110 transition-all duration-300"
                           aria-label="WhatsApp">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347Z"/>
                            </svg>
                        </a>
                    @endif
                    @if($instagramUrl)
                        <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 rounded-xl bg-[#161615] border border-[#3E3E3A] flex items-center justify-center text-[#E4405F] hover:border-[#E4405F] hover:scale-110 transition-all duration-300"
                           aria-label="Instagram">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    @endif
                    @if($facebookUrl)
                        <a href="{{ $facebookUrl }}" target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 rounded-xl bg-[#161615] border border-[#3E3E3A] flex items-center justify-center text-[#1877F2] hover:border-[#1877F2] hover:scale-110 transition-all duration-300"
                           aria-label="Facebook">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                    @endif
                    @if($tiktokUrl)
                        <a href="{{ $tiktokUrl }}" target="_blank" rel="noopener noreferrer"
                           class="w-12 h-12 rounded-xl bg-[#161615] border border-[#3E3E3A] flex items-center justify-center text-[#EDEDEC] hover:border-[#FF4433] hover:text-[#FF4433] hover:scale-110 transition-all duration-300"
                           aria-label="TikTok">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                            </svg>
                        </a>
                    @endif
                </div>
                @if($email)
                    <a href="mailto:{{ $email }}" class="text-[#A1A09A] hover:text-[#FF4433] text-sm transition-colors">
                        {{ $email }}
                    </a>
                @endif
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-[#3E3E3A] flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[#A1A09A] text-sm">
                © {{ date('Y') }} {{ $companyName }}. All rights reserved.
            </p>
            <div class="flex gap-6 text-sm">
                <a href="/" class="text-[#A1A09A] hover:text-[#FF4433] transition-colors">{{ __('common.home') }}</a>
                <a href="#tours" class="text-[#A1A09A] hover:text-[#FF4433] transition-colors">{{ __('common.tours') }}</a>
                <a href="#rental" class="text-[#A1A09A] hover:text-[#FF4433] transition-colors">{{ __('common.car_rental') }}</a>
                <a href="#contact" class="text-[#A1A09A] hover:text-[#FF4433] transition-colors">{{ __('common.contact') }}</a>
            </div>
        </div>
    </div>
</footer>
