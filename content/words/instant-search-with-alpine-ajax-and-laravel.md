---
title: An Instant Search UI using Alpine AJAX & Laravel
description: How to build an instant search filter using Alpine AJAX & Laravel
tags:
  - laravel
  - alpine
  - alpine-ajax
---

I’m going to walk you through how to easily add an instant search filter in your Laravel apps. This UI pattern is one of my favorite examples to demonstrate the power and simplicity of the [Alpine AJAX](https://alpine-ajax.js.org) library. When I say “instant search” I mean a text input that filters a list of results as you type. In this tutorial we’ll build out a simple contact list and then allow a user to search for a contact within the list by typing part of the contact’s name or email.

## The Data

You can start with a fresh Laravel install, get a database ready to go, then run `php artisan migrate` in the terminal to generate the “users” table. To ensure that you’ve got user data to work with, you can run `php artisan tinker` to enter the Tinker CLI, then `User::factory()->count(20)->create();` to generate 20 users in your database.

## The View

Since we're focusing on the user interface, let's start with the view so we can get a sense of how things will look and feel. We'll create a Blade template at `resources/views/contacts.blade.php`. It’s going to be a basic page with a search form followed by a list of contacts. I’m leaving CSS styling out of this walkthrough so that we can focus on writing good markup, style things however you’d like.

```html{% raw %}
<!-- resources/views/contacts.blade.php -->

<!doctype html>
<html>
<head>
  <title>Contacts</title>
</head>
<body>
  <h1>Contacts</h1>
  <form role="search" aria-label="Contacts">
    <label for="term">Search</label>
    <input type="search" id="term" name="term">
    <button>Submit</button>
  </form>
  <h2>Results</h2>
  <ul role="list">
    @foreach($contacts as $contact)
      <li>{{ $contact->name }} – {{ $contact->email }}</li>
    @endforeach
  </ul>
<body>
</html>
{% endraw %}```

We've left the `action` and `method` attributes off of the search `<form>` so by default the form will issue a `GET` request to the current URL. The search `<input>` has the `name` **“term”** so that we can access the submitted search team on the backend. Next, we'll scaffold out some backend logic for this form.

## The Route

Now let's create a new route at `/contacts`. Our route logic will check if the incoming request contains a value for **“term”**, if so, it’ll query the “users” table for a record with a **“name”** or **“email”** that contains the search term:

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

Note that this is a simple search implementation just for demonstration purposes, you’d probably be better off using something like [Laravel Scout](https://laravel.com/docs/10.x/scout) for database searches, but that’s beyond the scope of this walkthrough.

At this point you should be able to navigate to `/contacts` in your browser, submit the search form, and see that the page reloads with an updated list of contacts. We've got our basic search form working! Now we can layer on extra features to make it feel really good to use.

## The Interaction

It’s time to enhance our search form so that we get instant results as we type. This is where Alpine AJAX shines. Alpine AJAX is a small [Alpine.js](https://alpinejs.dev) plugin that provides an easy way to make AJAX requests and render content on the page.

First we’ll get Alpine and Alpine AJAX installed; we’ll add two script tags in the page `<head>`, but you can also [install these libraries through NPM](https://alpine-ajax.js.org/reference/#via-npm) if you’d like:

```html
<!-- resources/views/contacts.blade.php -->

<head>
  <title>Contacts</title>
  <script defer src="https://cdn.jsdelivr.net/npm/@imacrayon/alpine-ajax@0.3.0/dist/cdn.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.11.1/dist/cdn.min.js"></script>
</head>
```

Next, let’s add a few attributes to our search elements:

```html{% raw %}
<!-- resources/views/contacts.blade.php -->

<h1>Contacts</h1>
<form role="search" aria-label="Contacts" x-init x-target="contacts">
  <label for="term">Search</label>
  <input type="search" id="term" name="term" @input.debounce="$el.form.requestSubmit()">
  <button x-show="false">Submit</button>
</form>
<h2>Results</h2>
<ul id="contacts">
  @foreach($contacts as $contact)
    <li>{{ $contact->name }} – {{ $contact->email }}</li>
  @endforeach
</ul>
{% endraw %}```

Here's a breakdown of the attributes we've added:

1. `x-init` on the search form initializes our Alpine component.
2. `id="contacts"` on the list of contacts allows our search form the target the list.
3. `x-target="contacts"` on the search form changes the behavior of the form: When it is submitted an AJAX request is issued to `/contacts` and the updated `<ul id="contacts">` returned in the response replaces the existing contact list on the page.
4. `@input.debounce` on the search input automatically submits the search form when the value of the input is changed.
5. Finally, we’ve added `x-show="false"` to the search form’s submit button. This is a small progressive enhancement that will ensure the search form stays usable with or without JavaScript. When JavaScript is loaded, the button is hidden, but if JavaScript fails to load, the button stays on the page and provides a way for the user to manually submit a search term.

That’s it! With the new Blade markup in place, refresh the page (make sure to clear out the `?term` query string in the URL if it's there). Now you should see the contact list magically update as you type.

Check out the [Alpine AJAX examples](https://alpine-ajax.js.org/examples) page to see more UI examples in action. It’s wild to see all the things you can accomplish with such a small JavaScript library.
