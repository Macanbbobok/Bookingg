@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-primary-50 text-primary-600 hover:bg-primary-50 hover:text-primary-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md'
            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>