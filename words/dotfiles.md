---
layout: post.webc
title: A Clean Start With Dotfiles
date: 2020-01-28 17:54:00
description: New year new computer. What dotfiles are and how to use them.
tags:
  - tooling
---

## New Year, New Computer

I started off this year with a new job and a fresh MacBook Pro. My previous MacBook had been around for a while and was gathering cruft; I decided this year I wanted a digital fresh start, and thus began my quest to organize my dotfiles.

## What Are Dotfiles?

Dotfiles are various text files that store your preferred system setup. They're commonly used to define preferences for development tools like shell environments, git, and system configurations.

Backing up and tracking changes to these files makes it easier to restore your system preferences on any install of MacOS.

## My Approach

Surprisingly, finding a good approach to managing dotfiles can be overwhelming, [there are a **ton** of solutions out there](https://dotfiles.github.io/inspiration/) and everybody has their own priorities when it comes to backing up these simple files.

I settled on an approach that is <del>heavily inspired</del> stolen from [Dries Vints' Mackup Solution](https://driesvints.com/blog/getting-started-with-dotfiles/).

### Mackup

This is an awesome little tool that keeps a lot of your application config files synchronized with iCloud. It does a lot of the heavy lifting in my setup. Mackup takes care of backing up preferences for my apps like Spotify, TablePlus, VSCode, and Terminal.

### Homebrew

At this point I think [Homebrew](http://brew.sh) is pretty much a must-have for any Mac developer. My dotfiles use a `Brewfile` to define most of the apps, development tools, and libraries I use everyday. Running `brew bundle` installs all of these tools in a single command.

### Z Shell

I'm a fan of [Z Shell](http://www.zsh.org) and as of MacOS Catalina it is the default shell for mac users. I use the [Zsh Improved Framework (ZIM)](https://github.com/zimfw/zimfw) which supplies additional features on top of Z Shell's defaults. [Oh-My-Zsh](http://ohmyz.sh/) and [Presto](https://github.com/sorin-ionescu/prezto) are two other popular Z Shell frameworks, but I think they both include a lot of over-the-top features I never end up needing.

## A Fresh Install

Installation of my dotfile preferences is super simple: Run `./install.sh`, and you're good to go!

[You can find a full installation guide on GitHub](https://github.com/imacrayon/dotfiles). Feel free to fork it and modify it as you see fit.
