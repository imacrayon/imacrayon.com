---
extends: _layouts.post
section: content
title: Mobile Friendly Tables
date: 2019-07-14 17:13:00
description: An easy way to build mobile friendly tables with only CSS
categories: [css]
---

Building a table that works well on smaller screens is tricky, but I've come up with a simple CSS-only approach that works well for the 80% use case.

## An Example

Check out the example below by resizing your browser window:

<table class="table-collapse">
  <caption>My Most Played Songs of 2018</caption>
  <thead>
    <tr>
      <th>Title</th>
      <th>Artist</th>
      <th>Album</th>
      <th class="text-right">Released</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td data-heading="Title">Our Song</td>
      <td data-heading="Artist">Radiator Hospital</td>
      <td data-heading="Album">Something Wild</td>
      <td data-heading="Released" class="text-right">2013</td>
    </tr>
    <tr>
      <td data-heading="Title">DEB</td>
      <td data-heading="Artist">Thin Lips</td>
      <td data-heading="Album">Riff Hard</td>
      <td data-heading="Released" class="text-right">2016</td>
    </tr>
    <tr>
      <td data-heading="Title">Crown Victoria</td>
      <td data-heading="Artist">Lithuania</td>
      <td data-heading="Album">White Reindeer</td>
      <td data-heading="Released" class="text-right">2017</td>
    </tr>
    <tr>
      <td data-heading="Title">Phoenix</td>
      <td data-heading="Artist">Slaughter Beach, Dog</td>
      <td data-heading="Album">Birdie</td>
      <td data-heading="Released" class="text-right">2018</td>
    </tr>
    <tr>
      <td data-heading="Title">Enter Entirely</td>
      <td data-heading="Artist">Cloud Nothings</td>
      <td data-heading="Album">Life Without Sound</td>
      <td data-heading="Released" class="text-right">2017</td>
    </tr>
    <tr>
      <td data-heading="Title">the cool</td>
      <td data-heading="Artist">Oso Oso</td>
      <td data-heading="Album">The Yunahon Mixtape</td>
      <td data-heading="Released" class="text-right">2017</td>
    </tr>
    <tr>
      <td data-heading="Title">How Simple</td>
      <td data-heading="Artist">Hop Along</td>
      <td data-heading="Album">Bark Your Head Off Dog</td>
      <td data-heading="Released" class="text-right">2018</td>
    </tr>
    <tr>
      <td data-heading="Title">Shark Smile - Edit</td>
      <td data-heading="Artist">Big Thief</td>
      <td data-heading="Album">Shark Smile (Edit)</td>
      <td data-heading="Released" class="text-right">2017</td>
    </tr>
    <tr>
      <td data-heading="Title">Raining in Kyoto</td>
      <td data-heading="Artist">The Wonder Years</td>
      <td data-heading="Album">Sister Cities</td>
      <td data-heading="Released" class="text-right">2018</td>
    </tr>
    <tr>
      <td data-heading="Title">Dead-Bird</td>
      <td data-heading="Artist">McCafferty</td>
      <td data-heading="Album">Beachboy</td>
      <td data-heading="Released" class="text-right">2014</td>
    </tr>
    <tr>
      <td data-heading="Title">I Never Wanted You</td>
      <td data-heading="Artist">Headphones</td>
      <td data-heading="Album">Headphones</td>
      <td data-heading="Released" class="text-right">2005</td>
    </tr>
    <tr>
      <td data-heading="Title">Your Best American Girl</td>
      <td data-heading="Artist">Mitski</td>
      <td data-heading="Album">Puberty 2</td>
      <td data-heading="Released" class="text-right">2016</td>
    </tr>
  </tbody>
</table>

## How It's Done

The first step to creating a good table is to ask yourself _"Do I actually need to use a table?"_. Many times there's better ways to present tabular data than just a boring table, [Steve Schoger](https://www.steveschoger.com/) has some [great tips on organizing tabular data](https://twitter.com/steveschoger/status/997125312411570176).

If it turns out you _really_ do need a table, check out the code in the next section.

## The Code

First, let's take a look at the markup:

```html
<table class="table-collapse">
    <thead>
        <tr>
            <th>Title</th>
            <th>Artist</th>
            <th>Album</th>
            <th class="text-right">Release Date</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td data-heading="Title">Our Song</td>
            <td data-heading="Artist">Radiator Hospital</td>
            <td data-heading="Album">Something Wild</td>
            <td data-heading="Release Date" class="text-right">2013</td>
        </tr>
    </tbody>
</table>
```

There's two important thing to note in the markup above:

1. The `table-collapse` class will apply the collapsible behavior to the table.
2. The `data-heading` attribute on each `<td>` element should describe the table cell data.

Now, for the CSS:

```css
@media (max-width: 768px) {
    .table-collapse {
        width: 100%;
        & > tfoot,
        & > thead {
            display: none;
        }
        & > tbody,
        & > tbody > tr,
        & > tbody > tr > td,
        & > tbody > tr > th {
            display: block;
            width: auto;
        }
        & > tbody > tr {
            padding-top: 0.5em;
            padding-bottom: 0.5em;
            & > th {
                border: none !important;
                padding: 0.25em 0.5em;
                text-align: left !important;
                &:first-child {
                    padding-left: 0.5em;
                }
                &:last-child {
                    padding-right: 0.5em;
                }
            }
            & > td {
                border: none !important;
                padding: 0.25em 0.5em 0.25em 35%;
                box-shadow: none !important;
                text-align: left !important;
                position: relative;
                &:first-child {
                    padding-left: 35%;
                }
                &:last-child {
                    padding-right: 0.5em;
                }
                &::before {
                    content: attr(data-heading);
                    position: absolute;
                    top: 0.25em;
                    left: 0.5em;
                    width: 35%;
                    padding-right: 0.25em;
                    white-space: nowrap;
                    z-index: 1;
                }
            }
        }
    }
}
```

[View the code for this table as a gist](https://gist.github.com/imacrayon/ffab2dfb5f0f143f6e2110aea8b11212).

Thanks to the media query in the first line above these styles are applied when the browser window is **less than or equal to** `768px` wide. The table's header and footer are hidden and the cells in each row stack vertically using `display: block`. Each of the table cells also have `padding-left: 35%` which allows a healthy amount of space for the `::before` pseudo element to sit to the left of the cell's data using `position: absolute`. The `content: attr(data-heading)` line dynamically pulls text from the `data-heading` attribute in the HTML and uses that text as a new label for the cell. The best part is the CSS `attr()` function has support all the way back to IE 8 when used as a `content` value.
