@extends('_layouts.base')

@section('content')
<article>
  <div class="pt-12">
    <div class="mx-auto px-4 max-w-2xl">
      <div class="space-y-2">
        <h1 class="text-2xl sm:text-3xl font-medium break-words">{{ $page->title }}</h1>
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

  <div class="my-10">
    <div class="mx-auto px-4 max-w-2xl">
      <div class="space-y-px">
        <img loading="lazy" width="826" src="{{ $page->image }}" alt="{{ $page->title }}" />
        @yield('content')
      </div>
    </div>
  </div>

  <div class="pt-12">
    <div class="mx-auto px-4 max-w-2xl">
      <nav class="my-12 grid sm:grid-cols-2 sm:gap-8">
        @if ($next = $page->getNext())
          <a class="group border-b border-gray-200 flex hover:border-gold-200 hover:bg-gold-50 hover:text-gold-800" href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}">
            <span class="flex-shrink-0 flex items-center group-hover:bg-gold-100">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" class="h-6 w-6 text-gray-400 group-hover:text-gold-400" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
            </span>
            <span class="flex-1 py-3 px-6 flex items-center justify-end text-right">
              <span class="space-y-1">
                <span class="font-medium">{{ $next->title }}</span>
                <x-post-date :post="$next" />
              </span>
            </span>
          </a>
        @endif
        @if ($previous = $page->getPrevious())
          <a class="group border-b border-gray-200 flex hover:border-gold-200 hover:bg-gold-50 hover:text-gold-800" href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}">
            <span class="flex-1 py-3 px-6 flex items-center">
              <span class="space-y-1">
                <span class="font-medium">{{ $previous->title }}</span>
                <x-post-date :post="$previous" />
              </span>
            </span>
            <span class="flex-shrink-0 flex items-center group-hover:bg-gold-100">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" class="h-6 w-6 text-gray-400 group-hover:text-gold-400" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </span>
          </a>
        @endif
      </nav>
    </div>
  </div>
</article>
@overwrite
