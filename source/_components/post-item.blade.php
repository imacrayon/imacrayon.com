@props(['post'])

<li class="relative font-display overflow-hidden space-y-2">
  <h1 class="text-3xl sm:text-5xl font-extrabold break-words">
    <a href="{{ $post->getUrl() }}" class="inline hover:bg-peach-100 hover:text-gray-900 group-focus:text-gray-900">{{ $post->title }}</a>
  </h1>
  <x-post-date :post="$post" />
</li>
