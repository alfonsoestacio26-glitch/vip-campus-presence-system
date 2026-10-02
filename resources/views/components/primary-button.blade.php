<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center bg-emerald-700 hover:bg-emerald-800 focus:bg-emerald-800 active:bg-emerald-900 text-white font-medium text-sm px-5 py-2.5 rounded-xl shadow-sm hover:shadow transition duration-150 border border-transparent disabled:opacity-50']) }}>
    {{ $slot }}
</button>
