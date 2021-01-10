---
extends: _layouts.post
section: content
title: Deploy Laravel Apps with Github Actions
date: 2020-06-06 20:26:00
description: How I deploy Laravel Apps using Github Actions
categories: [php, laravel, tooling]
---

I deployed my first Laravel project using [Github Actions](https://github.com/features/actions) today, these articles and resources were a big help in doing so:

- [Building and Deploying Laravel with Github Actions](https://medium.com/@driesvints/building-and-deploying-laravel-with-github-actions-8111e8a6646e) by Dries Vints
- [Using GitHub actions to run the tests of Laravel projects and packages](https://freek.dev/1546-using-github-actions-to-run-the-tests-of-laravel-projects-and-packages)
- [GitHub Actions Laravel Starter Workflow](https://github.com/actions/starter-workflows/blob/2ffdd0654ef8d0dfa8ff3c740a6f1d4c2eaccd8f/ci/laravel.yml)

Here's the workflow config I landed on:

```
name: Tests

on:
  push:
    branches: [main]
  pull_request:
    branches: [main]

jobs:
  tests:
    runs-on: ubuntu-latest

    steps:
      - name: Checkout code
        uses: actions/checkout@v2

      - name: Cache dependencies
        uses: actions/cache@v2
        with:
          path: ~/.composer/cache/files
          key: dependencies-composer-${{ hashFiles('composer.lock') }}

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 7.4
          extensions: dom, curl, libxml, mbstring, zip, pcntl, pdo, sqlite, pdo_sqlite
          coverage: none

      - name: Install Composer dependencies
        run: composer install --prefer-dist --no-interaction

      - name: Execute tests
        run: vendor/bin/phpunit --verbose

      - name: Send Slack notification
        uses: 8398a7/action-slack@v2
        if: failure()
        with:
          status: ${{ job.status }}
          author_name: ${{ github.actor }}
        env:
          SLACK_WEBHOOK_URL: ${{ secrets.SLACK_WEBHOOK }}
          GITHUB_TOKEN: ${{ secrets.GITHUB_TOKEN }}

      - name: Deploy to Envoyer
        if: github.ref == 'refs/heads/main'
        run: curl ${{ secrets.ENVOYER_HOOK }}?sha=${{ github.sha }}
```

Here's a summary of the steps and some required configuration:

- `Checkout code` checks out the fresh code.
- `Cache dependencies` will cache composer downloads so that future actions run quicker. The cache is busted when your `composer.lock` file changes.
- `Setup PHP` will setup PHP 7.4 as well as Laravel's required extensions.
- `Execute tests` runs PHPUnit.
- `Send Slack notification` will send a notification to the specified webhook if any tests fail.
- `Deploy to Envoyer` triggers a new Envoyer deployment when new code is pushed to the `main` branch.

In order for PHPUnit to work your Laravel app must have an `APP_KEY` set. The easiest way to do this is to modify the `phpunit.xml` file in your project and hardcode an app key:

```
<phpunit>
    <php>
        ...

        <server name="APP_KEY" value="base64:NXoQgjw2ZlOxnGbo5ZRhYgTdM6xLYsgYElNAgcTQJkE="/>

        ...
```

The last thing you'll need to do is setup two secrets under your repo's "Secrets" settings page on GitHub. Note that the `GITHUB_TOKEN` secret in our action is automatically provided for you.

- Create a `SLACK_WEBHOOK` secret to store your Slack webhook URL.
- Create a `ENVOYER_HOOK` secret to store the deployment URL for your Envoyer project.
