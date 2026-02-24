<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- ⚡ Dark mode: apply BEFORE render to avoid flash -->
    <script>
        (function() {
            var saved = localStorage.getItem('theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', App\Helpers\SettingsHelper::get()->meta_description ?? 'Solusi perjalanan wisata Sumatera Utara terbaik. Paket wisata Danau Toba, Berastagi, Medan, dan sewa mobil premium dengan harga terjangkau.')">
    <meta name="keywords" content="@yield('meta_keywords', App\Helpers\SettingsHelper::get()->meta_keywords ?? 'wisata sumatera utara, paket tour danau toba, sewa mobil medan, trip sumut, berastagi tour, bukit lawang adventure')">
    <meta name="author" content="{{ App\Helpers\SettingsHelper::companyName() }}">
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">
    <meta name="googlebot" content="@yield('meta_robots', 'index, follow, max-image-preview:large')">
    <meta name="language" content="{{ app()->getLocale() }}">
    <meta name="revisit-after" content="3 days">
    <meta name="rating" content="general">
    <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Hreflang for multi-language support -->
    <link rel="alternate" hreflang="id" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="ms" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type"        content="website">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:title"       content="@yield('title', 'NorthSumateraTrip | Solusi Perjalanan Wisata Sumatera Utara')">
    <meta property="og:description" content="@yield('meta_description', 'Solusi perjalanan wisata Sumatera Utara terbaik. Paket wisata Danau Toba, Berastagi, Medan, dan sewa mobil premium.')">
    <meta property="og:image"       content="@yield('meta_image', asset('images/og-image.jpg'))">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale"       content="id_ID">
    <meta property="og:site_name"    content="{{ App\Helpers\SettingsHelper::companyName() }}">

    <!-- Twitter -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:url"         content="{{ url()->current() }}">
    <meta name="twitter:title"       content="@yield('title', 'NorthSumateraTrip | Solusi Perjalanan Wisata Sumatera Utara')">
    <meta name="twitter:description" content="@yield('meta_description', 'Solusi perjalanan wisata Sumatera Utara terbaik. Paket wisata Danau Toba, Berastagi, Medan, dan sewa mobil premium.')">
    <meta name="twitter:image"       content="@yield('meta_image', asset('images/og-image.jpg'))">
    <meta name="twitter:site"        content="@northsumateratrip">

    <!-- Favicon & PWA -->
    <link rel="icon" type="image/x-icon" href="{{ App\Helpers\SettingsHelper::favicon() }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#3b82f6" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0f172a" media="(prefers-color-scheme: dark)">

    <!-- Fonts -->
    <link rel="dns-prefetch"  href="https://fonts.bunny.net">
    <link rel="preconnect"    href="https://fonts.bunny.net" crossorigin>
    <link rel="preconnect"    href="https://fonts.googleapis.com">
    <link rel="preconnect"    href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    <title>@yield('title', (App\Helpers\SettingsHelper::get()->meta_title ?? App\Helpers\SettingsHelper::companyName()) . ' | ' . (App\Helpers\SettingsHelper::heroTitle() ?? 'Solusi Perjalanan Wisata Sumatera Utara'))</title>

    <!-- Custom Scripts / JSON-LD -->
    @stack('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
    @stack('schema')

    <!-- Organization Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "Organization",
      "name": "{{ App\Helpers\SettingsHelper::companyName() }}",
      "url": "{{ url('/') }}",
      "logo": "{{ App\Helpers\SettingsHelper::logo() ?? asset('images/logo.png') }}",
      "contactPoint": {
        "@@type": "ContactPoint",
        "telephone": "+{{ App\Helpers\SettingsHelper::whatsappNumber() }}",
        "contactType": "customer service",
        "areaServed": "ID",
        "availableLanguage": ["Indonesian", "English"]
      },
      "sameAs": [
        "{{ App\Helpers\SettingsHelper::facebookUrl() }}",
        "{{ App\Helpers\SettingsHelper::instagramUrl() }}",
        "{{ App\Helpers\SettingsHelper::tiktokUrl() }}"
      ]
    }
    </script>
    <!-- Breadcrumb Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Beranda",
        "item": "{{ url('/') }}"
      }
      @if(!request()->routeIs('home'))
      ,{
        "@type": "ListItem",
        "position": 2,
        "name": "@yield('title')",
        "item": "{{ url()->current() }}"
      }
      @endif
      ]
    }
    </script>
</head>

<body class="antialiased font-['Instrument_Sans'] transition-colors duration-300 noise-bg" style="background-color:var(--bg-main); color:var(--text-main);">
    <!-- Skip to Content for A11y -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[1000] focus:px-6 focus:py-3 focus:bg-blue-700 focus:text-white focus:rounded-2xl focus:font-black focus:text-xs focus:uppercase focus:tracking-widest">
        Lanjut ke Konten
    </a>

    <!-- Blue dark mode ambient glow -->
    <div id="dm-glow" class="pointer-events-none fixed inset-0 z-0 opacity-0 transition-opacity duration-1000" aria-hidden="true">
        <div class="absolute top-0 left-1/4 w-[800px] h-[600px] rounded-full" style="background:radial-gradient(ellipse at center, rgba(59,130,246,0.15) 0%, transparent 75%); filter:blur(150px);"></div>
        <div class="absolute bottom-0 right-1/4 w-[700px] h-[500px] rounded-full" style="background:radial-gradient(ellipse at center, rgba(37,99,235,0.12) 0%, transparent 75%); filter:blur(150px);"></div>
    </div>

    <!-- ═══════════════════════════════════════════════════════ -->
    <!-- NAVBAR                                                  -->
    <!-- ═══════════════════════════════════════════════════════ -->
    <nav x-data="{ mobileMenu: false, isScrolled: false }" 
         x-init="window.addEventListener('scroll', function() { isScrolled = window.scrollY > 10 })"
         :class="{ 'bg-white dark:bg-slate-900 shadow-sm border-b border-slate-100 dark:border-slate-800 py-4': isScrolled || !request()->routeIs('home'), 'bg-transparent py-6 md:py-10': !isScrolled && request()->routeIs('home') }"
         class="fixed w-full top-0 left-0 z-[100] transition-all duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <!-- Logo -->
            <a href="/" class="relative group">
                <div class="flex items-center gap-2 sm:gap-3">
                    @if(App\Helpers\SettingsHelper::logo())
                        <img src="{{ App\Helpers\SettingsHelper::logo() }}" alt="{{ App\Helpers\SettingsHelper::companyName() }} Logo" class="h-10 md:h-12 w-auto object-contain transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-700 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-500/20 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                            <svg width="24" height="24" class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 012 2v1.5a2.5 2.5 0 01-2.5 2.5h-1.5a2 2 0 01-2-2zm1 15.865V19a2 2 0 114 0v.865M19 16.314a7 7 0 01-8.686 0M3.055 11V10a7.438 7.438 0 011.083-3.865M19 16.314V17a2 2 0 11-4 0v-.686"></path></svg>
                        </div>
                        <span class="text-lg md:text-xl font-black text-slate-900 dark:text-white tracking-tighter uppercase">North<span class="text-blue-700">Sumatera</span>Trip</span>
                    @endif
                </div>
            </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center gap-6 lg:gap-8">
                    <a href="{{ route('home') }}"          class="text-sm font-black transition-all duration-300 {{ request()->routeIs('home')          ? 'text-blue-600 dark:text-blue-400' : 'text-slate-500 dark:text-slate-400 hover:text-blue-600' }}">{{ __t('nav_home') ?? 'Utama' }}</a>
                    <a href="{{ route('packages') }}"      class="text-sm font-black transition-all duration-300 {{ request()->routeIs('packages')      ? 'text-blue-600 dark:text-blue-400' : 'text-slate-500 dark:text-slate-400 hover:text-blue-600' }}">{{ __t('nav_packages') ?? 'Paket Wisata' }}</a>
                    <a href="{{ route('rental') }}"        class="text-sm font-black transition-all duration-300 {{ request()->routeIs('rental')        ? 'text-blue-600 dark:text-blue-400' : 'text-slate-500 dark:text-slate-400 hover:text-blue-600' }}">{{ __t('nav_rental') ?? 'Sewa Mobil' }}</a>
                    <a href="{{ route('gallery.index') }}" class="text-sm font-black transition-all duration-300 {{ request()->routeIs('gallery.index') ? 'text-blue-600 dark:text-blue-400' : 'text-slate-500 dark:text-slate-400 hover:text-blue-600' }}">{{ __t('nav_gallery') ?? 'Galeri' }}</a>
                    <a href="{{ route('blog.index') }}"    class="text-sm font-black transition-all duration-300 {{ request()->routeIs('blog.index')    ? 'text-blue-600 dark:text-blue-400' : 'text-slate-500 dark:text-slate-400 hover:text-blue-600' }}">{{ __t('nav_blog') ?? 'Blog' }}</a>
                    <a href="{{ route('contact') }}"       class="text-sm font-black transition-all duration-300 {{ request()->routeIs('contact')       ? 'text-blue-600 dark:text-blue-400' : 'text-slate-500 dark:text-slate-400 hover:text-blue-600' }}">{{ __t('nav_contact') ?? 'Kontak' }}</a>
                </div>

                <!-- Nav Right Actions -->
                <div class="flex items-center gap-0.5 sm:gap-2">
                    <div class="hidden md:block">
                        <x-language-switcher />
                    </div>

                    <!-- 🌙 Dark Mode Toggle -->
                    <button id="themeToggle"
                            onclick="toggleTheme()"
                            class="theme-toggle tap-target hidden md:flex"
                            aria-label="Ganti Tema Terang/Gelap"
                            title="Ganti Tema">
                        <!-- Sun icon (shown in dark mode) -->
                        <svg id="iconSun" width="20" height="20" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <!-- Moon icon (shown in light mode) -->
                        <svg id="iconMoon" width="20" height="20" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    @auth
                        <x-dropdown align="right" width="64">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2 p-1.5 pr-3 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-2xl transition-all border border-slate-100 dark:border-slate-700 group">
                                    <div class="w-7 h-7 bg-blue-700 rounded-xl flex items-center justify-center text-white font-black text-xs shadow-md group-hover:scale-110 transition-transform duration-300">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span class="hidden sm:block text-xs font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest">{{ Auth::user()->name }}</span>
                                    <svg width="16" height="16" class="w-4 h-4 text-slate-400 group-hover:text-blue-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Masuk Sebagai</p>
                                    <p class="text-sm font-black text-slate-900 dark:text-white truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <x-dropdown-link :href="route('dashboard')">{{ __('Dashboard') }}</x-dropdown-link>
                                <div class="border-t border-slate-50 dark:border-slate-700">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="text-rose-600 hover:text-rose-700 hover:bg-rose-50">
                                            {{ __('Keluar Akun') }}
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    @endauth

                    <!-- Wishlist -->
                    <button onclick="openWishlist()"
                            class="tap-target relative p-2 text-slate-600 dark:text-slate-300 hover:text-blue-500 transition-colors"
                            aria-label="Buka Wishlist">
                        <svg width="24" height="24" class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span id="wishlistBadge" class="hidden absolute top-0.5 right-0.5 w-4 h-4 bg-rose-500 text-white text-[9px] font-black rounded-full flex items-center justify-center">0</span>
                    </button>

                    <!-- Mobile Menu Toggle -->
                    <button class="md:hidden tap-target p-2 text-slate-600 dark:text-slate-300 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                            @click="mobileMenu = !mobileMenu"
                            :aria-expanded="mobileMenu"
                            aria-controls="mobile-menu"
                            aria-label="Toggle Menu Utama">
                        <svg width="24" height="24" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenu" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                        <svg width="24" height="24" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenu" x-cloak aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- ── Mobile Menu ─────────────────────────────────────── -->
        <div x-show="mobileMenu"
             id="mobile-menu"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden fixed inset-x-0 top-16 sm:top-20
                    bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl
                    border-b border-slate-200 dark:border-slate-700
                    shadow-2xl z-[90]"
             x-cloak>

            <div class="px-4 py-6 space-y-1">
                @foreach([
                    ['route' => 'home',          'label' => __t('nav_home')     ?? 'Utama'],
                    ['route' => 'packages',       'label' => __t('nav_packages') ?? 'Paket Wisata'],
                    ['route' => 'rental',         'label' => __t('nav_rental')   ?? 'Sewa Mobil'],
                    ['route' => 'gallery.index',  'label' => __t('nav_gallery')  ?? 'Galeri'],
                    ['route' => 'blog.index',     'label' => __t('nav_blog')     ?? 'Blog'],
                    ['route' => 'contact',        'label' => __t('nav_contact')  ?? 'Kontak'],
                ] as $item)
                    <a href="{{ route($item['route']) }}"
                       @click="mobileMenu = false"
                       class="flex items-center justify-between p-4 rounded-2xl text-base font-black transition-all duration-200
                              {{ request()->routeIs($item['route'])
                                  ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400'
                                  : 'text-slate-900 dark:text-slate-100 hover:bg-slate-50 dark:hover:bg-slate-800 active:bg-slate-100' }}">
                        <span>{{ $item['label'] }}</span>
                        <svg width="16" height="16" class="w-4 h-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                @endforeach

                <!-- Language Switcher (mobile) -->
                <div class="px-4 py-8 border-t border-slate-100 dark:border-slate-800 mt-4 min-h-[120px]">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">{{ __t('select_language') ?? 'Pilih Bahasa' }}</p>
                    <div class="relative">
                        <x-language-switcher />
                    </div>
                </div>

                <!-- Dark mode toggle (mobile) -->
                <div class="pt-3 pb-1 border-t border-slate-100 dark:border-slate-700 mt-2">
                    <button @click="toggleTheme(); mobileMenu = false"
                            class="w-full flex items-center gap-3 p-4 rounded-2xl text-base font-black
                                   text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                        <span id="mobileThemeIcon" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                            <!-- Updated by JS -->
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </span>
                        <span id="mobileThemeLabel">Mode Gelap</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- ═══════════════════════════════════════════════════════ -->
    <!-- MAIN CONTENT                                            -->
    <!-- ═══════════════════════════════════════════════════════ -->
    <main id="main-content">
        @yield('content')
    </main>

    <x-footer />
    <x-floating-whatsapp />

    <!-- ═══════════════════════════════════════════════════════ -->
    <!-- GLOBAL SCRIPTS                                          -->
    <!-- ═══════════════════════════════════════════════════════ -->
    <script>
        /* ─── Dark Mode ─────────────────────────────────────── */
        function toggleTheme() {
            var html = document.documentElement;
            var isDark = html.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeIcons(isDark);
            updateGlow(isDark);
        }

        function updateGlow(isDark) {
            var glow = document.getElementById('dm-glow');
            if (glow) glow.style.opacity = isDark ? '1' : '0';
        }

        function updateThemeIcons(isDark) {
            var sun  = document.getElementById('iconSun');
            var moon = document.getElementById('iconMoon');
            var mobileLabel = document.getElementById('mobileThemeLabel');
            var mobileIcon  = document.getElementById('mobileThemeIcon');

            if (isDark) {
                if (sun)  sun.classList.remove('hidden');
                if (moon) moon.classList.add('hidden');
                if (mobileLabel) mobileLabel.textContent = 'Mode Terang';
                if (mobileIcon) mobileIcon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>';
            } else {
                if (sun)  sun.classList.add('hidden');
                if (moon) moon.classList.remove('hidden');
                if (mobileLabel) mobileLabel.textContent = 'Mode Gelap';
                if (mobileIcon) mobileIcon.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>';
            }
        }

        /* ─── Wishlist ──────────────────────────────────────── */
        function openWishlist() {
            var wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            if (wishlist.length === 0) {
                alert('Wishlist Anda masih kosong');
                return;
            }
            var html = '<div class="space-y-3 max-h-[55vh] overflow-y-auto custom-scrollbar pr-2">';
            wishlist.forEach(function(item) {
                html += '<div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-600">' +
                    '<img src="' + item.thumb + '" class="w-14 h-14 rounded-xl object-cover shadow-sm flex-shrink-0">' +
                    '<div class="flex-1 min-w-0">' +
                        '<h4 class="font-black text-slate-900 dark:text-white text-sm truncate">' + item.title + '</h4>' +
                        '<a href="/tour/' + item.id + '" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">Lihat Detail</a>' +
                    '</div>' +
                    '<button onclick="removeFromWishlist(' + item.id + ')" class="p-2 text-slate-400 hover:text-rose-500 transition-colors flex-shrink-0 tap-target">' +
                        '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>' +
                    '</button>' +
                '</div>';
            });
            html += '</div>';

            var overlay = document.createElement('div');
            overlay.id = 'wishlistOverlay';
            overlay.className = 'fixed inset-0 z-[200] bg-slate-900/60 backdrop-blur-sm flex items-end sm:items-center justify-center p-0 sm:p-6';
            overlay.innerHTML =
                '<div class="bg-white dark:bg-slate-800 rounded-t-[32px] sm:rounded-[32px] w-full sm:max-w-md p-6 sm:p-8 shadow-2xl animate-fade-up sm:animate-scale-in">' +
                    '<div class="w-10 h-1 bg-slate-200 dark:bg-slate-600 rounded-full mx-auto mb-6 sm:hidden"></div>' +
                    '<div class="flex items-center justify-between mb-6">' +
                        '<h3 class="text-xl font-black text-slate-900 dark:text-white">Wishlist <span class="text-blue-500">Saya</span></h3>' +
                        '<button onclick="document.getElementById(\'wishlistOverlay\').remove()" class="w-9 h-9 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">' +
                            '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>' +
                        '</button>' +
                    '</div>' +
                    html +
                    '<button onclick="document.getElementById(\'wishlistOverlay\').remove()" class="w-full mt-6 py-3.5 bg-slate-900 dark:bg-slate-700 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-colors">Tutup</button>' +
                '</div>';
            overlay.addEventListener('click', function(e) { if (e.target === overlay) overlay.remove(); });
            document.body.appendChild(overlay);
        }

        function removeFromWishlist(id) {
            var wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            wishlist = wishlist.filter(function(item) { return item.id !== id; });
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            updateWishlistBadge();
            var overlay = document.getElementById('wishlistOverlay');
            if (overlay) { overlay.remove(); openWishlist(); }
        }

        function updateWishlistBadge() {
            var wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            var badge = document.getElementById('wishlistBadge');
            if (badge) {
                badge.textContent = wishlist.length;
                badge.classList.toggle('hidden', wishlist.length === 0);
            }
        }

        /* ─── Scroll Reveal (throttled) ───────────────────── */
        var revealTicking = false;
        function reveal() {
            if (revealTicking) return;
            revealTicking = true;
            requestAnimationFrame(function() {
                var els = document.querySelectorAll('.reveal');
                for (var i = 0; i < els.length; i++) {
                    var top = els[i].getBoundingClientRect().top;
                    if (top < window.innerHeight - 80) {
                        els[i].classList.add('active');
                    }
                }
                revealTicking = false;
            });
        }

        /* ─── Premium Mouse Effects (throttled) ──────────── */
        var mouseTicking = false;
        function handleMouseMove(e) {
            if (mouseTicking) return;
            mouseTicking = true;
            requestAnimationFrame(function() {
                document.documentElement.style.setProperty('--mouse-x', e.clientX + 'px');
                document.documentElement.style.setProperty('--mouse-y', e.clientY + 'px');

                var parallaxEls = document.querySelectorAll('.parallax-el');
                for (var i = 0; i < parallaxEls.length; i++) {
                    var el = parallaxEls[i];
                    var speed = parseFloat(el.dataset.speed) || 0.05;
                    var x = (window.innerWidth / 2 - e.clientX) * speed;
                    var y = (window.innerHeight / 2 - e.clientY) * speed;
                    el.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
                }
                mouseTicking = false;
            });
        }

        /* ─── Init ──────────────────────────────────────────── */
        document.addEventListener('DOMContentLoaded', function() {
            var isDark = document.documentElement.classList.contains('dark');
            updateThemeIcons(isDark);
            updateGlow(isDark);
            updateWishlistBadge();
            reveal();
            window.addEventListener('scroll', reveal, { passive: true });
            document.addEventListener('mousemove', handleMouseMove, { passive: true });
        });
    </script>
    @stack('scripts')
</body>
</html>
