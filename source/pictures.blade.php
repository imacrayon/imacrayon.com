@extends('_layouts.base')

@section('content')
<div class="py-12 sm:px-6">
  <ul class="text-xl max-w-prose mx-auto space-y-24">
      @foreach ($pictures as $picture)
        <li class="relative space-y-px">
          <img loading="lazy" width="826" src="{{ $picture->image }}" alt="{{ $picture->title }}" />
          <div class="text-sm text-gray-500 py-1 px-1 sm:px-0">
            <h2 class="inline italic">
              <a class="hover:bg-peach-100 hover:text-gray-900" href="{{ $picture->getUrl() }}">{{ $picture->title }}<span class="absolute inset-0"></span></a></h2>,
              <time datetime="{{ $picture->getDate()->format('Y') }}">{{ $picture->getDate()->format('Y') }}</time><br>
            {{ $picture->media }}<br>
            {{ $picture->dimentions }}
          </div>
        </li>
      @endforeach
  </ul>
</div>
@overwrite
