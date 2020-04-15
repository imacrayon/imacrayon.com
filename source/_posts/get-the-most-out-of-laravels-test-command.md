---
extends: _layouts.post
section: content
title: Get the Most out of Laravel's Test Runner in Visual Studio Code
date: 2020-04-14 22:29:00
description: How to get the most out of Laravel's new artisan test runner in Visual Studio Code.
categories: [laravel, php]
---

First, if you're writing PHPUnit tests in Visual Studio Code and **not** using the [Better PHPUnit](https://marketplace.visualstudio.com/items?itemName=calebporzio.better-phpunit) extension, download it now. It makes running test such a breeze.

The recent release of Laravel 7 introduced a new artisan test runner command:

```
php artisan test
```

It's essentially a wrapper around [PHPUnit](https://phpunit.de/) that provides excellent formatting with plenty of colors and whitespace. The new test command also gives you more context around failed tests.

With a small config change to Better PHPUnit, you can use the extension to fire off the new test runner; add the following line to your Visual Studio Code settings JSON and you're all set!

```
"better-phpunit.phpunitBinary": "php artisan test",
```
