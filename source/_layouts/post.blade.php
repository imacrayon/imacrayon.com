@extends('_layouts.base')

@section('content')
<div class="pt-12 px-4 sm:px-6">
  <article class="mx-auto text-xl max-w-prose">
    <div class="space-y-2">
      <h1 class="font-display text-3xl sm:text-5xl font-extrabold break-word overflow-hidden">{{ $page->title }}</h1>
      <div class="font-display justify-between items-start grid sm:grid-cols-2 gap-1">
        <x-post-date :post="$page" />
        @if ($page->categories)
          <div class="flex justify-end space-x-1">
            @foreach ($page->categories as $i => $category)
              <a href="{{ '/words/categories/' . $category }}" class="px-3 py-1 inline-block leading-none text-gray-800 text-xs uppercase tracking-widest bg-gray-100 border-transparent border-b hover:text-gray-900 focus:text-gray-900 hover:bg-peach-100 focus:bg-peach-100 hover:border-peach-400 focus:border-peach-400">
                {{ $category }}
              </a>
            @endforeach
          </div>
        @endif
      </div>
    </div>

    <div class="my-10 prose sm:prose-xl max-w-full font-serif">
      @yield('content')
    </div>

    <nav class="sm:flex justify-between leading-tight mb-12">
        @if ($next = $page->getNext())
          <a class="group flex justify-start w-1/2 hover:text-gray-900 hover:bg-peach-50" href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}">
            <span class="flex-shrink-0 flex items-center group-hover:bg-peach-100">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" class="h-6 w-6 text-gray-400 group-hover:text-peach-400" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </span>
            <span class="py-3 px-6 flex items-center">
              <span class="space-y-1">
                <span class="font-display font-bold">{{ $next->title }}</span>
                <x-post-date :post="$next" />
              </span>
            </span>
          </a>
        @else
          <div></div>
        @endif
        @if ($previous = $page->getPrevious())
          <a class="group flex justify-end text-right w-1/2 hover:text-gray-900 hover:bg-peach-50" href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}">
            <span class="py-3 px-6 flex items-center">
              <span class="space-y-1">
                <span class="font-display font-bold">{{ $previous->title }}</span>
                <x-post-date :post="$previous" />
              </span>
            </span>
            <span class="flex-shrink-0 flex items-center group-hover:bg-peach-100">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" class="h-6 w-6 text-gray-400 group-hover:text-peach-400" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </span>
          </a>
        @else
          <div></div>
        @endif
    </nav>
  </article>
</div>
@overwrite
