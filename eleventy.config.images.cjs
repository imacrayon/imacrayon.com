const path = require("path");
const eleventyImage = require("@11ty/eleventy-img");

module.exports = eleventyConfig => {
  const options = {
    widths: [1508],
    formats: ['webp'],
    urlPath: "/img/_transforms/",
    outputDir: path.join(eleventyConfig.dir.output, "img/_transforms")
  }

  const attributes = {
    sizes: 'calc(100vw - 2rem)',
    loading: 'lazy',
    decoding: 'async'
  }

  async function imageShortcode(src, alt = '', widths = null) {
    options.widths = widths || options.widths
    let file = path.resolve('.' + src);
    const metadata = await eleventyImage(file, options)
    return eleventyImage.generateHTML(metadata, {
      alt,
      ...attributes
    })
  }

  eleventyConfig.addAsyncShortcode('image', imageShortcode)

  eleventyConfig.amendLibrary("md", markdown => {
    markdown.renderer.rules.image = function (tokens, idx) {
      const token = tokens[idx]
      // Prepend the markdown path with a `.` so it's treated as relative.
      // This is a workaround because the `this.page.inputPath` context
      // is not available within `amendLibrary` callbacks.
      let file = path.resolve('.' + token.attrGet('src'))
      eleventyImage(file, options)
      const metadata = eleventyImage.statsSync(file, options)
      return eleventyImage.generateHTML(metadata, {
        alt: token.content,
        ...attributes
      }, {
        whitespaceMode: "inline"
      })
    }
  })
};
