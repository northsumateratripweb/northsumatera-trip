<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full bg-rose-600 hover:bg-rose-700 text-white font-black py-5 rounded-[24px] shadow-xl shadow-rose-500/20 transition-all text-xs uppercase tracking-widest transform hover:-translate-y-1 inline-flex items-center justify-center']) }}>
    {{ $slot }}
</button>
