---
extends: _layouts.post
section: content
title: Make Laravel Tests Easier To Debug With `assertSessionHasNoErrors`
date: 2020-04-26 20:55:00
description: The `assertSessionHasNoErrors` method in Laravel's test suit is a suprisingly powerful tool.
categories: [laravel]
---

The `assertSessionHasNoErrors` method in Laravel's test suit is surprisingly powerful. It not only asserts that your request has validation errors, it also clearly identifies exactly which validation rules are triggering the errors.

When I first began writing feature tests in Laravel I would oftentimes run into situations where my tests would fail because of a validation issue. To figure out exactly which validation rule was causing the test failure, I would wrap my requests in a `try`/`catch` like this:

```php
try {
  $response = $this->post(route('my-route'), $someData);
  $response->assertOk();
} catch (ValidationException $e) {
  dd($e->errors());
}
```

Later on I realized all my problems could be solved with in a single line and without any ugly `try`/`catch` statements:

```php
  $response = $this->post(route('my-route'), $someData);
  $response->assertSessionHasNoErrors();
  $response->assertOk();
```

It's not immediately obvious, but if this test fails, `assertSessionHasNoErrors` will provide a helpful message like this:

```
Session has unexpected errors: ["The name field is required."]
```

So now you'll know exactly which validation rule you need to focus on when fixing your test.
