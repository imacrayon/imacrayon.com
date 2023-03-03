const p = require("path");
const fs = require("fs");
const { DateTime } = require("luxon");
const markdownItFigures = require('markdown-it-image-figures');
const markdownItAnchor = require("markdown-it-anchor");
const pluginWebc = require("@11ty/eleventy-plugin-webc");

const pluginRss = require("@11ty/eleventy-plugin-rss");
const pluginSyntaxHighlight = require("@11ty/eleventy-plugin-syntaxhighlight");
const pluginImage = require('@11ty/eleventy-img')

const image = {
  path: (src) => src.replace('/img', `${__dirname}/_includes/img`),
  options: {
    widths: [686, 1576],
    formats: ['avif', 'jpeg'],
    outputDir: './_site/img'
  },
  attrs: {
    sizes: 'calc(100vw - 2rem)',
    loading: 'lazy',
    decoding: 'async'
  }
}

module.exports = function (eleventyConfig) {
  eleventyConfig.ignores.add("README.md");

  eleventyConfig.addPassthroughCopy({ "_static": "/" });

  eleventyConfig.addPlugin(pluginRss);
  eleventyConfig.addPlugin(pluginSyntaxHighlight);
  eleventyConfig.addPlugin(pluginWebc);

  eleventyConfig.addCollection('latest', function (collection) {
    return collection.getAllSorted().filter(item => {
      return item.data.tags && item.data.tags.some(tag => ['words', 'pictures'].includes(tag))
    }).reverse()
  });

  eleventyConfig.addFilter('version', path => {
    let source = p.join('_site', path)
    if (!fs.existsSync(source)) return `${path}?id=${Date.now()}`;

    let content = fs.readFileSync(source, 'utf8');
    let hash = 0;
    for (let i = 0, len = content.length; i < len; i++) {
      let chr = content.charCodeAt(i);
      hash = (hash << 5) - hash + chr;
      hash |= 0; // Convert to 32bit integer
    }

    return `${path}?id=${hash}`;
  })

  const WIDONT_REGEX = /([^\s])\s+([^\s]+)\s*$/
  const DASH_REGEX = /-/g

  eleventyConfig.addFilter('widont', str => {
    return str.replace(WIDONT_REGEX, (str, lead, word) => {
      // Prefer replacing hyphens inside last word if present
      if (word.indexOf('-') >= 0) {
        return lead + ' ' + word.replace(DASH_REGEX, '&#8209;')
      }
      return lead + '&nbsp;' + word
    })
  })

  const responsiveImage = async function (src, alt = '', widths = null) {
    image.options.widths = widths || image.options.widths
    const metadata = await pluginImage(image.path(src), image.options)
    return pluginImage.generateHTML(metadata, {
      alt,
      ...image.attrs
    })
  }
  eleventyConfig.addFilter('responsiveImage', responsiveImage)

  eleventyConfig.addFilter("readableDate", dateObj => {
    return DateTime.fromJSDate(dateObj, { zone: 'America/Chicago' }).toFormat("dd LLL yyyy");
  });

  // https://html.spec.whatwg.org/multipage/common-microsyntaxes.html#valid-date-string
  eleventyConfig.addFilter('htmlDate', dateObj => {
    return DateTime.fromJSDate(dateObj, { zone: 'America/Chicago' }).toFormat('yyyy-LL-dd');
  });

  eleventyConfig.addFilter("year", dateObj => {
    return DateTime.fromJSDate(dateObj, { zone: 'America/Chicago' }).toFormat("yyyy");
  });

  eleventyConfig.addFilter("slice", (array, n) => {
    if (!Array.isArray(array) || array.length === 0) {
      return [];
    }

    if (n < 0) {
      return array.slice(n);
    }

    return array.slice(0, n);
  });


  eleventyConfig.addFilter("webmentions", page => {
    let file = `_includes/webmentions${page.filePathStem}.json`
    if (!fs.existsSync(file)) return []

    let content = fs.readFileSync(file);
    const verbs = {
      'in-reply-to': 'replied',
      'like-of': 'liked',
      'repost-of': 'retweeted',
      'bookmark-of': 'bookmarked',
      'mention-of': 'mentioned',
      'rsvp': 'RSVPed',
      'follow-of': 'followed',
    }

    return JSON.parse(content).map(data => ({
      author: data.author,
      url: data.url,
      verb: verbs[data['wm-property']],
      date: new Date(data['published'] || data['wm-received']),
      text: data?.content?.text
    }))
  })

  // Customize Markdown library and settings
  eleventyConfig.amendLibrary("md", markdown => {
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

    markdown.use(markdownItFigures, {
      figcaption: 'title',
    })

    markdown.use(markdownItAnchor, {
      permalink: markdownItAnchor.permalink.ariaHidden({
        placement: "after",
        class: "direct-link",
        symbol: "#",
      }),
      level: [1, 2, 3, 4],
      slugify: eleventyConfig.getFilter("slug")
    });
  });

  // Override @11ty/eleventy-dev-server defaults (used only with --serve)
  eleventyConfig.setServerOptions({
    showVersion: true,
  });

  return {
    templateFormats: [
      "md",
      "njk",
      "html"
    ],
  };
};
