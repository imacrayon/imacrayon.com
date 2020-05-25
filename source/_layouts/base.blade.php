<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="{{ $page->description ?? $page->siteDescription }}">

        <meta property="og:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ $page->getUrl() }}"/>
        <meta property="og:description" content="{{ $page->siteDescription }}" />

        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@ima_crayon">
        <meta name="twitter:creator" content="@ima_crayon">

        <title>{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}</title>

        <link rel="home" href="{{ $page->baseUrl }}">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#161e2e">
        <meta name="msapplication-TileColor" content="#161e2e">
        <meta name="theme-color" content="#ffffff">

        <link href="/words/feed.atom" type="application/atom+xml" rel="alternate" title="{{ $page->siteName }} Atom Feed">

        @stack('meta')

        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">

        <script>
            WebFontConfig = {
                google: {
                    families: [
                        'Inter:400,500,700',
                        'IBM Plex Mono',
                    ],
                }
            }
            ;(function(d) {
                var wf = d.createElement('script'), s = d.scripts[0]
                wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js'
                wf.async = true
                s.parentNode.insertBefore(wf, s)
            })(document)
        </script>
    </head>

    <body class="text-gray-600 leading-6 font-sans antialiased">
        <header class="mt-8 lg:mt-12" role="banner">
            <a
                class="sr-only block bg-black text-white text-lg text-center font-bold focus:not-sr-only"
                href="#main"
            >
                <span class="block p-4">Skip to content</span>
            </a>
            <div class="container flex items-center max-w-3xl mx-auto px-6">
                <h1>
                    <a class="{{ $page->isActive('/') ? 'text-gray-400' : 'text-gray-500 hover:text-gray-900' }}" href="/" title="{{ $page->siteName }} home">
                        <svg height="24" viewBox="0 0 471 470" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M81 0C36.265 0 0 36.265 0 81v308c0 44.735 36.265 81 81 81h308c44.735 0 81-36.265 81-81V81c0-44.735-36.265-81-81-81H81zm44.925 287.462l-29.767 29.767a9 9 0 00-2.636 6.364V367a9 9 0 009 9h44.319a8.998 8.998 0 006.364-2.636l29.767-29.767-57.047-56.135zm20.08-20.081l57.048 56.135 120.941-120.941-57.047-56.135-120.942 120.941zm224.109-110.926l-26.039 26.039-57.048-56.135 26.496-26.495a9 9 0 0112.728 0l43.863 43.863a9 9 0 010 12.728z"/></svg>
                    </a>
                </h1>
                <div class="flex flex-1 justify-end items-center">
                    @include('_nav.menu')

                    @include('_components.search')

                    @include('_nav.menu-toggle')
                </div>
            </div>
        </header>

        @include('_nav.menu-responsive')

        <main id="main" role="main" class="flex-auto w-full container max-w-3xl mx-auto my-8 lg:my-16 px-6">
            @yield('main')
        </main>

        <script src="{{ mix('js/main.js', 'assets/build') }}"></script>

        @stack('scripts')
    </body>
</html>
