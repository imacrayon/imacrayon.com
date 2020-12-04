@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center line-through text-gray-500 hover:text-gray-500'
            : 'inline-flex items-center hover:text-gray-900 hover:bg-peach-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
  {{ $slot }}
</a>
