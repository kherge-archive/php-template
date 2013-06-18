Template
========

[![Build Status]](http://travis-ci.org/herrera-io/php-template)

Template is a very simple template rendering engine that uses normal PHP files.

```php
$engine = Herrera\Template\Engine::create('/path/to/templates');

$engine['myGlobal'] = 123;

$engine->display('myTemplate.php', array('templateVar' => 456));
```

```php
<p>myGlobal: <?php echo $myGlobal; ?></p>
<p>templateVar: <?php echo $templateVar; ?></p>
```

Documentation
-------------

- [Installing][]
- [Usage][]

[Build Status]: https://travis-ci.org/herrera-io/php-template.png
[Installing]: doc/00-Installing.md
[Usage]: doc/01-Usage.md
