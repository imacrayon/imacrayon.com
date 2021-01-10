/* Credit to https://sebastiandedeyne.com/webmentions-on-a-static-site-with-github-actions/ */

const fs = require('fs')
const https = require('https')

fetchWebmentions().then(webmentions => {
  webmentions.forEach(webmention => {
    const path = webmention['wm-target'].replace('https://imacrayon.com/', '').replace(/\/$/, '')

    const filename = `${__dirname}/webmentions/${path}.json`

    if (!fs.existsSync(filename)) {
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
  const token = process.env.WEBMENTIONS_TOKEN

  const since = new Date()
  since.setDate(since.getDate() - 3)

  const url =
    'https://webmention.io/api/mentions.jf2' +
    '?domain=imacrayon.com' +
    `&token=${token}` +
    `&since=${since.toISOString()}` +
    '&per-page=100'

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
      console.log(response)
      throw new Error('Invalid webmention.io response.')
    }

    return response.children
  })
}

function latestReceivedDate(a, b) {
  return (a['wm-received'] < b['wm-received']) ? -1 : ((a['wm-received'] > b['wm-received']) ? 1 : 0)
}
