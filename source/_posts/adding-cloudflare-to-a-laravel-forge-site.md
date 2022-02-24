---
extends: _layouts.post
title: Adding Cloudflare to a Laravel Forge Site
date: 2022-02-23 19:15:00
description: The steps I took to put Cloudflare in front of a website managed on Laravel Forge
---

I manage several websites hosted on [Digital Ocean](https://digitalocean.com) through [Laravel Forge](https://forge.laravel.com). Recently some unusual traffic on one of these websites prompted me setup some [Cloudflare](https://cloudflare.com) security features. Cloudflare required that I migrate my website's DNS from Digital Ocean into their platform. This required some additional tweaks to settings within Laravel Forge and Digital Ocean. I'm going to document my whole migration process here for future me.

## Moving DNS

Migrating the DNS settings is pretty straight forward. Cloudflare is able to scan the domain and pull in all of the existing DNS settings already in Digital Ocean.

## SSL

After migrating the DNS. You need to create a new TLS certificate signed by Cloudflare. Without this certificate the Digital Ocean server fails to respond to requests forwarded from Cloudflare. From the Cloudflare dashboard navigate to **SSL/TSL > Origin Server**. From this page you can generate a new certificate for your domain. Next, within Forge, navigate to the website's dashboard; then go to **SSL** and click **Install Existing** under the New Certificate panel. Copy and paste the certificate information from Cloudflare into the Private Key and Certificate fields.

At this point the website should be ready to go. The last step is to add your SSL certificate to any Digital Ocean Spaces CDNs your might have configured.

## Digital Ocean Spaces CDN

From within the Settings page for your Digital Ocean Space you can select **Edit > Add a new certificate**. Within the settings modal select the **Bring your own certificate** tab. From here you can add your certificate settings just like you did in SSL step above.
