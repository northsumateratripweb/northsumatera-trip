<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NorthSumateraTrip') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            .bg-auth {
                background-color: #f8fafc;
                background-image: radial-gradient(at 0% 0%, rgba(29, 78, 216, 0.05) 0px, transparent 50%),
                                radial-gradient(at 100% 0%, rgba(29, 78, 216, 0.05) 0px, transparent 50%);
            }
        </style>
    </head>
    <body class="antialiased bg-auth text-slate-900">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-6">
            <div class="mb-12">
                <a href="/" class="text-3xl font-black tracking-tighter flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-blue-700 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-700/20 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </div>
                    <div class="flex flex-col -space-y-1">
                        <span class="text-slate-900 leading-none">NorthSumatera</span>
                        <span class="text-blue-700 leading-none">Trip</span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md bg-white p-8 md:p-12 rounded-[40px] shadow-2xl shadow-blue-900/5 border border-slate-100">
                {{ $slot }}
            </div>
            
            <div class="mt-12 text-center">
                <p class="text-sm font-bold text-slate-400">© {{ date('Y') }} NorthSumateraTrip. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
