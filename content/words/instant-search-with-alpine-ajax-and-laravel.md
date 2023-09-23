---
title: An Instant Search UI using Alpine AJAX & Laravel
description: How to build an instant search filter using Alpine AJAX & Laravel
tags:
  - laravel
  - alpine
  - alpine-ajax
---

I’m going to walk you through how to easily add an instant search filter in your Laravel apps. This UI pattern is one of my favorite examples that demonstrates the power and simplicity of the [Alpine AJAX](https://alpine-ajax.js.org) library. When I say “instant search” I mean a text input that filters a list of results as you type. In this example we’ll build out a simple contact list and then allow a user to search for a contact within the list by typing part of the contact’s name or email.

## The Data

You can start with a fresh Laravel install, get a database ready to go, then run `php artisan migrate` in the terminal to generate the “users” table. To ensure that you’ve got user data to work with, you can run `php artisan tinker` to enter the Tinker CLI, then `User::factory()->count(20)->create();` to generate 20 users in your database.

## The Route

Next, we’ll build out a route to view our list of contacts:

```php
// routes/web.php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/contacts', function () {
    return view('contacts', [
        'contacts' => User::get(),
    ]);
});
```

## The View

The route we just created requires a view file at `resources/views/contacts.blade.php`, so we’ll add that. It’s going to be a basic page with a search form followed by a list of contacts. I’m leaving CSS styling out of this walkthrough so that we can focus on the markup, style things however you’d like:

```html{% raw %}
<!-- resources/views/contacts.blade.php -->

<!doctype html>
<html>
<head>
  <title>Contact</title>
</head>
<body>
  <form role="search" aria-label="Contacts">
    <label for="term">Search</label>
    <input type="search" id="term" name="term">
    <button>Submit</button>
  </form>
  <h1>Contacts</h1>
  <ul>
    @foreach($contacts as $contact)
      <li>{{ $contact->name }} – {{ $contact->email }}</li>
    @endforeach
  </ul>
<body>
</html>
{% endraw %}```

## The Logic

Alright, at this point we should be able to visit `/contacts` in the browser and see our search form and contact list. Now we need to get our form returning search results, so we’ll add some new logic to our route:

```php
// routes/web.php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/contacts', function (Request $request) {
    $contacts = User::when($request->term, function ($query, $term) {
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%");
        });
    })->get();

    return view('contacts', [
        'contacts' => $contacts,
    ]);
});
```

With this change our search form should be working now: When the HTTP request contains a value for **“term”** in the query string, we’ll query the “users” table for a record with a **“name”** or **“email”** that contains the search term. Note that this is a simple search implementation just for demonstration purposes, you’d probably be better off using something like [Laravel Scout](https://laravel.com/docs/10.x/scout) for database searches, but that’s beyond the scope of this walkthrough.

## The Interaction

Now it’s time to enhance our interface so that we get instant results as we type. This is where Alpine AJAX shines. Alpine AJAX is a small [Alpine.js](https://alpinejs.dev) plugin that provides an easy way to make AJAX requests and render content on the page.

First, we’ll get Alpine and Alpine AJAX installed. We’ll add two script tags in the page `<head>`, but you can also [install these libraries through NPM](https://alpine-ajax.js.org/reference/#via-npm) if you’d like:

```html
<!-- resources/views/contacts.blade.php -->

<head>
  <title>Contact</title>
  <script defer src="https://cdn.jsdelivr.net/npm/@imacrayon/alpine-ajax@0.3.0/dist/cdn.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.11.1/dist/cdn.min.js"></script>
</head>
```

Next, let’s add a few attributes to our search elements:

```html{% raw %}
<!-- resources/views/contacts.blade.php -->

<form role="search" aria-label="Contacts" x-init x-target="contacts">
  <label for="term">Search</label>
  <input type="search" id="term" name="term" @input.debounce="$el.form.requestSubmit()">
  <button x-show="false">Submit</button>
</form>
<h1>Contacts</h1>
<ul id="contacts">
  @foreach($contacts as $contact)
    <li>{{ $contact->name }} – {{ $contact->email }}</li>
  @endforeach
</ul>
{% endraw %}```

`x-init` on the `<form>` initializes our Alpine component. The `@input.debounce` attribute on the `<input>` submits the search form when the value of the input is changed. Since the search form has a `x-target="contacts"` attribute, a normal form submission does **not** take place. Instead our form is submitted via an AJAX request and the `<ul id="contacts">` rendered in the response replaces the existing contact list on the page. Finally, we’ve added `x-show="false"` to the search form’s submit button. This is a small progressive enhancement that will ensure the search form stays usable with or without JavaScript. When JavaScript is loaded, the button is hidden, but if JavaScript fails to load, the button stays on the page and provides a way for the user to manually submit a search term.

With the new markup in place, refresh the page, and make sure to clear out the `?term` query string in the URL. And that’s it! You should see the contact list update as you type now.

Check out the [Alpine AJAX examples](https://alpine-ajax.js.org/examples) page to see more UI examples in action. It’s wild to see all the things you can accomplish with such a small JavaScript library.
