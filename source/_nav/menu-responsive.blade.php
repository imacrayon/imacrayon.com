<nav id="js-nav-menu" class="hidden lg:hidden pt-8">
    <ul class="container max-w-3xl mx-auto">
        <li class="px-6">
            <a
                title="{{ $page->siteName }} About"
                href="/about"
                class="block {{ $page->isActive('/about') ? 'line-through text-gray-500 hover:text-gray-50' : 'text-gray-800' }}"
            >About</a>
        </li>
    </ul>
</nav>
