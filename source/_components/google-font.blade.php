@props(['src'])

{{--
    https://gist.github.com/leMaur/e41f2205fad1651b1eb7ccbd60f09d44
  - 1. Preemptively warm up the fonts’ origin.
  -
  - 2. Initiate a high-priority, asynchronous fetch for the CSS file. Works in
  -    most modern browsers.
  -
  - 3. Initiate a low-priority, asynchronous fetch that gets applied to the page
  -    only after it’s arrived. Works in all browsers with JavaScript enabled.
  -
  - 4. In the unlikely event that a visitor has intentionally disabled
  -    JavaScript, fall back to the original method. The good news is that,
  -    although this is a render-blocking request, it can still make use of the
  -    preconnect which makes it marginally faster than the default.
--}}

{{-- [1] --}}
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

{{-- [2] --}}
<link rel="preload" as="style" href="{{ $src }}&display=swap" />

{{-- [3] --}}
<link rel="stylesheet" href="{{ $src }}&display=swap" media="print" onload="this.media='all'" />

{{-- [4] --}}
<noscript>
  <link rel="stylesheet" href="{{ $src }}&display=swap" />
</noscript>
