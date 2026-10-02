@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-200 bg-white text-gray-800 focus:border-emerald-600 focus:ring-emerald-600 rounded-xl shadow-xs text-sm py-2.5 px-3.5 placeholder:text-gray-400']) }}>
