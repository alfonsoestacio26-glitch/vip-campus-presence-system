<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center bg-white border border-gray-200 text-gray-700 font-medium text-sm px-5 py-2.5 rounded-xl shadow-xs hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition duration-150 disabled:opacity-50']) }}>
    {{ $slot }}
</button>
