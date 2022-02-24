@props(['page'])

<nav class="flex items-center justify-end space-x-6">
  <x-nav-link href="/pictures" :active="$page->isActive('/pictures*')">Pictures</x-nav-link>
  <x-nav-link href="/about" :active="$page->isActive('/about')">About</x-nav-link>
</nav>
