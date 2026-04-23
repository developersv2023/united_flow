<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-3 bg-primary border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-wider hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 shadow-lg shadow-primary/30 transition-all ease-in-out duration-300']) }}>
    {{ $slot }}
</button>
