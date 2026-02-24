<button {{ $attributes->merge(['type' => 'button', 'class' => 'w-full bg-slate-100 hover:bg-slate-200 text-slate-900 font-black py-5 rounded-[24px] transition-all text-xs uppercase tracking-widest inline-flex items-center justify-center']) }}>
    {{ $slot }}
</button>
