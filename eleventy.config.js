import { IdAttributePlugin } from "@11ty/eleventy";
import SyntaxHighlightPlugin from "@11ty/eleventy-plugin-syntaxhighlight";
import DraftsPlugin from "./_config/drafts.js";
import FeedsPlugin from "./_config/feeds.js";
import ImagesPlugin from "./_config/images.js";
import FiltersPlugin from "./_config/filters.js";
import WebmentionsPlugin from "./_config/webmentions.js";

export default async function (eleventyConfig) {
  eleventyConfig.addPassthroughCopy({ "./public/": "/" })
  eleventyConfig.addBundle("css", { toFileDirectory: "dist" });
  eleventyConfig.addBundle("js", { toFileDirectory: "dist" });

  eleventyConfig.addPlugin(DraftsPlugin);
  eleventyConfig.addPlugin(FeedsPlugin);
  eleventyConfig.addPlugin(FiltersPlugin);
  eleventyConfig.addPlugin(IdAttributePlugin);
  eleventyConfig.addPlugin(ImagesPlugin);
  eleventyConfig.addPlugin(SyntaxHighlightPlugin, { preAttributes: { tabindex: 0 } });
  eleventyConfig.addPlugin(WebmentionsPlugin);

  eleventyConfig.addCollection('feed', function (collection) {
    return collection.getAllSorted().filter(item => {
      return item.data.tags && item.data.tags.some(tag => ['words', 'notes', 'pictures'].includes(tag))
    })
  });
};

export const config = {
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
