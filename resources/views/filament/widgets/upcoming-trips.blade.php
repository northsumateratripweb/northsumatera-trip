<div class="fi-wi p-6">
    <h2 class="text-base font-bold text-gray-950 dark:text-white mb-6 flex items-center gap-2">
        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-blue-100 text-blue-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </span>
        Jadwal Trip — {{ $monthLabel }}
    </h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- MINI CALENDAR --}}
        <div>
            <div class="grid grid-cols-7 mb-2">
                @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $day)
                    <div class="text-center text-[10px] font-black text-gray-400 uppercase tracking-wider py-1">{{ $day }}</div>
                @endforeach
            </div>
            <div class="grid grid-cols-7 gap-1">
                @foreach($calendar as $cell)
                    @if(is_null($cell))
                        <div></div>
                    @else
                        <div class="rounded-xl p-1 text-center min-h-[48px] relative
                            {{ $cell['today'] ? 'bg-blue-600 text-white ring-2 ring-blue-400 ring-offset-1' : 'bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300' }}
                            {{ $cell['trips']->isNotEmpty() && !$cell['today'] ? 'bg-blue-50 dark:bg-blue-900/20 ring-1 ring-blue-200' : '' }}
                        ">
                            <span class="text-xs font-bold block">{{ $cell['day'] }}</span>
                            @if($cell['trips']->isNotEmpty())
                                <div class="flex justify-center gap-0.5 mt-0.5 flex-wrap">
                                    @foreach($cell['trips']->take(3) as $trip)
                                        <span class="w-1.5 h-1.5 rounded-full {{ $cell['today'] ? 'bg-white/70' : 'bg-blue-500' }}"></span>
                                    @endforeach
                                    @if($cell['trips']->count() > 3)
                                        <span class="text-[8px] font-black {{ $cell['today'] ? 'text-white/70' : 'text-blue-500' }}">+{{ $cell['trips']->count() - 3 }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- UPCOMING LIST --}}
        <div>
            <h3 class="text-xs font-black text-gray-500 uppercase tracking-widest mb-4">30 Hari Ke Depan</h3>
            @if($upcoming->isEmpty())
                <div class="flex flex-col items-center justify-center py-10 text-gray-400">
                    <svg class="w-10 h-10 mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="text-xs font-medium">Tidak ada trip dalam 30 hari ke depan</p>
                </div>
            @else
                <div class="space-y-2 max-h-72 overflow-y-auto pr-1 scrollbar-thin">
                    @foreach($upcoming as $trip)
                        @php
                            $daysLeft = now()->diffInDays($trip->tanggal, false);
                            $badgeClass = match(true) {
                                $daysLeft === 0 => 'bg-rose-100 text-rose-600',
                                $daysLeft <= 3  => 'bg-amber-100 text-amber-700',
                                default         => 'bg-blue-50 text-blue-600',
                            };
                            $daysLabel = $daysLeft === 0 ? 'Hari ini!' : ($daysLeft === 1 ? 'Besok' : $daysLeft . ' hari lagi');

                            $statusClass = match($trip->status) {
                                'Selesai'           => 'bg-green-100 text-green-700',
                                'Sedang Berjalan'   => 'bg-yellow-100 text-yellow-700',
                                'Sudah Booking'     => 'bg-blue-100 text-blue-700',
                                default             => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <a href="{{ route('filament.admin.resources.trip-datas.edit', $trip->id) }}"
                           class="flex items-center gap-3 p-3 rounded-2xl bg-gray-50 dark:bg-gray-800 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors group">
                            <div class="flex-shrink-0 w-11 h-11 rounded-xl bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600 flex flex-col items-center justify-center shadow-sm">
                                <span class="text-[10px] font-black text-blue-600">{{ $trip->tanggal->format('M') }}</span>
                                <span class="text-sm font-black text-gray-900 dark:text-white leading-none">{{ $trip->tanggal->format('d') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-black text-gray-900 dark:text-white truncate group-hover:text-blue-600 transition-colors">{{ $trip->nama_pelanggan }}</p>
                                <p class="text-[10px] text-gray-500 truncate">
                                    {{ $trip->layanan }} • {{ $trip->jumlah_hari }} hari • {{ $trip->penumpang }} pax
                                </p>
                            </div>
                            <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                                <span class="px-2 py-0.5 rounded-lg text-[9px] font-black {{ $badgeClass }}">{{ $daysLabel }}</span>
                                <span class="px-2 py-0.5 rounded-lg text-[9px] font-black {{ $statusClass }}">{{ $trip->status }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
