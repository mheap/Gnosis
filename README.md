Gnosis
======

Gnosis is a PHP powered markdown rendering app. ```Gnosis``` is the Greek word for ```knowledge```.
See a working version [here](http://gnosis.michaelheap.com/).

<a href="http://michaelheap.com/wp-content/uploads/2012/08/gnosis.png"><img src="http://michaelheap.com/wp-content/uploads/2012/08/gnosis.png" alt="" title="gnosis" width="962" height="726" class="aligncenter size-full wp-image-382" /></a>

# Installation
For now, the code is only available via the [Github repo](https://github.com/mheap/Gnosis). To install Gnosis, you'll need to clone to repository, then install the dependencies using [Composer](http://getcomposer.org/). At the moment, there are a lot of dependencies (some of which aren't used) that I'm working on removing. For now though, they aren't doing any harm.

# Using Gnosis
To use the app, you'll need to create a "content" directory and start putting markdown files into it. If you'd like to see an example, rename "example_content" to "content" and open the app. There's two kinds of special file. The first is the homepage, whicht lives in the root of the content folder and is named ```home.md```. Next, there is ```index.md``` that can be in any subfolder, and will act as the page if someone tries to view a folder.

It supports unlimited nested folders, and as many files in each folder as you'd like to create. Here's the structure for the example files:

    .
    ├── 01-about-us
    │   └── index.md
    ├── 02-projects
    │   ├── 01-project-a
    │   │   ├── api.md
    │   │   ├── database.md
    │   │   └── index.md
    │   └── 02-project-b.md
    ├── 03-contributing
    │   └── index.md
    ├── 04-contact
    │   ├── email.md
    │   ├── index.md
    │   └── twitter.md
    └── home.md
    
# Looking forward

Gnosis is still in *very* early development. It uses Twitter Bootstrap for some basic styling, and it has no tests at all.

# Contributing

If you fancy contributing anything, just fork the repo and send in a pull request. There's no guidelines yet, so just do whatever you fancy and we'll see how it goes.