<article class="relative my-8 md:my-12 first:mt-0">
    <time class="block leading-none text-gray-600 text-xs uppercase tracking-wide" datetime="{{ $post->getDate()->format(DATE_W3C) }}">
        {{ $post->getDate()->format('F j, Y') }}
    </time>

    <h2 class="h2 mt-2">
        <a
            href="{{ $post->getUrl() }}"
            title="Read more - {{ $post->title }}"
            class="group-link hover:text-gray-900"
        >{{ $post->title }}</a>
    </h2>

    <p class="text-base leading-6 sm:text-lg sm:leading-8">{!! $post->getExcerpt(200) !!}</p>
</article>
