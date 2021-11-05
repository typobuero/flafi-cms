![Welcome to flafi CMS on GitHub](https://git.flafi.de/readme-welcome.jpg "Welcome to the flafi repo!")

# Howdy, I’m flafi !

**Flafi CMS is an Intentionally Featureless Modular Flat File Content Management System.**

* Software: flafi CMS
* Project: [flafi.de](https://flafi.de/)
* Source: [github.com/typobuero/flafi-cms](https://github.com/typobuero/flafi-cms/)
* Licence: [MIT-NA](https://github.com/typobuero/flafi-cms/blob/main/LICENCE.txt)
* Creator: Christian Münch, Typobüro
* Homepage: [typobuero.com](https://typobuero.com/)


## Goal

Flafi aims to provide a quick and simple approach to creating small websites. Its main feature is to create a fully functional, visually appealing and mobile-ready menu structure out of just subdirectories. Whenever you have a subdirectory with your content, you’ll have a new menu item automatically. This is meant by ‘modular’.

This gives the possibility to make direct file editing in plain and simple HTML – and PHP, if you need to do some dynamic stuff. No sluggish WYSIWYG editors, no backends, no processing and generating, no database. This is meant by ‘flat file’.

Your content is served directly from files. You manage your content on your own, straight and clear inside the directory, which is your menu item. Keeps everything simple and well-arranged. This is meant by ‘content management system’.

Sounds too easy? That’s right ― because sometimes you need exactly that for a project.

## Preview

For a preview of what exactly you get when downloading and using this repo, you can visit this link:

* [git.flafi.de/flafi-cms](git.flafi.de/flafi-cms/)

![Preview of flafi CMS out-of-the-box](https://git.flafi.de/readme-preview-gitflafide.png "Preview of flafi CMS")

## Prerequisites

To make use of flafi you need webspace on an Apache server with PHP ≥ 5.6 running — and you need this repository. To be more specific: You need the following files as a bare minimum:

- `.htaccess` ― to set the stage.
- `flafi.php` — the main engine.
- `index.php` ― your HTML template.
- subdirectories ― with your content inside.

Additionally it is very advisable to also have the following files:

- `favicon.ico` ― a nice little favicon for your webpage.
- `normalize.min.css` ― [stylesheet reset](https://github.com/necolas/normalize.css), recommended by [HTML5 Boilerplate](https://github.com/h5bp/html5-boilerplate).
- `styles.css` — the flafi theme (or your very own site-wide CSS).


## How to use

1. In `.htaccess` line 2 set the `RewriteBase` to the directory where you plan to have flafi running — usually in your web root, so just `/`.
2. In `index.php` go to HTML’s `<head>` section and set `<base href="">` to exactly this directory where you plan to have flafi running ― **with** a trailing slash `/`.
3. In `index.php` edit the whole template (`head`, `header`, `footer`) to match your project.
4. Create subdirectories (your future menu items) containing at least an `index.php`. It is expected that you provide the `<main>` element of your HTML in there.

Just explore the example files and you will know your way around real quick. You're also encouraged to have a dive in `flafi.php`, where you’ll find a lot of comments and will have access to some more useful features to hand-craft your project.


## Standard Features

* Auto-generates the menu structure of your webpage from present subdirectories.
* This let’s you manage your content pages like modules.
* Comes with a small CSS theme to kick-start with.


## Advanced Features

* Define where flafi looks for subdirectories that are to be turned into menu items.
* Have fine-grained control over the *order* of your menu items.
* Define a whitelist which menu items shall be *visible* in the menu.
* Define a blacklist which menu items shall be *hidden* from the menu, but accessible via URL.
* Define a blacklist which menu items shall be *protected* and not be accessible via URL.
* Thanks to CSS3 variables (hue), you can quickly set an overall color appearence for your site.

To access this advanced features, please see the Setup section in `flafi.php`, read the comments and make your edits. The CSS variable you’ll of course find in `styles.css`.


## Limitations

Because flafi is meant to be simple, be aware of its limitations:

* One menu and one level of depth. Constrains your content into a clear navigation.
* You have to write everything on your own, no drag’n’drop building blocks. What you write is what you get.
* No MVC architecture, no database. It’s up to you if you want to implement it.
* No user management or access rights. You just have files on your webserver.
* No multi language or fancy i18n. Flafi keeps it simple.
* No cunning SEO stuff in HTML’s `<head>`. `<main>` content is king!

## Roadmap

* [ ] Add advanced templating functions to have more automated fine-grain control.
* [ ] Add ability to auto-generate OpenGraph or Twitter cards.
* [ ] Auto-include page-specific `styles.css`, if file is present.
* [ ] Auto-include page-specific `scripts.js` near page footer, if file is present.
* [ ] Provide more useful CSS styles out of the box.


## License

Flafi is released under the [MIT Non-Aggression](https://github.com/typobuero/flafi-cms/blob/main/LICENCE.txt) licence. This means that you can freely do whatever you want with the software, as long as it is without intention to aggression.


**Now have fun using flafi CMS for your projects — drop me a line if you built something great!**