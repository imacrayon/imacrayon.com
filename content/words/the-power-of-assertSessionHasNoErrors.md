---
title: Make Laravel Tests Easier To Debug With `assertSessionHasNoErrors`
date: 2020-04-26 20:55:00
description: The `assertSessionHasNoErrors` method in Laravel's test suit is a suprisingly powerful tool.
tags:
  - laravel
  - php
---

The `assertSessionHasNoErrors` method in Laravel's test suit is surprisingly powerful. It not only asserts that your request has validation errors, it also clearly identifies exactly which validation rules are triggering the errors.

When I first began writing feature tests in Laravel I would oftentimes run into situations where my tests would fail because of a validation issue. To figure out exactly which validation rule was causing the test failure, I would wrap my requests in a `try`/`catch` like this:

```php
public function __invoke(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'code' => ['required'],
    ]);

    $gift = Gift::where('code', $request->code)->first();

    if (is_null($gift)) {
        ValidationException::withMessages([
            'code' => 'Invalid gift code. If you feel this is an error, please contact us.',
        ]);
    }

    if ($gift->redeemed()) {
        ValidationException::withMessages([
            'code' => 'Gift code already redeemed. If this is in error, please contact us.',
        ]);
    }

    $customer = Customer::firstOrCreate([
        'email' => $request->email,
    ], [
        'name' => $request->name,
    ]);

    $gift->redeem($customer);

    return redirect()->route('checkout.thanks', [
        'product_id' => $gift->order->items->first()->product_id,
    ]);
}
```

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

```shell
Session has unexpected errors: ["The name field is required."]
```

So now you'll know exactly which validation rule you need to focus on when fixing your test.
