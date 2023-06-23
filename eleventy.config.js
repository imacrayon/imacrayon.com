const pluginWebc = require("@11ty/eleventy-plugin-webc");
const pluginRss = require("@11ty/eleventy-plugin-rss");
const pluginSyntaxHighlight = require("@11ty/eleventy-plugin-syntaxhighlight");
const pluginDrafts = require("./eleventy.config.drafts.js");
const pluginImages = require("./eleventy.config.images.js");
const pluginDates = require("./eleventy.config.dates.js");
const pluginWebmentions = require("./eleventy.config.webmentions.js");

const markdownItFigures = require('markdown-it-image-figures');
const markdownItAnchor = require("markdown-it-anchor");

module.exports = function (eleventyConfig) {
  eleventyConfig.addPassthroughCopy('img');
  eleventyConfig.addPassthroughCopy('css');
  eleventyConfig.addPassthroughCopy('fonts');
  eleventyConfig.addPassthroughCopy('humans.txt');

  eleventyConfig.addPlugin(pluginDrafts);
  eleventyConfig.addPlugin(pluginImages);
  eleventyConfig.addPlugin(pluginDates);
  eleventyConfig.addPlugin(pluginWebmentions);
  eleventyConfig.addPlugin(pluginRss);
  eleventyConfig.addPlugin(pluginSyntaxHighlight);
  eleventyConfig.addPlugin(pluginWebc);

  eleventyConfig.addCollection('latest', function (collection) {
    return collection.getAllSorted().filter(item => {
      return item.data.tags && item.data.tags.some(tag => ['words', 'pictures'].includes(tag))
    }).reverse()
  });

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

  eleventyConfig.addFilter("year", dateObj => {
    return DateTime.fromJSDate(dateObj, { zone: 'America/Chicago' }).toFormat("yyyy");
  });

  eleventyConfig.amendLibrary("md", markdown => {
    markdown.use(markdownItFigures, {
      figcaption: 'title',
    })

    markdown.use(markdownItAnchor, {
      permalink: markdownItAnchor.permalink.ariaHidden({
        placement: "after",
        class: "direct-link",
        symbol: "#",
        ariaHidden: false,
      }),
      level: [1, 2, 3, 4],
      slugify: eleventyConfig.getFilter("slugify")
    });
  });

  return {
    templateFormats: [
      "md",
      "njk",
      "html"
    ],
    markdownTemplateEngine: "njk",
    htmlTemplateEngine: "njk",
    dir: {
      input: "content",
      includes: "../_includes",
      data: "../_data",
      output: "_site"
    },
  };
};
