@extends('_layouts.base')

@push('meta')
<meta property="og:title" content="{{ $page->title }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ $page->getUrl() }}"/>
<meta property="og:description" content="{{ $page->description }}" />
@endpush

@section('main')
<h1 class="h1">{{ $page->title }}</h1>

<div class="text-base leading-6 sm:text-lg sm:leading-8">
    @yield('content')
</div>

<hr class="my-8 md:my-12">

@foreach ($page->posts($posts) as $post)
    @include('_components.post-item')
@endforeach
@stop
