---
layout: post.webc
title: Subdomain Redirects in Laravel Forge
date: 2021-02-04 21:28:00
description: How to redirect a subdomain to another domain in Laravel Forge.
tags:
  - tooling
---

I had to go through some trial and error to get this working so I'm writing it down. My goal was to permanently redirect a domain like `beta.imacrayon.com` to `imacrayon.com` in Laravel Forge.

In order to properly redirect `https://beta.imacrayon.com`. I generated a new LetsEncrypt certificate with the following domains:

```shell
imacrayon.com,www.imacrayon.com,beta.imacrayon.com
```

Next I added two new server blocks to the top of my nginx config:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name beta.imacrayon.com;
    return 301 https://imacrayon.com$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;

    # PASTE YOUR SSL DIRECTIVES HERE

    server_name beta.imacrayon.com;
    return 301 https://imacrayon.com$request_uri;
}
```

The second server block requires you to add the SSL directives for the LetsEncrypt certificate generated in the first step. You should be able to find these directives inside your existing nginx config. They’ll probably be labeled with a comment like `# FORGE SSL (DO NOT REMOVE!)` and look like this:

```nginx
    # FORGE SSL (DO NOT REMOVE!)
    ssl_certificate /etc/nginx/ssl/imacrayon.com/xxx/server.crt;
    ssl_certificate_key /etc/nginx/ssl/imacrayon.com/xxx/server.key;

    ssl_protocols TLSv1.2;
    ssl_ciphers ...;
    ssl_prefer_server_ciphers on;
    ssl_dhparam /etc/nginx/dhparams.pem;
```

That’s it! After saving your config `http://beta.imacrayon.com` and `https://beta.imacrayon.com` should now redirect to `https://imacrayon.com`.

Browsers will cache 301 redirects. So when testing these new redirects you may need to enable the “Clear cache” option in your browser's Developer Tools, it’s usually located under the “Network” tab.
