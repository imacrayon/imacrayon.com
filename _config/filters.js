import { DateTime } from "luxon"
import metadata from '../_data/metadata.js'

export default function (eleventyConfig) {
  eleventyConfig.addFilter('ogimage', (url) => {
    'https://v1.screenshot.11ty.dev/' + encodeURIComponent(metadata().url + url) + '/opengraph/_wait:2'
  })

  eleventyConfig.addFilter('dateformat', (dateObj, format) => {
    let formats = {
      'iso': 'yyyy-LL-dd',
      'long': 'dd LLL yyyy',
      'year': 'yyyy',
    }

    if (!formats[format]) {
      console.warn(`Unknown date format: "${format}"`);
    }

    return DateTime.fromJSDate(dateObj, { zone: 'utc' }).toFormat(formats[format]);
  })

  eleventyConfig.addFilter("take", (array, n) => {
    if (!Array.isArray(array) || array.length === 0) {
      return [];
    }

    return array.slice(0, n);
  });
}
