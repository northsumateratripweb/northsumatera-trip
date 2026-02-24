@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1']) }}>
    {{ $value ?? $slot }}
</label>
