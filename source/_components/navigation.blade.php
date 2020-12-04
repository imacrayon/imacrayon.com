@props(['page'])

<nav class="flex items-center justify-end space-x-6">
  <x-nav-link href="/about" :active="$page->isActive('/about')">About</x-nav-link>
  <x-nav-link href="/feed.atom" class="text-gray-500">RSS</x-nav-link>
</nav>
