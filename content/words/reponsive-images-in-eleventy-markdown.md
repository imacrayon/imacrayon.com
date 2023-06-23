---
title: Responsive Images in Eleventy Markdown
date: 2023-03-03 15:38:00
description: How I added support for responsive images in my Markdown templates
tags:
   - html
   - markdown
   - eleventy
---

I added image support to my Eleventy website. I was looking for a solution that would automatically take a lot of the grunt work out of preparing images for the web. When it comes to images, there's actually a lot to consider:

* You should serve images with the correct dimensions so they don't get distorted
* You should use `srcset` & `sizes` attributes to load different sized images based your user's viewport
* You should serve images in various formats (jpeg, avif, webp) so that modern browsers can load the page faster
* You should support lazy loading and async decoding to improve page speed

In addition to these technical concerns I wanted a solution that was easy to implement and would support adding captions to my images. I also wanted all of these features to be available to use in both my Eleventy templates and plain markdown files.

I settled on using theses two plugins that take care of the heavy lifting:

1. [eleventy-img](https://github.com/11ty/eleventy-img) provides all of the responsive image markup
2. [markdown-it-image-figures](https://github.com/Antonio-Laguna/markdown-it-image-figures) adds optional caption support to Markdown images

Here's how I stung all the configuration together in my `eleventy.config.js` file:

```js
const markdownItFigures = require('markdown-it-image-figures')
const pluginImage = require('@11ty/eleventy-img')

// Shared image configuration for templates & markdown
const image = {
  path: (src) => src.replace('/img', `${__dirname}/_includes/img`), // Source directory
  options: {
    widths: [686, 1576],
    formats: ['avif', 'jpeg'],
    outputDir: './_site/img' // Output directory
  },
  attrs: {
    sizes: 'calc(100vw - 2rem)',
    loading: 'lazy',
    decoding: 'async'
  }
}

// Add an Eleventy template shortcode
const responsiveImage = async function (src, alt = '', widths = null) {
  image.options.widths = widths || image.options.widths
  const metadata = await pluginImage(image.path(src), image.options)
  return pluginImage.generateHTML(metadata, {
    alt,
    ...image.attrs
  })
})
eleventyConfig.addAsyncShortcode('image', responsiveImage)

// Add markdown support
eleventyConfig.amendLibrary("md", markdown => {
  // Transform image markdown into responsive image markup
  markdown.renderer.rules.image = function (tokens, idx) {
    const token = tokens[idx]
    let src = image.path(token.attrGet('src'))
    const alt = token.content

    pluginImage(src, image.options)
    const metadata = pluginImage.statsSync(src, image.options)
    return pluginImage.generateHTML(metadata, {
      alt,
      ...image.attrs
    }, {
      whitespaceMode: "inline"
    })
  }

  // Add support for image captions
  markdown.use(markdownItFigures, {
    figcaption: 'title',
  })
})
```

This configuration assumes that you are storing your source images in `_includes/img` and that the resized and compressed images will be output to `_sites/img`. I wanted to author my image markup as if the image `src` was relative to the final output directory, so I included this line that rewrites the incoming image path to the correct source directory:

```js
src.replace('/img', `${__dirname}/_includes/img`)
```

With all that setup out to the way, you can use images in Markdown like this:

```md
![My image alt text](/img/my-image.jpg "My optional caption for this image.")
```

which will generate HTML like this:

```html
<figure>
  <picture>
    <source type="image/avif" srcset="/img/vGjvxtLm9u-686.avif 686w, /img/vGjvxtLm9u-1576.avif 1576w" sizes="calc(100vw - 2rem)">
    <source type="image/jpeg" srcset="/img/vGjvxtLm9u-686.jpeg 686w, /img/vGjvxtLm9u-1576.jpeg 1576w" sizes="calc(100vw - 2rem)">
    <img alt="My image alt text" loading="lazy" decoding="async" src="/img/vGjvxtLm9u-686.jpeg" width="1576" height="1576">
  </picture>
  <figcaption>My optional caption for this image.</figcaption>
</figure>
```

...and the same image markup can be generated within an Eleventy template like this:

```html
<figure>
  {% raw %}{% image "/img/my-image.jpg", "My image alt text", "calc(100vw - 2rem)" %}{% endraw %}
  <figcaption>My optional caption for this image.</figcaption>
</figure>
```
