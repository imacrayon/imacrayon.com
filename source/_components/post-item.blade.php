@props(['post'])

<li class="relative overflow-hidden space-y-2">
  <h1 class="text-2xl sm:text-3xl font-medium break-words">
    <a href="{{ $post->getUrl() }}" class="inline hover:bg-gold-100 hover:text-gold-800 group-focus:text-gold-800">{{ $post->title }}</a>
  </h1>
  <x-post-date :post="$post" />
</li>
