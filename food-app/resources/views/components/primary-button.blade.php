<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-teal-dark border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-medium focus:bg-teal-medium active:bg-teal-dark focus:outline-none focus:ring-2 focus:ring-teal-light focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg']) }}>
    {{ $slot }}
</button>
