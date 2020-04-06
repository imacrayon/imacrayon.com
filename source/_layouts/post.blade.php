@extends('_layouts.base')

@push('meta')
<meta property="og:title" content="{{ $page->title }}" />
<meta property="og:type" content="article" />
<meta property="og:url" content="{{ $page->getUrl() }}"/>
<meta property="og:description" content="{{ $page->description }}" />
@endpush

@section('main')
    <article>
        @if ($page->cover_image)
            <img src="{{ $page->cover_image }}" alt="{{ $page->title }} cover image" class="-mx-6">
        @endif

        <h1 class="h1">{{ $page->title }}</h1>

        <div class="sm:flex justify-between items-start mt-4">
            <time class="my-2 inline-block mr-8 leading-none text-gray-600 text-xs uppercase tracking-wide" datetime="{{ $page->getDate()->format(DATE_W3C) }}">{{ date('F j, Y', $page->date) }}</time>
            @if ($page->categories)
                <div>
                    @foreach ($page->categories as $i => $category)
                        <a
                            href="{{ '/words/categories/' . $category }}"
                            title="View posts in {{ $category }}"
                            class="px-3 py-1 inline-block leading-none text-gray-600 text-xs uppercase tracking-wide border border-gray-200 rounded hover:border-gray-400 focus:border-gray-400 hover:text-gray-900 focus:text-gray-900"
                        >{{ $category }}</a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="rich-text my-8 md:my-12">
            @yield('content')
        </div>

        <hr class="my-8 md:my-12 -mx-6">

        <nav class="sm:flex justify-between text-sm sm:text-base leading-tight">
            <div class="mr-4 mb-4">
                @if ($next = $page->getNext())
                    <a class="hover:text-gray-900 flex justify-start items-center" href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}">
                        <span class="flex-none mr-2">&LeftArrow;</span>
                        <span>{{ $next->title }}</span>
                    </a>
                @endif
            </div>

            <div class="ml-4 mb-4">
                @if ($previous = $page->getPrevious())
                    <a class="hover:text-gray-900 flex justify-end items-center text-right" href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}">
                        <span>{{ $previous->title }}</span>
                        <span class="flex-none ml-2">&RightArrow;</span>
                    </a>
                @endif
            </div>
        </nav>
    </article>
@endsection
