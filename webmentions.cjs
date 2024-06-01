/* Credit to https://sebastiandedeyne.com/webmentions-on-a-static-site-with-github-actions/ */

const fs = require('fs')
const path = require('path')
const https = require('https')

const DIRECTORY = `_includes/webmentions`
const DOMAIN = 'imacrayon.com'
const FEED = 'https://webmention.io/api/mentions.jf2'
const TOKEN = process.env.WEBMENTIONS_TOKEN

fetchWebmentions().then(webmentions => {
  webmentions.forEach(webmention => {
    const filePath = webmention['wm-target'].replace(`https://${DOMAIN}/`, '').replace(/\/$/, '') || 'index'

    const filename = `${DIRECTORY}/${filePath}.json`

    if (!fs.existsSync(filename)) {
      fs.mkdirSync(path.dirname(filename), { recursive: true })
      fs.writeFileSync(filename, JSON.stringify([webmention], null, 2))

      return
    }

    const entries = JSON.parse(fs.readFileSync(filename))
      .filter(wm => wm['wm-id'] !== webmention['wm-id'])
      .concat([webmention])
      .sort(latestReceivedDate)

    fs.writeFileSync(filename, JSON.stringify(entries, null, 2))
  })
})

function fetchWebmentions() {
  const since = '2019-06-01T10:00:00-0700' // new Date()
  // since.setDate(since.getDate() - 3)
  const url = `${FEED}?domain=${DOMAIN}&token=${TOKEN}&since=${since}&per-page=100`

  return new Promise((resolve, reject) => {
    https.get(url, res => {
      let body = ''

      res.on('data', chunk => { body += chunk })

      res.on('end', () => {
        try {
          resolve(JSON.parse(body))
        } catch (error) {
          reject(error)
        }
      })
    }).on('error', error => {
      reject(error)
    })
  }).then(response => {
    if (!('children' in response)) {
      throw new Error('Invalid webmention.io response.')
    }

    return response.children
  })
}

function latestReceivedDate(a, b) {
  let dateA = a.published || a['wm-received'];
  let dateB = b.published || b['wm-received'];
  // Newest first
  return (dateA < dateB) ? -1 : ((dateA > dateB) ? 1 : 0)
}
