<button class="flex justify-center items-center text-gray-500 lg:hidden focus:outline-none focus:text-gray-900 hover:text-gray-900 ml-6"
    onclick="navMenu.toggle()"
>
    <svg id="js-nav-menu-show" class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>

    <svg id="js-nav-menu-hide" class="hidden fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/></svg>
</button>

@push('scripts')
<script>
    const navMenu = {
        toggle() {
            const menu = document.getElementById('js-nav-menu');
            menu.classList.toggle('hidden');
            menu.classList.toggle('lg:block');
            document.getElementById('js-nav-menu-hide').classList.toggle('hidden');
            document.getElementById('js-nav-menu-show').classList.toggle('hidden');
        },
    }
</script>
@endpush
