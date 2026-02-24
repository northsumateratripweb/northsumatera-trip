@extends('layouts.main')

@section('title', 'Dashboard | NorthSumateraTrip')

@section('content')
    <main class="pt-32 pb-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="reveal mb-12">
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tight">{!! __t('dashboard_welcome', ['name' => '<span class="text-blue-700">' . Auth::user()->name . '</span>']) !!}</h1>
                <p class="text-slate-500 font-medium">{{ __t('dashboard_subtitle') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Stat Card 1 -->
                <div class="bg-white p-8 rounded-[40px] shadow-xl border border-slate-100 reveal">
                    <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-700 mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">{{ __t('dashboard_stat_total') }}</p>
                    <p class="text-4xl font-black text-slate-900">{{ $stats['total'] }}</p>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white p-8 rounded-[40px] shadow-xl border border-slate-100 reveal" style="transition-delay: 100ms;">
                    <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">{{ __t('dashboard_stat_completed') }}</p>
                    <p class="text-4xl font-black text-slate-900">{{ $stats['completed'] }}</p>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white p-8 rounded-[40px] shadow-xl border border-slate-100 reveal" style="transition-delay: 200ms;">
                    <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">{{ __t('dashboard_stat_pending') }}</p>
                    <p class="text-4xl font-black text-slate-900">{{ $stats['pending'] }}</p>
                </div>
            </div>

            <div class="bg-white p-10 md:p-12 rounded-[40px] shadow-xl border border-slate-100 reveal">
                <div class="flex items-center justify-between mb-10">
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">{{ __t('dashboard_table_title_1') }} <span class="text-blue-700">{{ __t('dashboard_table_title_2') }}</span></h2>
                </div>

                @if($bookings->isEmpty())
                    <div class="text-center py-20">
                        <div class="w-24 h-24 bg-slate-50 rounded-[30px] flex items-center justify-center text-slate-300 mx-auto mb-6">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <p class="text-slate-500 font-bold">{{ __t('dashboard_empty_title') }}</p>
                        <p class="text-sm text-slate-400 mt-2">{{ __t('dashboard_empty_subtitle') }}</p>
                        <div class="mt-8 flex justify-center">
                            <a href="{{ route('packages') }}" class="bg-blue-700 hover:bg-blue-800 text-white font-black px-8 py-4 rounded-2xl shadow-xl shadow-blue-500/20 transition-all text-xs uppercase tracking-widest transform hover:-translate-y-1">
                                {{ __t('dashboard_cta_search') }}
                            </a>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-separate border-spacing-y-4">
                            <thead>
                                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-6">
                                    <th class="pb-4 pl-6">{{ __t('dashboard_table_header_package') }}</th>
                                    <th class="pb-4">{{ __t('dashboard_table_header_date') }}</th>
                                    <th class="pb-4">{{ __t('dashboard_table_header_total') }}</th>
                                    <th class="pb-4">{{ __t('dashboard_table_header_status') }}</th>
                                    <th class="pb-4 text-right pr-6">{{ __t('dashboard_table_header_action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @foreach($bookings as $booking)
                                    <tr class="bg-slate-50/50 hover:bg-slate-50 transition-colors rounded-3xl overflow-hidden">
                                        <td class="py-6 pl-6 rounded-l-3xl">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-200">
                                                    @if($booking->tour)
                                                        <img src="{{ $booking->tour->image_url }}" class="w-full h-full object-cover">
                                                    @elseif($booking->car)
                                                        <img src="{{ $booking->car->image_url }}" class="w-full h-full object-cover">
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-black text-slate-900 line-clamp-1">{{ $booking->tour->title ?? ($booking->car->name ?? 'N/A') }}</p>
                                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $booking->external_id }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-6">
                                            <p class="font-bold text-slate-600">{{ \Carbon\Carbon::parse($booking->travel_date)->format('d M Y') }}</p>
                                        </td>
                                        <td class="py-6">
                                            <p class="font-black text-slate-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="py-6">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                    'paid' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                    'failed' => 'bg-rose-50 text-rose-600 border-rose-100',
                                                    'expired' => 'bg-slate-50 text-slate-400 border-slate-100',
                                                ];
                                                $statusColor = $statusColors[$booking->payment_status] ?? 'bg-slate-50 text-slate-400 border-slate-100';
                                            @endphp
                                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $statusColor }}">
                                                {{ $booking->payment_status }}
                                            </span>
                                        </td>
                                        <td class="py-6 text-right pr-6 rounded-r-3xl">
                                            <div class="flex items-center justify-end gap-3">
                                                <div class="flex flex-col md:flex-row items-center gap-2">
                                                    <a href="{{ route('invoice.show', $booking->id) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 transition-all shadow-sm group">
                                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                        <span class="text-[10px] font-black uppercase tracking-widest">{{ __t('dashboard_invoice') ?: 'Invoice' }}</span>
                                                    </a>
                                                    
                                                    @php
                                                        $waMessage = "Halo Admin NorthSumateraTrip, saya ingin bertanya mengenai pesanan saya dengan kode: " . $booking->external_id;
                                                        $waUrl = "https://wa.me/" . \App\Helpers\SettingsHelper::whatsappNumber() . "?text=" . urlencode($waMessage);
                                                    @endphp
                                                    <a href="{{ $waUrl }}" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all shadow-sm group">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 0 5.414 0 12.05c0 2.123.552 4.197 1.6 6.023L0 24l6.135-1.61a11.802 11.802 0 005.91 1.586h.005c6.637 0 12.05-5.414 12.05-12.05a11.852 11.852 0 00-3.487-8.522z"/></svg>
                                                        <span class="text-[10px] font-black uppercase tracking-widest">Chat Admin</span>
                                                    </a>
                                                </div>

                                                @if($booking->payment_status == 'pending' && $booking->snap_token)
                                                    <button onclick="window.snap.pay('{{ $booking->snap_token }}')" class="px-6 py-3 bg-blue-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-800 transition-all shadow-lg shadow-blue-500/20 transform hover:-translate-y-0.5 active:scale-95">
                                                        {{ __t('dashboard_button_pay') }}
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
