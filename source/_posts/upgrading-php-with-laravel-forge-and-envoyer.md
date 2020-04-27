---
extends: _layouts.post
section: content
title: Upgrading PHP with Laravel Forge and Envoyer
date: 2020-02-12 21:24:00
description: I ran into a hiccup to day upgrading the PHP version on my Laravel Forge server today.
categories: [php, laravel, tooling]
---

Laravel Forge makes it dead simple switch PHP versions. It's literally just a one button click and you're good to go. However, today I ran into a hiccup with Forge and Envoyer after upgrading from PHP 7.3 to 7.4.

First, after upgrading, I had to manually change the PHP FPM version in my Nginx config:

```
fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
```

After this change re-deploying my site through Forge appeared to work, yet I shortly ran up against problems when trying to deploy through Envoyer. It turns out Envoyer also needs to know about any changes to your server's PHP version. From the "Servers" tab, if you click "Update server" (the pencil icon), you'll find a "PHP Version" menu under the "System" section. This field also needs to be set to "PHP 7.4".

Changing the PHP version in Envoyer quickly fixed all my deployment woes, hopefully this might help somebody else facing the same issue.
