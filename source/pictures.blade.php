@extends('_layouts.base')

@section('content')
<div class="py-12">
  <ul class="mx-auto px-4 max-w-2xl space-y-24">
      @foreach ($pictures as $picture)
        <li class="relative space-y-px">
          <img class="-mx-8 max-w-none" loading="lazy" src="{{ $picture->image }}" alt="{{ $picture->title }}" />
          <div class="text-sm text-gray-500 py-1 px-1 sm:px-0">
            <h2 class="inline italic">
              <a class="hover:bg-gold-100 hover:text-gold-800" href="{{ $picture->getUrl() }}">{{ $picture->title }}<span class="absolute inset-0"></span></a>
            </h2>,
            <time datetime="{{ $picture->getDate()->format('Y') }}">{{ $picture->getDate()->format('Y') }}</time><br>
            {{ $picture->media }}<br>
            {{ $picture->dimentions }}
            @if ($picture->owner)
              <br>Collection of {{ $picture->owner }}
            @endif
          </div>
        </li>
      @endforeach
  </ul>
</div>
@overwrite
