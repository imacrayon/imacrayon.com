@props(['picture'])

<time {{ $attributes->merge(['class' => 'block text-gray-500 text-sm']) }} datetime="{{ $picture->getDate()->format(DATE_W3C) }}">
  {{ $picture->getDate()->format('Y') }}
</time>
