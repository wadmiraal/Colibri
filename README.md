# Colibri, the tiny PHP MVC Framework

Colibri is a (really) small, but fully functional MVC framework. It's meant for small projects or quickly bootstrapping web applications.

Colibri is licensed under the MIT licence.


## Philosophy

Colibri makes no assumption about your workflow, nor does it restrict you in any way (except the template engine - more on that below). This means that it lacks many functionalities found in (much) larger frameworks like Symfony or Zend. But it also means that you can program your application the way *you* want.


### Template engine

PHP comes bundled with a great, efficient and easy template-engine: PHP itself. Colibri simply uses php code to parse your template files and insert the data. Here again, Colibri enforces very little. The only thing is that it will always use a *layout* (which could be thought of as the HTML wrapper of your content) to which is passed a `$content` variable. This `$content`variable itself contains data from a *view*. Views and layouts are simply PHP files with HTML. You can output any variables you want (iow: name the variables as you see fit in each file).

For convenience, 2 variables will also be available for the *layouts*: `$stylesheets` and `$scripts`. These will be populated by calling the `$view->add_css()` or `$view->add_js()` methods, but this is not mandatory.


### Models

Colibri does not provide any models by default. Each application is unique, so it's your job to provide the model logic.


### Views

A view in Colibri is simply a file containing both HTML and PHP code. By default, all view files have a *.php* file extension, but this can be set to any extension you want in the `app/conf.php` file.


### Controllers

All controllers must extend the `C_Controller` class. All public methods with no prefixing underscore will be considered "callable" and can be mapped to in the url. Colibri uses the standard `controller/method/param1/param2/.../paramN` paradigm for routing the requests.


### Helper functions

There are a few helper functions that are globally available.

`conf()` retrieves values from the global `$_conf` variable.

`url()` makes it easier to format internal links for your application.

`segment()` will return the requested segment from the URI (e.g.: for `controller/method/param1`, `segment(1)` will return *method*).

`language()` will return the current language in i18n enabled applications.


### i18n out of the box

Colibri can route requests for localized applications be prepending a language parameter to all URIs. This *language* parameter can be anything you want, and it's up to you to implement the localization or internationalization logic for your application. For example, these are all valid:
`en/controller/method`
`fr-FR/controller/method`
`ITA/controller/method`

If a default language is set, all URIs with no language parameter will be considered of the default language (see `language()` above).

Use the `app/conf.php` file to configure your i18n settings. It's as easy as setting a variable to `TRUE`: no complex configuration or hacks. It just works.


### SEO friendly

Colibri is SEO-friendly. The default .htaccess file provides URL rewriting instructions for Apache servers to remove the `index.php` from the request (`controller/method/param1` instead of `index.php/controller/method/param1`).

All class names and methods are made *URI-friendly* by replacing underscores with hyphens and lowercasing all segments (except the language parameter - see above).


### AJAX ?

A view can also be rendered as JSON. By calling `$view->json()`, the template engine will skip the template parsing and directly output all variables as a JSON string. This is super-easy and very usefull for AJAX heavy applications.


#### Configuration

Configuration directives are found in `app/conf.php` and are pretty self-explainatory.

The `web` directory is the webroot. Colibri code is located outside the web root by default (recommended). If you don't want to place your code outside the webroot, move the `app` and `sys` directories in the same directory as `index.php`. Open `index.php` and change the `SYS_PATH` and `APP_PATH` constants to map to your directory structure. `APP_PATH` is where your configuration and your code reside (`app` folder). `SYS_PATH` is where the Colibri core files reside (`sys` folder). 
