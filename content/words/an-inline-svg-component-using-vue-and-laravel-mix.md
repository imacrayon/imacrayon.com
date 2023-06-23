---
title: An Inline SVG Component Using Vue & Laravel Mix
date: 2019-08-25 14:24:00
description: Building an SVG icon Vue component
tags:
  - vue
  - laravel
  - php
  - svg
---

I wanted a Vue component that could pull any SVG from a file and inline it onto the page. [View a gist of the full code here](https://gist.github.com/imacrayon/f72ce5e40ec30d047b5eda0ae6ea0e39).

[Jeffery Way](https://laracasts.com/series/practical-vue-components/episodes/6) and [Caleb Porzio](https://calebporzio.com/using-inline-svgs-in-vue-compoments/) have already tackled this problem. However, their solutions wrapped the SVG output in a `<div>` tag. Extra elements like this feel gross to me, so I modified their work and came up with a solution that outputs clean SVGs instead.

## The Webpack Config

First, Webpack needs to be configured to handle SVG paths with [HTML Loader](https://github.com/webpack-contrib/html-loader). By default Laravel Mix is configured to use File Loader, you can override this config with the code below:

```js
mix.override(config => {
    config.module.rules.find(rule => rule.test.test('.svg')).exclude = /\.svg$/

    config.module.rules.push({
        test: /\.svg$/,
        use: [{ loader: 'html-loader' }],
    })
})
```

## The Vue Component

The Vue component should accept an SVG file name as a prop and then output the SVG onto the page, like this:

```html
<icon name="user" />
```

Here's the basic Vue component structure:

```js
<template>
    <!-- <svg> element will eventually render here -->
</template>

<script>
export default {
    props: ['name'],
}
</script>
```

Next, we will pull the SVG file and transform it into a DOM Node. Using a DOM node we can work with our SVG more easily than trying to parse the raw SVG code as a string. I've added a `created` hook that will do this below:

```js
<template>
    <!-- <svg> element will eventually render here -->
</template>

<script>
export default {
    props: ['name'],

    created() {
        const div = document.createElement('div')
        // Adjust the path below to point to your own SVG directory
        div.innerHTML = require('../../' + this.name + '.svg')

        const fragment = document.createDocumentFragment()
        fragment.appendChild(div)

        const svg = fragment.querySelector('svg')
    },
}
</script>
```

As soon as our Vue component is created, we create a `<div>` and set its `innerHTML` to the SVG file's HTML. Then we place the `<div>` inside of a document fragment and query for the SVG node inside. Building a document fragment in this way lets us use the Vue DOM API without having to actually insert any elements into our webpage's real DOM.

Finally, now that we have our `svg` node we can finish off the `<template>` code that will render the SVG onto the page.

```js
<template>
    <svg v-bind="attributes" v-html="html"></svg>
</template>

<script>
export default {
    props: ['name'],

    data: () => ({
        attributes: {},
        html: '',
    }),

    created() {
        const div = document.createElement('div')
        div.innerHTML = require('../../' + this.name + '.svg')

        const fragment = document.createDocumentFragment()
        fragment.appendChild(div)

        const svg = fragment.querySelector('svg')

        const attributes = Array.from(svg.attributes).reduce((attrs, attr) => {
            attrs[attr.name] = attr.value

            return attrs
        }, {})

        this.attributes = Object.assign(attributes, this.$attrs)

        this.html = svg.innerHTML
    },
}
</script>
```

In the code above, we grab all of the SVG node's attributes and merge them with any attributes that might exist on our Vue component (contained in `$attrs`). Then we copy over the `innerHTML` from our SVG node and output in our Vue template using the `v-html` directive.

**And we're done!** Now we have a super flexible inline SVG component: Any attributes applied to the component will be inherited by the SVG.

```html
<icon name="user" width="16px" height="16px" fill="red"></icon>
```
