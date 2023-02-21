---
layout: post.webc
title: Cranking My Website Up to Eleventy
date: 2023-02-04 12:19:00
description: A fresh coat of a paint and a new tech stack.
tags:
   - eleventy
   - html
   - css
---

At about the same time I started a design refresh on this website, [Zach Leatherman launched WebC](https://www.zachleat.com/twitter/1568270015094464512/), it's a small compiler used to author websites with single file components. I'd been feeling NPM-dependency-hell-burnout lately and was looking for a way to simplify my website's tech stack and return to good 'ol plain HTML & CSS; [Eleventy](https://11ty.dev) paired with [WebC](https://www.11ty.dev/docs/languages/webc/) felt like just enough abstraction without straying to far away from the web platform. So I did what many (all?) developers do with their personal site: I went all-in, scrapped everything, and rebuilt it all from scratch. I cranked my website up to Eleventy!

![The &quot;up to eleven&quot; volume knobs from the film This Is Spinal Tap](/img/words/2023/11ty.jpg "The numbers all go to eleven...It's not ten. You see, most blokes will be playing at ten.")

## Eleventy is fast and light

Eleventy has a small footprint, currently the `node_modules` folder for this website, including four plugins, totals 34MB. Before now I wasn't convinced a Node project could be that small. In comparison, the `node_modules` for my old [Jigsaw](https://jigsaw.tighten.com)-powered blog weighed in at 190MB. Similarly, Next.js and Gatsby base installs start at a chonky 230MB and 368MB respectively.

While getting up and going with Eleventy is fast, (you only need an index.html file to start) it's [build time is also among the fastest](https://www.zachleat.com/web/build-benchmark/). Recent benchmarks show that it outperforms most other static site generators when transforming markdown files into HTML.

## Organize code with WebC

WebC provides is a simple way to co-locate your HTML, CSS, and JavaScript. Here's an abbreviated example of the intro component that appears on my new homepage:

```html
<figure>
  <img src="/img/christian-taylor.jpg" alt="Christian Taylor's mug shot" width="64" height="64">
  <figcaption>
    <h1>Christian Taylor</h1>
    <p>Co-Founder of Moonbase Labs</p>
  </figcaption>
</figure>
<p>I’m a full stack developer...</p>

<style webc:scoped>
  :host {
    display: block;
    padding-block: 2.5vh;
  }
  :host figure {
    display: flex;
    align-items: center;
    gap: 1rem;
  }
  :host img {
    border-radius: 100%;
  }
  ...
</style>
```

Notice the `webc:scoped` attribute on the `<style>` tag, it instructs the WebC parser to replace `:host` with a randomly generated CSS class so that all the styles are scoped to only the elements within the component.

As another bonus, all of the `<style>` and `<script>` tags in all of the components on the page are bundled, minified, and injected right into the `<head>` of the page, so your website is optimized with critical CSS out of the box.

## View the source

You can view all the [source code for this site on GitHub](https://github.com/imacrayon/imacrayon.com).
