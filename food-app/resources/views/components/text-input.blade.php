@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-teal-light bg-white text-gray-900 focus:border-teal-medium focus:ring-teal-light rounded-md shadow-sm transition-colors']) }}>
