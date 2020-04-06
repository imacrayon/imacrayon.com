---
pagination:
    collection: posts
    perPage: 6
---
@extends('_layouts.base')

@section('main')
@foreach ($pagination->items as $post)
    @include('_components.post-item')
@endforeach

@if ($pagination->pages->count() > 1)
    <nav class="flex -mx-4 mt-8 text-xl font-medium">
        @if ($previous = $pagination->previous)
            <a
                href="{{ $previous }}"
                title="Previous Page"
                class="p-4 link"
            >&LeftArrow;</a>
        @endif

        @foreach ($pagination->pages as $pageNumber => $path)
            <a
                href="{{ $path }}"
                title="Go to Page {{ $pageNumber }}"
                class="p-4 {{ $pagination->currentPage == $pageNumber ? 'line-through font-normal text-gray-500' : 'hover:text-gray-900' }}"
            >{{ $pageNumber }}</a>
        @endforeach

        @if ($next = $pagination->next)
            <a
                href="{{ $next }}"
                title="Next Page"
                class="p-4 hover:text-gray-900"
            >&RightArrow;</a>
        @endif
    </nav>
@endif
@stop
