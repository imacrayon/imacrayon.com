<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="referrer" content="always">
    <link rel="canonical" href="{{ $page->getUrl() }}">

    <title>{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}</title>
    <meta name="description" content="{{ $page->description ?? $page->siteDescription }}">

    <link rel="icon" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
    <link rel="manifest" href="/site.webmanifest" />
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#fbbcb6">
    <meta name="msapplication-TileColor" content="#feebe9">
    <meta name="theme-color" content="#feebe9">

    <meta property="og:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->siteDescription }}" />

    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@ima_crayon">
    <meta name="twitter:creator" content="@ima_crayon">

    {{-- indielogin.com --}}
    <link href="https://twitter.com/ima_crayon" rel="me">
    <link href="/feed.atom" type="application/atom+xml" rel="alternate" title="{{ $page->siteName }} Atom Feed">

    <x-google-font src="https://fonts.googleapis.com/css2?family=Rubik:wght@400;800&family=Bitter:ital,wght@0,400;0,700;1,400&family=IBM+Plex+Mono" />
    <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">

    @stack('head')
  </head>
  <body class="text-gray-700 font-sans antialiased">
    <header role="banner" class="mt-12 px-4 sm:px-6">
      <div class="sm:text-xl max-w-prose mx-auto">
        <a class="sr-only block bg-black text-white text-lg text-center font-bold focus:not-sr-only" href="#main">
          <span class="block p-4">Skip to content</span>
        </a>
        <div class="flex items-center">
          <a class="text-gray-500 {{ $page->isActive('/') ? '' : 'hover:text-gray-900 hover:bg-peach-100' }}" href="/" title="{{ $page->siteName }} home">
            I'm a crayon
          </a>
          <div class="flex flex-1 justify-end items-center">
            <x-navigation :page="$page" />
          </div>
        </div>
      </div>
    </header>
    <main id="main">
      @yield('content')
    </main>
    <footer class="mb-12 flex justify-center">
      <x-navigation :page="$page" />
    </footer>
  </body>
</html>
