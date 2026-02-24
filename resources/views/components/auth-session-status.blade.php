@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'bg-emerald-50 border border-emerald-100 text-emerald-600 px-6 py-4 rounded-2xl text-xs font-black uppercase tracking-widest flex items-center gap-3']) }}>
        <div class="w-6 h-6 bg-emerald-500 rounded-lg flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>
        {{ $status }}
    </div>
@endif
