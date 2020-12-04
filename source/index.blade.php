---
pagination:
  collection: posts
---

@extends('_layouts.base')

@section('content')
<div class="py-12 px-4 sm:px-6">
  <ul class="text-xl max-w-prose mx-auto space-y-12">
    @foreach ($pagination->items as $post)
      <x-post-item :post="$post" />
    @endforeach
  </ul>
</div>
@overwrite
