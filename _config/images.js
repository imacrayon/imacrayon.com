import markdownItFigures from "markdown-it-image-figures"
import { eleventyImageTransformPlugin } from "@11ty/eleventy-img";

export default function (eleventyConfig) {
  eleventyConfig.addWatchTarget("content/**/*.{svg,webp,png,jpeg}");

  eleventyConfig.amendLibrary("md", markdown => {
    markdown.use(markdownItFigures, {
      figcaption: "title",
    })
  });

  // @todo: Once classes are properly copied to the transformed `<picture>`
  // the `eleventy:formats="webp"` attribute can be removed from
  // items in the `pictures` collection.
  // See: https://github.com/11ty/eleventy-img/issues/243
  eleventyConfig.addPlugin(eleventyImageTransformPlugin, {
    // File extensions to process in _site folder
    extensions: "html",

    // Output formats for each image.
    formats: ["avif", "webp", "auto"],

    // widths: ["auto"],

    defaultAttributes: {
      // e.g. <img loading decoding> assigned on the HTML tag will override these values.
      loading: "lazy",
      decoding: "async",
    }
  });
}
