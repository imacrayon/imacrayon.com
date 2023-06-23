const { DateTime } = require("luxon");

module.exports = eleventyConfig => {
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
}
