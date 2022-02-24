@extends('_layouts.base')

@section('content')
<div class="space-y-12">
  <div class="mx-auto px-4 max-w-2xl">
    <div class="border-l-4 border-gold-200 py-3 pl-6">
      <h1 class="text-2xl sm:text-3xl text-gray-900 font-medium">{{ $page->title }}</h1>
      <div>@yield('content')</div>
    </div>
    <ul class="space-y-12">
      @foreach ($page->posts($posts) as $post)
        <x-post-item :post="$post" />
      @endforeach
    </ul>
  </div>
</div>
@overwrite
