import { feedPlugin } from "@11ty/eleventy-plugin-rss";

export default function (eleventyConfig) {
  eleventyConfig.addPlugin(feedPlugin, {
    type: "atom", // or "rss", "json"
    outputPath: "/feed.xml",
    collection: {
      name: "feed",
      limit: 10,
    },
    metadata: {
      language: "en",
      title: "I'm a crayon",
      subtitle: "Work by Christian Taylor. An artist & full stack developer based in Wichita, KS.",
      base: "https://imacrayon.com/",
      author: {
        name: "Christian Taylor",
      }
    }
  });
};
