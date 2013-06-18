Usage
=====

To use Template, you must first initialize its engine:

```php
use Herrera\Template\Engine;

$engine = Engine::create('/path/to/templates');
```

If your templates are spread across multiple directories, you may instead
provide an array of directory paths. Note that the order in which the paths
are given define the precedence in which templates are used. If you have a
file called `test.php` in two directories, and set the paths to:

```php
array(
    '/path/1',
    '/path/2', // has "test.php"
    '/path/3',
    '/path/4', // has "test.php
)
```

Only `/path/2/test.php` will ever be used.

Templates
---------

A template is simply a PHP script.

```php
<p>My template!</p>
```

Like with any PHP script, you can do all sorts of crazy things with it. Keep
in mind that it is generally a good idea to keep all logic (that you can) out
of any of your templates. You should only rely on using constructs such as
`foreach`, `isset`, and others.

### Variables

With templates, you can assign variables that will be made available for
rendering content. The following template:

```php
<p>My <?= $thing ?>!</p>
```

with the following script:

```php
$engine->display('test.php', array('thing' => 'template'));
```

will result in:

```php
<p>My template!</p>
```

### Globals

In addition to using template variables, you may also use global variables:

```php
$engine['thing'] = 'global';

$engine->display('test.php');
```

```php
<p>My global.</p>
```

When setting the variables that are available to the template, any variables
passed to `display()` will take precedence over any globals that may have been
set:

```php
$engine['thing'] = 'global';

$engine->display('test.php', array('thing' => 'template'));
```

```php
<p>My template.</p>
```

Rendering
---------

There are two methods available to render your templates: `display()` and
`render()`. The `display()` method will render your template, and then output
the result. The `render()` method will render your template, and then return
the result.

Locators
--------

The templating engine makes use of the Herrera.io [`FileLocator`][] library.
By default, the `Herrera\\FileLocator\\Collection` locator is used with the
`Herrera\\FileLocator\\Locator\\FileSystemLocator` locator. This is set for
you when you provide the path to `Engine::__construct()`. If you wish to
retrieve the locator, you may call `$engine->getLocator()`. You may also
replace the locator by calling `$engine->setLocator($myLocator)`.

[`FileLocator`]: https://github.com/herrera-io/php-file-locator
