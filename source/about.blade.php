@extends('_layouts.base')

@push('meta')
<meta property="og:title" content="About {{ $page->siteName }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ $page->getUrl() }}"/>
<meta property="og:description" content="A little bit about {{ $page->siteName }}" />
@endpush

@section('main')
<div class="flex sm:items-center">
    <img src="/assets/img/christian-taylor.jpg"
        alt="Photo of Christian Taylor"
        class="block flex-none rounded-full h-16 w-16 sm:h-56 sm:w-56 mr-6 my-6">

    <div class="rich-text">
        <p>
            I'm Christian Taylor, a full-stack developer and visual artist from Wichita, Kansas.
            I build online software at a company I co-founded called <a href="https://moonbaselabs.com">Moonbase Labs</a>.
            I maintain a few open source things on <a href="https://github.com/imacrayon">GitHub</a> and through <a href="https://devict.org">devICT</a>.
        </p>
        <p>My twitter handle is <a href="https://twitter.com/ima_crayon">@ima_crayon</a>.</p>
    </div>
</div>
@endsection
