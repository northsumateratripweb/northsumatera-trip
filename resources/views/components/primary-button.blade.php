<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full bg-blue-700 hover:bg-blue-800 text-white font-black py-5 rounded-[24px] shadow-xl shadow-blue-500/20 transition-all text-xs uppercase tracking-widest transform hover:-translate-y-1 inline-flex items-center justify-center']) }}>
    {{ $slot }}
</button>
