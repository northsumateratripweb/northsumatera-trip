@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-slate-50 border border-slate-100 rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-blue-700/5 focus:border-blue-700 outline-none transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 placeholder:font-medium']) }}>
