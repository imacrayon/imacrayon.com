@extends('_layouts.base')

@push('head')
<script src="/assets/js/webmention.js" data-page-url="https://imacrayon.com/pictures/" async></script>
@endpush

@section('content')
<div class="pt-12">
  <article class="mx-auto px-4 max-w-2xl">
    <div class="space-y-2">
      <h1 class="text-2xl sm:text-3xl font-medium break-words">{{ $page->title }}</h1>
      <div class="grid sm:grid-cols-2 gap-1">
        <div>
          <x-post-date :post="$page" />
        </div>
        @if ($page->categories)
          <div class="text-xs uppercase tracking-widest flex justify-end">
            <div>
              @foreach ($page->categories as $i => $category)
                <a href="{{ '/words/categories/' . $category }}" class="hover:text-gold-800 focus:text-gold-800 hover:bg-gold-100 focus:bg-gold-100">{{ $category }}</a>@if(! $loop->last), @endif
              @endforeach
            </div>
          </div>
        @endif
      </div>
    </div>

    <div class="mt-10 prose max-w-full">
      @yield('content')
    </div>

    <nav class="my-12 border-t border-gray-200 grid sm:grid-cols-2 sm:border-0 sm:gap-8">
      @if ($next = $page->getNext())
        <a class="group border-b border-gray-200 flex hover:bg-gold-50 hover:text-gold-800" href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}">
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
        <a class="group border-b border-gray-200 flex hover:bg-gold-50 hover:text-gold-800" href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}">
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

    <div id="mentions" class="space-y-8 mb-12">
      <h2 class="text-2xl sm:text-3xl font-medium">Mentions</h2>
      @forelse($page->getWebmentions() as $webmention)
        <div class="text-base">
          <div class="flex items-center">
            <div class="mr-2 flex-shrink-0">
              <img loading="lazy" src="{{ $webmention->author->photo }}" class="h-8 w-8 rounded-full border border-gray-200 bg-white text-gray-500"/>
            </div>
            <div>
              <h3>
                <a href="{{ $webmention->author->url }}" class="font-medium hover:bg-gold-100 hover:text-gold-800">{{ $webmention->author->name }}</a>
                <a href="{{ $webmention->url }}" class="underline hover:bg-gold-100 hover:text-gold-800">{{ $webmention->verb }}</a>
                <span class="text-gray-500">on {{ $webmention->date->format('F j, Y') }}</span>
              </h3>
            </div>
          </div>
          @if ($webmention->text)
            <div class="mt-2">{{ $webmention->text }}</div>
          @endif
        </div>
      @empty
        <p class="italic text-gray-500">Nothing.</p>
      @endforelse
    </div>
  </article>
</div>
@overwrite
