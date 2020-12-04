@props(['post'])

<time {{ $attributes->merge(['class' => 'block text-gray-500 text-xs uppercase tracking-widest']) }} datetime="{{ $post->getDate()->format(DATE_W3C) }}">
  {{ $post->getDate()->format('F j, Y') }}
</time>
