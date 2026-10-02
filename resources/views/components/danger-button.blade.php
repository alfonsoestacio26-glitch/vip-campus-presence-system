<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-800 text-white font-medium text-sm px-5 py-2.5 rounded-xl shadow-sm transition duration-150 border border-transparent disabled:opacity-50']) }}>
    {{ $slot }}
</button>
