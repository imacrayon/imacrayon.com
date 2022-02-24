@extends('_layouts.base')

@section('content')
<div class="py-12">
  <ul class="mx-auto px-4 max-w-2xl space-y-12">
    @foreach ($posts as $post)
      <x-post-item :post="$post" />
    @endforeach
  </ul>
</div>
@overwrite
