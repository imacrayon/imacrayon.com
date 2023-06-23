---
title: CSS Scroll Padding
date: 2020-04-19 22:30:00
description: The CSS scroll-padding property
tags:
  - css
---

This weekend I ran across I hot tip by [Jeffrey Yasskin](https://twitter.com/jyasskin) which highlighted a CSS property I hadn't encountered before, `scroll-padding-top`:

<blockquote class="twitter-tweet"><p lang="en" dir="ltr">Best kept secret for websites with fixed headers: scroll-padding-top (<a href="https://t.co/L7muNZV9d5">https://t.co/L7muNZV9d5</a>) can make fragment links scroll the fragment to somewhere visible instead of under the header.</p>&mdash; Jeffrey Yasskin (@jyasskin) <a href="https://twitter.com/jyasskin/status/1250916297803620352?ref_src=twsrc%5Etfw">April 16, 2020</a></blockquote> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

I promptly added this new property to a project I'm currently working on, and now I've got some nice scroll functionality, no JavaScript required.

In my case the height of my app's sticky header is different between the mobile and desktop view, so I took advantage of CSS custom properties:

```css
html {
    --navbar-height: 57px;
    scroll-padding-top: calc(var(--navbar-height) + 47px);
}

@media (min-width: 768px) {
    html {
        --navbar-height: 73px;
    }
}
```
