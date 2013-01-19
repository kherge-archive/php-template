Template
========

[![Build Status](https://travis-ci.org/herrera-io/php-template.png)](http://travis-ci.org/herrera-io/php-template)

A simple templating engine using regular PHP files.

Summary
-------

The `Template` library will use ordinary PHP scripts to render any type of content needed. There is no templating language to learn, no extra compiling, and no need to cache compiled templates.

Installation
------------

Add it to your list of Composer dependencies:

```sh
$ composer require herrera-io/template=1.*
```

Usage
-----

To initialize the templating engine, you call the `Engine::create()` method and pass the directory path to the templates. If there is more than one directory, you may pass an array of directory paths.

```php
<?php

use Herrera\Template\Engine;

$engine = Engine::create('/path/to/templates');
$engine = Engine::create(array(
    '/path/to/templates1',
    '/path/to/templates2',
    '/path/to/templates3' // etc
));
```

To render a template, call `render()`:

```php
<?php

$engine->render('template.php');
```

To pass variables to the template, pass an array of variables after the name:

```php
<?php

$engine->render('template.php', array(
    'var1' => 'My variable 1.',
    'var2' => 'My variable 2.',
    'var3' => 'My variable 3.' // etc
));
```

The variables will be available as `$tpl` in the template file:

```php
<html>
  <head>
    <title>Example</title>
  </head>
  <body>
    <h1><?php echo $tpl['var1']; ?></h1>
    <h2><?php echo $tpl['var2']; ?></h2>
    <h3><?php echo $tpl['var3']; ?></h3>
  </body>
</html>
```

If you want to retrieve the result of the rendering, instead of outputting it, pass `true` as the 3rd argument:

```php
<?php

$result = $engine->render('template.php', array(), true);
```