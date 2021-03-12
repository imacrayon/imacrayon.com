@extends('_layouts.base')

@section('content')
<article>
  <div class="pt-12 px-4 sm:px-6">
    <div class="mx-auto text-xl max-w-prose">
      <div class="space-y-2">
        <h1 class="font-display text-3xl sm:text-5xl font-extrabold break-word overflow-hidden">{{ $page->title }}</h1>
        <div class="text-sm text-gray-500 py-1">
          <time datetime="{{ $page->getDate()->format('Y') }}">{{ $page->getDate()->format('Y') }}</time><br>
          {{ $page->media }}<br>
          {{ $page->dimentions }}
          @if ($page->owner)
            <br>Collection of {{ $page->owner }}
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="my-10 sm:px-6">
    <div class="mx-auto text-xl max-w-prose">
      <div class="space-y-px">
        <img loading="lazy" width="826" src="{{ $page->image }}" alt="{{ $page->title }}" />
        @yield('content')
      </div>
    </div>
  </div>

  <div class="pt-12 px-4 sm:px-6">
    <div class="mx-auto text-xl max-w-prose">
      <nav class="sm:flex justify-between leading-tight mb-12">
          @if ($next = $page->getNext())
            <a class="group flex justify-start hover:text-gray-900 hover:bg-peach-50 sm:w-1/2" href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}">
              <span class="flex-shrink-0 flex items-center group-hover:bg-peach-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" class="h-6 w-6 text-gray-400 group-hover:text-peach-400" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
              </span>
              <span class="py-3 px-6 flex items-center">
                <span class="space-y-1">
                  <span class="font-display font-bold">{{ $next->title }}</span>
                  <x-picture-date :picture="$next" />
                </span>
              </span>
            </a>
          @else
            <div></div>
          @endif
          @if ($previous = $page->getPrevious())
            <a class="group flex justify-end text-right hover:text-gray-900 hover:bg-peach-50 sm:w-1/2" href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}">
              <span class="py-3 px-6 flex items-center">
                <span class="space-y-1">
                  <span class="font-display font-bold">{{ $previous->title }}</span>
                  <x-picture-date :picture="$previous" />
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
    </div>
  </div>
</article>
@overwrite
