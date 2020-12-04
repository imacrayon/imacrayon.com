@extends('_layouts.base')

@section('content')
<div class="pt-12 px-4 sm:px-6">
  <div class="mx-auto text-xl max-w-prose space-y-12">
    <div class="border-l-4 border-peach-200 py-3 pl-6">
      <h1 class="text-3xl sm:text-5xl text-gray-900 font-extrabold">{{ $page->title }}</h1>
      <div class="text-xl">@yield('content')</div>
    </div>
    <ul class="space-y-12">
      @foreach ($page->posts($posts) as $post)
        <x-post-item :post="$post" />
      @endforeach
    </ul>
  </div>
</div>
@overwrite
