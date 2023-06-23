---
title: Expressive Syncing in Laravel
date: 2019-07-06 14:49:00
description: How to make your many to many relationships more expressive
tags:
  - laravel
  - php
---

`sync` accepts a second parameter that prevents a model from detaching any associations.

```php
$post->tags()->pluck('id'); // 1, 3, 5

$post->tags()->sync([2, 4], false);

$past->tags()->pluck('id'); // 1, 2, 3, 4, 5
```

If you haven't check the Laravel docs lately there's a nice, new `syncWithoutDetaching` method that makes your code a whole lot more expressive.

```php
$post->tags()->pluck('id'); // 1, 3, 5

$post->tags()->syncWithoutDetaching([2, 4]);

$past->tags()->pluck('id'); // 1, 2, 3, 4, 5
```
