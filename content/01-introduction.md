# PSL - PHP as a Second Language

## Who is this for?

This is for anyone who wants to learn to program in PHP as a second language.

You should already know at least one programming language with curly braces, if conditions, variables, functions and
loops. The most likely scenario is that you are a Javascript or Typescript developer, working on a team that uses 
a combination of PHP and JS or TS, and while you might not currently need deep PHP knowledge, 
you want 'T-shaped skills', involving basic PHP knowledge. There will be some comparisons between with Javascript and
Typescript.

## Why did I write it?

(*This part should probably be moved out of the intro, perhaps entirely out of the main tutorial content.*)

I work as a PHP developer, and have some colleagues with great Javascript skills who sometimes want to do work in the PHP
side of our application, but don't have PHP experience from their previous jobs. I looked around for an introductory 
tutorial to recommend they can work through, but I didn't find anything satisfying. 

[The tutorial at php.net](https://www.php.net/manual/en/tutorial.php) appears not to have been updated for several years,
and doesn't even introduce either the `function` or `class` keywords. On the other hand it does show PHP mixed with HTML,
which I plan to pretend doesn't exist. I think it's now probably worse than useless.

David Brumbaugh's 
[Learn a New Language: Migrating from JavaScript to PHP](https://www.codementor.io/@davidbrumbaugh/migrating-from-javascript-to-php-du1088tr4)
is much closer to what I want to write, but it's a bit too short. It doesn't explain how to install PHP, or what composer is,
and again it prominently covers mixing PHP with HTML. It shows both the pre-and post 5.4 array syntax, whereas I want to
require the reader to install at least PHP 7.2, and spend little if any time on older versions.

[PHP The Right Way](https://phptherightway.com/) is often recommended to PHP beginners, for good reasons. It has very good
advice, but it's not really a tutorial to work through step by step. I think it could be overwhelming as an introduction
to PHP, and covers a lot more than I think most new PHP developers would want to know, including several paragraphs about
the MySQL Extension, which as it says "is incredibly old and has been superseded by two other extensions". I plan to
concentrate on the parts of PHP that I can recommend.

For PHP devs learning some Javascript, typescript, and/or React there seem to be great materials available online,
such as the [React Tutorial](https://reactjs.org/tutorial/tutorial.html), 
[HTML Dog's Javascript Tutorials](https://htmldog.com/guides/javascript/), 
[TypeScript in 5 minutes](https://www.typescriptlang.org/docs/handbook/typescript-in-5-minutes.html) and the (paid) Typescript course at 
[Execute Program](https://www.executeprogram.com/). As far as I can tell there's nothing similar available free to help
JS devs learn some PHP.
