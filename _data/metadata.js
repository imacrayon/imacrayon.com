module.exports = function () {
  return {
    "environment": process.env.SITE_ENVIRONMENT || "development",
    "title": "I'm a crayon",
    "url": "https://imacrayon.com",
    "language": "en",
    "description": "Work by Christian Taylor. An artist & full stack developer based in Wichita, KS.",
    "feed": {
      "subtitle": "Work by Christian Taylor. An artist & full stack developer based in Wichita, KS.",
      "filename": "feed.xml",
      "path": "/feed/feed.xml",
      "id": "https://imacrayon.com"
    },
    "jsonfeed": {
      "path": "/feed/feed.json",
      "url": "https://imacrayon.com/feed/feed.json"
    },
    "author": {
      "name": "Christian",
      "email": "christianbtaylor@gmail.com",
      "url": "https://imacrayon.com/about/"
    }
  }
}
