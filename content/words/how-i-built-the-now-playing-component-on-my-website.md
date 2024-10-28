---
title: How I Built the "Now Playing" Component on My Website
date: 2024-10-27
description: How I built the realtime "Now Playing" component on this website
tags:
  - html
  - css
  - serverless
  - javascript
---

The "Now Playing" component on my homepage features the last five jams I've been jamming to and updates in real-time as I play music. Here's how I made it and how you can build one for yourself:

I listen to music mostly through Spotify, but the Spotify API requires a complex OAuth authentication process. To make things easier I created a Last.fm account and setup Spotify Scrobbling from [Last.fm Settings page](https://www.last.fm/settings). Authenticating with the Last.fm API is very simple, you only need to [register an API application](https://www.last.fm/api/account/create) and you're all set with an API token.

Since the Last.fm API key is private, we can’t just fire off an API request in the browser, instead we've got to make API requests in a protected environment where our API credentials won’t be exposed to website visitors. Let's create a serverless function for this task. Digital Ocean, Netlify, or Cloudflare Workers all offer free serverless functions. I already have a lot of projects setup on Digital Ocean so it just made sense to stick with them. The function retrieves the four most recently played tracks from Last.fm and creates HTML snippets for each song. Note that you'll need to replace `YOUR_LAST_FM_USERNAME_HERE` and `YOUR_LAST_FM_API_KEY_HERE` with your actual credentials:

```js
const USERNAME = 'YOUR_LAST_FM_USERNAME_HERE'
const API_KEY = 'YOUR_LAST_FM_API_KEY_HERE'
const API_URL = 'https://ws.audioscrobbler.com/2.0/'

function trackHtml(track, lazy = true) {
  return `<a href="${track.url}" class="track">
    <img ${lazy ? 'loading="lazy"' : ''} width="64" height="64" src="${track.image[2]['#text']}" alt="">
    <div>
      <p>${track.name}</p>
      <p>${track.artist['#text']}</p>
    </div>
  </a>`
}

function main() {
  return fetch(`${API_URL}?method=user.getrecenttracks&user=${USERNAME}&limit=4&api_key=${API_KEY}&format=json`)
    .then(response => response.json())
    .then(json => json.recenttracks.track)
    .then(tracks => {
      let body = ''
      if (tracks.length) {
        body = `${trackHtml(tracks[0], false)}
        <details>
          <summary>Recently played</summary>
          <ul role="list">
            <li>${trackHtml(tracks[1])}</li>
            <li>${trackHtml(tracks[2])}</li>
            <li>${trackHtml(tracks[3])}</li>
          </ul>
        </details>`
      }

      return { body }
    })
}
```

So with a serverless function in place we can build a reusable web component that to display the "Now Playing" information on any web page. Make sure to replace `API_URL_ENDPOINT` with the actual URL of your serverless function:

```js
// now-playing.js

window.customElements.define('now-playing', class extends HTMLElement {
  connectedCallback() {
    fetch(`API_URL_ENDPOINT`)
      .then(response => response.text())
      .then(html => {
        if (html) {
          this.innerHTML = html
        }
      })
  }
})
```

Simply add a `<now-playing>` element to your HTML wherever you want the "Now Playing" section to appear. Any child elements will act as a "loading" state for the component, here's how the component on my homepage is structured:

```html
<now-playing>
  <div class="track">
    <img src="" alt="" width="64" height="64">
    <div>
      <p>Fetching track...</p>
      <p>Fetching artist...</p>
    </div>
  </div>
  <details>
    <summary>Recently played</summary>
    Fetching playlist...
  </details>
</now-playing>
```

 Don't forget to style it with a little CSS to make it look great!
