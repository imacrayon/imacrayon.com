import { existsSync, readFileSync } from 'node:fs'

export default function (eleventyConfig) {
  eleventyConfig.addFilter("webmentions", (page) => {
    let file = `content/webmentions${page.filePathStem}.json`
    if (!existsSync(file)) return []

    let content = readFileSync(file);
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
