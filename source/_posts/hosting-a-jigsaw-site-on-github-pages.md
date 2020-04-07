---
extends: _layouts.post
section: content
title: Hosting a Jigsaw Site on GitHub Pages
date: 2020-04-07 17:36:00
description: How I came to host my Jigsaw static site on GitHub Pages
categories: [php, tips]
---

Last week I re-built this site using the [Jigsaw](https://jigsaw.tighten.co) static site generator. Before now I've been hosting my site on a Digital Ocean droplet, but I thought it might be fun to try hosting it through GitHub Pages.

Unfortunatly, Jigsaw's documentation for deploying to GitHub Pages is sparce. My intitial push to the `gh-pages` branch was easy, but after that I struggle with pushing subsequent updates to the `master` and `gh-pages` branches.

I wrestled with trying to come up with a clean deployment strategy until I stumbled upon an [awesome blog post by James Brooks](https://james.brooks.page/blog/jigsaw-github-actions/). James recently setup his own Jigsaw blog to deploy to Github Pages using GitHub Actions and it's exactly what I was needing.

James' strategy is to store all of the Jigsaw assets in a `source` branch and then setup a GitHub Action that will build and deploy the static site files to be served in the `master` branch. This approach doesn't require any crazy git commands and it has the added benefit of being deployable anywhere through GitHub's UI.
