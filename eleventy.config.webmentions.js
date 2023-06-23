const fs = require("fs");

module.exports = eleventyConfig => {
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
}
