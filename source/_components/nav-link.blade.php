@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center line-through text-gray-500 hover:text-gray-500'
            : 'inline-flex items-center hover:bg-gold-100 hover:text-gold-800';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
  {{ $slot }}
</a>
