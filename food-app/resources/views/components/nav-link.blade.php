@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-teal-light text-sm font-medium leading-5 text-white focus:outline-none focus:border-teal-pastel transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-teal-pastel hover:text-white hover:border-teal-light focus:outline-none focus:text-white focus:border-teal-light transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
